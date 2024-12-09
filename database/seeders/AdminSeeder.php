<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'codigo' => '000001',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('residentado123'), // asegúrate de cambiar esto por una contraseña segura
            'remember_token' => Str::random(10),
            'dni' => '12345678',
            'user_type' => 1, // 1 para admin
            'is_delete' => 0, // 0 para no eliminado
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
