<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:companies'],
            'location' => ['required'],
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

        Company::create([
            'name' => $request->name,
            'logo' => $folder . '/' . $fileName,
            'location' => $request->location
        ]);


        return back()->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $company = Company::find($request->company_id);
        if ($company) {
            $file =  $request->file('logo');
            if ($file) {
                $fileName = (string) Str::uuid();
                $folder = env('DO_FOLDER');

                Storage::disk('do')->put(
                    "{$folder}/{$fileName}",
                    file_get_contents($file),
                    'public'
                );
                $company->logo = $folder . '/' . $fileName;
            }
            $company->name = $request->name;
            $company->location = $request->location;

            $company->update();
            return back()->with('success', 'Company updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }

    public function updateCompanyStatus($id){
        $company = Company::find($id);
        if($company){
            $company->is_active = !$company->is_active;
            $company->update();
            return back()->with('success', 'Company Status changed successfully');
        }
    }
}
