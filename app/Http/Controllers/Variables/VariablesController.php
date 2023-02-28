<?php

namespace App\Http\Controllers\Variables;

use App\Data\Repositories\Variables\VariablesRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class VariablesController extends BaseController
{
    protected $variables_repo;

    public function __construct(
        VariablesRepository $variablesRepository
    ){
        $this->variables_repo = $variablesRepository;
    }

    // region CRUD
    /**
     * @param Request $request
     * @param int $id
     *
     * @return mixed
     */
    public function define( Request $request ){
        $data = $request->all();

        return $this->absorb (
            $this->variables_repo->define ( $data )
        )->json();
    }

    // region Fetch
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function all( Request $request ){
        $data = $request->all();

        return $this->absorb (
            $this->variables_repo->fetch( $data )
        )->json();
    }
    /**
     * @param Request $request
     * @param $type
     *
     * @return mixed
     */
    public function fetchByType( Request $request, $type='' ){
        $data = $request->all();

        if( trim($type) === '' ){
            return $this->httpInternalServerResponse ([
                "message" => _("Invalid type"),
            ])->json();
        }

        $data['where'] = [
            [
                'target' => 'type',
                'operator' => '=',
                'value' => $type,
            ]
        ];

        return $this->absorb (
            $this->variables_repo->fetch ( $data )
        )->json();
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return mixed
     */
    public function fetch( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;

        return $this->absorb (
            $this->variables_repo->fetch( $data )
        )->json();
    }
    // endregion Fetch

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function delete( Request $request, $id ){
        $data = $request->all();
        $data['id'] = $id;

        return $this->absorb (
            $this->variables_repo->delete( $data )
        )->json();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function search( Request $request ){
        $data = $request->all();

        return $this->absorb (
            $this->variables_repo->search( $data )
        )->json();
    }
    // endregion CRUD
}
