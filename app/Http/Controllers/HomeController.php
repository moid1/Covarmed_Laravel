<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->user_type == 0) {
            $data = $this->getIncidentsReportedByMonth();
            $pieChartData = $this->getCompaniesNamesForIncidentsReported();
            $preventionalAdvisors = PreventionAdvisor::latest()->limit(5)->get();
            $dashboardStats = $this->getDashboardStatsForAdmin();
            return view('home', compact('data', 'preventionalAdvisors', 'pieChartData', 'dashboardStats'));
        } else if (Auth::user()->user_type == 1) {
            $data = $this->getIncidentsReportedByMonthPreventionAdvisor();
            $dashboardStats = $this->getDashboardStatsForPreventionAdvisors();
            $pieChartData = $this->getTotalKitsByMonth();
            return view('prevention_dashboard.home', compact('data', 'dashboardStats', 'pieChartData'));
        }
    }

    public function getIncidentsReportedByMonth()
    {
        $monthlyIncidents = Incidents::selectRaw('CONCAT(YEAR(created_at), "-", DATE_FORMAT(created_at, "%M")) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        return [
            'labels' => $monthlyIncidents->pluck('month')->toArray(),
            'data' => $monthlyIncidents->pluck('total')->toArray(),
        ];
    }

    public function getIncidentsReportedByMonthPreventionAdvisor()
    {
        $preventionAdvisor = PreventionAdvisor::whereUserId(Auth::id())->first();

        $monthlyIncidents = Incidents::where('prevention_advisor_id', $preventionAdvisor->id)->selectRaw('CONCAT(YEAR(created_at), "-", DATE_FORMAT(created_at, "%M")) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        return [
            'labels' => $monthlyIncidents->pluck('month')->toArray(),
            'data' => $monthlyIncidents->pluck('total')->toArray(),
        ];
    }

    public function getCompaniesNamesForIncidentsReported()
    {
        $companyIncidents = Incidents::join('prevention_advisors', 'incidents.prevention_advisor_id', '=', 'prevention_advisors.id')
            ->select('prevention_advisors.company_name as company', DB::raw('COUNT(*) as total'))
            ->groupBy('company')
            ->get();
        return [
            'labels' => $companyIncidents->pluck('company')->toArray(),
            'data' => $companyIncidents->pluck('total')->toArray(),
        ];
    }

    public function getDashboardStatsForAdmin()
    {
        $totalPreventionalAdvisors = PreventionAdvisor::count();
        $totalKits = Kits::count();
        $totalIncidents = Incidents::count();
        return [
            'totalPreventionalAdvisors' => $totalPreventionalAdvisors,
            'totalKits' => $totalKits,
            'totalIncidents' => $totalIncidents
        ];
    }

    public function getDashboardStatsForPreventionAdvisors()
    {
        $preventionAdvisor = PreventionAdvisor::whereUserId(Auth::id())->get()->first();
        $totalKits = Kits::where('prevention_advisor_id', $preventionAdvisor->id)->count();
        $totalIncidents = Incidents::where('prevention_advisor_id', $preventionAdvisor->id)->count();
        return [
            'totalKits' => $totalKits,
            'totalIncidents' => $totalIncidents
        ];
    }

    public function getTotalKitsByMonth()
    {
        $preventionAdvisor = PreventionAdvisor::whereUserId(Auth::id())->get()->first();

        $monthlyKits = Kits::where('prevention_advisor_id', $preventionAdvisor->id)->selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'labels' => $monthlyKits->pluck('month')->toArray(),
            'data' => $monthlyKits->pluck('total')->toArray(),
        ];
    }
}
