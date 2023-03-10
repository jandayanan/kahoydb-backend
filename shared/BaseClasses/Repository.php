<?php

namespace Shared\BaseClasses;

use Shared\BaseClasses\Model;
use Shared\Traits\Response;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseRepository
 * @package Shared\BaseClasses
 */
abstract class Repository
{
    use \Shared\Traits\Response;
    use \Shared\Traits\Loggable;

    protected $data_index;

    protected $config = [
        "soft_limit" => 1000,
    ];

    protected $states = [
        "soft_limited" => true,
    ];

    /**
     * List of default index order conditions.
     *
     * @var array
     */
    private $index_order = [
        'order_conditions' => [
            'sort' => 'sort_index',
            'order' => 'desc',
        ],
    ];

    /**
     * List of exempted fields.
     *
     * @var array
     */
    protected $no_sort = [];


    // region Shared functions

    /**
     * Counts the number of elements in a given data set.
     *
     * @param $data
     * @param $model
     * @return integer
     */
    public function countData($data, $model)
    {
        $remove = [
            'single',
            'offset',
            'limit',
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, $remove)) {
                unset($data[$key]);
            }
        }

        $data['count'] = true;

        if (isset($data['search']) && $data['search'] == true) {
            return $this->genericSearch($data, $model);
        } else {
            return $this->fetchGeneric($data, $model);
        }

    }

    /**
     * A generic fetch function to retrieve data
     * based on provided parameters
     *
     * @param $data
     * @param \Shared\BaseClasses\Model $model
     * @return Model
     */
    protected function fetchGeneric($data, &$model)
    {
        $result = null;

        //region Selection
        if ( isset( $data[ 'columns' ] ) ) {
            if (is_array($data['columns']) ||
                ($data['columns'] !== "" && !is_array($data['columns']))) {
                if ( is_multidimensional($data['columns']) ) {
                    $columns = [];
                    array_walk_recursive($data['columns'], function ($item, $key) use (&$columns) {
                        if ($key == 'data') {
                            $columns[] = $item;
                        }

                    });
                    $data['columns'] = $columns;

                }
                $model = $model->select($data['columns']);

            }
        }
        //endregion Selection

        //region Logical Conditions
        if (isset($data['where'])) {
            foreach ((array) $data['where'] as $key => $conditions) {
                if( is_multidim ( $conditions ) ){
                    $model = $model->orWhere( function( $root_model ) use ( $conditions ) {
                        foreach ( (array)$conditions as $key => $sub_conditions ) {
                            $root_model->where ( function ( $submodel ) use ( $sub_conditions ) {
                                if ( isset( $sub_conditions[ 'target' ] ) || isset( $sub_conditions[ 'value' ] ) ) {
                                    if ( isset( $sub_conditions[ 'value' ] )
                                        && is_array ( $sub_conditions[ 'value' ] )
                                        && $sub_conditions[ 'operator' ] == '=' ) {
                                        $submodel->whereIn ( $sub_conditions[ 'target' ], $sub_conditions[ 'value' ] );
                                    } else if ( isset( $sub_conditions[ 'value' ] )
                                        && is_array ( $sub_conditions[ 'value' ] )
                                        && $sub_conditions[ 'operator' ] == '!=' ) {
                                        $submodel->whereNotIn ( $sub_conditions[ 'target' ], $sub_conditions[ 'value' ] );
                                    } else {
                                        $submodel->where ( $sub_conditions[ 'target' ], $sub_conditions[ 'operator' ], $sub_conditions[ 'value' ] );
                                    }
                                }
                            } );
                        }
                    });
                } else if( isset( $conditions['target'] ) || isset( $conditions['value'] ) ){
                    if (isset($conditions['value'])
                        && is_array($conditions['value'])
                        && $conditions['operator'] == '=') {
                        $model = $model->whereIn($conditions['target'], $conditions['value']);
                    } else if (isset($conditions['value'])
                        && is_array($conditions['value'])
                        && $conditions['operator'] == '!=') {
                        $model = $model->whereNotIn($conditions['target'], $conditions['value']);
                    } else {
                        $model = $model->where($conditions['target'], $conditions['operator'], $conditions['value']);
                    }
                }
            }
        }

        if (isset($data['where_between'])) {
            $model = $model->where(function ($query) use ($data) {
                foreach ((array) $data['where_between'] as $key => $conditions) {
                    if (isset($conditions['prepend']) && $conditions['prepend'] == 'or') {
                        $query->orWhere( function( $qry ) use ($data, $conditions, $key) {
                            $qry->whereBetween($conditions['target'], [$conditions['from'], $conditions['to']]);
                        });
                    } else {
                        $query->where( function( $qry ) use ($data, $conditions, $key) {
                            $qry->whereBetween($conditions['target'], [$conditions['from'], $conditions['to']]);
                        });
                    }
                }

                if (isset($data['where_range'])) {
                    $query->orWhere(function ($nested_query) use ($data) {
                        foreach ((array) $data['where_range'] as $key => $conditions) {
                            $nested_query->where($conditions['target'], $conditions['operator'], $conditions['value']);
                        }
                    });
                }
            });

        }

        if (isset($data['where_raw'])) {
            foreach ((array) $data['where_raw'] as $statement => $datum ) {
                $model = $model->whereRaw($statement, $datum);
            }
        }

        if (isset($data['where_date'])) {
            foreach ((array) $data['where_date'] as $key => $conditions) {
                $model = $model->whereDate($conditions['target'], $conditions['operator'], $conditions['value']);
            }
        }

        if(isset($data['where_in'])) {
            foreach ((array) $data['where_in'] as $key => $conditions) {
                $model = $model->whereIn($conditions['target'], $conditions['value']);
            }
        }

        if (isset($data['where_year'])) {
            foreach ((array) $data['where_year'] as $key => $conditions) {
                $model = $model->whereYear($conditions['target'], $conditions['operator'], $conditions['value']);
            }
        }

        if (isset($data['where_has'])) {
            foreach ((array) $data['where_has'] as $key => $conditions) {
                $model = $model->whereHas($conditions['relation'], function ($query) use ($conditions) {
                    foreach ((array) $conditions['query'] as $q) {
                        if ($q['target'] === 'filter_year') {
                            $query->whereYear('start_date', '=', $q['value']);
                        } else {
                            $query->where($q['target'], $q['operator'], $q['value']);
                        }
                    }
                });
            }
        }

        // region Fuzzy Search

        if (isset($data['target'])) {
            $model = $model->where(function ($query) use ($data, $model) {
                foreach ((array) $data['target'] as $column) {
                    if ($query->getModel()->isSearchable($column)) {
                        if (str_contains($column, ".")) {
                            $search_components = explode(".", $column);

                            $query = $query->with($search_components[0]);

                            $query = $query->orWhereHas($search_components[0], function ($q) use ($data, $column, $search_components) {
                                $q->where($search_components[1], "LIKE", $this->generateSearchTerm($data, $column));
                            });
                        } else {
                            $query = $query->orWhere($column, "LIKE", $this->generateSearchTerm($data, $column));
                        }
                    }
                }

                if (isset($data['order'])) {
                    foreach ((array) $data['order'] as $column => $order) {
                        $query = $query->orderBy($column, $order);
                    }
                }

            });
        }

        // endregion Fuzzy Search
        //endregion Logical Conditions

        //region Data Relation
        if (isset($data['relations'])) {
            if (!is_array($data['relations'])) {
                $data['relations'] = (array) $data['relations'];
            }
            $model = $model->with(array_map('Illuminate\Support\Str::camel', $data['relations']));
        }
        //endregion Data Relation

        //region Data Presentation
        if (isset($data['limit']) && $data['limit'] && is_numeric($data['limit'])) {
            $model = $model->take($data['limit']);
        } else {
            if( isset( $this->config['soft_limit'] ) &&
                $this->config['soft_limit'] > 0 &&
                $this->states['soft_limited'] === true ){
                $model = $model->take( $this->config['soft_limit'] );
            }
        }

        if (isset($data['offset']) && $data['offset'] && is_numeric($data['offset'])) {
            $model = $model->offset($data['offset']);
        }

        if (isset($data['sort']) && !in_array($data['sort'], $this->no_sort)) {
            $model = $model->orderBy($data["sort"], $data['order'] ?? 'asc');
        }

        if (isset($data['sort_raw']) ) {
            $model = $model->orderByRaw ( $data['sort_raw'] );
        }

        if (isset($data['distinct']) && $data['distinct'] === true ) {
            $model->distinct ();
        }

        if (isset($data['count']) && $data['count'] === true) {
            return $model->get()->count();
        }

        if (isset($data['group_by'])) {
            $result = $model->groupBy($data['group_by']);
        }

        /**
         * Dumps query for debugging
         */
        if( isset( $data['dump_sql'] ) && $data['dump_sql'] === true ){
            var_dump( dump_query( $model ) );
        }

        if( isset( $data['ddump_sql'] ) && $data['ddump_sql'] === true ){
            dd( dump_query( $model ) );
        }

        if( isset($data['dump_data']) && $data['dump_data'] === true ) var_dump( $data );

        if( isset($data['dump_result']) && $data['dump_result'] === true ) dd( $result );

        if (isset($data['single']) && $data['single'] === true) {
            $result = $model->get()->first();
        } else if (isset($data['sort']) && in_array($data['sort'], $this->no_sort)) {
            $result = $model->get();

            if (in_array($data['sort'], $this->no_sort)) {
                if (isset($data['order']) && $data['order'] == 'desc') {
                    $result = $result->sortByDesc($data['sort'])->values()->all();
                } else {
                    $result = $result->sortBy($data['sort'])->values()->all();
                }
            }
        } else {
            if (isset($data['as_array']) && $data['as_array'] === true) {
                $result = $model->get()->toArray ();
            } else if (isset($data['as_builder']) && $data['as_builder'] === true) {
                $result = $model;
            } else {
                if (isset($data['paginate']) && $data['paginate'] && is_numeric($data['paginate'])) {
                    return $model->paginate($data['paginate']);
                }

                $result = $model->get()->all();
            }
        }


        //endregion Data Presentation


        return $result;
    }

    /**
     * Builds on top of existing Builder query and returns appropriate "search-like" query
     * Accepts params of `target` for specifying which columns to search
     * Note that you should define the `searchable` columns inside your model's $searchable property
     * Also accepts params of `order` for ordering based on a specific column
     * Also accepts `terms[column]` for specifying search term type
     *
     * @param $data
     * @param Builder|Model $model
     * @return Builder
     */
    protected function genericSearch($data, $model=null )
    {
        //region Selection
        //endregion Selection

        //region Logical Conditions
        $model = $model->where(function ($query) use ($data, $model) {
            if (isset($data['target'])) {
                foreach ((array) $data['target'] as $column) {
                    if ($query->getModel()->isSearchable($column)) {
                        if (str_contains($column, ".")) {
                            $search_components = explode(".", $column);

                            $query = $query->with($search_components[0]);

                            $query = $query->orWhereHas($search_components[0], function ($q) use ($data, $column, $search_components) {
                                $q->where($search_components[1], "LIKE", $this->generateSearchTerm($data, $column));
                            });
                        } else {
                            $query = $query->orWhere($column, "LIKE", $this->generateSearchTerm($data, $column));
                        }
                    }
                }
            }

            if (isset($data['order'])) {
                foreach ((array) $data['order'] as $column => $order) {
                    $query = $query->orderBy($column, $order);
                }
            }

        });

        if (isset($data['where'])) {
            foreach ((array) $data['where'] as $key => $conditions) {
                if (is_array($conditions['value']) && $conditions['operator'] == '=') {
                    $model = $model->whereIn($conditions['target'], $conditions['value']);
                } else if (is_array($conditions['value']) && $conditions['operator'] == '!=') {
                    $model = $model->whereNotIn($conditions['target'], $conditions['value']);
                } else {
                    $model = $model->where($conditions['target'], $conditions['operator'], $conditions['value']);
                }
            }
        }
        //endregion Logical Conditions

        //region Data Relation
        if (isset($data['relations'])) {
            if (!is_array($data['relations'])) {
                $data['relations'] = (array) $data['relations'];
            }
            $model = $model->with(array_map('Illuminate\Support\Str::camel', $data['relations']));
        }
        //endregion Data Relation

        //region Data Presentation
        if (isset($data['limit']) && $data['limit'] && is_numeric($data['limit'])) {
            $model = $model->take($data['limit']);
        }

        if (isset($data['offset']) && $data['offset'] && is_numeric($data['offset'])) {
            $model = $model->offset($data['offset']);
        }

        if (isset($data['sort']) && !in_array($data['sort'], $this->no_sort)) {
            $model = $model->orderBy($data["sort"], $data['order'] ?? 'asc');
        }

        if (isset($data['count']) && $data['count'] === true) {
            return $model->get()->count();
        }
        //endregion Data Presentation

        return $model;
    }

    /**
     * Creates search term used by genericSearch
     *
     * @param array $data
     * @param string $column
     * @return string
     */
    protected function generateSearchTerm($data, $column = "")
    {
        if(isset($data['query'])){
            $term = "%" . $data['query'] . "%";

            if (isset($data['term'][$column])) {
                switch ($data['term'][$column]) {
                    case "left":
                        $term = "%" . $data['query'];
                        break;
                    case "right":
                        $term = $data['query'] . "%";
                        break;
                    case "none":
                        $term = $data['query'];
                        break;
                }
            }

            return $term;
        }
    }

    /**
     * Get auto generated and ordered index from a given model.
     *
     * @param array $data
     * @param model $model
     * @return mixed
     */
    protected function getIndexIncrement($data = [], $model=null )
    {
        //region validation
        $order = null;

        if (!isset($data['order_conditions'])) {
            $order = $this->index_order['order_conditions'];
        } else {
            $order = $data['order_conditions'];
            unset($data['order_conditions']);
        }

        $data = \array_merge($data, $order);
        //endregion validation

        //region execution
        $result = $this->fetchGeneric($data, $model);

        if (!$result) {
            return 1; //default index
        }

        return \intval($result[$order['sort']]) + 1;
        //endregion execution
    }

    /**
     * Recomputes the indices in order from a given model.
     *
     * @param array $data
     * @param model $model
     * @return boolean
     */
    protected function recomputeIndicesIncrement($data = [], $model=null )
    {
        //region validation
        if (!isset($data['id'])) {
            return false;
        }

        $order = null;

        if (!isset($data['order_conditions'])) {
            $order = $this->index_order['order_conditions'];
        } else {
            $order = $data['order_conditions'];
            unset($data['order_conditions']);
        }

        $data = \array_merge($data, $order);
        //endregion validation

        //region execution
        $result = $this->fetchGeneric($data, $model);

        foreach ($result as $key => $model_item) {
            $model_item->sort_index = $key + 1;

            if (!$model_item->save()) {
                return false;
            }
        }

        return true;
        //endregion execution
    }

    // region Query Helpers
    protected function checkSoftLimits( &$data ){
        if( isset( $data['no_soft_limit'] ) && $data['no_soft_limit'] === true ){
            $this->states['soft_limited'] = false;
            $this->config['soft_limit'] = 0;
        }
    }

    protected function makeModel( $data, $model ){
        if( isset( $data['fresh']) && $data['fresh'] == true ){
            $model = refresh_model ($model);
        }

        return $model;
    }
    // endregion Query Helpers

    // region Response Management
    protected function buildData( $data ){
        return $data;
    }

    protected function getDataIndex( $count=1, $override="" ){
        $index = $this->data_index;

        if( !is_numeric( $count ) ){
            if( $count instanceof \Countable || is_array($count) ){
                $original = $count;
                $count = count( $count );
            }
        }

        $functions = [
//            '_',
            'Str::plural' => [
                $index,
                $count,
            ],
            'ucfirst' => [$index],
        ];

        if( trim($override) != "" ){
            $index = $override;
        }

        foreach( $functions as $function => $params ){
            $index = call_user_func_array( $function, $params );
        }

        return $index;
    }
    // endregion Response Management

    // endregion Shared functions
}
