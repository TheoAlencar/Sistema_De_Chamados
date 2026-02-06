<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar roles se não existirem
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'adm']);
        $tecnicoRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'tecnico']);
        $clienteRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'cliente']);

        // Atribuir roles aos usuários existentes
        $users = \App\Models\User::all();
        foreach ($users as $index => $user) {
            if ($index === 0) {
                $user->assignRole('adm');
            } elseif ($index === 1) {
                $user->assignRole('tecnico');
            } else {
                $user->assignRole('cliente');
            }
        }
    }
}
