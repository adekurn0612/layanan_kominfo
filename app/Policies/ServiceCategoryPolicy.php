<?php

namespace App\Policies;

use App\Models\ServiceCategory;
use App\Models\User;

class ServiceCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('service-categories.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('service-categories.manage');
    }

    public function update(User $user, ServiceCategory $serviceCategory): bool
    {
        return $user->hasPermission('service-categories.manage');
    }
}
