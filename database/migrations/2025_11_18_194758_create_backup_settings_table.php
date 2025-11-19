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
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('time')->nullable(); // store as "HH:MM", e.g. "02:00"
            $table->string('frequency')->default('daily'); // 'daily', 'weekly', 'every_minute', 'every_15_minutes'
            $table->integer('day_of_week')->nullable(); // 0-6 if weekly and you want day control (optional)
            $table->timestamps();
        });
            DB::table('backup_settings')->insert([
            'enabled' => true,
            'time' => '02:00',
            'frequency' => 'daily',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_settings');
    }
};
