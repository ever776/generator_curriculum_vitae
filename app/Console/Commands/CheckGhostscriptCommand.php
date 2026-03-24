<?php

namespace App\Console\Commands;

use App\Services\PdfPreprocessor;
use Illuminate\Console\Command;

class CheckGhostscriptCommand extends Command
{
    protected $signature = 'pdf:check-gs';

    protected $description = 'Verificar si Ghostscript está instalado para preprocesar PDFs';

    public function handle(): int
    {
        if (! PdfPreprocessor::isGhostscriptAvailable()) {
            $this->error('Ghostscript no está instalado o no es ejecutable.');

            $this->newLine();
            $this->info('Para instalar Ghostscript, ejecuta:');

            if (PHP_OS_FAMILY === 'Debian' || PHP_OS_FAMILY === 'Ubuntu') {
                $this->line('  sudo apt install ghostscript');
            } elseif (PHP_OS_FAMILY === 'Redhat' || PHP_OS_FAMILY === 'Fedora') {
                $this->line('  sudo dnf install ghostscript');
            } elseif (PHP_OS_FAMILY === 'Darwin') {
                $this->line('  brew install ghostscript');
            } else {
                $this->line('  Consulta la documentación de tu sistema operativo');
            }

            return Command::FAILURE;
        }

        $version = PdfPreprocessor::getVersion();
        $path = is_executable('/usr/bin/gs') ? '/usr/bin/gs' : '/usr/local/bin/gs';

        $this->info('✓ Ghostscript está instalado');
        $this->line("  Versión: {$version}");
        $this->line("  Ubicación: {$path}");
        $this->newLine();
        $this->info('✓ Listo para procesar PDFs');

        return Command::SUCCESS;
    }
}
