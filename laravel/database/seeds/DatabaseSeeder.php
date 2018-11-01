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
          'password' => bcrypt('123456'),
        ]);

        App\User::create([
          'status' => 'Activo',
          'role' => 'Operativo',
          'nombre' => 'Operativo',
          'tipo_cedula' => 'V',
          'cedula' => '0000002',
          'departamento_id' => 1,
          'cargo_id' => 1,
          'password' => bcrypt('123456'),
        ]);

        App\User::create([
          'status' => 'Activo',
          'role' => 'Usuario',
          'nombre' => 'Usuario',
          'tipo_cedula' => 'V',
          'cedula' => '0000003',
          'departamento_id' => 1,
          'cargo_id' => 1,
          'password' => bcrypt('123456'),
        ]);

        App\About::create([
          'email' => 'admin@admin.com',
          'rif' => null,
          'rif_expiracion' => null,
          'registro_mercantil' => null,
          'registro_mercantil_expiracion' => null,
          'patente_industria' => null,
          'patente_industria_expiracion' => null,
          'racda' => null,
          'racda_expiracion' => null,
          'solvencia_ss' => null,
          'solvencia_ss_expiracion' => null,
          'solvencia_ince' => null,
          'solvencia_ince_expiracion' => null,
        ]);

      App\About::create([]);
    }
}
