<?php

namespace App\Repositories;

use App\Models\Enums\Role;
use App\Models\User;
use App\Repositories\IRepositories\IUserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserRepository extends AbstractRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function paginate(Request $request)
    {
        return $this->query()->with(['role', 'department', 'position'])
                    ->andWhen($request->only('department_id', 'position_id', 'role_id', 'status'))
                    ->when($request->keyword, function (Builder $query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->search(['name', 'email'], $request->keyword)
                            ->orSearchWhereHas(['role' => ['name'], 'department' => ['name'],
                                        'position' => ['name']], $request->keyword);
                        });
                    })->paginate($request->limit);
    }

    public function get(Request $request)
    {
        return $this->query()->admin()
        ->whereNotNull('email_verified_at')
            ->when($request->category_id, function (Builder $query) use ($request) {
                $query->whereHas('category', function (Builder $query) use ($request) {
                    $query->where('id', $request->category_id);
                });
            })->get();
    }
}
