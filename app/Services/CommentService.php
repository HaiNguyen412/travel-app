<?php

namespace App\Services;

use App\Models\Request as ModelsRequest;
use App\Repositories\IRepositories\ICommentRepository;
use App\Services\IServices\ICommentService;
use Illuminate\Http\Request;

class CommentService extends AbstractService implements ICommentService
{
    public function __construct(ICommentRepository $commentRepository)
    {
        parent::__construct($commentRepository);
    }

    public function paginate(Request $request)
    {
        return $this->repository->paginate($request);
    }
}
