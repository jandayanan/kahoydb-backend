<?php

namespace App\Data\Models\Auth;

use App\Data\Models\AuthBaseModel;
use App\Data\Models\Entity\Entity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends AuthBaseModel
{

    use HasApiTokens, Notifiable;

    protected $guard_name = 'web';

    /**
     * database table name
     */
    protected $table = 'users';

    /**
     * list of fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'username',
        'password'
    ];

    /**
     * list of searchable fields
     *
     * @var array
     */
    protected $searchable = [
        'id',
        'entity_id',
        'username',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function entity(){
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expired_at' => carbon_now()->addHours(12)
        ]);
        $token->plainTextToken = ( (string) $token->id) .'|'. $plainTextToken;

        return $token;
    }

}

