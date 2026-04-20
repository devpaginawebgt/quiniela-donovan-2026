<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                // 'codigo_id'        =>  1,
                'nombres'          =>  'Dennis',
                'apellidos'        =>  'PWG',
                'numero_documento' =>  '1234567891111',
                'telefono'         =>  '63443212',
                'email'            =>  'dev@paginawebguatemala.com',
                'direccion'        =>  'Ciudad de Guatemala',
                'pais_id'          =>  1,
                'user_type_id'     =>  1,

                'company_id'       =>  1,
                'branch'           =>  'Sucursal 12',
                'colegiado'        => null,
                'region'           => null,
                'capital'          => null,
                'visitor_id'       => null,

                'accepted_terms_version' => '0.1.0',
                'password'         =>  Hash::make(env('DEFAULT_PASS')),
                'created_at'       =>  (Carbon::now())->toDateTimeString(),
            ],

            [
                // 'codigo_id'        =>  2,
                'nombres'          =>  'Dwight',
                'apellidos'        =>  'PWG',
                'numero_documento' =>  '1234567891112',
                'telefono'         =>  '63443212',
                'email'            =>  'app@paginawebguatemala.com',
                'direccion'        =>  'Ciudad de Guatemala',
                'pais_id'          =>  1,
                'user_type_id'     =>  1,

                'company_id'       =>  2,
                'branch'           =>  'Sucursal 20',
                'colegiado'        => null,
                'region'           => null,
                'capital'          => null,
                'visitor_id'       => null,

                'accepted_terms_version' => '0.1.0',
                'password'         =>  Hash::make(env('DEFAULT_PASS')),
                'created_at'       =>  (Carbon::now())->toDateTimeString(),
            ],

            [
                // 'codigo_id'        =>  13,
                'nombres'          =>  'Revisor',
                'apellidos'        =>  'Google',
                'numero_documento' =>  '1234567891113',
                'telefono'         =>  '39987867',
                'email'            =>  'revisor@email.com',
                'direccion'        =>  'Ciudad de Guatemala',
                'pais_id'          =>  1,
                'user_type_id'     =>  2,

                'company_id'       =>  null,
                'branch'           =>  null,
                'colegiado'        => '43552',
                'region'           => 'Central',
                'capital'          => 'Ciudad capital',
                'visitor_id'       => 1,

                'accepted_terms_version' => '0.1.0',
                'password'         =>  Hash::make(env('DEFAULT_PASS')),
                'created_at'       =>  (Carbon::now())->toDateTimeString(),
            ],

            [
                // 'codigo_id'        =>  14,
                'nombres'          =>  'Revisor',
                'apellidos'        =>  'IOS',
                'numero_documento' =>  '1234567891114',
                'telefono'         =>  '83323462',
                'email'            =>  'revisorios@email.com    ',
                'direccion'        =>  'Ciudad de Guatemala',
                'pais_id'          =>  1,
                'user_type_id'     =>  2,

                'company_id'       =>  null,
                'branch'           =>  null,    
                'colegiado'        => '43552',
                'region'           => 'Central',
                'capital'          => 'Ciudad capital',
                'visitor_id'       => 2,

                'accepted_terms_version' => '0.1.0',
                'password'         =>  Hash::make(env('DEFAULT_PASS')),
                'created_at'       =>  (Carbon::now())->toDateTimeString(),
            ],

            [
                // 'codigo_id'        =>  15,
                'nombres'          =>  'Dependiente',
                'apellidos'        =>  'HN',
                'numero_documento' =>  '1234567891115',
                'telefono'         =>  '83773462',
                'email'            =>  'dependientehn@email.com',
                'direccion'        =>  'Atlantida',
                'pais_id'          =>  2,
                'user_type_id'     =>  2,

                'company_id'       =>  null,
                'branch'           =>  null,    
                'colegiado'        => '2345',
                'region'           => 'Central',
                'capital'          => 'Ciudad capital',
                'visitor_id'       => 59,

                'accepted_terms_version' => '0.1.0',
                'password'         =>  Hash::make(env('DEFAULT_PASS')),
                'created_at'       =>  (Carbon::now())->toDateTimeString(),
            ],
        ];

        DB::table('users')->insert($users);

        User::whereIn('id', [1, 2])->each(fn (User $user) => $user->assignRole('admin'));
        User::whereIn('id', [3, 4, 5])->each(fn (User $user) => $user->assignRole('participant'));

        // 500 dependientes (tipo 1) — mixto GT y HN
        // User::factory()->count(250)->dependiente(paisId: 1)->create();
        // User::factory()->count(250)->dependiente(paisId: 2)->create();

        // 500 doctores (tipo 2) — mixto GT y HN
        // User::factory()->count(250)->doctor(paisId: 1)->create();
        // User::factory()->count(250)->doctor(paisId: 2)->create();
    }
}
