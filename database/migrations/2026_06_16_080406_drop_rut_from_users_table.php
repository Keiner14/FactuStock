<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'rut')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('rut');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'rut')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('rut')->nullable()->after('apellidos');
            });
        }
    }
};