<?php

namespace App\Imports;

use App\Models\Kit;
use Maatwebsite\Excel\Concerns\ToModel;

class KitsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kit([
            //
        ]);
    }
}
