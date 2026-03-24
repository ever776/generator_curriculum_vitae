<?php

namespace App\Services;

class PdfPreprocessor
{
    private string $tempDir;

    public function __construct()
    {
        $this->tempDir = storage_path('app/temp/pdfs');

        if (! is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0755, true);
        }
    }

    public function preprocess(string $inputPath): ?string
    {
        if (! file_exists($inputPath)) {
            return null;
        }

        $outputPath = $this->tempDir.'/'.uniqid('pdf_').'.pdf';

        $command = sprintf(
            'gs -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -sOutputFile=%s %s -c quit 2>&1',
            escapeshellarg($outputPath),
            escapeshellarg($inputPath)
        );

        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
            return $outputPath;
        }

        if (file_exists($outputPath)) {
            @unlink($outputPath);
        }

        return null;
    }

    public function cleanup(?string $tempFile = null): void
    {
        if ($tempFile && file_exists($tempFile)) {
            @unlink($tempFile);
        }
    }

    public function cleanupAll(): void
    {
        $files = glob($this->tempDir.'/*.pdf');

        foreach ($files as $file) {
            @unlink($file);
        }
    }

    public static function isGhostscriptAvailable(): bool
    {
        return is_executable('/usr/bin/gs') || is_executable('/usr/local/bin/gs');
    }

    public static function getVersion(): ?string
    {
        if (! self::isGhostscriptAvailable()) {
            return null;
        }

        $path = is_executable('/usr/bin/gs') ? '/usr/bin/gs' : '/usr/local/bin/gs';
        $output = [];
        exec(escapeshellarg($path).' --version 2>&1', $output);

        return $output[0] ?? null;
    }
}
