<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->renameColumn('pdfs', 'pdf_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->renameColumn('pdf_path', 'pdfs');
        });
    }
};
