<?php

namespace App\Services;

use App\Jobs\SendEmail;
use App\Jobs\SendEmailComment;
use App\Models\Category;
use App\Models\Enums\Request as EnumsRequest;
use App\Models\Enums\Role;
use App\Repositories\IRepositories\IRequestRepository;
use App\Services\IServices\IRequestService;
use Exception;
use Illuminate\Http\Request;

use App\Models\Request as ModelRequest;
use App\Models\User;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class RequestService extends AbstractService implements IRequestService
{
    public function __construct(IRequestRepository $requestRepository)
    {
        parent::__construct($requestRepository);
    }

    public function paginateWhere(Request $request)
    {
        return $this->repository->paginateWhere($request);
    }

    public function paginate(Request $request)
    {
        $data = $request->except('limit');
        $count = 0;
        foreach ($data as $key => $value) {
            if (!empty($value) || $value === '0') {
                $count++;
                break;
            }
        }
        if ($count == 0) {
            return $this->repository->paginate($request);
        }

        return $this->repository->findByAttributes($data)->paginate($request->limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->validated();
            $dataCreate = $this->repository->create($data);
            $comment = [
                'name' => __('request.name').': '.$dataCreate->name,
                'content' => __('request.content').': '.$dataCreate->content,
                'priority' => __('request.priority').': '.$dataCreate->priority->name,
                'category' => __('request.category').': '.$dataCreate->category->name,
                'assignee' => __('request.assignee').': '.$dataCreate->assigneeId->name,
                'due_date' => __('request.due_date').': '.$dataCreate->due_date,
                'status' => __('request.status').': '.'Open',
            ];
            $this->autoComment($dataCreate, [
                'content' => json_encode(__('message.request.created')),
                'type' => __('message.request.type_history')
            ]);
            $this->autoComment($dataCreate, [
                'content' => json_encode($comment),
                'type' => __('message.request.type_comment')
            ]);
            $idRequest = $dataCreate->id;
            if (!empty($idRequest)) {
                $users = User::query()->where('id', $data['assignee_id'])
                                            ->orWhere('role_id', Role::IT_ADMIN)
                                            ->orWhere('id', function ($query) use ($data) {
                                                $query->select('assignee')
                                                        ->from('categories')
                                                        ->where('id', $data['category_id']);
                                            })->get();
                $message = [
                    'type' => __('message.request.created.content'),
                    'task' => $data['name'],
                    'status' => __('message.request.status.open'),
                    'assignee' =>  $dataCreate->assigneeId->name,
                    'time' => Carbon::now()->toFormattedDateString(),
                    'id' => $idRequest,
                ];
                SendEmail::dispatch($message, $users);

                return $dataCreate;
            }

            return Response::clientError();
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }


    public function createComment(ModelRequest $modelRequest, Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();
            $data['content'] = json_encode(['content' => $data['content']]);
            $modelRequest->users()->attach([$user->id => $data]);
            $users = User::query()->orWhere('id', $modelRequest->assignee_id)
            ->orWhere('id', $modelRequest->created_by)
            ->orWhere(
                function (Builder $query) use ($modelRequest) {
                    $query->where(['role_id' => Role::MANAGER,
                    'department_id' => $modelRequest->createdBy->department_id]);
                }
            )->get();
            $message = [
                'type' => __('message.request.type_comment'),
                'task' => $modelRequest->name,
                'content' => $request->content,
                'user' => $user->name,
                'time' => Carbon::now()->toFormattedDateString(),
                'id' => $modelRequest->id
            ];
            SendEmailComment::dispatch($message, $users);
            return __('message.request.create_success');
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $data = $request->validated();
            $status = [EnumsRequest::STATUS_CLOSE, EnumsRequest::STATUS_IN_PROGRESS, EnumsRequest::STATUS_OPEN];
            $dataRequest = $this->repository->find($id);
            if (Auth::user()->role_id == Role::USER) {
                if (!empty($data['status']) || $data['status'] == '0') {
                    unset($data['status']);
                }
            } elseif (Auth::user()->role_id == Role::IT_ADMIN) {
                if (!empty($data['status'])) {
                    $data['status'] = strtolower($data['status']);
                    if (!in_array($data['status'], $status)) {
                        $data['status'] = $dataRequest->status;
                    }
                    if ($data['status'] == $dataRequest->status) {
                        unset($data['status']);
                    }
                    if ($dataRequest->created_at->greaterThan($data['due_date'])) {
                        $data['due_date'] = $dataRequest->due_date;
                    }
                }
            }
            $users = User::query()->where('id', $data['assignee_id'])
                                            ->orWhere('id', $dataRequest->assignee_id)
                                            ->orWhere('role_id', Role::IT_ADMIN)
                                            ->orWhere('id', function ($query) use ($data) {
                                                $query->select('assignee')
                                                        ->from('categories')
                                                        ->where('id', $data['category_id']);
                                            })
                                            ->orWhere('id', function ($query) use ($dataRequest) {
                                                $query->select('assignee')
                                                        ->from('categories')
                                                        ->where('id', $dataRequest->category_id);
                                            })
                                            ->orWhere('id', $dataRequest->created_by)->get();
            $dataUpdate = $this->repository->update($id, $data);
            $newRequest = $this->repository->find($id);
            $dataChange = [];
            foreach ($data as $key => $value) {
                if ($value != $dataRequest->$key) {
                    if ($key == 'category_id') {
                        $dataChange[$key] = __('request.status').': '.$dataRequest->category->name
                                                        .' -> '.$newRequest->category->name;
                    } elseif ($key == 'priority_id') {
                        $dataChange[$key] = __('request.priority').': '.$dataRequest->priority->name
                                                        .' -> '.$newRequest->priority->name;
                    } elseif ($key == 'assignee_id') {
                        $dataChange[$key] = __('request.assignee').': '.$dataRequest->assigneeId->name
                                                        .' -> '.$newRequest->assigneeId->name;
                    } else {
                        if ($key == 'due_date') {
                            $dataChange[$key] = __('request.due_date').': '
                                                .$dataRequest->$key.' -> '.$newRequest->$key;
                        } else {
                            $dataChange[$key] = ucfirst($key).': '.$dataRequest->$key.' -> '.$newRequest->$key;
                        }
                    }
                }
            }
            if (count($dataChange) > 0) {
                $this->autoComment($newRequest, [
                    'content' => json_encode($dataChange),
                    'type' => __('message.request.type_comment')
                ]);
                $this->autoComment($newRequest, [
                    'content' => json_encode(__('message.request.updated')),
                    'type' => __('message.request.type_history')
                ]);
            }
            if (!empty($dataUpdate)) {
                foreach ($users as $user) {
                    if ($user->id == $data['assignee_id']) {
                        $assigneeName = $user->name;
                        break;
                    }
                }
                $message = [
                    'type' => __('message.request.updated.content'),
                    'task' => $newRequest['name'],
                    'status' => $newRequest['status'],
                    'assignee' => $assigneeName,
                    'time' => Carbon::now()->toFormattedDateString(),
                    'id' => $id,
                ];
                SendEmail::dispatch($message, $users);

                return $dataUpdate;
            }
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }

    public function autoComment(ModelRequest $modelRequest, $content)
    {
        $userId = Auth::user()->id;
        $modelRequest->users()->attach([$userId => $content]);
        return __('message.request.create_success');
    }

    public function approveRequest(ModelRequest $modelRequest)
    {
        $this->autoComment($modelRequest, [
            'content' => json_encode(__('message.request.approve')),
            'type' => __('message.request.type_history')
        ]);
        $this->repository->update($modelRequest->id, ['approve_id' => Auth::user()->id]);

        return __('message.request.approve_success');
    }

    public function rejectRequest(ModelRequest $modelRequest)
    {
        $this->autoComment($modelRequest, [
            'content' => json_encode(__('message.request.reject')),
            'type' => __('message.request.type_history')
        ]);
        $this->repository->update($modelRequest->id, ['status' => 'close']);
        $this->autoComment($modelRequest, [
            'content' => json_encode(__('message.request.closed')),
            'type' => __('message.request.type_history')
        ]);

        return __('message.request.reject_success');
    }

    public function updateStatus(int $id, Request $request)
    {
        try {
            $oldRequest = $this->repository->find($id);
            $data = $request->validated();
            $status = [EnumsRequest::STATUS_CLOSE, EnumsRequest::STATUS_IN_PROGRESS, EnumsRequest::STATUS_OPEN];
            $dataRequest = $this->repository->find($id);
            if (!empty($data['status'])) {
                $data['status'] = strtolower($data['status']);
                if (!in_array($data['status'], $status)) {
                    $data['status'] = $dataRequest->status;
                }
                if ($data['status'] == $dataRequest->status) {
                    unset($data['status']);
                    return ;
                }
            }
            $users = User::query()->Where('id', $dataRequest->assignee_id)
                                    ->orWhere('role_id', Role::IT_ADMIN)
                                    ->orWhere('id', $dataRequest->created_by)->get();
            $dataUpdate = $this->repository->update($id, $data);
            $newRequest = $this->repository->find($id);
            $dataChange['status'] = __('request.status').': '
                                    .$oldRequest->status.' -> '.$newRequest->status;
            if (!empty($dataChange)) {
                $this->autoComment($newRequest, [
                    'content' => json_encode($dataChange),
                    'type' => __('message.request.type_comment')
                ]);
                $this->autoComment($newRequest, [
                    'content' => json_encode(__('message.request.updated')),
                    'type' => __('message.request.type_history')
                ]);
            }
            if (!empty($dataUpdate)) {
                $message = [
                    'type' =>  __('message.request.updated.content'),
                    'task' => $newRequest['name'],
                    'status' => $newRequest['status'],
                    'assignee' => $newRequest->assigneeId->name,
                    'time' => Carbon::now()->toFormattedDateString(),
                    'id' => $id,
                ];
                SendEmail::dispatch($message, $users);

                return $dataUpdate;
            }
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }
}
