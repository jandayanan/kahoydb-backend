<?php

namespace App\Data\Models\Organizations;

use App\Data\Models\Activities\Activity;
use App\Data\Models\Entity\Entity;

class Organization extends \Shared\BaseClasses\Model
{
    /**
     * database table name
     */
    protected $table = 'organizations';

    protected $searchable = [
        'id',
        'parent_organization_id',
        'entity_id',
        'organization_type',
        'organization_status',
        'status'
    ];

    protected $fillable = [
        'parent_organization_id',
        'entity_id',
        'organization_type',
        'organization_status',
        'status'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class, "entity_id");
    }

}
