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
        'parent_organization_id',
        'child_organization_id',
        'name',
        'start_date',
        'end_date',
        'activity_status'
    ];

    protected $fillable = [
        'parent_organization_id',
        'child_organization_id',
        'name',
        'start_date',
        'end_date',
        'activity_status'
    ];

    protected $appends = [
        'app_hash'
    ];

    public function getAppHashAttribute()
    {
        return app_hash("ACTIVITY".env("APP_SALT", 'KAHOY_Default').$this->id);
    }

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
