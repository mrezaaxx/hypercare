<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'medical_record_number' => 'RM-000001',
                'name' => 'Siti Aisyah',
                'nik' => '3173011201900001',
                'birth_date' => '1990-01-12',
                'gender' => 'Perempuan',
                'address' => 'Jl. Melati No. 10, Jakarta',
                'phone' => '081234567801',
                'blood_type' => 'A',
                'insurance_type' => 'BPJS',
                'insurance_number' => '0001234567890',
            ],
            [
                'medical_record_number' => 'RM-000002',
                'name' => 'Budi Santoso',
                'nik' => '3173011201900002',
                'birth_date' => '1988-06-03',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Kenanga No. 7, Bandung',
                'phone' => '081234567802',
                'blood_type' => 'O',
                'insurance_type' => 'Umum',
                'insurance_number' => null,
            ],
            [
                'medical_record_number' => 'RM-000003',
                'name' => 'Maria Clara',
                'nik' => '3173011201900003',
                'birth_date' => '1995-09-20',
                'gender' => 'Perempuan',
                'address' => 'Jl. Flamboyan No. 18, Surabaya',
                'phone' => '081234567803',
                'blood_type' => 'B',
                'insurance_type' => 'Asuransi',
                'insurance_number' => 'POL-99887766',
            ],
            [
                'medical_record_number' => 'RM-000004',
                'name' => 'Andi Pratama',
                'nik' => '3173011201900004',
                'birth_date' => '1979-11-15',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Anggrek No. 4, Bogor',
                'phone' => '081234567804',
                'blood_type' => 'AB',
                'insurance_type' => 'BPJS',
                'insurance_number' => '0001234567891',
            ],
            [
                'medical_record_number' => 'RM-000005',
                'name' => 'Dewi Lestari',
                'nik' => '3173011201900005',
                'birth_date' => '2000-02-08',
                'gender' => 'Perempuan',
                'address' => 'Jl. Cempaka No. 2, Depok',
                'phone' => '081234567805',
                'blood_type' => '-',
                'insurance_type' => 'Umum',
                'insurance_number' => null,
            ],
        ];

        foreach ($patients as $patient) {
            Patient::updateOrCreate(
                ['medical_record_number' => $patient['medical_record_number']],
                $patient
            );
        }
    }
}
