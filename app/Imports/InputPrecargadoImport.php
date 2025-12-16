<?php

namespace App\Imports;

use App\Models\InformacionInputPrecargado;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use App\Models\CampoForaneo;
use App\Models\CampoForaneoInformacion;
use Illuminate\Support\Collection;

class InputPrecargadoImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

                foreach ($rows as $row) {

                    if (!$row['id'] || !$row['informacion']) {
                        continue;
                    }


                    $campoForaneo = CampoForaneo::firstOrCreate(
                        ['id_input' => $row['id']],
                        ['nombre'   => $row['nombre']],
                        ['descripcion' => $row['descripcion']]
                    );


                    CampoForaneoInformacion::create([
                        'id_campo_foraneo' => $campoForaneo->id,
                        'informacion'      => $row['informacion'],
                        'mes'              => $row['mes'],
                        'year'             => $row['year'],
                    ]);


                    //Aqui puedo poner la logica 
                    $input_precargado = CampoPrecargado::where('id_input_foraneo', $campoForaneo->id)->firts();

                    if($input_precargado){

                        InformacionInputPrecargado::create([
                            'informacion' => $row['informacion'],
                            'id_input_precargado' => $input_precargado->id,
                            
                        ]);

                    }

                }
            });
    }
}
