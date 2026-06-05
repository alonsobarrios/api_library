<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->randomElement([
                'María', 'José', 'Ana', 'Luis', 'Carmen', 'Miguel', 'Sofía', 'Diego', 'Lucía', 'Carlos',
            ]),
            'last_name' => $this->faker->randomElement([
                'García', 'Martínez', 'López', 'Rodríguez', 'Fernández', 'Sánchez', 'Pérez', 'González', 'Hernández', 'Ruiz',
            ]),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-20 years')->format('Y-m-d'),
            'nationality' => $this->faker->randomElement([
                'española', 'argentina', 'mexicana', 'colombiana', 'chilena', 'peruana', 'venezolana', 'uruguaya', 'cubana',
            ]),
            'biography' => $this->faker->randomElement([
                'Escritor apasionado por la literatura latinoamericana y la historia.',
                'Autor con un estilo íntimo que retrata la vida cotidiana y los sentimientos.',
                'Narrador interesado en temas sociales y culturales desde una voz contemporánea.',
                'Creador de relatos que combinan realidad y fantasía con sensibilidad humana.',
                'Investigador de historias regionales y personajes con profundidad emocional.',
            ]),
        ];
    }
}
