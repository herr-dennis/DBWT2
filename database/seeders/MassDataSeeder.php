<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbUser;
class MassDataSeeder extends Seeder
{

    public function run(): void
    {
        AbUser::factory()->count(10000)->create();
    }
}
