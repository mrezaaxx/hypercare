<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Departments
        $poliUmum = \App\Models\Department::create(['name' => 'Poliklinik Umum', 'description' => 'Pelayanan medis dasar']);
        $poliGigi = \App\Models\Department::create(['name' => 'Poliklinik Gigi', 'description' => 'Pelayanan kesehatan gigi dan mulut']);
        $igd = \App\Models\Department::create(['name' => 'IGD', 'description' => 'Instalasi Gawat Darurat']);
        $bangsalMawar = \App\Models\Department::create(['name' => 'Bangsal Mawar', 'description' => 'Rawat Inap Kelas 1 & VIP']);

        // 2. Doctors
        $drBudi = \App\Models\Doctor::create(['name' => 'dr. Budi Santoso', 'specialization' => 'Dokter Umum', 'phone' => '081234567890']);
        $drSiti = \App\Models\Doctor::create(['name' => 'drg. Siti Aminah', 'specialization' => 'Dokter Gigi', 'phone' => '081298765432']);
        $drAndi = \App\Models\Doctor::create(['name' => 'dr. Andi Wijaya, Sp.PD', 'specialization' => 'Penyakit Dalam', 'phone' => '081333444555']);

        // 3. Rooms & Beds
        $room1 = \App\Models\Room::create(['department_id' => $bangsalMawar->id, 'name' => 'Mawar 101', 'room_class' => 'VIP', 'price_per_night' => 1500000]);
        \App\Models\Bed::create(['room_id' => $room1->id, 'bed_number' => 'B1', 'status' => 'Available']);
        
        $room2 = \App\Models\Room::create(['department_id' => $bangsalMawar->id, 'name' => 'Mawar 102', 'room_class' => 'Kelas 1', 'price_per_night' => 800000]);
        \App\Models\Bed::create(['room_id' => $room2->id, 'bed_number' => 'B1', 'status' => 'Occupied']);
        \App\Models\Bed::create(['room_id' => $room2->id, 'bed_number' => 'B2', 'status' => 'Available']);

        // 4. Doctor Schedules (0 = Sunday, 1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday, 5 = Friday, 6 = Saturday)
        $days = [1, 2, 3, 4, 5]; // Monday to Friday
        foreach ($days as $day) {
            \App\Models\DoctorSchedule::create([
                'doctor_id' => $drBudi->id,
                'department_id' => $poliUmum->id,
                'day_of_week' => (string)$day,
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
                'quota' => 20,
            ]);
            
            \App\Models\DoctorSchedule::create([
                'doctor_id' => $drSiti->id,
                'department_id' => $poliGigi->id,
                'day_of_week' => (string)$day,
                'start_time' => '09:00:00',
                'end_time' => '15:00:00',
                'quota' => 15,
            ]);
        }
    }
}
