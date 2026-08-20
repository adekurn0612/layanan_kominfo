<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'organizationCount' => Organization::count(),
            'userCount' => User::count(),
            'roleCount' => Role::count(),
            'permissionCount' => Permission::count(),
            'serviceCategoryCount' => ServiceCategory::count(),
            'serviceCount' => Service::count(),
            'ticketCount' => Ticket::count(),
            'submittedTicketCount' => Ticket::where('status', 'submitted')->count(),
        ]);
    }
}
