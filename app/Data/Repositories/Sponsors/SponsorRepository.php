<?php

namespace App\Data\Repositories\Sponsors;

use App\Data\Models\Sponsors\Sponsor;
use App\Data\Repositories\BaseRepository;
use App\Data\Repositories\Entity\EntityRepository;

class SponsorRepository extends BaseRepository
{

    protected $sponsor, $entity_repo, $meta_index = "sponsors";

    /**
     * Instantiate class
     *
     * @param Sponsor $sponsor
     */
    public function __construct(
        Sponsor $sponsor,
        EntityRepository $entityRepository){
        $this->sponsor = $sponsor;
        $this->entity_repo = $entityRepository;
    }

    // region Define

    /**
     * Create a new sponsor or updates an existing one.
     *
     * @param array $data
     * @return SponsorRepository
     */
    public function define( $data=[] ){
        $sponsor = null;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid sponsor ID.",
                ]);
            }
        }

        if( isset( $data['id'] ) ){
            $sponsor  = $this->sponsor->find($data['id']);
            if( !$sponsor){
                return $this->httpNotFoundResponse([
                    'message' => "This sponsor does not exists",
                ]);
            }
        } else {
            $sponsor = refresh_model( $this->sponsor, $data );
        }

        foreach( $data as $key => $value ){
            if( in_array( $key, $sponsor->getFillable()) ){
                if( $sponsor->hasAttribute( $key ) ){
                    $sponsor->$key = $value;
                }
            }
        }

        if( !$sponsor->save() ){
            $error_message = $sponsor->errors();

            return $this->httpInternalServerResponse([
                'message' => "Sponsor definition was not successful.",
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully defined sponsor",
            'data' => [
                $this->meta_index => $sponsor,
            ]
        ]);

    }

    // endregion Define

    // region Delete

    /**
     * Delete a sponsor
     *
     * @param id
     * @return SponsorRepository
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
        $deleted_already =  $this->sponsor->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This sponsor does not exists.",
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
                "message" => "Sponsor was not deleted successfully",
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted sponsor",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch a sponsor's information.
     *
     * @param array $data
     * @return SponsorRepository
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

        $result = $this->fetchGeneric( $params, $this->sponsor );
        if( !$result ){
            return $this->httpNotFoundResponse([
                'message' => "This sponsor does not exists",
            ]);
        }

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully retrieved sponsor",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for sponsors with given parameters.
     *
     * @param array $data
     * @return SponsorRepository
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
            foreach( $this->sponsor->searchableColumns() as $column_  ){
                if ( str_contains( $column, $column_  )) {
                    $data['target'][$index] = $column_;
                }
            }
        }

        $builder = $this->genericSearch($data, $this->sponsor);

        $result = $builder->get()->all();

        if (!$result) {
            return $this->httpNotFoundResponse([
                'message' => 'No sponsors found.',
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData($data, $builder);

        return $this->httpSuccessResponse([
            "message" => "Successfully searched sponsors",
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
