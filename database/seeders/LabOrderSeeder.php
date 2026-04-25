<?php

namespace Database\Seeders;

use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class LabOrderSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::where('email', 'admin@hypercare.test')->value('id');

        $orders = [
            [
                'patient_mrn' => 'RM-000001',
                'order_number' => 'LAB-20260425-0001',
                'test_type' => 'Hematologi Lengkap',
                'clinical_notes' => 'Kontrol pasca demam tinggi.',
                'priority' => 'Normal',
                'status' => 'Selesai',
                'result_value' => 'Hb 12.8 g/dL, Leukosit 7.400/uL',
                'result_notes' => 'Nilai dalam batas normal.',
            ],
            [
                'patient_mrn' => 'RM-000002',
                'order_number' => 'LAB-20260425-0002',
                'test_type' => 'Gula Darah Sewaktu',
                'clinical_notes' => 'Skrining hiperglikemia.',
                'priority' => 'Cito',
                'status' => 'Diproses',
                'result_value' => null,
                'result_notes' => null,
            ],
            [
                'patient_mrn' => 'RM-000004',
                'order_number' => 'LAB-20260425-0003',
                'test_type' => 'Fungsi Ginjal',
                'clinical_notes' => 'Monitoring terapi hipertensi.',
                'priority' => 'Normal',
                'status' => 'Menunggu',
                'result_value' => null,
                'result_notes' => null,
            ],
        ];

        foreach ($orders as $order) {
            $patientId = Patient::where('medical_record_number', $order['patient_mrn'])->value('id');

            LabOrder::updateOrCreate(
                ['order_number' => $order['order_number']],
                [
                    'patient_id' => $patientId,
                    'test_type' => $order['test_type'],
                    'clinical_notes' => $order['clinical_notes'],
                    'priority' => $order['priority'],
                    'status' => $order['status'],
                    'result_value' => $order['result_value'],
                    'result_notes' => $order['result_notes'],
                    'ordered_by' => $userId,
                ]
            );
        }
    }
}
