<?php

namespace App\Http\Controllers\Participate;

use App\Data\Repositories\Activities\ActivityRepository;
use App\Data\Repositories\Entity\EntityRepository;
use App\Data\Repositories\Participants\ParticipantRepository;
use App\Data\Repositories\Trees\TreeRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Shared\Traits\Instances\Response;
use Inertia\Inertia;

/**
 * Class TreeController
 *
 */
class ParticipateController extends BaseController
{

    protected $base_url, $activity_repo, $entity_repo, $participant_repo, $salt, $tree_repo;

    /**
     * Instantiate class with $treeRepository
     *
     * @param EntityRepository $entityRepository
     * @param ParticipantRepository $participantRepository
     */
    public function __construct(
        ActivityRepository $activityRepository,
        EntityRepository  $entityRepository,
        ParticipantRepository $participantRepository,
        TreeRepository $treeRepository){
        $this->activity_repo = $activityRepository;
        $this->entity_repo = $entityRepository;
        $this->participant_repo = $participantRepository;
        $this->tree_repo = $treeRepository;
        $this->base_url = env("APP_URL", 'http://localhost:8000');
        $this->salt = env("APP_SALT", 'KAHOY_Default');
    }
    // region show

    /**
     * Show Create tree form.
     *
     * @param Request $request
     * @return Inertia
     */
    public function show( Request $request, $activity_id ) {
        $hash = $request->query('hash');
        if(!isset($hash) || !validate_app_hash("ACTIVITY".$this->salt.$activity_id, $hash)){
            return Inertia::render('404');
        }

        return Inertia::render('Participate', [
            'hash' => $hash,
            'activityId' => $activity_id
        ]);
    }

    // region viewTree

    /**
     * Show Tree status page.
     *
     * @param Request $request
     * @return Inertia
     */
    public function viewTree( Request $request, $tree_id ) {
        $hash = $request->query('hash');
        if(!isset($hash) || !validate_app_hash("TREE".$this->salt.$tree_id, $hash)){
            return Inertia::render('404');
        }

        return Inertia::render('ParticipateView', [
            'hash' => $hash,
            'treeId' => $tree_id
        ]);
    }


    // region Add

    /**
     * Add tree.
     *
     * @param Request $request
     * @return mixed
     */
    public function add( Request $request, $activity_id ){
        $data = $request->all();
        $data['activity_id'] = $activity_id;

        /**
         * Check if activity is found.
         */
        $activity = $this->absorb(
            $this->activity_repo->fetch( [
                'id' => $data['activity_id'],
            ] )
        );

        if ( $activity->isError() ) {
            return $this->absorb(
                $this->httpNotFoundResponse([
                    'message' => "Activity does not exists",
                ])
            )->json();
        }

        /**
         * Hash Validation
         */
        if(!isset($data['hash']) || !validate_app_hash("ACTIVITY".$this->salt.$data['activity_id'], $data['hash'])){
            return $this->absorb(
                $this->httpInternalServerResponse([
                    'message' => "Invalid app hash.",
                    'data' => []
                ])
            )->json();
        }

        /**
         * Entity validation and define
         */
        if( isset($data['full_name']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'full_name',
                'value' => $data[ 'full_name' ],
            ];
        }

        if( isset($data['email']) ){
            $data['where'] = []; // unset firstname & lastname
            $data['where'][] = [
                'operator' => '=',
                'target' => 'email',
                'value' => $data[ 'email' ],
            ];
        }

        if( isset($data['contact_number']) ){
            $data['where'] = []; // unset firstname & lastname
            $data['where'][] = [
                'operator' => '=',
                'target' => 'contact_number',
                'value' => $data[ 'contact_number' ],
            ];
        }

        $data['single'] = true;

        $entity = $this->absorb(
            $this->entity_repo->fetch( $data )
        );

        if ( $entity->isError() ) {

            $entity_creation = $this->absorb(
                $this->entity_repo->define( $data )
            );
            if ( $entity_creation->isError() ) {
                return $this->absorb(
                    $this->httpNotFoundResponse([
                        'message' => $entity_creation->getMessage(),
                    ])
                )->json();
            }

            $data['entity_id'] = $entity_creation->pluckData()->id;
        }

        if(!isset( $data['entity_id'] )) $data['entity_id'] = $entity->pluckData()->id;

        /**
         * Participant validation and define
         */
        $participant_params['single'] = true;
        $participant_params['where'] = [
            [
                'operator' => '=',
                'target' => 'entity_id',
                'value' => $data[ 'entity_id' ],
            ],
            [
                'operator' => '=',
                'target' => 'activity_id',
                'value' => $data[ 'activity_id' ],
            ]
        ];
        $participant = $this->absorb(
            $this->participant_repo->fetch( $participant_params )
        );

        if ( $participant->isError() ) {
            $participant_creation = $this->absorb(
                $this->participant_repo->define( [
                    'entity_id' => $data['entity_id'],
                    'activity_id' => $data['activity_id']
                ] )
            );
            if ( $participant_creation->isError() ) {
                return $this->absorb(
                    $this->httpNotFoundResponse([
                        'message' => $participant_creation->getMessage(),
                    ])
                )->json();
            }
        }

        /**
         * Prepare data for tree define
         */
        $data['planter_id'] = $data['entity_id'];
        $data['tree_status'] = 'Planted';

        /**
         * Define a tree
         */
        $tree = $this->absorb(
            $this->tree_repo->define( $data )
        );

        if ( $tree->isError() ) {
            return $this->absorb(
                $this->httpNotFoundResponse([
                    'message' => 'Failed to add tree.',
                    'data' => [
                        "exception" => $tree->getMessage (),
                    ]
                ])
            )->json();
        }

        $hash = app_hash("TREE".$this->salt.$tree->pluckData()->id);
        $url = $this->base_url."/participate/view/tree/".$tree->pluckData()->id."?hash=".$hash;

        return response()->json(
            Response::respond([
                "code" => 200,
                "message" => 'Successfully added a tree.',
                "data" => [
                    "tree_id" => $tree->data['trees']->id,
                    "hash" => $hash,
                    "url" => $url
                ]
            ])
        );

    }

    //endregion Add

    // region View

    /**
     * View a tree.
     *
     * @param Request $request
     * @return mixed
     */
    public function view( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        $data['single'] = true;

        /**
         * Check if the tree exists.
         */
        $tree = $this->absorb(
            $this->tree_repo->fetch( $data )
        );

        if ( $tree->isError() ) {
            return $this->absorb(
                $this->httpNotFoundResponse([
                    'message' => "Tree does not exists",
                    'data' => []
                ])
            )->json();
        }

        /**
         * Hash Validation
         */
        if(!isset($data['hash']) || !validate_app_hash("TREE".$this->salt.$data['id'], $data['hash'])){
            return $this->absorb(
                $this->httpInternalServerResponse([
                    'message' => "Invalid app hash.",
                    'data' => []
                ])
            )->json();
        }

        return $tree->json();
    }

    //endregion View
}
