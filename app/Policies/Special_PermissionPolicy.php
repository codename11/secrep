<?php

namespace App\Policies;

use App\Special_Permission;
use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Special_PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Special_Permission  $specialPermission
     * @return mixed
     */
    public function view(User $user, Special_Permission $specialPermission)
    {
        return ($user->id || $user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Special_Permission  $specialPermission
     * @return mixed
     */
    public function update(User $user, Special_Permission $specialPermission)
    {
        return ($user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Special_Permission  $specialPermission
     * @return mixed
     */
    public function delete(User $user, Special_Permission $specialPermission)
    {
        return ($user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Special_Permission  $specialPermission
     * @return mixed
     */
    public function restore(User $user, Special_Permission $specialPermission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Special_Permission  $specialPermission
     * @return mixed
     */
    public function forceDelete(User $user, Special_Permission $specialPermission)
    {
        //
    }
}
