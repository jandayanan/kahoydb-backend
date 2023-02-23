<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 5/21/21
 * Time: 2:33 AM
 */

namespace App\Http\Controllers;


class BaseController extends \Shared\BaseClasses\Controller
{
    protected $tenant_defaults = [
        'tenant_id' => 1,
    ];

    public function getTenantDefaults( $data = [] ){
        return array_merge($this->tenant_defaults, $data);
    }

    public function fillDefaultData( ...$data ){
        $flat = [];

        foreach( $data as $arr ){
            $flat = array_merge( $flat, $arr );
        }

        return array_merge($flat, $this->getTenantDefaults ());
    }
}
