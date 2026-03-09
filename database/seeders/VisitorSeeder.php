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
            [ 'name' => 'Iris Marisol',      'lastname' => 'Trujillo Mena',        'country_id' => 1],
            [ 'name' => 'Maria Alejandra',   'lastname' => 'Velásquez',            'country_id' => 1],
            [ 'name' => 'Lester Eduardo',    'lastname' => 'Illescas Urlá',        'country_id' => 1],
            [ 'name' => 'Sharon Isabel',     'lastname' => 'Pozuelos Pineda',      'country_id' => 1],
            [ 'name' => 'Mario Fernando',    'lastname' => 'de Leon G.',           'country_id' => 1],
            [ 'name' => 'José Ricardo',      'lastname' => 'Chajón Castillo',      'country_id' => 1],
            [ 'name' => 'Dennis Francisco',  'lastname' => 'Valderramos',          'country_id' => 1],
            [ 'name' => 'Francisco José',    'lastname' => 'Girón Díaz',           'country_id' => 1],
            [ 'name' => 'Julio Alberto',     'lastname' => 'Rodríguez',            'country_id' => 1],
            [ 'name' => 'Gerber Antonio',    'lastname' => 'Solares Calvillo',     'country_id' => 1],
            [ 'name' => 'Greyssi Mariela',   'lastname' => 'Mazá Trujillo',        'country_id' => 1],
            [ 'name' => 'José Geovany',      'lastname' => 'Tenas Mateo',          'country_id' => 1],
            [ 'name' => 'María Sonia',       'lastname' => 'Castillo Alvarado',    'country_id' => 1],
            [ 'name' => 'Karla Leticia',     'lastname' => 'Juárez Rosales',       'country_id' => 1],
            [ 'name' => 'Enrique José',      'lastname' => 'Morataya Pacheco',     'country_id' => 1],
            [ 'name' => 'Ivan Armando',      'lastname' => 'Azurdia Alvizurez',    'country_id' => 1],
            [ 'name' => 'Byron Salvador',    'lastname' => 'Estrada Ortiz',        'country_id' => 1],
            [ 'name' => 'Jorge Alejandro',   'lastname' => 'Solares Arriola',      'country_id' => 1],
            [ 'name' => 'Juan Carlos',       'lastname' => 'Gálvez Cardona',       'country_id' => 1],
            [ 'name' => 'Joseph Anthony',    'lastname' => 'Illescas Guevara',     'country_id' => 1],
            [ 'name' => 'Pablo Alejandro',   'lastname' => 'Barrios Tolosa',       'country_id' => 1],
            [ 'name' => 'Karen Ivette',      'lastname' => 'Lima Quelex',          'country_id' => 1],
            [ 'name' => 'Dulce María',       'lastname' => 'Ramos',                'country_id' => 1],
            [ 'name' => 'María Angela',      'lastname' => 'Mencos Orantes',       'country_id' => 1],
            [ 'name' => 'Jinmy Estuardo',    'lastname' => 'Monterroso Maldonado', 'country_id' => 1],
            [ 'name' => 'Maria José',        'lastname' => 'Alvarado Castellanos', 'country_id' => 1],
            [ 'name' => 'Joselin Marielos',  'lastname' => 'Telón Orellana',       'country_id' => 1],
            [ 'name' => 'Edwin Obdulio',     'lastname' => 'Herrera Cortez',       'country_id' => 1],
            [ 'name' => 'Fernando Alfonso',  'lastname' => 'Ruiz Esquivel',        'country_id' => 1],
            [ 'name' => 'Pablo José',        'lastname' => 'Lemus Román',          'country_id' => 1],
            [ 'name' => 'Ligda Abigail',     'lastname' => 'Pérez Navas',          'country_id' => 1],
            [ 'name' => 'Sergio Antonio',    'lastname' => 'Fernández Vásquez',    'country_id' => 1],
            [ 'name' => 'Madelin Yesenia',   'lastname' => 'Mijangos Flores',      'country_id' => 1],
            [ 'name' => 'Lesly Jeanethe',    'lastname' => 'Kuckling Solis',       'country_id' => 1],
            [ 'name' => 'Jorge Mario',       'lastname' => 'López González',       'country_id' => 1],
            [ 'name' => 'Mersy Abigail',     'lastname' => 'Morales Soto',         'country_id' => 1],
            [ 'name' => 'Elmer Oswaldo',     'lastname' => 'Alonzo Briones',       'country_id' => 1],
            [ 'name' => 'Everth Leonel',     'lastname' => 'Marroquín Estrada',    'country_id' => 1],
            [ 'name' => 'Marilin Paola',     'lastname' => 'Mejía Cosajay',        'country_id' => 1],
            [ 'name' => 'Yenni Liset',       'lastname' => 'Miranda',              'country_id' => 1],
            [ 'name' => 'Amanda Mishel',     'lastname' => 'González Marroquín',   'country_id' => 1],
            [ 'name' => 'José Alfredo',      'lastname' => 'Díaz Morán',           'country_id' => 1],
            [ 'name' => 'Maria Fernanda',    'lastname' => 'Valdez Ravanales',     'country_id' => 1],
            [ 'name' => 'Adamaris Samantha', 'lastname' => 'Godoy Ramos',          'country_id' => 1],
            [ 'name' => 'Josué Daniel',      'lastname' => 'Tala González',        'country_id' => 1],
            [ 'name' => 'Jorge Antonio',     'lastname' => 'Muñoz Echeverría',     'country_id' => 1],
            [ 'name' => 'Brenda Regina',     'lastname' => 'López Márquez',        'country_id' => 1],
            [ 'name' => 'Mario Alfredo',     'lastname' => 'Fuentes Castillo',     'country_id' => 1],
            [ 'name' => 'Onayda Judiza',     'lastname' => 'De León Mazariegos',   'country_id' => 1],
            [ 'name' => 'Genzer Engadi',     'lastname' => 'González López',       'country_id' => 1],
            [ 'name' => 'Luis Manuel',       'lastname' => 'Maldonado de León',    'country_id' => 1],
            [ 'name' => 'Werner Estuardo',   'lastname' => 'Díaz Girón',           'country_id' => 1],
            [ 'name' => 'Ricardo Francisco', 'lastname' => 'Gatica Oquendo',       'country_id' => 1],
            [ 'name' => 'Allan René',        'lastname' => 'Arreaga de León',      'country_id' => 1],
            [ 'name' => 'Carlos Ivan',       'lastname' => 'Velazquez',            'country_id' => 1],
            [ 'name' => 'Luis Diego',        'lastname' => 'Carrascosa Gutiérrez', 'country_id' => 1],
            [ 'name' => 'Mario José',        'lastname' => 'Ortiz Ruiz',           'country_id' => 1],
            [ 'name' => 'Humberto Josué',    'lastname' => 'Calderón Alvarado',    'country_id' => 1],

            [ 'name' => 'Visitador',         'lastname' => 'PWG 1',                'country_id' => 2],
            [ 'name' => 'Visitador',         'lastname' => 'PWG 2',                'country_id' => 2],
        ];

        foreach($visitadores as $visitador) {
            Visitor::create($visitador);
        }
    }
}
