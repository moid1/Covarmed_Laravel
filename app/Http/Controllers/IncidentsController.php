<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents  = null;
        if (Auth::user()->user_type == 0) {
            $incidents = Incidents::all();
        } elseif (Auth::user()->user_type == 1) {
            $preventionalAdvisorId = PreventionAdvisor::where('user_id', Auth::id())->first()->only('id');
            if (!empty($preventionalAdvisorId)) {
                $incidents = Incidents::where('prevention_advisor_id', $preventionalAdvisorId['id'])->get();
            }
        }

        return view('incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidents $incidents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidents $incidents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidents $incidents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidents $incidents)
    {
        //
    }

    public function createIncidentForm($code)
    {
        $kit = Kits::where('unique_code', $code)->with('preventionAdvisor')->first();
        if ($kit)
            return view('incidents.create', compact('kit'));
    }

    public function submitIncident(Request $request)
    {

        $this->validate($request, [
            'employee_name' => ['required', 'string', 'max:255'],
            'kit_use_reason' => ['required'],
            'taken_from_kit' => ['required'],
        ]);

        Incidents::create($request->all());
        return back()->with('success', 'Your Incident is reported to preventional advisor');
    }
}
