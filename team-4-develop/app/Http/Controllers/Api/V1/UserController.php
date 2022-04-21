<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\IServices\IUserService;
use Hash;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        $this->middleware(['jwt.auth']);
        $this->userService = $userService;
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BaseIndexRequest $request)
    {
        return UserResource::collection(
            $this->userService->paginate($request)
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
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        return Response::storeSuccess(
            $this->userService->create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return UserResource::make($user->load(['role', 'position', 'department']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // $avatar = null;
        // if(!is_null($request->file('avatar'))) {
        //     $request->file('avatar')->store('public/avatars');
        //     $filename = $request->file('avatar')->hashName();
        //     $avatar = 'storage/avatars/'.$filename;
        // }
        $this->userService->update($user->id, $request);
        return Response::updateSuccess('update user successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->authorize('updateProfile', User::class);
        $user = Auth::user();
        return Response::updateSuccess(
            $this->userService->update($user->id, $request)
        );
    }

    public function listAdmin(HttpRequest $request)
    {
        $this->authorize('listAdmin', User::class);
        return UserResource::collection(
            $this->userService->get($request)
        );
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $this->userService->update($user->id, $request);
        return Response::updateSuccess('update user successfull');
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $this->userService->updateAvatar($request);
        return Response::updateSuccess('update user successfull');
    }
}
