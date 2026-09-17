<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'slug' => 'admin', 'descripcion' => 'Acceso total al sistema', 'creado_en' => now()],
            ['nombre' => 'Responsable de Calidad', 'slug' => 'resp_calidad', 'descripcion' => 'Aprueba o rechaza solicitudes documentales y gestiona versiones', 'creado_en' => now()],
            ['nombre' => 'Líder de Área', 'slug' => 'lider_area', 'descripcion' => 'Radica solicitudes documentales de su área y consulta formatos', 'creado_en' => now()],
        ]);
    }
}