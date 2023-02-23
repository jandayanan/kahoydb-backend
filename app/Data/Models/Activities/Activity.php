<?php

namespace App\Data\Models\Activities;

class Activity extends \Shared\BaseClasses\Model
{
    /**
     * database table name
     */
    protected $table = 'activities';

    protected $searchable = [
        'id',
        'name',
        'start_date',
        'end_date',
        'activity_status'
    ];

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'activity_status'
    ];

}
