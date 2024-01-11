<?php

namespace App\Http\Controllers;

use App\Models\PreventionAdvisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PreventionAdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preventionAdvisors = PreventionAdvisor::with('user')->get();
        return view('prevention_advisor.index', compact('preventionAdvisors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prevention_advisor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'location' => ['required'],
            'phone' => ['required'],
            'logo' => ['required'],
        ]);

        $file =  $request->file('logo');
        $fileName = (string) Str::uuid();
        $folder = env('DO_FOLDER');

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            file_get_contents($file),
            'public'
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
        ]);

        if ($user) {
            $request->merge([
                'user_id' => $user->id
            ]);

            $preventionAdvisor = PreventionAdvisor::create($request->except(['logo', 'email']));
            $preventionAdvisor->logo = $folder . '/' . $fileName;
            $preventionAdvisor->update();
            return back()->with('success', 'Prevention Advisor Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $preventionalAdvisor = PreventionAdvisor::find($id)->with('kits')->first();
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
            $preventionAdvisor->update($request->except(['logo', 'email']));

            if ($request->file('logo')) {
                $file =  $request->file('logo');
                $fileName = (string) Str::uuid();
                $folder = env('DO_FOLDER');
                $isUploaded = Storage::disk('do')->put(
                    "{$folder}/{$fileName}",
                    file_get_contents($file),
                    'public'
                );

                if ($isUploaded) {
                    $preventionAdvisor->logo = $folder . '/' . $fileName;
                    $preventionAdvisor->update();
                }
            }
            return back()->with('success', 'Data has been updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PreventionAdvisor $preventionAdvisor)
    {
        //
    }

}
