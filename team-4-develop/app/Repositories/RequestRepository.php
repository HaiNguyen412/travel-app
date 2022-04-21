<?php

namespace App\Repositories;

use App\Models\Enums\Role;
use App\Models\Request;
use App\Models\User;
use App\Repositories\IRepositories\IRequestRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class RequestRepository extends AbstractRepository implements IRequestRepository
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function queryCustom()
    {
        $user = Auth::user();
        if ($user->role_id == Role::MANAGER) {
            return $this->model->query()
                        ->with(['priority', 'category', 'createdBy', 'approveBy', 'assigneeId'])
                        ->whereHas('createdBy', function (Builder $query) use ($user) {
                            $query->searchWhereHas(['department' => 'id'], $user->department_id);
                        });
        } else {
            return $this->model->query()
                        ->with(['priority', 'category', 'createdBy', 'approveBy', 'assigneeId'])
                        ->searchWhereHas(['createdBy' => 'id', 'assigneeId' => 'id'], $user->id);
        }
    }

    public function paginateWhere(HttpRequest $request)
    {
        return $this->queryCustom()
                    ->andWhen($request->only('status', 'category_id', 'priority_id'))
                    ->when($request->create_at, function (Builder $query) use ($request) {
                        $query->where('created_at', '>=', date($request->create_at));
                    })
                    ->when($request->due_date, function (Builder $query) use ($request) {
                        $query->where('due_date', '<=', date($request->due_date));
                    })
                    ->when($request->keyword, function (Builder $query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->search(['name', 'content', 'due_date','status'], $request->keyword)
                                    ->orSearchWhereHas([ 'priority' => ['name'], 'category' => ['name'],
                                        'createdBy' => ['name', 'email']
                                    ], $request->keyword);
                        });
                    })->orderBy('priority_id', 'DESC')->paginate($request->limit);
    }

    public function paginate(HttpRequest $request)
    {
        return $this->query()->with(['category', 'priority', 'createdBy', 'approveBy', 'assigneeId'])
                            ->orderBy('priority_id', 'desc')->paginate($request->limit);
    }

    public function findByAttributes($attributes)
    {
        return $this->query()->with(['category', 'priority', 'createdBy', 'approveBy', 'assigneeId'])
                                ->filter($attributes);
    }
}
