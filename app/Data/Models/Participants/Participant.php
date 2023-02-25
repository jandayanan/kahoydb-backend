<?php

namespace App\Data\Models\Participants;

use App\Data\Models\Activities\Activity;
use App\Data\Models\Entity\Entity;

class Participant extends \Shared\BaseClasses\Model
{
    /**
     * database table name
     */
    protected $table = 'participants';

    protected $searchable = [
        'id',
        'entity_id',
        'activity_id',
        'participant_status'
    ];

    protected $fillable = [
        'entity_id',
        'activity_id',
        'participant_status'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, "activity_id");
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class, "entity_id");
    }

}
