<?php

namespace App\Data\Models\Variables;

use App\Data\Models\BaseModel;

class Variable extends BaseModel
{

    /**
     * database table name
     */
    protected $table = 'variables';
    protected $primaryKey = 'id';

    protected $searchable = [
        "key",
        "value",
        "description",
        "type",
        "status",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $fillable = [
        "key",
        "value",
        "description",
        "type",
        "status",
    ];

    public $timestamps = true;

    protected $hidden  = [
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $safe_attributes = [
        "id" => "",
        "id_hash" => "",
    ];

}
