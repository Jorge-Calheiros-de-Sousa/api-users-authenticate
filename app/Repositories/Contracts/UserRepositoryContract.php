<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryContract
{
    public function findValue(string $field, string $value);
    public function resolveModel();
    public function create(array $data);
    public function update(array $data, int $id);
    public function destroy(int $id);
    public function findOrFail(int $id);
    public function paginate(int $perPage, string $field, string $search): LengthAwarePaginator;
    public function list();
}
