<?php

namespace App\Imports;

use App\models\pages\Agente;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class DatosImport implements WithMappedCells, ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function mapping(): array
    {
        return [
            'Agente'  => 'C5',
            'Solicitadas' => 'D5',
            'Aprobadas' => 'E5',
        ];
    }

    public function model(array $row)
    {
        dd($row['Agente'], $row['Solicitadas'], $row['Aprobadas']);
    }
}
