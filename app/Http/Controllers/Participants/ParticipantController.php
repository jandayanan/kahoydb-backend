<?php

namespace App\Http\Controllers\Participants;

use App\Data\Repositories\Participants\ParticipantRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class ParticipantController
 *
 * @property ParticipantRepository $participant_repo
 */
class ParticipantController extends BaseController
{

    protected $participant_repo;

    /**
     * Instantiate class with $participantRepository
     *
     * @param ParticipantRepository $participantRepository
     */
    public function __construct(
        ParticipantRepository $participantRepository){
        $this->participant_repo = $participantRepository;
    }

    // region All

    /**
     * Fetch all participant.
     *
     * @param Request $request
     * @return ParticipantController
     */
    public function all( Request $request ){
        return $this->absorb(
            $this->participant_repo->fetch( $request->all() )
        )->json();
    }

    //endregion All

    // region Define

    /**
     * Create and Update participant.
     *
     * @param Request $request
     * @return ParticipantController
     */
    public function define( Request $request ){
        return $this->absorb(
            $this->participant_repo->define( $request->all() )
        )->json();

    }

    // endregion Define

    // region Delete

    /**
     * Delete a participant.
     *
     * @param Request $request
     * @param integer $id
     * @return ParticipantController
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->participant_repo->delete(
                $data
            )
        )->json();
    }

    // endregion Delete

    // region Retrieve Data

    /**
     * Fetch a participant.
     *
     * @param Request $request
     * @param integer $id
     * @return ParticipantController
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb(
            $this->participant_repo->fetch(
                $data
            )
        )->json();

    }

    // endregion Retrieve Data

    // region Search Data

    /**
     * Search a participant.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * url ?query='find'&target[]=columnname
     */
    public function search( Request $request ){
        return $this->absorb(
            $this->participant_repo->search( $request->all() )
        )->json();

    }

    // endregion Search Data

}
