<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombres'                => $this->faker->firstName(),
            'apellidos'              => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'numero_documento'       => $this->faker->unique()->numerify('#############'),
            'telefono'               => $this->faker->numerify('########'),
            'email'                  => $this->faker->unique()->safeEmail(),
            'direccion'              => $this->faker->city(),
            'pais_id'                => 1,
            'user_type_id'           => 1,
            'puntos_trivias'         => 0,
            'puntos_predicciones'    => 0,
            'puntos'                 => 0,
            'status_user'            => 1,
            'password'               => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'accepted_terms_version' => '0.1.0',
        ];
    }

    /**
     * Tipo 1: Dependiente (con company y branch).
     */
    public function dependiente(int $paisId = 1): static
    {
        $companies = $paisId === 1 ? [1, 2] : [3, 4];

        return $this->state(fn () => [
            'pais_id'      => $paisId,
            'user_type_id' => 1,
            'company_id'   => $this->faker->randomElement($companies),
            'branch'       => 'Sucursal ' . $this->faker->numberBetween(1, 50),
            'colegiado'    => null,
            'region'       => null,
            'capital'      => null,
            'visitor_id'   => null,
        ]);
    }

    /**
     * Tipo 2: Doctor (con colegiado, region, capital y visitor).
     */
    public function doctor(int $paisId = 1): static
    {
        $visitorRange = $paisId === 1 ? [1, 58] : [59, 73];

        return $this->state(fn () => [
            'pais_id'      => $paisId,
            'user_type_id' => 2,
            'company_id'   => null,
            'branch'       => null,
            'colegiado'    => (string) $this->faker->numberBetween(10000, 99999),
            'region'       => $this->faker->randomElement(['Central', 'Norte', 'Sur', 'Oriente', 'Occidente']),
            'capital'      => $this->faker->randomElement(['Ciudad capital', 'Departamental']),
            'visitor_id'   => $this->faker->numberBetween($visitorRange[0], $visitorRange[1]),
        ]);
    }
}
