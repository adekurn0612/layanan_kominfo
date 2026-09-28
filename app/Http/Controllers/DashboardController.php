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
        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::whereNotNull('resolved_at')->count();
        $onTimeCount = Ticket::where('sla_breached', false)->whereNotNull('resolved_at')->count();
        $breachedCount = Ticket::where('sla_breached', true)->whereNotNull('resolved_at')->count();
        $nearDeadlineCount = Ticket::whereNull('resolved_at')
            ->whereNotNull('target_deadline_at')
            ->where('sla_breached', false)
            ->count();
        $avgResponseHours = Ticket::whereNotNull('first_response_at')->average('response_hours');
        $avgResolutionHours = Ticket::whereNotNull('resolved_at')->average('resolution_hours');

        $statusSummary = Ticket::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $overdueTickets = Ticket::where('sla_breached', true)
            ->with(['service', 'user'])
            ->latest('resolved_at')
            ->limit(10)
            ->get();

        $byService = Ticket::query()
            ->join('services', 'services.id', '=', 'tickets.service_id')
            ->selectRaw('services.name as service_name, count(*) as total, sum(case when tickets.sla_breached = true then 1 else 0 end) as breached')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total')
            ->get();

        $categorySummaries = ServiceCategory::query()
            ->where('service_categories.is_active', true)
            ->leftJoin('services', 'services.category_id', '=', 'service_categories.id')
            ->leftJoin('tickets', 'tickets.service_id', '=', 'services.id')
            ->select('service_categories.id', 'service_categories.name')
            ->selectRaw('count(tickets.id) as total')
            ->selectRaw("sum(case when tickets.status = 'submitted' then 1 else 0 end) as submitted")
            ->selectRaw("sum(case when tickets.status = 'in_progress' then 1 else 0 end) as in_progress")
            ->selectRaw("sum(case when tickets.status = 'completed' then 1 else 0 end) as completed")
            ->selectRaw("sum(case when tickets.status = 'rejected' then 1 else 0 end) as rejected")
            ->groupBy('service_categories.id', 'service_categories.name', 'service_categories.sort_order')
            ->orderBy('service_categories.sort_order')
            ->orderBy('service_categories.name')
            ->get();

        return view('dashboard', [
            'organizationCount' => Organization::count(),
            'userCount' => User::count(),
            'roleCount' => Role::count(),
            'permissionCount' => Permission::count(),
            'serviceCategoryCount' => ServiceCategory::count(),
            'serviceCount' => Service::count(),
            'ticketCount' => $totalTickets,
            'submittedTicketCount' => Ticket::where('status', 'submitted')->count(),
            'resolvedTicketCount' => $resolvedTickets,
            'onTimeCount' => $onTimeCount,
            'breachedCount' => $breachedCount,
            'nearDeadlineCount' => $nearDeadlineCount,
            'slaFulfillmentRate' => $resolvedTickets > 0 ? round(($onTimeCount / $resolvedTickets) * 100, 1) : 0,
            'avgResponseHours' => $avgResponseHours ? round((float) $avgResponseHours, 2) : 0,
            'avgResolutionHours' => $avgResolutionHours ? round((float) $avgResolutionHours, 2) : 0,
            'statusSummary' => $statusSummary,
            'overdueTickets' => $overdueTickets,
            'byService' => $byService,
            'categorySummaries' => $categorySummaries,
        ]);
    }
}
