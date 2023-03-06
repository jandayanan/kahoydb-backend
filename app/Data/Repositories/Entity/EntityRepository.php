<?php

namespace App\Data\Repositories\Entity;

use App\Data\Models\Entity\Entity;
use App\Data\Repositories\BaseRepository;

class EntityRepository extends BaseRepository
{
    /**
     * Defining entity model
     *
     * @var mixed $entity
     */
    protected $entity;

    public function __construct(
        Entity $entity){
        $this->entity = $entity;
    }

    /**
     * Create or update an entity
     *
     * @param array $data
     * @return mixed
     */
    public function define($data = []){
        //region existence check

        if (isset($data['id'])) {
            $does_exist = $this->entity->find($data['id']);

            if (!$does_exist) {
                return $this->httpNotFoundResponse([
                    'code'  => 404,
                    'message' => 'Entities ID does not exist.',
                ]);
            }
        }
        //endregion existence check

        //region insertion
        if (isset($data['id'])) {
            $entity = $this->entity->find($data['id']);

            if(isset($data['email'])){
                if($entity->email == $data['email']){
                    unset($data['email']);
                }
            }

            if(isset($data['contact_number'])){
                if($entity->contact_number == $data['contact_number']){
                    unset($data['contact_number']);
                }
            }
        } else {
            if (isset($data['email']) && $this->entity->where('email', $data['email'])->exists()) {
                return $this->httpInternalServerResponse([
                    'code' => 500,
                    'message' => "Email is already exists."
                ]);
            }
            if(isset($data['contact_number']) && $this->entity->where('contact_number', $data['contact_number'])->exists()){
                return $this->httpInternalServerResponse([
                    'code' => 500,
                    'message' => "Contact Number is already exists."
                ]);
            }
            $entity = $this->entity->init($this->entity->pullFillable($data));
        }

        if(!$entity->save($data)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => "Data Validation Error.",
                "description" => "An error was detected on one of the inputted data.",
                "data" =>   [
                    "errors" => $entity->errors(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => "Successfully defined an entity.",
            "data" => [
                'entity' => $entity,
            ],
        ]);
        //endregion insertion


    }

    /**
     * Delete an entity
     *
     * @param array $data
     * @return mixed
     */
    public function delete($data = []){
        if( !isset($data['id']) ||
            !is_numeric ( $data['id'] ) ||
            $data['id'] <= 0 ){
            return $this->httpNotFoundResponse([
                'code' => 404,
                'message' => "ID is not set."
            ]);
        }

        $record = $this->entity->find($data['id']);

        if(!$record){
            return $this->httpNotFoundResponse([
                "code" => 404,
                "message" => "Entities not found",
                "description" => "No entity found.",
                "data" =>  $data['id'],
            ]);
        }

        if(!$record->delete()){
            return $this->httpInternalServerResponse() ([
                "code" => 500,
                "message" => "Deleting entity was not successful.",
                "data" => $data['id'],
            ]);
        }

        $record->status = "inactive";

        if(!$record->save()){
            return $this->httpInternalServerResponse() ([
                "code" => 500,
                "message" => "Changing entity status was not successful.",
                "data" => $data['id'],
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => "Entities deleted",
            "description" => "An entity was deleted.",
            "data" =>  $record,
        ]);

    }

    /**
     * Fetch an entity by id
     *
     * @param array $data
     * @return mixed
     */
    public function fetch($data = []){
        $meta_index = "entity";
        $parameters = [];

        if (isset($data['id']) &&
            is_numeric($data['id'])) {

            $meta_index = "entity";
            $data['single'] = true;
            $data['where']  = [
                [
                    "target"   => "id",
                    "operator" => "=",
                    "value"    => $data['id'],
                ],
                [
                    "target" => "status",
                    "operator" => "=",
                    "value" => "active",
                ],
            ];

        }

        if ( isset($data['status']) && trim( $data['status'] ) !== "" && trim( $data['status'] ) !== "-" ) {
            $data['where'][] = [
                'operator' => '=',
                'target' => 'status',
                'value' => $data['status'],
            ];
        }

        $count_data = $data;
        $model = $this->makeModel($data, $this->entity);
        $result = $this->fetchGeneric($data, $model);

        if (!$result) {
            return $this->httpNotFoundResponse([
                'code'       => 404,
                'message'      => "No entities are found",
                "data"       => [
                    $meta_index => $result,
                ],
                "parameters" => $parameters,
            ]);
        }

        $count = is_array( $result ) ? count( $result ) : $this->countData($count_data, refresh_model($this->entity->getModel())) ;

        return $this->httpSuccessResponse([
            "code"       => 200,
            "message"      => "Successfully retrieved entity",
            "data"       => [
                $meta_index => $result,
                "count"     => $count,
            ],
            "parameters" => $parameters,
        ]);
    }

    /**
     * Search entities
     *
     * @param array $data
     * @return mixed
     */
    public function search($data = []){
        $result = $this->entity;

        $meta_index = "entities";
        $parameters = [
            "query" => $data['query'],
        ];

        $count_data = $data;
        $result = $this->genericSearch($data, $result)->get()->all();

        if(!$result){
            return $this->httpNotFoundResponse([
                'code'        => 404,
                'message'       => 'No entity item found.',
                'parameters'  => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count_data['search'] = true;
        $count = $this->genericSearch($count_data, refresh_model($this->entity->getModel()))->count();

        return $this->httpSuccessResponse([
            "code"       => 200,
            "message"      => "Successfully searched entities",
            "data"       => [
                $meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);
    }
}
