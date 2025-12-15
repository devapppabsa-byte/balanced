<?php

namespace App\Imports;

use App\Models\InformacionInputPrecargado;
use Maatwebsite\Excel\Concerns\ToModel;

class InputPrecargadoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new InformacionInputPrecargado([
            



        ]);
    }
}
