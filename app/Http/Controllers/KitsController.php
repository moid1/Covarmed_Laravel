<?php

namespace App\Http\Controllers;

use App\Exports\ExportKits;
use App\Imports\KitsImport;
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
use Intervention\Image\Facades\Image;

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
            if ($pvId->is_seniour) {
                $seniourPVCompanyID = $pvId->company_id;
                $allPVAdvisorsForSeniourPVCompany = PreventionAdvisor::where('company_id',  $seniourPVCompanyID)->get()->pluck('id');
                if (!empty($allPVAdvisorsForSeniourPVCompany)) {
                    $kits = Kits::with('preventionAdvisor')->whereIn('prevention_advisor_id', $allPVAdvisorsForSeniourPVCompany)->get();
                }
            } else {
                $kits = Kits::with('preventionAdvisor')->where('prevention_advisor_id', $pvId->id)->get();
            }


            return view('kits.index', compact('kits'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{ phpinfo();
    exit;
    $preventionAdvisors = PreventionAdvisor::where('is_verified', 1)->with('user')->get();
    $unique_code = $this->generateUniqueCode();

    

    $fileName = (string) Str::uuid();
    $folder = 'qrcodes';
    $qrCodeFilePath = "{$folder}/{$fileName}";
    $absoluteUrl = url('incident-kit/' . $unique_code);

    $companies  = Company::where('is_active', true)->get();
    $qrCode = QrCode::format('png')
    ->size(200)
    ->merge(public_path('logo.jpg'), 0.8, true)
    ->errorCorrection('H')
    ->generate($absoluteUrl);

// Save the QR code to a temporary file
$tempQrCodePath = tempnam(sys_get_temp_dir(), 'qr_code');
file_put_contents($tempQrCodePath, $qrCode);

// Load the QR code image using Intervention Image
$image = Image::make($tempQrCodePath);

// Create a new canvas image
$canvas = Image::canvas($image->width(), $image->height());

// Insert the QR code onto the canvas
$canvas->insert($image);

// Add company name as text overlay
$canvas->text('testingCompany', $canvas->width() / 2, $canvas->height() + 20, function($font) {
    $font->size(24);
    $font->color('#000000');
    $font->align('center');
    $font->valign('bottom');
});

// Save the canvas image
Storage::disk('do')->put("{$folder}/{$fileName}", $canvas->encode(), 'public');

// Clean up temporary QR code file
unlink($tempQrCodePath);

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

            return back()->with('success', trans('First-aid Kit created succesfully'));
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
            $kit->update($request->except(['unique_code', 'kit_id', 'company']));
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
            $isSvg = strpos($output, '<svg') !== false;
            if ($isSvg) {
                $pdfPath = time() . '.svg';
            } else {
                $pdfPath = time() . '.png';
            }
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

    public function importKits(Request $request)
    {

            Excel::import(new KitsImport, $request->file);

            // Provide feedback to the user
            return redirect()->back()->with('success', 'Data imported successfully!');
    }
}
