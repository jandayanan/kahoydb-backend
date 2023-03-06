<?php

namespace App\Http\Controllers\Sponsors;

use App\Data\Repositories\Sponsors\SponsorRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class SponsorController
 *
 * @property SponsorRepository $sponsor_repo
 */
class SponsorController extends BaseController
{

    protected $sponsor_repo;

    /**
     * Instantiate class with $sponsorRepository
     *
     * @param SponsorRepository $sponsorRepository
     */
    public function __construct(
        SponsorRepository $sponsorRepository){
        $this->sponsor_repo = $sponsorRepository;
    }

    // region All

    /**
     * Fetch all sponsor.
     *
     * @param Request $request
     * @return SponsorController
     */
    public function all( Request $request ){
        return $this->absorb(
            $this->sponsor_repo->fetch( $request->all() )
        )->json();
    }

    //endregion All

    // region Define

    /**
     * Create and Update sponsor.
     *
     * @param Request $request
     * @return SponsorController
     */
    public function define( Request $request ){
        return $this->absorb(
            $this->sponsor_repo->define( $request->all() )
        )->json();

    }

    /**
     * Create and Update sponsor and entity.
     *
     * @param Request $request
     * @return SponsorController
     */
    public function creation( Request $request ){
        return $this->absorb(
            $this->sponsor_repo->sponsorEntity( $request->all() )
        )->json();

    }

    // endregion Define

    // region Delete

    /**
     * Delete an sponsor.
     *
     * @param Request $request
     * @param integer $id
     * @return SponsorController
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->sponsor_repo->delete(
                $data
            )
        )->json();
    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch an sponsor.
     *
     * @param Request $request
     * @param integer $id
     * @return SponsorController
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->sponsor_repo->fetch(
                $data
            )
        )->json();

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Search an sponsor.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * url ?query='find'&target[]=columnname
     */
    public function search( Request $request ){
        return $this->absorb(
            $this->sponsor_repo->search( $request->all() )
        )->json();

    }

    // endregion Search Data

}
