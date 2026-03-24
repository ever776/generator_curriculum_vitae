<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->longText('pdf_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('experiencias_laborales', function (Blueprint $table) {
            $table->longText('pdf_path')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin')->change();
        });
    }
};
