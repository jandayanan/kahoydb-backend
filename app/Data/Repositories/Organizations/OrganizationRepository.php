<?php

namespace App\Data\Repositories\Organizations;

use App\Data\Models\Organizations\Organization;
use App\Data\Repositories\BaseRepository;
use App\Data\Repositories\Entity\EntityRepository;

class OrganizationRepository extends BaseRepository
{

    protected $organization, $entity_repo, $meta_index = "organizations";

    /**
     * Instantiate class
     *
     * @param Organization $organization
     * @param Organization $organization
     */
    public function __construct(
        Organization $organization,
        EntityRepository $entityRepository){
        $this->organization = $organization;
        $this->entity_repo = $entityRepository;
    }

    // region Define

    /**
     * Create a new organization or updates an existing one.
     *
     * @param array $data
     * @return OrganizationRepository
     */
    public function define( $data=[] ){
        $organization = null;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid organization ID.",
                ]);
            }
        }

        if( isset( $data['id'] ) ){
            $organization  = $this->organization->find($data['id']);
            if( !$organization){
                return $this->httpNotFoundResponse([
                    'message' => "This organization does not exists",
                ]);
            }
        } else {
            $organization = refresh_model( $this->organization, $data );
        }

        foreach( $data as $key => $value ){
            if( in_array( $key, $organization->getFillable()) ){
                if( $organization->hasAttribute( $key ) ){
                    $organization->$key = $value;
                }
            }
        }

        if( !$organization->save() ){
            $error_message = $organization->errors();

            return $this->httpInternalServerResponse([
                'message' => "Organization definition was not successful.",
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully defined organization",
            'data' => [
                $this->meta_index => $organization,
            ]
        ]);

    }

    /**
     * Create organization and entity
     *
     * @param array $data
     * @return OrganizationRepository
     */
    public function organizationEntity($data = []){
        $meta_index = 'entity';

        // region Validation

        $fillable = [
            'full_name' => 'Name',
            'organization_type' => 'Organization Type'
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

        if(!$this->organization->save($data)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("Data Validation Error."),
                "description" => _("An error was detected on one of the inputted data."),
                "data" =>   [
                    "errors" => $this->organization->errors(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully added a organization and entity."),
            'data' => [
                $this->meta_index => $this->organization,
                $meta_index => $entity->getData()['entity']
            ],
        ]);

    }

    // endregion Define

    // region Delete

    /**
     * Delete an organization
     *
     * @param id
     * @return OrganizationRepository
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
        $deleted_already =  $this->organization->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This organization does not exists.",
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
                "message" => "Organization was not deleted successfully",
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted organization",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an organization's information.
     *
     * @param array $data
     * @return OrganizationRepository
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

        $result = $this->fetchGeneric( $params, $this->organization );
        if( !$result ){
            return $this->httpNotFoundResponse([
                'message' => "This organization does not exists",
            ]);
        }

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully retrieved organization",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for organizations with given parameters.
     *
     * @param array $data
     * @return OrganizationRepository
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
            foreach( $this->organization->searchableColumns() as $column_  ){
                if ( str_contains( $column, $column_  )) {
                    $data['target'][$index] = $column_;
                }
            }
        }

        $builder = $this->genericSearch($data, $this->organization);

        $result = $builder->get()->all();

        if (!$result) {
            return $this->httpNotFoundResponse([
                'message' => 'No organizations found.',
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData($data, $builder);

        return $this->httpSuccessResponse([
            "message" => "Successfully searched organizations",
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
