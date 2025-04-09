<?php

namespace App\Policies;

use App\Classes\Permissions\Permissions;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Collection;

class AnimalPolicy
{
    public function basicViewAny(User $user): Response
    {
        return Response::allow();
    }



    public function basicView(User $user, Animal $animal): Response
    {
        return Response::allow();
    }



    public function viewAny(User $user): Response
    {
        // Permission check
        if (!$user->can(Permissions::APP_VIEW_GENCESTORANIMALS)) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    

    public function view(User $user, Animal $animal): Response
    {
        // Permission check
        if (!$user->can(Permissions::APP_VIEW_GENCESTORANIMALS)) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }



    public function create(User $user): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORANIMALS, Permissions::APP_CREATE_GENCESTORANIMALS])) return Response::deny('You are missing the required permission.');
        
        return Response::allow();
    }



    public function update(User $user, Animal $animal): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORANIMALS, Permissions::APP_EDIT_GENCESTORANIMALS])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }



    public function delete(User $user, Animal $animal): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORANIMALS, Permissions::APP_DELETE_GENCESTORANIMALS])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    
    
    public function deleteMany(User $user, Collection $animals): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORANIMALS, Permissions::APP_DELETE_GENCESTORANIMALS])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    
    
    public function restore(User $user, Animal $animal): Response
    {
        return Response::deny();
    }

    
    
    public function forceDelete(User $user, Animal $animal): Response
    {
        return Response::deny();
    }
}
