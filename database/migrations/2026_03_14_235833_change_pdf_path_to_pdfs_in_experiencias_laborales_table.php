<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->dropColumn('pdf_path');
            $table->json('pdfs')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->dropColumn('pdfs');
            $table->string('pdf_path')->nullable();
        });
    }
};
