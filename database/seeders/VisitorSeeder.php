<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visitadores = [
            [ 'name' => 'Iris Marisol',       'lastname' => 'Trujillo Mena' ],
            [ 'name' => 'Maria Alejandra',    'lastname' => 'Velásquez' ],
            [ 'name' => 'Lester Eduardo',     'lastname' => 'Illescas Urlá' ],
            [ 'name' => 'Sharon Isabel',      'lastname' => 'Pozuelos Pineda' ],
            [ 'name' => 'Mario Fernando',     'lastname' => 'de Leon G.' ],
            [ 'name' => 'José Ricardo',       'lastname' => 'Chajón Castillo' ],
            [ 'name' => 'Dennis Francisco',   'lastname' => 'Valderramos' ],
            [ 'name' => 'Francisco José',     'lastname' => 'Girón Díaz' ],
            [ 'name' => 'Julio Alberto',      'lastname' => 'Rodríguez' ],
            [ 'name' => 'Gerber Antonio',     'lastname' => 'Solares Calvillo' ],
            [ 'name' => 'Greyssi Mariela',    'lastname' => 'Mazá Trujillo' ],
            [ 'name' => 'José Geovany',       'lastname' => 'Tenas Mateo' ],
            [ 'name' => 'María Sonia',        'lastname' => 'Castillo Alvarado' ],
            [ 'name' => 'Karla Leticia',      'lastname' => 'Juárez Rosales' ],
            [ 'name' => 'Enrique José',       'lastname' => 'Morataya Pacheco' ],
            [ 'name' => 'Ivan Armando',       'lastname' => 'Azurdia Alvizurez' ],
            [ 'name' => 'Byron Salvador',     'lastname' => 'Estrada Ortiz' ],
            [ 'name' => 'Jorge Alejandro',    'lastname' => 'Solares Arriola' ],
            [ 'name' => 'Juan Carlos',        'lastname' => 'Gálvez Cardona' ],
            [ 'name' => 'Joseph Anthony',     'lastname' => 'Illescas Guevara' ],
            [ 'name' => 'Pablo Alejandro',    'lastname' => 'Barrios Tolosa' ],
            [ 'name' => 'Karen Ivette',       'lastname' => 'Lima Quelex' ],
            [ 'name' => 'Dulce María',        'lastname' => 'Ramos' ],
            [ 'name' => 'María Angela',       'lastname' => 'Mencos Orantes' ],
            [ 'name' => 'Jinmy Estuardo',     'lastname' => 'Monterroso Maldonado' ],
            [ 'name' => 'Maria José',         'lastname' => 'Alvarado Castellanos' ],
            [ 'name' => 'Joselin Marielos',   'lastname' => 'Telón Orellana' ],
            [ 'name' => 'Edwin Obdulio',      'lastname' => 'Herrera Cortez' ],
            [ 'name' => 'Fernando Alfonso',   'lastname' => 'Ruiz Esquivel' ],
            [ 'name' => 'Pablo José',         'lastname' => 'Lemus Román' ],
            [ 'name' => 'Ligda Abigail',      'lastname' => 'Pérez Navas' ],
            [ 'name' => 'Sergio Antonio',     'lastname' => 'Fernández Vásquez' ],
            [ 'name' => 'Madelin Yesenia',    'lastname' => 'Mijangos Flores' ],
            [ 'name' => 'Lesly Jeanethe',     'lastname' => 'Kuckling Solis' ],
            [ 'name' => 'Jorge Mario',        'lastname' => 'López González' ],
            [ 'name' => 'Mersy Abigail',      'lastname' => 'Morales Soto' ],
            [ 'name' => 'Elmer Oswaldo',      'lastname' => 'Alonzo Briones' ],
            [ 'name' => 'Everth Leonel',      'lastname' => 'Marroquín Estrada' ],
            [ 'name' => 'Marilin Paola',      'lastname' => 'Mejía Cosajay' ],
            [ 'name' => 'Yenni Liset',        'lastname' => 'Miranda' ],
            [ 'name' => 'Amanda Mishel',      'lastname' => 'González Marroquín' ],
            [ 'name' => 'José Alfredo',       'lastname' => 'Díaz Morán' ],
            [ 'name' => 'Maria Fernanda',     'lastname' => 'Valdez Ravanales' ],
            [ 'name' => 'Adamaris Samantha',  'lastname' => 'Godoy Ramos' ],
            [ 'name' => 'Josué Daniel',       'lastname' => 'Tala González' ],
            [ 'name' => 'Jorge Antonio',      'lastname' => 'Muñoz Echeverría' ],
            [ 'name' => 'Brenda Regina',      'lastname' => 'López Márquez' ],
            [ 'name' => 'Mario Alfredo',      'lastname' => 'Fuentes Castillo' ],
            [ 'name' => 'Onayda Judiza',      'lastname' => 'De León Mazariegos' ],
            [ 'name' => 'Genzer Engadi',      'lastname' => 'González López' ],
            [ 'name' => 'Luis Manuel',        'lastname' => 'Maldonado de León' ],
            [ 'name' => 'Werner Estuardo',    'lastname' => 'Díaz Girón' ],
            [ 'name' => 'Ricardo Francisco',  'lastname' => 'Gatica Oquendo' ],
            [ 'name' => 'Allan René',         'lastname' => 'Arreaga de León' ],
            [ 'name' => 'Carlos Ivan',        'lastname' => 'Velazquez' ],
            [ 'name' => 'Luis Diego',         'lastname' => 'Carrascosa Gutiérrez' ],
            [ 'name' => 'Mario José',         'lastname' => 'Ortiz Ruiz' ],
            [ 'name' => 'Humberto Josué',     'lastname' => 'Calderón Alvarado' ],
        ];

        foreach($visitadores as $visitador) {
            Visitor::create($visitador);
        }
    }
}
