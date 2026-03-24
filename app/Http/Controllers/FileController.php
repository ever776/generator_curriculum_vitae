<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function serve(string $path): StreamedResponse
    {
        $fullPath = $path;

        if (! Storage::disk('public')->exists($fullPath)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($fullPath);
        $fullFilePath = Storage::disk('public')->path($fullPath);
        $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $fullFilePath);

        return response()->stream(
            function () use ($file) {
                echo $file;
            },
            200,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline',
            ],
        );
    }
}
