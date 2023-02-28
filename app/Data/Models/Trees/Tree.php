<?php

namespace App\Data\Models\Trees;

use App\Data\Models\Activities\Activity;
use App\Data\Models\Entity\Entity;

class Tree extends \Shared\BaseClasses\Model
{
    /**
     * database table name
     */
    protected $table = 'trees';

    protected $searchable = [
        'id',
        'activity_id',
        'planter_id',
        'unique_id',
        'planted_at',
        'donated_at',
        'tree_type',
        'tree_species',
        'latitude',
        'longitude',
        'tree_status'
    ];

    protected $fillable = [
        'activity_id',
        'planter_id',
        'unique_id',
        'planted_at',
        'donated_at',
        'tree_type',
        'tree_species',
        'latitude',
        'longitude',
        'tree_status'
    ];


    public function activity()
    {
        return $this->belongsTo(Activity::class, "activity_id");
    }


    public function planter()
    {
        return $this->belongsTo(Entity::class, "planter_id");
    }

}
