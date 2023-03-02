<?php

namespace App\Data\Repositories\Trees;

use App\Data\Models\Trees\Tree;
use App\Data\Repositories\BaseRepository;

class TreeRepository extends BaseRepository
{

    protected $trees, $meta_index = "trees";

    /**
     * Instantiate class
     *
     * @param Tree $tree
     */
    public function __construct(
        Tree $tree ){
        $this->tree = $tree;
    }

    // region Define

    /**
     * Create a new tree or updates an existing one.
     *
     * @param array $data
     * @return TreeRepository
     */
    public function define( $data=[] ){
        $tree = null;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid tree ID.",
                ]);
            }
        }

        if(!isset($data['unique_id'])){
            $data['unique_id'] = quick_hash(now());
        }

        if( isset( $data['id'] ) ){
            $tree  = $this->tree->find($data['id']);
            if( !$tree){
                return $this->httpNotFoundResponse([
                    'message' => "This tree does not exists",
                ]);
            }
        } else {
            $tree = refresh_model( $this->tree, $data );
        }

        foreach( $data as $key => $value ){
            if( in_array( $key, $this->tree->getFillable()) ){
                if( $tree->hasAttribute( $key ) ){
                    $tree->$key = $value;
                }
            }
        }

        if( !$tree->save() ){
            $error_message = $tree->errors();

            return $this->httpInternalServerResponse([
                'message' => "Tree definition was not successful.",
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully defined tree",
            'data' => [
                $this->meta_index => $tree,
            ]
        ]);

    }

    // endregion Define

    // region Delete

    /**
     * Delete an tree
     *
     * @param id
     * @return TreeRepository
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
        $deleted_already =  $this->tree->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This tree does not exists.",
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
                "message" => "Tree was not deleted successfully",
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted tree",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an tree's information.
     *
     * @param array $data
     * @return TreeRepository
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
                $params['where'][] = [
                    'operator' => '=',
                    'target' => 'id',
                    'value' => $data[ 'id' ],
                ];
            }
        }

        if(isset($data['relations'])){
            $params['relations'] = $data['relations'];
        }

        $result = $this->fetchGeneric( $params, $this->tree );
        if( !$result ){
            return $this->httpNotFoundResponse([
                'message' => "This tree does not exists",
            ]);
        }

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully retrieved tree",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for trees with given parameters.
     *
     * @param array $data
     * @return TreeRepository
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
            foreach( $this->tree->searchableColumns() as $column_  ){
                if ( str_contains( $column, $column_  )) {
                    $data['target'][$index] = $column_;
                }
            }
        }

        $builder = $this->genericSearch($data, $this->tree);

        $result = $builder->get()->all();

        if (!$result) {
            return $this->httpNotFoundResponse([
                'message' => 'No trees found.',
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData($data, $builder);

        return $this->httpSuccessResponse([
            "message" => "Successfully searched trees",
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
