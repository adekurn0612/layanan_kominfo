<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\OrganizationPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\ServicePolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Organization::class, OrganizationPolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Service::class, ServicePolicy::class);
        Gate::policy(ServiceCategory::class, ServiceCategoryPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Gate::before(function (User $user): ?bool {
            return $user->isSuperAdmin() ? true : null;
        });

        Gate::define('view-admin', fn (User $user): bool => $user->hasPermission('admin.access'));
    }
}
