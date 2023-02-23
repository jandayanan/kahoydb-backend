<?php

namespace App\Data\Models\Participants;

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

    // ToDo: Relationship

}
