<?php

namespace App\Http\Controllers\Organizations;

use App\Data\Repositories\Organizations\OrganizationRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class OrganizationController
 *
 * @property OrganizationRepository $organization_repo
 */
class OrganizationController extends BaseController
{

    protected $organization_repo;

    /**
     * Instantiate class with $organizationRepository
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(
        OrganizationRepository $organizationRepository){
        $this->organization_repo = $organizationRepository;
    }

    // region All

    /**
     * Fetch all organization.
     *
     * @param Request $request
     * @return OrganizationController
     */
    public function all( Request $request ){
        return $this->absorb(
            $this->organization_repo->fetch( $request->all() )
        )->json();
    }

    //endregion All

    // region Define

    /**
     * Create and Update organization.
     *
     * @param Request $request
     * @return OrganizationController
     */
    public function define( Request $request ){
        return $this->absorb(
            $this->organization_repo->define( $request->all() )
        )->json();

    }

    /**
     * Create and Update organization and entity.
     *
     * @param Request $request
     * @return OrganizationController
     */
    public function creation( Request $request ){
        return $this->absorb(
            $this->organization_repo->organizationEntity( $request->all() )
        )->json();

    }

    // endregion Define

    // region Delete

    /**
     * Delete an organization.
     *
     * @param Request $request
     * @param integer $id
     * @return OrganizationController
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->organization_repo->delete(
                $data
            )
        )->json();
    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an organization.
     *
     * @param Request $request
     * @param integer $id
     * @return OrganizationController
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->organization_repo->fetch(
                $data
            )
        )->json();

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Search an organization.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * url ?query='find'&target[]=columnname
     */
    public function search( Request $request ){
        return $this->absorb(
            $this->organization_repo->search( $request->all() )
        )->json();

    }

    // endregion Search Data

}
