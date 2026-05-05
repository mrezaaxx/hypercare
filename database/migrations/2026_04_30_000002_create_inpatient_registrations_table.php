<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inpatient_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('igd_visit_id')->nullable()->constrained('igd_visits')->nullOnDelete();
            $table->dateTime('admission_date');
            $table->enum('admission_source', ['IGD', 'Poliklinik', 'Rujukan Eksternal', 'Langsung']);
            $table->string('ward'); // Nama ruangan/bangsal
            $table->string('room_number')->nullable();
            $table->string('bed_number')->nullable();
            $table->enum('room_class', ['Kelas 1', 'Kelas 2', 'Kelas 3', 'VIP', 'VVIP', 'ICU', 'HCU']);
            $table->string('doctor_in_charge')->nullable();
            $table->string('admission_diagnosis');
            $table->string('final_diagnosis')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->dateTime('discharge_date')->nullable();
            $table->enum('discharge_type', ['Sembuh', 'Pulang Atas Permintaan', 'Dirujuk', 'Meninggal'])->nullable();
            $table->enum('status', ['Aktif', 'Selesai', 'Dipindah'])->default('Aktif');
            $table->foreignId('admitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inpatient_registrations');
    }
};
