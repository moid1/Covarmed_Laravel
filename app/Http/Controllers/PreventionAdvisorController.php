<?php

namespace App\Http\Controllers;

use App\Mail\RegisterPreventionalAdvisor;
use App\Models\Company;
use App\Models\PreventionAdvisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PreventionAdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preventionAdvisors = PreventionAdvisor::with(['user','company'])->get();
        return view('prevention_advisor.index', compact('preventionAdvisors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('is_active', true)->get();
        return view('prevention_advisor.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);


        $user = User::create([
            'name' => 'Not Defined',
            'email' => $request->email,
            'password' => Hash::make('12345678'),
        ]);

        if ($user) {
          
            $isSenior = $request->pv_role == 'spv' ? true : false;

            $request->merge([
                'user_id' => $user->id,
                'is_seniour' => $isSenior
            ]);





            $preventionAdvisor = PreventionAdvisor::create($request->except(['logo', 'email']));

            // Need to send email to preventionalAdvisor
            $link = route('prevention.advisor.showregisterformviamail', $preventionAdvisor->id);
            $details = [
                'link' =>$link
            ];
            Mail::to($request->email)->send(new RegisterPreventionalAdvisor($details));

            return back()->with('success', trans('Verification link send to the prevention advisor'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $preventionalAdvisor = PreventionAdvisor::whereId($id)->with(['kits','user','company'])->first();
        return view('prevention_advisor.show', compact('preventionalAdvisor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreventionAdvisor $preventionAdvisor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $preventionAdvisor = PreventionAdvisor::find($id);
        if ($preventionAdvisor) {
            $preventionAdvisor->phone = $request->phone;
            $preventionAdvisor->is_seniour = $request->pv_role == 'spv' ? true : false;
            $preventionAdvisor->update();
            $user = User::find($preventionAdvisor->user_id);
            if ($user) {
                $user->update(['name' => $request->name]);
            }
            return back()->with('success', 'Advisor succesfully updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PreventionAdvisor::whereId($id)->delete();
        return back()->with('success', 'Preventional Advisor is deleted');
    }

    public function showRegisterFormViaMail($preventionalId)
    {
        $preventionAdvisor = PreventionAdvisor::where('id', $preventionalId)->with('user')->first();
        if ($preventionAdvisor) {
            return view('prevention_advisor.register_form_mail', compact('preventionAdvisor'));
        } else {
            dd('Something bad happend');
        }
    }

    public function updateViaEmail(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8'],
            'prevention_advisor_id' => ['required', 'exists:prevention_advisors,id'],
        ]);

        $preventionAdvisor = PreventionAdvisor::find($request->prevention_advisor_id);
        if ($preventionAdvisor) {
            $preventionAdvisor->update([
                'phone' => $request->phone,
                'is_verified' => true,
            ]);
            $user = User::find($preventionAdvisor->user_id);
            if ($user) {
                $user->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                ]);
            }

            return redirect('/login');
        }
    }
}
