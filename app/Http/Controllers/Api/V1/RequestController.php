<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Requests\HistoryRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\RequestResource;
use App\Models\Request;
use App\Repositories\IRepositories\ICommentRepository;
use App\Services\IServices\IRequestService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Route;
use stdClass;

class RequestController extends Controller
{
    private $requestService;

    public function __construct(IRequestService $requestService, ICommentRepository $commentService)
    {
        $this->middleware(['jwt.auth']);
        $this->requestService = $requestService;
        // $this->authorizeResource(Request::class, 'request');
        $this->commentService = $commentService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BaseIndexRequest $request)
    {
        $this->authorize('viewAny', Request::class);
        return RequestResource::collection(
            $this->requestService->paginate($request)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestRequest $request)
    {
        $this->authorize('create', Request::class);
        return Response::storeSuccess(
            $this->requestService->create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return RequestResource::make(
            $request->load(['priority', 'category', 'createdBy', 'approveBy', 'assigneeId', 'users'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequestRequest  $httpRequest
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $httpRequest, Request $request)
    {
        $this->authorize('update', $request);
        return Response::updateSuccess(
            $this->requestService->update($request->id, $httpRequest)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Response::deleteSuccess(
            $this->requestService->delete($id)
        );
    }

    public function myRequest(BaseIndexRequest $request)
    {
        $this->authorize('myRequest', Request::class);
        return RequestResource::collection(
            $this->requestService->paginateWhere($request)
        );
    }


    public function comment(StoreCommentRequest $httpRequest, Request $request)
    {
        $this->authorize('comment', $request);
        return Response::updateSuccess(
            $this->requestService->createComment($request, $httpRequest)
        );
    }

    public function approve(Request $request)
    {
        $this->authorize('approveOrReject', $request);
        return Response::updateSuccess(
            $this->requestService->approveRequest($request)
        );
    }

    public function reject(Request $request)
    {
        $this->authorize('approveOrReject', $request);
        return Response::updateSuccess(
            $this->requestService->rejectRequest($request)
        );
    }

    public function history(HistoryRequest $httpRequest)
    {
        $this->authorize('history', Request::class);
        return HistoryResource::collection(
            $this->commentService->paginate($httpRequest)
        );
    }

    public function updateStatus(UpdateStatusRequest $httpRequest, Request $request)
    {
        $this->authorize('updateStatus', Request::class);
        return Response::updateSuccess(
            $this->requestService->updateStatus($request->id, $httpRequest)
        );
    }
}
