<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Enums\Role;
use App\Models\Request as ModelsRequest;
use App\Repositories\IRepositories\ICommentRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentRepository extends AbstractRepository implements ICommentRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    public function query()
    {
        $user = Auth::user();
        if ($user->role_id == Role::MANAGER) {
            return $this->model->query()
                        ->with(['createdBy','request'])
                        ->whereHas('request', function (Builder $query) use ($user) {
                            $query->whereHas('createdBy', function (Builder $query) use ($user) {
                                $query->searchWhereHas(['department' => 'id'], $user->department_id);
                            });
                        });
        } else {
            return $this->model->query()
                        ->with(['createdBy','request'])
                        ->whereHas('request', function (Builder $query) use ($user) {
                            $query->searchWhereHas(['createdBy' => 'id', 'assigneeId' => 'id'], $user->id);
                        });
        }
    }

    public function paginate(Request $request)
    {
        return $this->query()->history()->orderBy('created_at', 'DESC')->paginate($request->limit);
    }
}
