<?php

namespace Database\Seeders;

use App\Models\Titulo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TituloSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->createMany([
                ['name' => 'Test User', 'email' => 'test@example.com'],
            ]);
        }

        $titulosBase = [
            ['nombre' => 'Licenciatura en Ingeniería de Software', 'institucion' => 'Universidad Nacional Autónoma de México'],
            ['nombre' => 'Ingeniería en Sistemas Computacionales', 'institucion' => 'Instituto Politécnico Nacional'],
            ['nombre' => 'Licenciatura en Ciencias de la Computación', 'institucion' => 'Universidad Autónoma de México'],
            ['nombre' => 'Ingeniería de Sistemas', 'institucion' => 'Universidad Iberoamericana'],
            ['nombre' => 'Licenciatura en Ingeniería en Computación', 'institucion' => 'Universidad Veracruzana'],
            ['nombre' => 'Ingeniería en Tecnologías de la Información', 'institucion' => 'Universidad de Guadalajara'],
            ['nombre' => 'Licenciatura en Sistemas Digitales', 'institucion' => 'Instituto Tecnológico de Estudios Superiores de Monterrey'],
            ['nombre' => 'Ingeniería en Desarrollo de Software', 'institucion' => 'Universidad Tecnológica de México'],
            ['nombre' => 'Licenciatura en Administración de TI', 'institucion' => 'Universidad Anáhuac'],
            ['nombre' => 'Ingeniería en Redes y Comunicaciones', 'institucion' => 'Universidad Politécnica de Valencia'],
        ];

        $instituciones = [
            'Universidad Nacional Autónoma de México',
            'Instituto Politécnico Nacional',
            'Universidad Iberoamericana',
            'Universidad de Guadalajara',
            'Instituto Tecnológico de Estudios Superiores de Monterrey',
            'Universidad Veracruzana',
            'Universidad Tecnológica de México',
            'Universidad Anáhuac',
            'Universidad Autónoma de Nuevo León',
            'Universidad Autónoma del Estado de México',
            'Universidad Autónoma de Guadalajara',
            'Instituto Tecnológico de Monterrey',
            'Universidad Panamericana',
            'Universidad La Salle',
        ];

        // User 1 - 60 títulos (10 base + 50 nuevos)
        $user1 = User::find(1);
        if ($user1) {
            // 10 títulos base
            foreach ($titulosBase as $titulo) {
                $anio = rand(2015, 2020);
                $mes = rand(1, 12);
                $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, rand(1, 28));

                Titulo::create([
                    'user_id' => $user1->id,
                    'nombre' => $titulo['nombre'],
                    'institucion' => $titulo['institucion'],
                    'fecha_titulacion' => $fecha,
                    'pdf_path' => null,
                ]);
            }

            // 50 títulos nuevos
            for ($i = 0; $i < 50; $i++) {
                $nombre = $this->generarNombreTitulo();
                $institucion = $instituciones[array_rand($instituciones)];
                $anio = rand(2010, 2024);
                $mes = rand(1, 12);
                $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, rand(1, 28));

                Titulo::create([
                    'user_id' => $user1->id,
                    'nombre' => $nombre,
                    'institucion' => $institucion,
                    'fecha_titulacion' => $fecha,
                    'pdf_path' => null,
                ]);
            }
        }

        // User 2 - 30 títulos
        $user2 = User::find(2);
        if (! $user2) {
            $user2 = User::factory()->create([
                'name' => 'Second User',
                'email' => 'second@example.com',
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            $nombre = $this->generarNombreTitulo();
            $institucion = $instituciones[array_rand($instituciones)];
            $anio = rand(2010, 2024);
            $mes = rand(1, 12);
            $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, rand(1, 28));

            Titulo::create([
                'user_id' => $user2->id,
                'nombre' => $nombre,
                'institucion' => $institucion,
                'fecha_titulacion' => $fecha,
                'pdf_path' => null,
            ]);
        }
    }

    private function generarNombreTitulo(): string
    {
        $carreras = [
            'Ingeniería en Sistemas Computacionales',
            'Licenciatura en Ingeniería de Software',
            'Ingeniería en Computación',
            'Licenciatura en Ciencias de la Computación',
            'Ingeniería de Sistemas',
            'Licenciatura en Ingeniería de Sistemas',
            'Ingeniería en Tecnologías de la Información',
            'Licenciatura en Sistemas de Información',
            'Ingeniería en Desarrollo de Software',
            'Licenciatura en Ingeniería en Computación',
            'Ingeniería en Redes y Comunicaciones',
            'Licenciatura en Telemática',
            'Ingeniería en Sistemas Digitales',
            'Licenciatura en Ingeniería de Datos',
            'Ingeniería en Inteligencia Artificial',
            'Licenciatura en Ciencia de Datos',
            'Ingeniería de Software',
            'Licenciatura en Sistemas Computacionales',
            'Ingeniería en Seguridad Informática',
            'Licenciatura en Ingeniería en Redes',
            'Ingeniería en Multimedia',
            'Licenciatura en Animación Digital',
            'Ingeniería en Games',
            'Licenciatura en Desarrollo de Videojuegos',
            'Ingeniería de Telecomunicaciones',
            'Licenciatura en Ingeniería en Comunicaciones',
            'Ingeniería Electrónica',
            'Licenciatura en Ingeniería Electrónica',
            'Ingeniería Mecatrónica',
            'Licenciatura en Ingeniería Mecatrónica',
            'Ingeniería en Automatización',
            'Licenciatura en Robótica',
            'Ingeniería Industrial',
            'Licenciatura en Administración',
            'Ingeniería en Gestión Empresarial',
            'Licenciatura en Contabilidad',
            'Ingeniería Financiera',
            'Licenciatura en Economía',
            'Ingeniería en Marketing Digital',
            'Licenciatura en Marketing',
            'Ingeniería en Negocios Digitales',
            'Licenciatura en Comercio Internacional',
            'Ingeniería en Recursos Humanos',
            'Licenciatura en Psicología',
            'Ingeniería en Arquitectura',
            'Licenciatura en Arquitectura',
            'Ingeniería Civil',
            'Licenciatura en Ingeniería Civil',
            'Ingeniería Mecánica',
            'Licenciatura en Ingeniería Mecánica',
            'Ingeniería Eléctrica',
            'Licenciatura en Ingeniería Eléctrica',
            'Ingeniería en Energía',
            'Licenciatura en Ingeniería en Energía',
            'Ingeniería Ambiental',
            'Licenciatura en Ingeniería Ambiental',
            'Ingeniería en Biotecnología',
            'Licenciatura en Biotecnología',
            'Ingeniería Aeronáutica',
            'Licenciatura en Ingeniería Aeronáutica',
            'Ingeniería Petrolera',
            'Licenciatura en Ingeniería Petrolera',
            'Ingeniería Química',
            'Licenciatura en Ingeniería Química',
            'Ingeniería de Materiales',
            'Licenciatura en Ingeniería de Materiales',
            'Ingeniería en Alimentos',
            'Licenciatura en Ingeniería de Alimentos',
            'Ingeniería Agronómica',
            'Licenciatura en Ingeniería Agronómica',
            'Ingeniería Forestal',
            'Licenciatura en Ingeniería Forestal',
            'Ingeniería en Medicina',
            'Licenciatura en Medicina',
            'Ingeniería en Odontología',
            'Licenciatura en Odontología',
            'Ingeniería en Farmacia',
            'Licenciatura en Farmacia',
            'Ingeniería en Nutrición',
            'Licenciatura en Nutrición',
            'Ingeniería en Comunicación',
            'Licenciatura en Comunicación',
            'Ingeniería en Diseño',
            'Licenciatura en Diseño',
            'Ingeniería en Derecho',
            'Licenciatura en Derecho',
            'Ingeniería en Pedagogía',
            'Licenciatura en Pedagogía',
            'Ingeniería en Actuaría',
            'Licenciatura en Actuaría',
            'Ingeniería en Matemáticas',
            'Licenciatura en Matemáticas',
            'Ingeniería en Física',
            'Licenciatura en Física',
        ];

        $modalidades = ['Presencial', 'En línea', 'Semipresencial', 'A distancia', 'Híbrida'];

        $carrera = $carreras[array_rand($carreras)];
        $modalidad = $modalidades[array_rand($modalidades)];

        return "$carrera ($modalidad)";
    }
}
