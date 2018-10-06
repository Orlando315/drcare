<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        App\Departamento::create([
          'departamento' => 'ADMINISTRACIÓN',
        ]);

        App\Cargo::create([
          'departamento_id'   => 1,
          'cargo' => 'GERENTE DE CONTRALORIA',
        ]);

        App\User::create([
          'status' => 'Activo',
          'role' => 'Admin',
          'nombre' => 'Administrador',
          'tipo_cedula' => 'V',
          'cedula' => '0000001',
          'departamento_id' => 1,
          'cargo_id' => 1,
          'password' => bcrypt('admin123456'),
        ]);
    }
}
