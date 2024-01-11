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
        $preventionAdvisors = PreventionAdvisor::all();
        $unique_code = $this->generateUniqueCode();

        $fileName = (string) Str::uuid();
        $folder = 'qrcodes';
        $qrCodeFilePath = "{$folder}/{$fileName}";

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            (QrCode::format('svg')->size(200)->generate($unique_code)),
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
        ]);

        $kit = Kits::create([
            'prevention_advisor_id' => $request->prevention_advisor_id,
            'unique_code' => $request->unique_code,
            'qr_image' => $request->qr_image
        ]);

        return back()->with('success', 'Kit is created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kits $kits)
    {
        //
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
    public function update(Request $request, Kits $kits)
    {
        //
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
}
