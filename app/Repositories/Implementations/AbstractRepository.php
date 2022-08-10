<?php

namespace App\Repositories\Implementations;

abstract class AbstractRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function list()
    {
        return $this->model->all();
    }

    public function findValue(string $field, string $value)
    {
        $data = $this->model->where($field, $value)->first();
        return $data;
    }

    public function create(array $data)
    {
        return $this->model->fill($data)->save();
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($data);
        return $model->save();
    }

    public function destroy(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function resolveModel()
    {
        return app($this->model);
    }
}
