<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;

class CustomerPolicy
{
    private function isAdmin(User $user): bool
    {
        return in_array($user->role, ['admin','superadmin']);
    }

    private function isSalesOrMarketing(User $user): bool
    {
        return in_array($user->role, ['sale','marketing']);
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user) || $this->isSalesOrMarketing($user);
    }

    public function view(User $user, Customer $customer): bool
    {
        return $this->isAdmin($user) || $customer->owner_id === $user->id || $this->isSalesOrMarketing($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user) || $this->isSalesOrMarketing($user);
    }

    public function update(User $user, Customer $customer): bool
    {
        // sales/marketing can edit only when draft and owns it
        if ($this->isAdmin($user)) return true;
        return $this->isSalesOrMarketing($user) && $customer->status === 'draft' && $customer->owner_id === $user->id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $this->isAdmin($user);
    }

    public function complete(User $user, Customer $customer): bool
    {
        if ($this->isAdmin($user)) return true;
        return $this->isSalesOrMarketing($user) && $customer->status === 'draft' && $customer->owner_id === $user->id;
    }

    public function share(User $user, Customer $customer): bool
    {
        if ($this->isAdmin($user)) return true;
        return $this->isSalesOrMarketing($user) && !$customer->shared_to_telegram && $customer->owner_id === $user->id;
    }
}
