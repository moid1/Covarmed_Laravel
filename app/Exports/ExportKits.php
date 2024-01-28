<?php

namespace App\Exports;

use App\Models\Kits;
use App\Models\PreventionAdvisor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportKits implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user()->user_type == 0)
            return Kits::with('preventionAdvisor')->get();
        else {
            $pv = PreventionAdvisor::where('user_id', Auth::id())->first();
            return Kits::where('prevention_advisor_id', $pv->id)->get();
        }
    }

    public function headings(): array
    {
        return [
            "id",
            "Unique Code",
            "Name",
            'Company',
            'Prevention Advisor',
            'QR',
        ];
    }

    public function map($data): array
    {

        return [
            $data->id,
            $data->unique_code,
            $data->name,
            $data->preventionAdvisor->company->name,
            $data->preventionAdvisor->user->name,
            env('DO_CDN_ENDPOINT') . '/' . $data->qr_image,
        ];
    }
}
