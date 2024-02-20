<?php

namespace App\Imports;

use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KitsImport implements ToModel, WithHeadingRow
{
  public function model(array $row)
{
    // Generate a unique code for the kit
    $uniqueCode = $this->generateUniqueCode();

    // Construct the absolute URL for the kit
    $absoluteUrl = url('incident-kit/' . $uniqueCode);

    // Generate a unique file name for the QR code
    $fileName = (string) Str::uuid();
    $folder = 'qrcodes';
    $qrCodeFilePath = "{$folder}/{$fileName}";

    // Generate and store the QR code
    Storage::disk('do')->put(
        $qrCodeFilePath,
        QrCode::format('svg')->size(200)->merge(public_path('logo.svg'), 0.4, true)->generate($absoluteUrl),
        'public'
    );

    // Create or update the kit
    return Kits::updateOrCreate(
        ['name' => $row['name']],
        [
            'unique_code' => $uniqueCode,
            'name' => $row['name'],
            'prevention_advisor_id' => (int)$row['prevention_advisor'],
            'qr_image' => $qrCodeFilePath, // Store the path to the QR code file
        ]
    );
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
