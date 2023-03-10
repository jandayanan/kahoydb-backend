<?php

namespace Shared\BaseClasses;

use Shared\Traits\Response;
use Shared\Traits\Permissioned;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Support\Facades\Request;

/**
 * Class Controller
 * @package App\Http\Controllers
 *
 * @function all() Retrieves all related data of a specific definition
 */
abstract class Controller extends LaravelController
{
    use Response, Permissioned, AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use \Shared\Traits\Loggable;


    public function respond( $result, $data ){
        if( isset($data['as_data']) && $data['as_data'] === true ){
            return $result->getData();
        }

        if( isset($data['as_object']) && $data['as_object'] === true ){
            return $result;
        }

        return $result->json();
    }

    /**
     * Set response header code.
     *
     * @return void
     */
    public function json()
    {
        $code = 200;

        if (!Request::has("no_response_code") || Request::input('no_response_code') != "yes") {
            $code = $this->getCode();
        }

        if( $code < 100 ){
            $code = $code < 100 ? 200 : $code;
        }

        return response()->json($this->getResponse(), $code);
    }

    public function absorbJson( $object ){
        return $this->absorb( $object )->json();
    }

    public function absorbParameters( $params ){
        return $this->setParameters ( $params );
    }
}
