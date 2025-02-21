<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Purchase $purchase)
    {
        return $user->id === $purchase->user_id;
    }

    public function update(User $user, Purchase $purchase)
    {
        return $user->id === $purchase->user_id;
    }
}
