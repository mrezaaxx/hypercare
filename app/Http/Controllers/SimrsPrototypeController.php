<?php

namespace App\Http\Controllers;

use App\Models\LabOrder;
use App\Models\Patient;
use App\Models\RadiologyOrder;

class SimrsPrototypeController extends Controller
{
    public function index()
    {
        $summary = [
            'registeredPatients' => Patient::count(),
            'pendingLabOrders' => LabOrder::whereIn('status', ['Menunggu', 'Diproses'])->count(),
            'pendingRadiologyOrders' => RadiologyOrder::whereIn('status', ['Menunggu', 'Diproses'])->count(),
            'completedOrders' => LabOrder::where('status', 'Selesai')->count()
                + RadiologyOrder::where('status', 'Selesai')->count(),
        ];

        $patients = Patient::query()
            ->with([
                'labOrders' => fn ($query) => $query->latest(),
                'radiologyOrders' => fn ($query) => $query->latest(),
            ])
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Patient $patient) {
                $latestLabOrder = $patient->labOrders->first();
                $latestRadiologyOrder = $patient->radiologyOrders->first();

                $service = 'Pendaftaran';
                $status = 'Data pasien aktif';

                if ($latestRadiologyOrder && (! $latestLabOrder || $latestRadiologyOrder->created_at->gte($latestLabOrder->created_at))) {
                    $service = 'Radiologi';
                    $status = $latestRadiologyOrder->status;
                } elseif ($latestLabOrder) {
                    $service = 'Laboratorium';
                    $status = $latestLabOrder->status;
                }

                return [
                    'mrn' => $patient->medical_record_number,
                    'name' => $patient->name,
                    'service' => $service,
                    'payer' => $patient->insurance_type,
                    'status' => $status,
                ];
            })
            ->all();

        $integrations = [
            [
                'name' => 'SATUSEHAT',
                'description' => 'Sinkronisasi Encounter, Medication, dan Observation.',
                'status' => 'Sehat',
                'metric' => '182 transaksi hari ini',
            ],
            [
                'name' => 'BPJS Kesehatan',
                'description' => 'Verifikasi peserta, SEP, rujukan, dan klaim.',
                'status' => 'Perlu monitoring',
                'metric' => '14 antrean pending',
            ],
            [
                'name' => 'PACS',
                'description' => 'Akses citra radiologi dan laporan hasil baca.',
                'status' => 'Sehat',
                'metric' => '47 studi tersinkron',
            ],
            [
                'name' => 'LIS',
                'description' => 'Order laboratorium, hasil, dan validasi analis.',
                'status' => 'Sehat',
                'metric' => '61 hasil masuk otomatis',
            ],
        ];

        $timeline = [
            'Pendaftaran pasien membuat antrean dan episode kunjungan.',
            'Bridging BPJS memvalidasi kepesertaan dan membentuk SEP.',
            'Dokter membuat order radiologi atau laboratorium.',
            'PACS dan LIS mengirim hasil balik ke EMR dan dashboard klinis.',
            'SATUSEHAT menerima sinkronisasi encounter dan observasi terverifikasi.',
        ];

        return view('simrs.dashboard', compact('summary', 'patients', 'integrations', 'timeline'));
    }
}
