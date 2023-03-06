<?php

namespace App\Data\Models\Sponsors;

use App\Data\Models\Entity\Entity;

class Sponsor extends \Shared\BaseClasses\Model
{
    /**
     * database table name
     */
    protected $table = 'sponsors';

    protected $searchable = [
        'id',
        'organization_id',
        'sponsorship_type',
        'sponsorship_status'
    ];

    protected $fillable = [
        'organization_id',
        'sponsorship_type',
        'sponsorship_status'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class, "organization_id");
    }

}
