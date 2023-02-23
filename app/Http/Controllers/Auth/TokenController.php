<?php

namespace App\Http\Controllers\Auth;

use App\Data\Repositories\Auth\TokenRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class TokenController extends BaseController
{

    /**
     * @var TokenRepository $token_repo
     */
    protected $token_repo;

    public function __construct(
        TokenRepository $tokenRepository
    ){
        $this->token_repo = $tokenRepository;
    }

    /**
     * Login a user.
     *
     * @return TokenController
     */
    public function login(Request $request) {
        return $this->absorb(
            $this->token_repo->login( $request->all() )
        )->json();
    }

}
