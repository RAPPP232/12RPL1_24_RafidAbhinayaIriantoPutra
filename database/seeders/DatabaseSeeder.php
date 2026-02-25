<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Part;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Supervisor',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator 1',
            'email' => 'operator@example.com',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        User::create([
            'name' => 'QC Inspector',
            'email' => 'qc@example.com',
            'password' => Hash::make('password'),
            'role' => 'qc_inspector',
        ]);

        // Create Parts
        Part::create(['code' => 'P001', 'name' => 'Brake Pad', 'description' => 'Kampas rem mobil']);
        Part::create(['code' => 'P002', 'name' => 'Piston Ring', 'description' => 'Ring piston mesin']);
        Part::create(['code' => 'P003', 'name' => 'Clutch Disc', 'description' => 'Piringan kopling']);
    }
}
