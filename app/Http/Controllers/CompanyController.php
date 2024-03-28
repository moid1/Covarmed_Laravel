<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Question;
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


        $companiesWithTotalActiveKits = Company::with('preventionalAdvisors.kits')
            ->get()
            ->map(function ($company) {
                $totalActiveKits = $company->preventionalAdvisors->flatMap(function ($advisor) {
                    return $advisor->kits;
                })->where('is_active', true)->count();

                return [
                    'id' => $company->id,
                    'company_name' => $company->name,
                    'location' => $company->location,
                    'total_active_kits' => $totalActiveKits,
                    'total_preventional_advisors' => $company->preventionalAdvisors->count(),
                    'is_active' => $company->is_active
                ];
            });

        // $companies = Company::with('preventionalAdvisors')->get();

        return view('companies.index', compact('companiesWithTotalActiveKits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        return view('companies.create', compact('questions'));
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
        $questions = null;
        if ($request->questions) {
            $questions = implode(',', $request->questions);
        }
        Company::create([
            'name' => $request->name,
            'logo' => $folder . '/' . $fileName,
            'location' => $request->location,
            'password' => $request->password,
            'questions' => $questions ? implode(',', $request->questions) : null,
            'is_name_required' => $request->is_name_required ?? false
        ]);


        return back()->with('success', trans('Company created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::find($id);
        $questions = Question::all();
        return view('companies.show', compact('company', 'questions'));
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
            $company->questions = implode(',', $request->questions);
            $company->location = $request->location;
            $company->is_name_required = $request->is_name_required ? true : false;
            if ($request->password) {
                $company->password = $request->password;
            }


            $company->update();
            return back()->with('success', 'Company successfully updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }

    public function updateCompanyStatus($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->is_active = !$company->is_active;
            $company->update();
            return back()->with('success', 'Company Status changed successfully');
        }
    }
}
