<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', env('ADMIN_EMAIL'))->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => env('ADMIN_EMAIL'),
                'password' => Hash::make(env('ADMIN_PASS')),
            ]);
        }
    }
}
