<?php

namespace App\Data\Repositories\Activities;

use App\Data\Models\Activities\Activity;
use App\Data\Repositories\BaseRepository;

class ActivityRepository extends BaseRepository
{

    protected $activities, $meta_index = "activities";

    /**
     * Instantiate class
     *
     * @param Activity $activity
     */
    public function __construct(
        Activity $activity ){
        $this->activity = $activity;
    }

    // region Define

    /**
     * Create a new activity or updates an existing one.
     *
     * @param array $data
     * @return ActivityRepository
     */
    public function define( $data=[] ){
        $activity = null;

        if( isset( $data['id'] ) ){
            if( !is_numeric( $data['id'] ) || $data['id'] <= 0 ){
                return $this->httpInternalServerResponse([
                    'message' => "Invalid activity ID.",
                ]);
            }
        }

        if( isset( $data['id'] ) ){
            $activity  = $this->activity->find($data['id']);
            if( !$activity){
                return $this->httpNotFoundResponse([
                    'message' => "This activity does not exists",
                ]);
            }
        } else {
            $activity = refresh_model( $this->activity, $data );
        }

        foreach( $data as $key => $value ){
            if( in_array( $key, $this->activity->getFillable()) ){
                if( $activity->hasAttribute( $key ) ){
                    $activity->$key = $value;
                }
            }
        }

        if( !$activity->save() ){
            $error_message = $activity->errors();

            return $this->httpInternalServerResponse([
                'message' => "Activity definition was not successful.",
                'data' => [
                    'errors' => $error_message,
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully defined activity",
            'data' => [
                $this->meta_index => $activity,
            ]
        ]);

    }

    // endregion Define

    // region Delete

    /**
     * Delete an activity
     *
     * @param array $data
     * @return ActivityRepository
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
        $deleted_already =  $this->activity->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This activity does not exists.",
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
                "message" => "Activity was not deleted successfully",
                "data" => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted activity",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an activity's information.
     *
     * @param array $data
     * @return ActivityRepository
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

        $result = $this->fetchGeneric( $params, $this->activity );
        if( !$result ){
            return $this->httpNotFoundResponse([
                'message' => "This activity does not exists",
            ]);
        }

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully retrieved activity",
            'data' => [
                $this->meta_index => $result,
            ]
        ]);

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Searches for activities with given parameters.
     *
     * @param array $data
     * @return ActivityRepository
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
            foreach( $this->activity->searchableColumns() as $column_  ){
                  if ( str_contains( $column, $column_  )) {
                      $data['target'][$index] = $column_;
                  }
            }
        }

        $builder = $this->genericSearch($data, $this->activity);

        $result = $builder->get()->all();

        if (!$result) {
            return $this->httpNotFoundResponse([
                'message' => 'No activities found.',
                'parameters' => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        $count = $this->countData($data, $builder);

        return $this->httpSuccessResponse([
            "message" => "Successfully searched activities",
            "data" => [
                $this->meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);

    }

    //endregion Search Data

}
