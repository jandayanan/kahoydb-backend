<?php

namespace App\Data\Repositories\Auth;

use App\Data\Repositories\BaseRepository;
use App\Data\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Data\Repositories\Auth\UserRepository;

class TokenRepository extends BaseRepository
{
    use HasApiTokens;

    protected $user, $user_repo;

    public function __construct(
        User $user,
        UserRepository $userRepository
    ){
        $this->user = $user;
        $this->user_repo = $userRepository;
    }

    /**
     * Login a user.
     *
     * @param array $data
     * @return TokenRepository
     */
    public function login($data = [])
    {
        $token_name = 'KahoyToken';
        $scope = [];

        //region data validation
        if (!isset($data['username'])) {
            return $this->httpNotFoundResponse([
                'code' => 404,
                'message' => "Username is not set."
            ]);
        }
        if (!isset($data['password']) &&  strlen($data['password']) <= 6 ){
            return $this->httpInternalServerResponse([
                'code' => 500,
                'message' => "Password is invalid."
            ]);
        }
        //endregion data validation

        $user = $this->user->where('username', $data['username'])->get()->first();

        if(!$user || !Hash::check($data['password'], $user->password)) {
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("The provided credentials are incorrect."),
            ]);
        }

        $user->save();

        if (isset($data['token_name'])) {
            $token_name = $data['token_name'];
        }

        if (isset($data['scope'])) {
            $scope = $data['scope'];
        }

        $token = $user->createToken($token_name, $scope)->plainTextToken;

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully logged in a users."),
            "data" => [
                'token' => $token,
                'user' => $user
            ]
        ]);

        //endregion insertion
    }

}
