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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->nullable();
            $table->string('lugar_fecha_nacimiento')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('cedula_identidad')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('idioma')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('celular')->nullable();
            $table->text('descripcion_profesional')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellidos',
                'lugar_fecha_nacimiento',
                'nacionalidad',
                'cedula_identidad',
                'estado_civil',
                'idioma',
                'domicilio',
                'celular',
                'descripcion_profesional',
            ]);
        });
    }
};
