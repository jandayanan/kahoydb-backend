<?php

namespace App\Http\Controllers\Trees;

use App\Data\Repositories\Trees\TreeRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class TreeController
 *
 * @property TreeRepository $tree_repo
 */
class TreeController extends BaseController
{

    protected $tree_repo;

    /**
     * Instantiate class with $treeRepository
     *
     * @param TreeRepository $treeRepository
     */
    public function __construct(
        TreeRepository $treeRepository){
        $this->tree_repo = $treeRepository;
    }

    // region All

    /**
     * Fetch all tree.
     *
     * @param Request $request
     * @return TreeController
     */
    public function all( Request $request ){
        $data = $request->all();
        if( isset($data['tree_type']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'tree_type',
                'value' => $data[ 'tree_type' ],
            ];
        }

        if( isset($data['tree_species']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'tree_species',
                'value' => $data[ 'tree_species' ],
            ];
        }

        if( isset($data['tree_status']) ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'tree_status',
                'value' => $data[ 'tree_status' ],
            ];
        }

        return $this->absorb(
            $this->tree_repo->fetch( $data )
        )->json();
    }

    //endregion All

    // region Define

    /**
     * Create and Update tree.
     *
     * @param Request $request
     * @return TreeController
     */
    public function define( Request $request ){
        return $this->absorb(
            $this->tree_repo->define( $request->all() )
        )->json();

    }

    // endregion Define

    // region Delete

    /**
     * Delete an tree.
     *
     * @param Request $request
     * @param integer $id
     * @return TreeController
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->tree_repo->delete(
                $data
            )
        )->json();
    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch a tree.
     *
     * @param Request $request
     * @param integer $id
     * @return TreeController
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->tree_repo->fetch(
                $data
            )
        )->json();

    }

    // endregion Retrieve Data

    // region Retrieve Summary Data

    /**
     * Fetch a summary data for a tree.
     *
     * @param Request $request
     * @return TreeController
     */
    public function fetchSummary( Request $request ){
        $data = $request->all();
        return $this->absorb(
            $this->tree_repo->fetchSummary(
                $data
            )
        )->json();

    }

    // endregion Retrieve Summary Data

    // region Search Data

    /**
     * Search a tree.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * url ?query='find'&target[]=columnname
     */
    public function search( Request $request ){
        return $this->absorb(
            $this->tree_repo->search( $request->all() )
        )->json();

    }

    // endregion Search Data

}
