<?php

namespace App\Http\Controllers\Auth;

use App\Data\Repositories\Auth\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{

    /**
     * @var UserRepository $user_repo
     */
    protected $user_repo;

    public function __construct(
        UserRepository $userRepository
    ){
        $this->user_repo = $userRepository;
    }

    /**
     * Fetch all user.
     *
     * @param  Request  $request
     * @return UserController
     */
    public function all(Request $request)
    {
        return $this->absorb(
            $this->user_repo->fetchUser( $request->all() )
        )->json();
    }

    /**
     * Create a new user or update existing.
     *
     * @param  Request  $request
     * @return UserController
     */
    public function define(Request $request)
    {
        return $this->absorb(
            $this->user_repo->defineUser( $request->all() )
        )->json();
    }

    /**
     * Delete a user.
     *
     * @param Request $request
     * @param integer $id
     * @return UserController
     */
    public function delete(Request $request, $id)
    {
        $data = array_merge( $request->all(),[
            'id' => $id
        ]);
        return $this->absorb(
            $this->user_repo->deleteUser( $data )
        )->json();
    }

    /**
     * Fetch a user by id.
     *
     * @param Request $request
     * @param integer $id
     * @return UserController
     */
    public function fetch(Request $request, $id)
    {
        $data = array_merge( $request->all(),[
            'id' => $id
        ]);
        return $this->absorb(
            $this->user_repo->fetchUser( $data )
        )->json();
    }

    /**
     * Create both entity and user resource.
     *
     * @param  Request  $request
     * @return UserController
     */
    public function register(Request $request)
    {
        return $this->absorb(
            $this->user_repo->register( $request->all() )
        )->json();
    }

    /**
     * Search a user.
     *
     * @param Request $request contains parameters target[] and query
     * @return mixed
     * @return UserController
     * url ?query='find'&target[]=columnname
     */
    public function search(Request $request)
    {
        return $this->absorb(
            $this->user_repo->searchUser( $request->all() )
        )->json();
    }

}
