<?php

namespace App\Http\Controllers;

use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class KitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kits = Kits::with('preventionAdvisor')->get();
        return view('kits.index', compact('kits'));
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

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            (QrCode::format('svg')->size(200)->generate($absoluteUrl)),
            'public'
        );

        return view('kits.create', compact('preventionAdvisors', 'unique_code', 'qrCodeFilePath'));
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
            'city' => ['required'],
            'postal_code' => ['required'],
            'country' => ['required'],

        ]);

        try {
            $kit = Kits::create([
                'prevention_advisor_id' => $request->prevention_advisor_id,
                'unique_code' => $request->unique_code,
                'qr_image' => $request->qr_image,
                'name' => $request->name ?? 'N/A',
                'address_1' => $request->address_1 ?? 'N/A',
                'city' => $request->city ?? 'N/A',
                'postal_code' => $request->postal_code ?? 'N/A',
                'country' => $request->country ?? 'N/A'


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
        if($kit){
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
        if($kit){
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

    public function downloadQR($id)
    {
        $kit = Kits::find($id);
        if ($kit) {
            $qrPath = env('DO_CDN_ENDPOINT') . '/' . $kit->qr_image;
            return response()->download($qrPath);
        }
    }
}
