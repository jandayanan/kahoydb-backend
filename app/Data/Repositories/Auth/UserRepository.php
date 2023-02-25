<?php

namespace App\Data\Repositories\Auth;


use App\Data\Repositories\BaseRepository;
use App\Data\Repositories\Entity\EntityRepository;
use App\Data\Models\Auth\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    use HasApiTokens;

    protected $user, $entity_repo, $reset_flag;

    public function __construct(
        User $user,
        EntityRepository $entityRepo
    ){
        $this->user = $user;
        $this->entity_repo = $entityRepo;
        $this->no_sort = [
            'full_name',
            'first_name',
            'last_name',
        ];
    }

    /**
     * Create a new user or updates an existing one.
     *
     * @param array $data
     * @return UserRepository
     */
    public function defineUser($data = [])
    {

        // region Data Validation

        if(!isset($data['id'])){

            if(!isset($data['entity_id']) ||
                !is_numeric ( $data['entity_id'] ) ||
                $data['entity_id'] <= 0 ){

                return $this->httpNotFoundResponse([
                    'code' => 404,
                    'message' => "Entities ID is not set."
                ]);
            }

            $fillable = [
                'username',
                'password',
            ];
            foreach($fillable as $value) {
                if (!isset($data[$value])) {
                    return $this->httpNotFoundResponse([
                        'code' => 404,
                        'message' => ucfirst($value)." is not set."
                    ]);
                }
            }

        }

        // endregion Data Validation

        // region Saving Record

        if (isset($data['id'])) {
            $user = $this->user->find($data['id']);

            // region Existence Check
            if (!$user) {
                return $this->httpNotFoundResponse([
                    'code'  => 404,
                    'message' => 'User ID does not exist.',
                ]);
            }
            // endregion Existence Check

            if(isset($data['username'])){
                if($user->username == $data['username']){
                    unset($data['username']);
                }
            }
            $execute = $user->update($data);
        } else {

            // region Check if exists
            $username_check = $this->user->where('username', $data['username'])->get()->first();
            if(isset($username_check)){
                return $this->httpInternalServerResponse([
                    'code' => 500,
                    'message' => "Username is already taken."
                ]);
            }
            // endregion Check if exists

            $user = $this->user;
            $execute = $user->save($data);
        }

        if(!$execute){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("Data Validation Error."),
                "description" => _("An error was detected on one of the inputted data."),
                "data" =>   [
                    "errors" => $user->errors(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully defined a user."),
            "parameters" => $user,
        ]);

        // endregion Saving Record

    }

    /**
     * Delete a user
     *
     * @param array $data
     * @return UserRepository
     */
    public function deleteUser($data = [])
    {
        $meta_index = 'user';

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

        $result = $this->fetchUser( $params );

        $deleted_already = $this->user->withTrashed()->where('id', $data['id'])->first();;

        if( !$deleted_already ){
            return $this->httpNotFoundResponse([
                'message' => "This user does not exists",
            ]);
        }

        if( $deleted_already->trashed() ){
            return $this->httpSuccessResponse([
                'message' =>  'This id deleted already.',
                'parameters' => [
                    'id' => $data['id']
                ]
            ]);
        }

        if( !$result->delete() ){
            return $this->httpInternalServerResponse([
                'message' => "Deleting user was not successful.",
                'data' => [
                    "errors" => $result->delete(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            'message' => "Successfully deleted a user.",
            'data' => [
                $meta_index => $result,
            ]
        ]);

    }

    /**
     * Fetch users.
     *
     * @param array $data
     * @return UserRepository
     */
    public function fetchUser($data = [])
    {
        $meta_index = "users";
        $parameters = [];

        if (isset($data['id']) &&
            is_numeric($data['id'])) {


            $data['single'] = true;
            $data['where']  = [
                [
                    "target"   => "id",
                    "operator" => "=",
                    "value"    => $data['id'],
                ],
            ];

        }

        if ( isset($data['entity_id']) && trim( $data['entity_id'] ) !== "" && trim( $data['entity_id'] ) !== "-" ){
            $data['where'][] = [
                'operator' => '=',
                'target' => 'entity_id',
                'value' => $data['entity_id'],
            ];
        }

        $data['relations'] = 'entity';

        $count_data = $data;
        $model = $this->makeModel($data, $this->user);
        $result     = $this->fetchGeneric($data, $model);

        if (!$result) {
            return $this->httpNotFoundResponse([
                'code'       => 404,
                'message'      => "No users are found",
                "data"       => [
                    $meta_index => $result,
                ],
                "parameters" => $parameters,
            ]);
        }

        $count = is_array( $result ) ? count( $result ) : $this->countData($count_data, $this->user);

        if( isset( $data['is_model'] ) && $data['is_model'] === true ){
            return $result;
        }

        return $this->httpSuccessResponse([
            "code"       => 200,
            "message"      => "Successfully retrieved list of users",
            "data"       => [
                $meta_index => $result,
                "count"     => $count,
            ],
            "parameters" => $parameters,
        ]);
    }

    /**
     * Search users with given parameters
     *
     * @param array $data
     * @return UserRepository
     */
    public function searchUser($data = [])
    {
        $result = $this->user;

        if(!isset($data['query'])){
            return $this->httpNotFoundResponse([
                "code" => 404,
                "message" => _("Query is not set"),
                "data" => [],
            ]);
        }

        $meta_index = "users";
        $parameters = [
            "query" => $data['query'],
        ];

        foreach ((array) $data['target'] as $index => $column) {
            if (str_contains($column, "full_name")) {
                $data['target'][$index] = "entity.full_name";
            }
        }

        $count_data = $data;
        $result = $this->genericSearch($data, $result)->get()->all();

        if(!$result){
            return $this->httpNotFoundResponse([
                'code'        => 404,
                'message'       => 'No users found.',
                'parameters'  => [
                    "parameters" => $parameters,
                ],
            ]);
        }

        if(isset($count_data['limit'])){
            unset($count_data['limit']);
        }

        if(isset($count_data['offset'])){
            unset($count_data['offset']);
        }

        $count = $this->genericSearch($count_data, $this->user)->count();

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully searched users"),
            "data" => [
                $meta_index => $result,
                'count' => $count,
            ],
            "parameters" => $parameters,
        ]);
    }

    /**
     * Create entity and user
     *
     * @param array $data
     * @return UserRepository
     */
    public function register($data = []){
        $meta_index = 'user';

        // region Validation

        $fillable = [
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'contact_number' => 'Contact number'
        ];
        foreach($fillable as $key => $value) {
            if (!isset($data[$key])) {
                return $this->httpNotFoundResponse([
                    'code' => 404,
                    'message' => $value." is not set."
                ]);
            }
        }

        if( strlen($data['password']) <= 6 ){
            return $this->httpInternalServerResponse([
                'code' => 500,
                'message' => "Password is invalid."
            ]);
        }

        // endregion Validation

        // region Existence Check
        if($this->user->where('username', $data['username'])->exists()){
            return $this->httpInternalServerResponse([
                'code' => 500,
                'message' => "Username is already taken."
            ]);
        }

        // endregion Existence Check

        $entity = $this->entity_repo->define($data);
        if((isset($entity) && !is_code_success( $entity->getCode() )) || is_null($entity)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("Data Validation Error."),
                "description" => _("An error was detected on one of the inputted data."),
                "data" => $entity->getData()
            ]);
        }

        $data['entity_id'] = $entity->getData()['entity']->id;

        if(!$this->user->save($data)){
            return $this->httpInternalServerResponse([
                "code" => 500,
                "message" => _("Data Validation Error."),
                "description" => _("An error was detected on one of the inputted data."),
                "data" =>   [
                    "errors" => $this->user->errors(),
                ]
            ]);
        }

        return $this->httpSuccessResponse([
            "code" => 200,
            "message" => _("Successfully added a user."),
            'data' => [
                $meta_index => $this->user,
            ],
        ]);

    }

}
