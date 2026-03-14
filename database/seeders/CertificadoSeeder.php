<?php

namespace Database\Seeders;

use App\Models\Certificado;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificadoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->createMany([
                ['name' => 'Test User', 'email' => 'test@example.com'],
            ]);
        }

        $certificadosBase = [
            ['nombre' => 'Desarrollo Web con Laravel', 'institucion' => 'Platzi', 'duracion' => 40],
            ['nombre' => 'Vue.js 3 Completo', 'institucion' => 'Udemy', 'duracion' => 35],
            ['nombre' => 'Base de Datos con MySQL', 'institucion' => 'Coursera', 'duracion' => 50],
            ['nombre' => 'Python para Data Science', 'institucion' => 'edX', 'duracion' => 60],
            ['nombre' => 'Machine Learning Fundamentals', 'institucion' => 'Coursera', 'duracion' => 80],
            ['nombre' => 'Docker y Kubernetes', 'institucion' => 'Udemy', 'duracion' => 25],
            ['nombre' => 'AWS Cloud Practitioner', 'institucion' => 'AWS Training', 'duracion' => 30],
            ['nombre' => 'JavaScript Advanced', 'institucion' => 'Platzi', 'duracion' => 20],
            ['nombre' => 'React Native Mobile Development', 'institucion' => 'Udemy', 'duracion' => 45],
            ['nombre' => 'Git y GitHub Professional', 'institucion' => 'Platzi', 'duracion' => 15],
            ['nombre' => 'TypeScript Mastery', 'institucion' => 'Udemy', 'duracion' => 35],
            ['nombre' => 'GraphQL API Development', 'institucion' => 'Platzi', 'duracion' => 28],
            ['nombre' => 'MongoDB Fundamentals', 'institucion' => 'Coursera', 'duracion' => 40],
            ['nombre' => 'REST API Design', 'institucion' => 'Udemy', 'duracion' => 22],
            ['nombre' => 'Linux Server Administration', 'institucion' => 'Platzi', 'duracion' => 50],
            ['nombre' => 'CI/CD with Jenkins', 'institucion' => 'Udemy', 'duracion' => 30],
            ['nombre' => 'Microservices Architecture', 'institucion' => 'Coursera', 'duracion' => 65],
            ['nombre' => 'Node.js Advanced', 'institucion' => 'Platzi', 'duracion' => 38],
            ['nombre' => 'PostgreSQL Database', 'institucion' => 'Udemy', 'duracion' => 42],
            ['nombre' => 'Tailwind CSS Course', 'institucion' => 'Platzi', 'duracion' => 18],
        ];

        $instituciones = ['Platzi', 'Udemy', 'Coursera', 'edX', 'AWS Training', 'Google Cloud', 'Microsoft Learn', 'FreeCodeCamp', 'Codecademy', 'Khan Academy'];

        // User 1 - 60 certificados (10 base + 50 nuevos)
        $user1 = User::find(1);
        if ($user1) {
            // 10 certificados base
            foreach ($certificadosBase as $cert) {
                $this->createCertificado($user1->id, $cert, '2024-01-01', '2024-12-31');
            }

            // 50 certificados nuevos
            for ($i = 0; $i < 50; $i++) {
                $nombre = $this->generarNombreCertificado();
                $institucion = $instituciones[array_rand($instituciones)];
                $duracion = rand(10, 100);
                $anio = rand(2020, 2024);
                $mesInicio = rand(1, 12);
                $mesConclusion = $mesInicio + rand(1, 6);
                $anioConclusion = $mesConclusion > 12 ? $anio + 1 : $anio;
                $mesConclusion = $mesConclusion > 12 ? $mesConclusion - 12 : $mesConclusion;

                $fechaInicio = sprintf('%04d-%02d-%02d', $anio, $mesInicio, rand(1, 28));
                $fechaConclusion = sprintf('%04d-%02d-%02d', $anioConclusion, $mesConclusion, rand(1, 28));

                Certificado::create([
                    'user_id' => $user1->id,
                    'nombre' => $nombre,
                    'institucion' => $institucion,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_conclusion' => $fechaConclusion,
                    'duracion' => $duracion,
                    'pdf_path' => null,
                ]);
            }
        }

        // User 2 - 30 certificados
        $user2 = User::find(2);
        if (! $user2) {
            $user2 = User::factory()->create([
                'name' => 'Second User',
                'email' => 'second@example.com',
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            $nombre = $this->generarNombreCertificado();
            $institucion = $instituciones[array_rand($instituciones)];
            $duracion = rand(10, 100);
            $anio = rand(2020, 2024);
            $mesInicio = rand(1, 12);
            $mesConclusion = $mesInicio + rand(1, 6);
            $anioConclusion = $mesConclusion > 12 ? $anio + 1 : $anio;
            $mesConclusion = $mesConclusion > 12 ? $mesConclusion - 12 : $mesConclusion;

            $fechaInicio = sprintf('%04d-%02d-%02d', $anio, $mesInicio, rand(1, 28));
            $fechaConclusion = sprintf('%04d-%02d-%02d', $anioConclusion, $mesConclusion, rand(1, 28));

            Certificado::create([
                'user_id' => $user2->id,
                'nombre' => $nombre,
                'institucion' => $institucion,
                'fecha_inicio' => $fechaInicio,
                'fecha_conclusion' => $fechaConclusion,
                'duracion' => $duracion,
                'pdf_path' => null,
            ]);
        }
    }

    private function createCertificado(int $userId, array $cert, string $fechaInicio, string $fechaConclusion): void
    {
        Certificado::create([
            'user_id' => $userId,
            'nombre' => $cert['nombre'],
            'institucion' => $cert['institucion'],
            'fecha_inicio' => $fechaInicio,
            'fecha_conclusion' => $fechaConclusion,
            'duracion' => $cert['duracion'],
            'pdf_path' => null,
        ]);
    }

    private function generarNombreCertificado(): string
    {
        $cursos = [
            'Desarrollo', 'Programación', 'Diseño', 'Marketing', 'Negocios',
            'Data Science', 'Machine Learning', 'Inteligencia Artificial', 'Cloud',
            'DevOps', 'Security', 'Mobile', 'Frontend', 'Backend', 'Full Stack',
            'Blockchain', 'Cybersecurity', 'UX/UI', 'Product Management', 'Agile',
            'Scrum', 'Leadership', 'Communication', 'Excel', 'Power BI', 'SQL',
            'NoSQL', 'React', 'Angular', 'Vue', 'Svelte', 'Node', 'Django',
            'Flask', 'Spring', 'Laravel', 'Ruby', 'Go', 'Rust', 'Swift', 'Kotlin',
            'Flutter', 'Unity', 'Unreal Engine', 'Photoshop', 'Illustrator', 'Figma',
            'After Effects', 'Premiere Pro', 'SEO', 'SEM', 'Social Media',
        ];

        $niveles = ['Básico', 'Intermedio', 'Avanzado', 'Profesional', 'Master',
            'Completo', 'Fundamentos', 'Práctico', 'Teórico', 'Especialización'];

        $extensiones = ['Course', 'Bootcamp', 'Workshop', 'Seminar', 'Certification',
            'Training', 'Program', 'Degree', 'Diploma', 'Certificate'];

        $curso = $cursos[array_rand($cursos)];
        $nivel = $niveles[array_rand($niveles)];
        $ext = $extensiones[array_rand($extensiones)];

        return "$curso $nivel $ext";
    }
}
