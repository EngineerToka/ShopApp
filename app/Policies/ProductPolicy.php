<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Product $product)
    {
        if( $user->role == 'seller'){
            return $user->id === $product->user_id;
        }
        if( $user->role == 'customer'){
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
       return $user->role == 'seller' || $user->role == 'admin';
    }

    public function update(User $user, Product $product)
    {
       return $user->role === 'admin' || $user->role == 'seller' && $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'admin' || $user->role == 'seller' && $user->id === $product->user_id;
    }

    public function restore(User $user, Product $product)
    {
        //
    }

    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
