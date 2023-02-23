<?php

namespace App\Data\Models\Trees;

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
        'latitude',
        'longitude',
        'tree_status'
    ];

    // ToDo: Relationship

}
