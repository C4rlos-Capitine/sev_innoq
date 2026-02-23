<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [
            'Maputo Provincia',
            'Maputo Cidade',
            'Gaza',
            'Inhambane',
            'Sofala',
            'Manica',
            'Tete',
            'Niassa',
            'Nampula',
            'Zambézia',
            'Cabo Delgado',
        ];

        foreach ($provincias as $nome) {
            \App\Models\Provincia::create(['nome_provincia' => $nome]);
        }
    }
}
