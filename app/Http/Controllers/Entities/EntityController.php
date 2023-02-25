<?php

namespace App\Http\Controllers\Entities;

use App\Data\Repositories\Entity\EntityRepository;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class EntityController extends BaseController
{
    /**
     * Defining entity repository
     *
     * @var EntityRepository $entity_repo
     */
    protected $entity_repo;

    public function __construct(
        EntityRepository $entityRepository){
            $this->entity_repo = $entityRepository;
    }

    /**
     * Fetch all entities
     *
     * @param Request $request
     * @return mixed
     */
    public function all( Request $request){
        $data = $request->all();
        return $this->absorb ( $this->entity_repo->fetch($data) )->json();
    }

    /**
     * Create an entity
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request){
        $data = $request->all();
        return $this->absorb ( $this->entity_repo->define($data) )->json();
    }

    /**
     * Delete an entity
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function delete(Request $request, $id){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb ( $this->entity_repo->delete($data) )->json();

    }

    /**
     * Fetch an entity by id
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function fetch(Request $request, $id){
        $data = $request->all();
        $data['id']     = $id;
        $data['single'] = true;

        if (!isset($data['id']) ||
            !is_numeric($data['id']) ||
            $data['id'] <= 0) {
            return $this->httpInternalServerResponse([
                'code'  => 500,
                'message' => "Entities ID is invalid.",
            ]);
        }

        return $this->absorb ( $this->entity_repo->fetch($data) )->json();
    }

    /**
     * Search entities
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request){
        $data = $request->all();
        return $this->absorb($this->entity_repo->search($data))->json();
    }

    /**
     * Update an entity
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, $id){
        $data = $request->all();
        $data['id'] = $id;
        return $this->absorb ( $this->entity_repo->define($data) )->json();
    }
}
