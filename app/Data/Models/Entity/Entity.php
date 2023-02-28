<?php

namespace App\Data\Models\Entity;

use App\Data\Models\BaseModel;
use App\Data\Models\Participants\Participant;
use App\Data\Models\Trees\Tree;

/**
 * Class Entities
 * @package App\Data\Models\Entities
 *
 * @property integer $id
 * @property string $name
 */
class Entity extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'entities';
    protected $searchable = [
        'id',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'status'
    ];

    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'status'
    ];
    public $timestamps = true;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function participant()
    {
        return $this->hasOne(participant::class, 'entity_id');
    }

    public function trees()
    {
        return $this->hasMany(Tree::class, 'planter_id');
    }
}
