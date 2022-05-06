<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\IServices\IUserService;
use App\Repositories\IRepositories\IUserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class UserService extends AbstractService implements IUserService
{
    public function __construct(User $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $limit = 10)
    {
        return $this->query()->when($request->name, function ($query, $name) {
            return $query->search('name', $name);
        })->paginate($limit);
    }

    public function updateAvatar(Request $request)
    {
        $id = Auth::user()->id;
        $request->file('avatar')->store('public/avatars');
        $filename = $request->file('avatar')->hashName();
        $avatar = 'storage/avatars/' . $filename;
        // dd($avatar);
        $data['avatar'] = $avatar;
        return $this->repository->update($id, $data);
    }

    public function get(Request $request)
    {
        if ($request->category_id) {
            return $this->repository->get($request);
        } else {
            return Cache::rememberForever('admins', function () use ($request) {
                return $this->repository->get($request);
            });
        }
    }

    public function create(Request $request)
    {
        try {
            $user = $this->repository->create($request->validated());
            Cache::forget('admins');
            Cache::rememberForever('admins', function () use ($request) {
                return $this->repository->get($request);
            });
            $user->sendEmailVerificationNotification();
            return $user;
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }

    public function update(int $id, Request $request)
    {
        $user = $this->repository->update($id, $request->validated());
        Cache::forget('admins');
        Cache::rememberForever('admins', function () use ($request) {
            return $this->repository->get($request);
        });
        return $user;
    }
}
