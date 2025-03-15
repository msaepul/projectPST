<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan firstOrCreate untuk mencegah duplikat
        Role::firstOrCreate(['role_name' => 'superadmin']);
        Role::firstOrCreate(['role_name' => 'pegawai']);

        User::factory(5)->create(); // Membuat 5 user
    }
}
