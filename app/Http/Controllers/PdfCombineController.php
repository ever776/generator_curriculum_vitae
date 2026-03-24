<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\ExperienciaLaboral;
use App\Models\Titulo;
use App\Services\PdfPreprocessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;

class PdfCombineController extends Controller
{
    public function __construct(
        private PdfPreprocessor $pdfPreprocessor
    ) {}

    public function downloadTitulos(): mixed
    {
        $user = Auth::user();

        $titulos = Titulo::where('user_id', $user->id)
            ->whereNotNull('pdf_path')
            ->orderBy('fecha_titulacion', 'desc')
            ->get();

        if ($titulos->isEmpty()) {
            return back()->with('error', 'No hay títulos con PDF para descargar.');
        }

        return $this->combinePdfs($titulos, 'pdf_path', 'titulos', 'nombre');
    }

    public function downloadCertificados(): mixed
    {
        $user = Auth::user();

        $certificados = Certificado::where('user_id', $user->id)
            ->whereNotNull('pdf_path')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        if ($certificados->isEmpty()) {
            return back()->with('error', 'No hay certificados con PDF para descargar.');
        }

        return $this->combinePdfs($certificados, 'pdf_path', 'certificados', 'nombre');
    }

    public function downloadExperiencias(): mixed
    {
        $user = Auth::user();

        $experiencias = ExperienciaLaboral::where('user_id', $user->id)
            ->whereNotNull('pdf_path')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        if ($experiencias->isEmpty()) {
            return back()->with('error', 'No hay experiencias con PDF para descargar.');
        }

        return $this->combinePdfs($experiencias, 'pdf_path', 'experiencias-laborales', 'puesto');
    }

    private function combinePdfs($records, string $pdfField, string $folderName, string $nameField): mixed
    {
        $pdf = new Fpdi;
        $failedPdfs = [];
        $tempFiles = [];

        foreach ($records as $record) {
            $pdfPath = $record->{$pdfField};
            $fullPath = Storage::disk('public')->path($pdfPath);

            if (! file_exists($fullPath)) {
                $failedPdfs[] = [
                    'id' => $record->id,
                    'nombre' => $record->{$nameField},
                    'razon' => 'Archivo no encontrado',
                ];
                Log::warning('PDF no encontrado al combinar', [
                    'pdf_path' => $pdfPath,
                    'record_id' => $record->id,
                ]);

                continue;
            }

            $processedPath = $this->pdfPreprocessor->preprocess($fullPath);

            if ($processedPath) {
                $tempFiles[] = $processedPath;
                $sourceFile = $processedPath;
            } else {
                $sourceFile = $fullPath;
            }

            try {
                $pageCount = $pdf->setSourceFile($sourceFile);

                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);
                }
            } catch (\Exception $e) {
                $failedPdfs[] = [
                    'id' => $record->id,
                    'nombre' => $record->{$nameField},
                    'razon' => 'No se pudo procesar el PDF',
                ];
                Log::warning('PDF fallido al combinar', [
                    'pdf_path' => $pdfPath,
                    'record_id' => $record->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        foreach ($tempFiles as $tempFile) {
            $this->pdfPreprocessor->cleanup($tempFile);
        }

        if (! empty($failedPdfs)) {
            session()->flash('failed_pdfs', $failedPdfs);
        }

        return response()->streamDownload(
            fn () => $pdf->output(),
            $folderName.'_'.date('Y-m-d').'.pdf',
            [
                'Content-Type' => 'application/pdf',
            ],
        );
    }
}
