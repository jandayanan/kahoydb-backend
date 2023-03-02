<?php

namespace App\Http\Controllers\Participate;

use App\Data\Repositories\Activities\ActivityRepository;
use App\Data\Repositories\Entity\EntityRepository;
use App\Data\Repositories\Participants\ParticipantRepository;
use App\Data\Repositories\Trees\TreeRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class TreeController
 *
 */
class ParticipateController extends BaseController
{

    protected $activity_repo, $entity_repo, $participant_repo, $tree_repo;

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
    }

    // region Add

    /**
     * Add tree.
     *
     * @param Request $request
     * @return ParticipateController
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

        if( isset($data['first_name']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'first_name',
                'value' => $data[ 'first_name' ],
            ];
        }

        if( isset($data['last_name']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'last_name',
                'value' => $data[ 'last_name' ],
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

        if ( $activity->isError() ) {
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

            $data['entity_id'] = $entity->pluckData()->id;
        }

        if(!isset( $data['entity_id'] )) $data['entity_id'] = $entity->pluckData()->id;

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

        $data['planter_id'] = $data['entity_id'];
        $data['tree_status'] = 'planted';

        return $this->absorb(
            $this->tree_repo->define( $data )
        )->json();

    }

    //endregion Add

}
