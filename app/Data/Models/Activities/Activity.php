<?php

namespace App\Data\Models\Activities;

use App\Data\Models\Participants\Participant;
use App\Data\Models\Trees\Tree;

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

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
