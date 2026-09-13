<?php

namespace Modules\SGC\Database\Seeders;

use Illuminate\Database\Seeder;

class SGCDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(SGCSeeder::class);
    }
}
