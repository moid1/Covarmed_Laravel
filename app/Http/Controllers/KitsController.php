<?php

namespace App\Http\Controllers;

use App\Exports\ExportKits;
use App\Models\Company;
use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class KitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->user_type == 0) {
            $kits = Kits::with('preventionAdvisor')->get();
            return view('kits.index', compact('kits'));
        } else {
            $pvId = PreventionAdvisor::where('user_id', Auth::id())->first();
            $kits = Kits::with('preventionAdvisor')->where('prevention_advisor_id', $pvId->id)->get();
            return view('kits.index', compact('kits'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $preventionAdvisors = PreventionAdvisor::where('is_verified', 1)->with('user')->get();
        $unique_code = $this->generateUniqueCode();

        $fileName = (string) Str::uuid();
        $folder = 'qrcodes';
        $qrCodeFilePath = "{$folder}/{$fileName}";
        $absoluteUrl = url('incident-kit/' . $unique_code);

        $companies  = Company::where('is_active', true)->get();

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            (QrCode::format('svg')->size(200)->generate($absoluteUrl)),
            'public'
        );

        return view('kits.create', compact('preventionAdvisors', 'unique_code', 'qrCodeFilePath', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'unique_code' => ['required', 'string', 'max:255'],
            'prevention_advisor_id' => ['required'],
            'qr_image' => ['required'],
            'name' => ['required'],
            'address_1' => ['required'],

        ]);

        try {
            $kit = Kits::create([
                'prevention_advisor_id' => $request->prevention_advisor_id,
                'unique_code' => $request->unique_code,
                'qr_image' => $request->qr_image,
                'name' => $request->name ?? 'N/A',
                'address_1' => $request->address_1 ?? 'N/A',
            ]);

            return back()->with('success', 'Kit is created successfully');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kit = Kits::find($id);
        if (Auth::user()->user_type == 1) {
            return view('kits.pv.show', compact('kit'));
        }

        if ($kit) {
            $preventionAdvisors = PreventionAdvisor::where('is_verified', true)->get();
            return view('kits.show', compact('kit', 'preventionAdvisors'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kits $kits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $kit = Kits::find($request->kit_id);
        if ($kit) {
            $kit->update($request->except(['unique_code', 'kit_id']));
            return back()->with('success', 'Kit is updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kits $kits)
    {
        //
    }

    function generateRandomCode()
    {
        // Generate your random code here
        // You can use Str::random() to generate a random string in Laravel
        return Str::random(8); // Adjust the length as needed
    }

    function generateUniqueCode()
    {
        $code = $this->generateRandomCode();

        // Check if the code already exists in the "kid" column
        while (Kits::where('unique_code', $code)->exists()) {
            $code = $this->generateRandomCode();; // Regenerate the code if it already exists
        }

        return $code;
    }


    public function updateKitStatus($id)
    {
        $kit = Kits::find($id);
        if ($kit) {
            $kit->is_active = !$kit->is_active;
            $kit->update();
            return back()->with('success', 'Kit Status has been changed successfully');
        } else {
            return back()->with('error', 'No Kit Found');
        }
    }

    public function getPreventionalAdvisorsForCompany($companyId)
    {
        $preventionalAdvisors = PreventionAdvisor::where([['company_id', $companyId], ['is_verified', true]])->with('user')->get();
        return $preventionalAdvisors;
    }

    public function downloadQr($kitId)
    {
        $kit = Kits::find($kitId);
        if ($kit) {
            $output = file_get_contents(env('DO_CDN_ENDPOINT') . '/' . $kit->qr_image);
            $pdfPath = time() . '.svg';
            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename=' . $pdfPath,
            ];
            // Return the response with the file contents and headers
            return Response::make($output, 200, $headers)->withHeaders([
                'Cache-Control' => 'private',
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename=' . $pdfPath,
            ]);

            return redirect('/');
        }
    }

    public function exportKits()
    {
        return Excel::download(new ExportKits, 'kits.xlsx');
    }
}
