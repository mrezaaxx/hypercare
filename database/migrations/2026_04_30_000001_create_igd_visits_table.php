<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('igd_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visit_number')->unique();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->dateTime('arrival_time');
            $table->enum('arrival_method', ['Jalan Kaki', 'Ambulans', 'Kendaraan Pribadi', 'Diantar Keluarga']);
            // Triase Data
            $table->enum('triage_category', ['P1 - Merah', 'P2 - Kuning', 'P3 - Hijau', 'P4 - Hitam']);
            $table->integer('systolic_bp')->nullable();
            $table->integer('diastolic_bp')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('oxygen_saturation')->nullable();
            $table->integer('gcs_score')->nullable()->comment('Glasgow Coma Scale 3-15');
            $table->string('chief_complaint');
            $table->text('physical_exam')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('action_taken')->nullable();
            // Status
            $table->enum('status', ['Menunggu', 'Dalam Pemeriksaan', 'Observasi', 'Dirujuk Rawat Inap', 'Pulang', 'Meninggal'])
                  ->default('Menunggu');
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igd_visits');
    }
};
