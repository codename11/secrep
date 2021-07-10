<?php

namespace App\Policies;

use App\User;
use App\WorkOrganization;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Role;
use Illuminate\Auth\Access\Response;

class WorkOrganizationPolicy
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
     * @param  \App\WorkOrganization  $workOrganization
     * @return mixed
     */
    public function view(User $user, WorkOrganization $workOrganization)
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
     * @param  \App\WorkOrganization  $workOrganization
     * @return mixed
     */
    public function update(User $user, WorkOrganization $workOrganization)
    {
        return ($user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrganization  $workOrganization
     * @return mixed
     */
    public function delete(User $user, WorkOrganization $workOrganization)
    {
        return ($user->role->name=="admin") ? Response::allow() : Response::deny('Access denied.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrganization  $workOrganization
     * @return mixed
     */
    public function restore(User $user, WorkOrganization $workOrganization)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\WorkOrganization  $workOrganization
     * @return mixed
     */
    public function forceDelete(User $user, WorkOrganization $workOrganization)
    {
        //
    }
}
