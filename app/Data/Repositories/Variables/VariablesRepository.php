<?php

namespace App\Data\Repositories\Variables;

use App\Data\Models\Variables\Variable;
use App\Data\Repositories\BaseRepository;

class VariablesRepository extends BaseRepository
{
    protected $variable, $meta_index= 'variable';

    /**
     * Instantiate class
     *
     * @param Variable $variable
     */
    public function __construct(
        Variable $variable
    ){
        $this->variable = $variable;
    }

    // region Define

    public function define( $data=[] ){
        $result = null;

        if( isset( $data['id'] ) ){
            $result  = $this->variable->find( $data['id'] );
            if( !$result ){
                return $this->httpNotFoundResponse([
                    'message' => _("This variable does not exists"),
                    'data' => [
                        'id' => $data['id']
                    ]
                ]);
            }
        } else {
            $result = refresh_model( $this->variable, $data );
        }

        $fresh = refresh_model( $this->variable );

        foreach( $data as $key => $value ){
            if( in_array( $key, $fresh->getFillable() ) ){
                if( $result->hasAttribute( $key ) ){
                    $result->$key = $value;
                }
            }
        }

        if( !$result->save() ){
            $error_message = $result->errors();

            return $this->httpInternalServerResponse([
                'message' => _( ucfirst($this->meta_index ) . " definition was not successful." ),
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse ([
            "message" => _("Successfully defined " . $this->meta_index),
            "data" => [
                $this->meta_index => $result,
            ]
        ]);
    }
    // endregion Define

    // region Delete

    /**
     * Deletes variable
     *
     * @param array $data
     * @return VariablesRepository
     */
    public function delete( $data=[] )
    {
        if( isset( $data['id']) ){
            if( !is_numeric( $data['id'] ) || $data['id']<= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => _("Invalid ID."),
                ]);

            }
        }

        $params = array_merge( $data, [
            "is_model" => true,
        ]);

        $result = $this->fetch( $params );
        $deleted_already =  $this->variable->withTrashed()->where( 'id', $data['id'] )->first();

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => _("This variable does not exists"),
            ]);
        }

        else if( $deleted_already->trashed() ){
            return $this->httpSuccessResponse([
                'message' =>  _('This variable already deleted'),
                'parameters' => [
                    'id' => $data['id']
                ]
            ]);
        }

        if( !$result->delete() ){
            return $this->httpInternalServerResponse([
                "message" => _("Variable was not deleted successfully"),
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => _("Successfully deleted variable"),
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch variable information.
     *
     * @param array $data
     * @return VariablesRepository
     */
    public function fetch( $data=[] )
    {
        $params = $data;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => _("Invalid ID."),
                ]);
            }

            $params = [
                'single' => true,
                'where' => [
                    [
                        'operator' => '=',
                        'target' => 'id',
                        'value' => $data['id'],
                    ]
                ]
            ];
        } else {
            $wheres = [];

            if( !empty( $wheres ) ){
                $params = [
                    'single' => true,
                    'where' => $wheres
                ];
            }
        }

        $result = $this->fetchGeneric( $params, $this->variable );

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        if( !$result ){
            $message =  _("No variable found on records.");
            if( isset( $data['id'] ) ) {
                $message =  _("This variable does not exists");
            }
            return $this->httpNotFoundResponse([
                'message' => $message,
            ]);
        }

        $index = get_plural ( $this->meta_index, $params );

        return $this->httpSuccessResponse([
            'message' => _("Successfully retrieved " . $index),
            'data' => [
                $index => $result,
            ]
        ]);
    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for variable with given parameters.
     *
     * @param array $data
     * @return VariablesRepository
     */
    public function search( $data = [] )
    {
        if ( !isset( $data['query'] ) ) {
            return $this->httpNotFoundResponse([
                "code" => 404,
                "message" => _("Query is not set"),
                "data" => [],
            ]);
        }

        $parameters = [
            "query" => $data['query'],
        ];

        if ( !is_array( $data['target'] ) ) {
            $data['target'] = explode(' ', $data['target']);
        }

        foreach ( (array) $data['target'] as $index => $column ) {
            foreach( $this->variable->searchableColumns() as $column_ ){
                if ( str_contains( $column, $column_  )) {
                    $data['target'][$index] = $column_;
                }
            }
        }

        $builder = $this->genericSearch( $data, $this->variable );

        $result = $builder->get()->all();

        if ( !$result ) {
            return $this->httpNotFoundResponse([
                'message' => _('No variable found.'),
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData( $data, $builder );

        return $this->httpSuccessResponse([
            "message" => _("Successfully searched variables"),
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
