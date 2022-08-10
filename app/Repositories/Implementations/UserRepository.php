<?php

namespace App\Repositories\Implementations;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    protected $model = User::class;

    public function paginate(int $perPage, string $field, string $search): LengthAwarePaginator
    {
        $mainQuery = $this->model
            ->when($search, function ($query) use ($search, $field) {
                $query->where($field, "like", "%$search");
            });

        return $mainQuery->paginate($perPage);
    }
}
