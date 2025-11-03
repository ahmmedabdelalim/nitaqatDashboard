<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(0)->change();
            $table->string('role')->default('user')->change();
            $table->boolean('calc')->default(0)->change();
            $table->boolean('reports')->default(0)->change();
            $table->boolean('upload')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert to having no defaults (or adjust as needed)
            $table->boolean('active')->nullable()->default(null)->change();
            $table->string('role')->nullable()->default(null)->change();
            $table->boolean('calc')->nullable()->default(null)->change();
            $table->boolean('reports')->nullable()->default(null)->change();
            $table->boolean('upload')->nullable()->default(null)->change();
        });
    }
};
