<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\RadiologyOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class RadiologyOrderSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::where('email', 'admin@hypercare.test')->value('id');

        $orders = [
            [
                'patient_mrn' => 'RM-000003',
                'order_number' => 'RAD-20260425-0001',
                'exam_type' => 'Thorax AP',
                'body_part' => 'Dada',
                'clinical_notes' => 'Evaluasi batuk kronis.',
                'priority' => 'Normal',
                'status' => 'Selesai',
                'result_findings' => 'Tidak tampak infiltrat aktif.',
                'result_impression' => 'Thorax dalam batas normal.',
            ],
            [
                'patient_mrn' => 'RM-000005',
                'order_number' => 'RAD-20260425-0002',
                'exam_type' => 'CT Scan Kepala',
                'body_part' => 'Kepala',
                'clinical_notes' => 'Nyeri kepala akut.',
                'priority' => 'Cito',
                'status' => 'Diproses',
                'result_findings' => null,
                'result_impression' => null,
            ],
            [
                'patient_mrn' => 'RM-000001',
                'order_number' => 'RAD-20260425-0003',
                'exam_type' => 'USG Abdomen',
                'body_part' => 'Abdomen',
                'clinical_notes' => 'Nyeri perut kanan atas.',
                'priority' => 'Normal',
                'status' => 'Menunggu',
                'result_findings' => null,
                'result_impression' => null,
            ],
        ];

        foreach ($orders as $order) {
            $patientId = Patient::where('medical_record_number', $order['patient_mrn'])->value('id');

            RadiologyOrder::updateOrCreate(
                ['order_number' => $order['order_number']],
                [
                    'patient_id' => $patientId,
                    'exam_type' => $order['exam_type'],
                    'body_part' => $order['body_part'],
                    'clinical_notes' => $order['clinical_notes'],
                    'priority' => $order['priority'],
                    'status' => $order['status'],
                    'result_findings' => $order['result_findings'],
                    'result_impression' => $order['result_impression'],
                    'ordered_by' => $userId,
                ]
            );
        }
    }
}
