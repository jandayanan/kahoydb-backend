<?php

namespace App\Data\Repositories\Trees;

use App\Data\Models\Organizations\Organization;
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

    // region Retrieve Summary Data

    /**
     * Fetch tree's summary.
     *
     * @param array $data
     * @return TreeRepository
     */
    public function fetchSummary( $data=[] )
    {
        if(!isset($data['tree_status'])){
            $data['tree_status'] = "planted";
        }

        if(isset($data['year'])){
            $years = [(object) [ 'year' => $data['year']]];
        } else {

            $years = json_decode(json_encode(
                \DB::table('trees')
                    ->select(\DB::raw('YEAR(created_at) as year'))
                    ->distinct()
                    ->get()
                    ->toArray()
                , true) );
        }

        $years = \DB::table('trees')
            ->select(\DB::raw('YEAR(trees.created_at) as year'), 'act.parent_organization_id', 'act.child_organization_id')
            ->leftjoin('activities as act', 'act.id', '=', 'trees.activity_id')
            ->distinct('act.parent_organization_id', 'act.child_organization_id');

        if(isset($data['year'])){
            $years = $years->whereRaw('YEAR(trees.created_at) = ?', [$data['year']]);
        }

        if(isset($data['organization_id'])){
            $years = $years->where('act.parent_organization_id', $data['organization_id']);
        }

        $years = $years->get()
            ->toArray();

        $result = [];
        if(!empty($years)){
            foreach($years as $key => $value){
                $monthly = \DB::table('trees')
                    ->whereRaw("YEAR(trees.created_at) = ". $value->year)
                    ->where('tree_status', $data['tree_status'])
                    ->leftjoin('activities as act', 'act.id', '=', 'trees.activity_id');

                if(!isset($data['organization_id'])){
                    if(!is_null($value->parent_organization_id)){
                        $org_id = $value->parent_organization_id;
                        $monthly = $monthly->where('act.parent_organization_id', $value->parent_organization_id);
                    } else {
                        $org_id = $value->child_organization_id;
                        $monthly = $monthly->where('act.child_organization_id', $value->child_organization_id);
                    }

                } else {
                    $org_id = $data['organization_id'];
                    if(isset($data['organization_type'])){
                        $org_type = $data['organization_type'] == 'parent' ? 'act.parent_organization_id' : 'act.child_organization_id';
                        $monthly = $monthly->where($org_type, $data['organization_id']);
                    } else {
                        $monthly = $monthly->where('act.parent_organization_id', $data['organization_id']);
                    }

                }

                $monthly = $monthly->select(\DB::raw('MONTH(trees.created_at) month, COUNT(*) as value'))
                    ->groupBy('month')
                    ->get()
                    ->toArray();

                $monthly = array_map(function($v){
                    return [$v['month'] => $v['value']];
                }, json_decode(json_encode($monthly), true));

                $total = 0;
                foreach ($monthly as $k_ => $v_ ) {
                    $total += array_values($v_)[0];
                }
                $result[$key][$value->year] = [
                    "year" => $value->year,
                    "total" => $total,
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                    "organization" => Organization::with(['entity'])->where('id', $org_id)->get()
                ];
                foreach( $monthly as $value_ ){
                    $result[$key][$value->year] = array_replace( $result[$key][$value->year], $value_ );
                }

            }
        }

        return $this->httpSuccessResponse([
            "message" => "Successfully retrieved trees summary",
            "data" => [
                $result
            ]
        ]);

    }

    // endregion Retrieve Summary Data

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
