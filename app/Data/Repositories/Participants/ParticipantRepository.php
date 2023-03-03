<?php

namespace App\Data\Repositories\Participants;

use App\Data\Models\Participants\Participant;
use App\Data\Repositories\BaseRepository;
use App\Data\Repositories\Entity\EntityRepository;

class ParticipantRepository extends BaseRepository
{

    protected $participants, $entity_repo, $meta_index = "participants";

    /**
     * Instantiate class
     *
     * @param Participant $participant
     */
    public function __construct(
        Participant $participant,
        EntityRepository $entityRepository){
        $this->participant = $participant;
        $this->entity_repo = $entityRepository;
    }

    // region Define

    /**
     * Create a new participant or updates an existing one.
     *
     * @param array $data
     * @return ParticipantRepository
     */
    public function define( $data=[] ){
        $participant = null;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid participant ID.",
                ]);
            }
        }

        if( isset( $data['id'] ) ){
            $participant  = $this->participant->find($data['id']);
            if( !$participant){
                return $this->httpNotFoundResponse([
                    'message' => "This participant does not exists",
                ]);
            }
        } else {
            $participant = refresh_model( $this->participant, $data );
        }

        foreach( $data as $key => $value ){
            if( in_array( $key, $participant->getFillable()) ){
                if( $participant->hasAttribute( $key ) ){
                    $participant->$key = $value;
                }
            }
        }

        if( !$participant->save() ){
            $error_message = $participant->errors();

            return $this->httpInternalServerResponse([
                'message' => "Participant definition was not successful.",
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully defined participant",
            'data' => [
                $this->meta_index => $participant,
            ]
        ]);

    }

    /**
     * Create participant and entity
     *
     * @param array $data
     * @return ParticipantRepository
     */
    public function participantEntity($data = []){
        $meta_index = 'entity';

        // region Validation

        $fillable = [
            'activity_id' => 'Activity ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'contact_number' => 'Contact number'
        ];
        foreach($fillable as $key => $value) {
            if (!isset($data[$key])) {
                return $this->httpNotFoundResponse([
                    'code' => 404,
                    'message' => $value." is not set."
                ]);
            }
        }

        // endregion Validation

        $entity = $this->entity_repo->define($data);
        if((isset($entity) && !is_code_success( $entity->getCode() )) || is_null($entity)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => $entity->getMessage(),
                "description" => _("An error was detected on one of the inputted data."),
                "data" => $entity->getData()
            ]);
        }

        $data['entity_id'] = $entity->getData()['entity']->id;

        if(!$this->participant->save($data)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("Data Validation Error."),
                "description" => _("An error was detected on one of the inputted data."),
                "data" =>   [
                    "errors" => $this->participant->errors(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully added a participant and entity."),
            'data' => [
                $this->meta_index => $this->participant,
                $meta_index => $entity->getData()['entity']
            ],
        ]);

    }

    // endregion Define

    // region Delete

    /**
     * Delete an participant
     *
     * @param id
     * @return ParticipantRepository
     */
    public function delete($data=[]){
        if( isset( $data['id']) ){
            if( !is_numeric( $data['id'] ) || $data['id']<= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid ID.",
                ]);
            }
        }

        $params = array_merge( $data, [
            "is_model" => true,
        ]);

        $result = $this->fetch( $params );
        $deleted_already =  $this->participant->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This participant does not exists.",
            ]);
        }

        else if( $deleted_already->trashed() ){
            return $this->httpSuccessResponse([
                'message' => 'This id deleted already.',
                'parameters' => [
                    'id' => $data['id']
                ]
            ]);
        }

        if( !$result->delete() ){
            return $this->httpInternalServerResponse([
                "message" => "Participant was not deleted successfully",
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted participant",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an participant's information.
     *
     * @param array $data
     * @return ParticipantRepository
     */
    public function fetch( $data=[] ){
        $params = $data;

        if( isset( $data['id'] ) ){
            if( !is_array( $data['id'] ) ) {
                if ( !is_numeric ( $data[ 'id' ] ) ) {
                    return $this->httpInternalServerResponse ( [
                        'message' => "Invalid ID.",
                    ] );
                }

                $params = [
                    'single' => true,
                    'where' => [
                        [
                            'operator' => '=',
                            'target' => 'id',
                            'value' => $data[ 'id' ],
                        ]
                    ]
                ];
            } else {
                $params = [
                    'where' => [
                        [
                            'operator' => '=',
                            'target' => 'id',
                            'value' => $data[ 'id' ],
                        ]
                    ]
                ];
            }
        }

        if(isset($data['relations'])){
            $params['relations'] = $data['relations'];
        }

        $result = $this->fetchGeneric( $params, $this->participant );
        if( !$result ){
            return $this->httpNotFoundResponse([
                'message' => "This participant does not exists",
            ]);
        }

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully retrieved participant",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for participants with given parameters.
     *
     * @param array $data
     * @return ParticipantRepository
     */
    public function search($data = []){
        if (!isset($data['query'])) {
            return $this->httpNotFoundResponse([
                "code" => 404,
                "message" => "Query is not set",
                "data" => [],
            ]);
        }

        $parameters = [
            "query" => $data['query'],
        ];

        if (!is_array($data['target'])) {
            $data['target'] = explode(' ', $data['target']);
        }

        foreach ((array) $data['target'] as $index => $column) {
            foreach( $this->participant->searchableColumns() as $column_  ){
                if ( str_contains( $column, $column_  )) {
                    $data['target'][$index] = $column_;
                }
            }
        }

        $builder = $this->genericSearch($data, $this->participant);

        $result = $builder->get()->all();

        if (!$result) {
            return $this->httpNotFoundResponse([
                'message' => 'No participants found.',
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData($data, $builder);

        return $this->httpSuccessResponse([
            "message" => "Successfully searched participants",
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
