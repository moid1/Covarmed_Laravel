<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Incidents;
use App\Models\Kits;
use App\Models\PreventionAdvisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
            $distinctYears = DB::table('incidents')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');
            $data = $this->getIncidentsReportedByMonth();
            $pieChartData = $this->getCompaniesNamesForIncidentsReported();
            $preventionalAdvisors = PreventionAdvisor::latest()->where('is_verified', true)->limit(5)->get();
            $dashboardStats = $this->getDashboardStatsForAdmin();
            $companies = Company::where('is_active', true)->get();
            return view('home', compact('data', 'preventionalAdvisors', 'pieChartData', 'dashboardStats', 'distinctYears', 'companies'));
        } else if (Auth::user()->user_type == 1) {
            $preventionAdvisorId = PreventionAdvisor::where('user_id', Auth::id())->first();
            $distinctYears = DB::table('incidents')
            ->selectRaw('YEAR(created_at) as year')
            ->where('prevention_advisor_id', $preventionAdvisorId->id)
            ->distinct()
            ->pluck('year');
            $data = $this->getIncidentsReportedByMonthForPV();
            $dashboardStats = $this->getDashboardStatsForPreventionAdvisors();
            $pieChartData = $this->getTotalKitsByMonth();
            return view('prevention_dashboard.home', compact('data', 'dashboardStats', 'pieChartData', 'distinctYears'));
        }
    }

    public function getIncidentsReportedByMonth()
    {
        $currentYear = date('Y');
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Retrieve monthly incidents from the database
        $monthlyIncidents = DB::table('incidents')
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) ASC')
            ->get(['month', 'total']);

        // Create a collection of all months
        $allMonths = collect($months)->map(function ($month) use ($currentYear) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        // Merge the result with the collection of all months
        $mergedData = $allMonths->mapWithKeys(function ($value, $key) use ($monthlyIncidents) {
            $matchingIncident = $monthlyIncidents->firstWhere('month', $value['month']);

            return [$key => $matchingIncident ? $matchingIncident : $value];
        });

        // Extract labels and data from the merged collection
        return [
            'labels' => $mergedData->pluck('month')->toArray(),
            'data' => $mergedData->pluck('total')->toArray(),
        ];
    }

    public function getIncidentsReportedByMonthForPV()
    {
        $preventionAdvisorId = PreventionAdvisor::where('user_id', Auth::id())->first();
        $currentYear = date('Y');
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Retrieve monthly incidents from the database
        $monthlyIncidents = DB::table('incidents')
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('prevention_advisor_id', $preventionAdvisorId->id)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) ASC')
            ->get(['month', 'total']);

        // Create a collection of all months
        $allMonths = collect($months)->map(function ($month) use ($currentYear) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        // Merge the result with the collection of all months
        $mergedData = $allMonths->mapWithKeys(function ($value, $key) use ($monthlyIncidents) {
            $matchingIncident = $monthlyIncidents->firstWhere('month', $value['month']);

            return [$key => $matchingIncident ? $matchingIncident : $value];
        });

        // Extract labels and data from the merged collection
        return [
            'labels' => $mergedData->pluck('month')->toArray(),
            'data' => $mergedData->pluck('total')->toArray(),
        ];
    }

    public function getCompaniesNamesForIncidentsReported()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $companyIncidents = Incidents::join('prevention_advisors', 'incidents.prevention_advisor_id', '=', 'prevention_advisors.id')
            ->join('companies', 'prevention_advisors.company_id', '=', 'companies.id')
            ->whereYear('incidents.created_at', $currentYear)
            ->whereMonth('incidents.created_at', $currentMonth)
            ->select('companies.name as company', DB::raw('COUNT(*) as total'))
            ->groupBy('company')
            ->get();

        return [
            'labels' => $companyIncidents->pluck('company')->toArray(),
            'data' => $companyIncidents->pluck('total')->toArray(),
        ];
    }

    public function getCompanyIncidentsReported($companyID)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        $companyIncidents = Incidents::join('prevention_advisors', 'incidents.prevention_advisor_id', '=', 'prevention_advisors.id')
            ->join('companies', 'prevention_advisors.company_id', '=', 'companies.id')
            ->where('prevention_advisors.company_id', $companyID) // Add this line for filtering by company_id
            ->whereYear('incidents.created_at', $currentYear)
            ->whereMonth('incidents.created_at', $currentMonth)
            ->select('companies.name as company', DB::raw('COUNT(*) as total'))
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
        if ($preventionAdvisor) {
            $totalKits = Kits::where('prevention_advisor_id', $preventionAdvisor->id)->count();
            $totalIncidents = Incidents::where('prevention_advisor_id', $preventionAdvisor->id)->count();
            return [
                'totalKits' => $totalKits,
                'totalIncidents' => $totalIncidents
            ];
        } else {
            return [
                'totalKits' => 0,
                'totalIncidents' => 0
            ];
        }
    }

    public function getTotalKitsByMonth()
    {
        $preventionAdvisor = PreventionAdvisor::whereUserId(Auth::id())->get()->first();
        if ($preventionAdvisor) {
            $monthlyKits = Kits::where('prevention_advisor_id', $preventionAdvisor->id)->selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            return [
                'labels' => $monthlyKits->pluck('month')->toArray(),
                'data' => $monthlyKits->pluck('total')->toArray(),
            ];
        } else {
            return [
                'labels' => [],
                'data' => [],
            ];
        }
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    function getCompaniesIncidentByYear($year)
    {
        $currentYear = $year;
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Retrieve monthly incidents from the database
        $monthlyIncidents = DB::table('incidents')
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderByRaw('MIN(created_at) ASC')
            ->get(['month', 'total']);

        // Create a collection of all months
        $allMonths = collect($months)->map(function ($month) use ($currentYear) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        // Merge the result with the collection of all months
        $mergedData = $allMonths->mapWithKeys(function ($value, $key) use ($monthlyIncidents) {
            $matchingIncident = $monthlyIncidents->firstWhere('month', $value['month']);

            return [$key => $matchingIncident ? $matchingIncident : $value];
        });

        // Extract labels and data from the merged collection
        return [
            'labels' => $mergedData->pluck('month')->toArray(),
            'data' => $mergedData->pluck('total')->toArray(),
        ];
    }
}
