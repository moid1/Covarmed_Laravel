<?php

namespace App\Http\Controllers;

use App\Mail\IncidentFilledForm;
use App\Models\Incidents;
use App\Models\Kits;
use App\Models\PreventionAdvisor;
use App\Models\Question;
use App\Models\QuestionsAnswers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidentsExport;

class IncidentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents  = null;
        $isSeniour = false;
        $pv = PreventionAdvisor::where('user_id', Auth::id())->first();
        if (Auth::user()->user_type == 0) {
            $incidents = Incidents::all();
        } elseif (Auth::user()->user_type == 1) {
            if ($pv->is_seniour) {
                $isSeniour = true;
                $seniourPVCompanyID = $pv->company_id;
                $allPVAdvisorsForSeniourPVCompany = PreventionAdvisor::where('company_id',  $seniourPVCompanyID)->get()->pluck('id');
                if (!empty($allPVAdvisorsForSeniourPVCompany)) {
                    $incidents = Incidents::whereIn('prevention_advisor_id', $allPVAdvisorsForSeniourPVCompany)->get();
                }
            } else {
                $preventionalAdvisorId = PreventionAdvisor::where('user_id', Auth::id())->first()->only('id');
                if (!empty($preventionalAdvisorId)) {
                    $incidents = Incidents::where('prevention_advisor_id', $preventionalAdvisorId['id'])->get();
                }
            }
        }

        return view('incidents.index', compact('incidents', 'isSeniour'));
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
    public function show($id)
    {
        $incident = Incidents::whereId($id)->with(['questionAnswers', 'preventionAdvisor', 'kit'])->first();
        return view('incidents.show', compact('incident'));
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

   public function createIncidentForm($code, Request $request)
{
    $kit = Kits::where('unique_code', $code)->with('preventionAdvisor')->first();
    
    if ($kit) {
        $questionsString = $kit->preventionAdvisor->company->questions;
        $questions =  null;
        if ($questionsString) {
            $questionValues = explode(',', $questionsString);
            $questions = Question::whereIn('id', $questionValues)->get();
        }
        $companyPassword = $kit->preventionAdvisor->company->password;

        $selectedLanguage = app()->getLocale();
        return view('incidents.create', compact('kit', 'questions', 'companyPassword', 'selectedLanguage'));
    } else {
        dd('Kit is not available');
    }
}


    public function submitIncident(Request $request)
    {

        // $this->validate($request, [
        //     'employee_name' => ['required', 'string', 'max:255'],
        // ]);
        // Extracting the employee name from the request
        $employeeName = $request->has('employee_name') ? $request->input('employee_name') : '';

        // Creating the incident record with the employee name if available
        $incident = Incidents::create([
            'employee_name' => $employeeName,
            'prevention_advisor_id' => $request->input('prevention_advisor_id'),
            'kit_id' => $request->input('kit_id'),
        ]);

        $kit = Kits::whereId($request->kit_id)->with('preventionAdvisor')->first();
        if ($kit) {
            $questionsString = $kit->preventionAdvisor->company->questions;
            $form = Question::findOrFail($questionsString);
            if ($form) {
                QuestionsAnswers::create([
                    'incident_id' => $incident->id,
                    'question_id' => $form->id,
                    'answers' => json_encode($request->except(['_token', 'prevention_advisor_id', 'kit_id', 'language-picker-select', 'employee_name']))
                ]);
            }
            // if ($questionsString) {
            //     $questionValues = explode(',', $questionsString);
            //     foreach ($questionValues as $key => $questionID) {
            //         // Check if the question exists
            //         $question = Question::find($questionID);
            
            //         // Proceed only if the question exists
            //         if ($question) {
            //             $questionId = $request->input('question_' . $questionID);
            //             if (is_array($questionId)) {
            //                 $questionId = implode(',', $questionId);
            //             }
            
            //             QuestionsAnswers::create([
            //                 'incident_id' => $incident->id,
            //                 'question_id' => $questionID,
            //                 'answers' => $questionId 
            //             ]);
            //         } else {
            //             // Handle case where question does not exist
            //             // This could be logging an error, skipping this question, or any other appropriate action
            //         }
            //     }
            // }

            $details = [
                'link' => route('incident.show', $incident->id)
            ];
            Mail::to($kit->preventionAdvisor->user->email)->send(new IncidentFilledForm($details));
        }

        return back()->with('success', 'Your Incident is reported to preventional advisor');
    }

    public function exportIncidentReport($id)
    {
        $incident = Incidents::whereId($id)->with(['questionAnswers', 'preventionAdvisor', 'kit'])->first();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('incidents.export', ['incident' => $incident]);
        return $pdf->stream();
    }

    public function exportIncidents()
    {
        return Excel::download(new IncidentsExport, 'incidents.xlsx');
    }
}
