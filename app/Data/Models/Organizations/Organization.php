<?php

namespace App\Data\Models\Organizations;

use App\Data\Models\Activities\Activity;
use App\Data\Models\Entity\Entity;
use App\Data\Models\Sponsors\Sponsor;

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

    protected $appends = [
        'branch'
    ];

    protected $hidden = [
        'children'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class, "entity_id");
    }

    public function children()
    {
        return $this->hasMany(Organization::class, 'parent_organization_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'parent_organization_id');
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function getBranchAttribute()
    {
        $result = collect([]);
        $children = $this->children;
        while (!is_null($children )) {
            if(!empty($children->toArray())){
                foreach($children as $value_){
                    if(isset($value_->entity) && isset($value->children)) $children['entity'] = $value_->entity;
                    if(isset($value_->sponsors) && isset($value->children)) $children['sponsors'] = $value_->entity;
                }
            }
            $result->push($children);
            if(isset($children->children)) {
                $children = $children->children;
            }
            else $children = null;

        }
        return $result;
    }
}
