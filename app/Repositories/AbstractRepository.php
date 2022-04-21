<?php

namespace App\Repositories;

use App\Repositories\IRepositories\IAbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AbstractRepository
{
    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->query();
    }


    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->query()->find($id);
    }

    /**
     * @param string $key
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function findByKeyValue(string $key, $value)
    {
        $res = new Collection();
        if (Schema::hasColumn($this->getModel()->getTable(), $key)) {
            $res = $this->model->query()->where($key, $value)->get();
        }
        return $res;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        // dd($attributes);
        return $this->model->query()
            ->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        return $this->model->query()
            ->findOrFail($id)
            ->update($attributes);
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        return $this->model->query()
            ->findOrFail($id)
            ->delete();
    }

    public function getModel()
    {
        return $this->model;
    }
}
