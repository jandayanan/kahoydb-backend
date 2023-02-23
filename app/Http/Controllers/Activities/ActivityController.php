<?php

namespace App\Http\Controllers\Activities;

use App\Data\Repositories\Activities\ActivityRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 *
 * @property ActivityRepository $activity_repo
 */
class ActivityController extends BaseController
{

    protected $activity_repo;

    /**
     * Instantiate class with $activityRepository
     *
     * @param ActivityRepository $activityRepository
     */
    public function __construct(
        ActivityRepository $activityRepository){
        $this->activity_repo = $activityRepository;
    }

    // region All

    /**
     * Fetch all activity.
     *
     * @param Request $request
     * @return ActivityController
     */
    public function all( Request $request ){
        return $this->absorb(
            $this->activity_repo->fetch( $request->all() )
        )->json();
    }

    //endregion All

    // region Define

    /**
     * Create and Update activity.
     *
     * @param Request $request
     * @return ActivityController
     */
    public function define( Request $request ){
        return $this->absorb(
            $this->activity_repo->define( $request->all() )
        )->json();

    }

    // endregion Define

    // region Delete

    /**
     * Delete an activity.
     *
     * @param Request $request
     * @param integer $id
     * @return ActivityController
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->activity_repo->delete(
                $data
            )
        )->json();
    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an activity.
     *
     * @param Request $request
     * @param integer $id
     * @return ActivityController
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->activity_repo->fetch(
                $data
            )
        )->json();

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Search an activity.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * url ?query='find'&target[]=columnname
     */
    public function search( Request $request ){
        return $this->absorb(
            $this->activity_repo->search( $request->all() )
        )->json();

    }

    // endregion Search Data

}
