<?php

namespace App\Policies;

use App\Models\Enums\Request as EnumsRequest;
use App\Models\Enums\Role;
use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->role_id == Role::IT_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Request $request)
    {
        if ($user->role_id == Role::IT_ADMIN || $request->createdBy == $user->id ||
        ($request->createdBy->department_id == $user->department_id
        && $user->role_id == Role::MANAGER)
        ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Request $request)
    {
        if (strtolower($request->status) == EnumsRequest::STATUS_CLOSE) {
            if ($user->role_id == Role::IT_ADMIN) {
                return true;
            }

            return false;
        } elseif (($user->id == $request->created_by && empty($request->approve_id))) {
            return true;
        } elseif ($user->role_id == Role::IT_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Request $request)
    {
        if ($request->createdBy == $user->id &&
                $request->status != EnumsRequest::STATUS_CLOSE && empty($request->approve_id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Request $request)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Request $request)
    {
        //
    }

    public function myRequest()
    {
        return true;
    }

    public function comment(User $user, Request $request)
    {
        return $this->isRightComment($user, $request);
    }

    public function approveOrReject(User $user, Request $request)
    {
        return $this->isManagerOfCreateBy($user, $request);
    }

    public function history()
    {
        return true;
    }

    public function isRightComment(User $user, Request $request)
    {
        if ($user->role_id == Role::IT_ADMIN || $this->isCreateBy($user, $request) ||
            $this->isManagerOfCreateBy($user, $request)) {
            return true;
        }
        return false;
    }

    public function isAssignee(User $user, Request $request)
    {
        return $request->assignee_id === $user->id;
    }

    public function isCreateBy(User $user, Request $request)
    {
        return $request->created_by === $user->id;
    }

    public function isManagerOfCreateBy(User $user, Request $request)
    {
        if ($request->createdBy->department_id == $user->department_id
        && $user->role_id == Role::MANAGER) {
            return true;
        }
        return false;
    }

    public function updateStatus(User $user)
    {
        if ($user->role_id == Role::IT_ADMIN) {
            return true;
        }

        return false;
    }
}
