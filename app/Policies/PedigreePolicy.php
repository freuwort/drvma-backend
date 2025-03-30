<?php

namespace App\Policies;

use App\Classes\Permissions\Permissions;
use App\Models\Pedigree;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Collection;

class PedigreePolicy
{
    public function basicViewAny(User $user): Response
    {
        return Response::allow();
    }



    public function basicView(User $user, Pedigree $pedigree): Response
    {
        return Response::allow();
    }



    public function viewAny(User $user): Response
    {
        // Permission check
        if (!$user->can(Permissions::APP_VIEW_GENCESTORPEDIGREES)) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    

    public function view(User $user, Pedigree $pedigree): Response
    {
        // Permission check
        if (!$user->can(Permissions::APP_VIEW_GENCESTORPEDIGREES)) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }



    public function create(User $user): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORPEDIGREES, Permissions::APP_CREATE_GENCESTORPEDIGREES])) return Response::deny('You are missing the required permission.');
        
        return Response::allow();
    }



    public function update(User $user, Pedigree $pedigree): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORPEDIGREES, Permissions::APP_EDIT_GENCESTORPEDIGREES])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }



    public function delete(User $user, Pedigree $pedigree): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORPEDIGREES, Permissions::APP_DELETE_GENCESTORPEDIGREES])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    
    
    public function deleteMany(User $user, Collection $pedigrees): Response
    {
        // Permission check
        if (!$user->can([Permissions::APP_VIEW_GENCESTORPEDIGREES, Permissions::APP_DELETE_GENCESTORPEDIGREES])) return Response::deny('You are missing the required permission.');

        return Response::allow();
    }

    
    
    public function restore(User $user, Pedigree $pedigree): Response
    {
        return Response::deny();
    }

    
    
    public function forceDelete(User $user, Pedigree $pedigree): Response
    {
        return Response::deny();
    }
}
