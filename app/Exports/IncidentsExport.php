<?php

namespace App\Exports;

use App\Models\Incidents;
use App\Models\PreventionAdvisor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidentsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user() && Auth::user()->type == 0) {
            return Incidents::all();
        } elseif (Auth::user()->user_type == 1) {
            $preventionalAdvisorId = PreventionAdvisor::where('user_id', Auth::id())->first()->only('id');
            if (!empty($preventionalAdvisorId)) {
                return Incidents::where('prevention_advisor_id', $preventionalAdvisorId['id'])->get();
            }
        }
    }

    public function headings(): array
    {
       
        return [
            "Date",
            "Id",
            "Employee Name",
            "PV Name",
            "Company Name",
            "First-aid Kit Name",
            "First-aid Kit Code",
            "First-aid QR Code",
        ];
    }

    public function map($data): array
    {

        return [
            $data->created_at->format('m/d/Y'),
            $data->id,
            $data->employee_name,
            $data->preventionAdvisor->user->name,
            $data->preventionAdvisor->company->name,
            $data->kit->name,
            $data->kit->unique_code,
            env('DO_CDN_ENDPOINT').'/'.$data->kit->qr_image,

        ];
    }
}
