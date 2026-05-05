<?php

namespace App\Http\Controllers;

use App\Models\InpatientRegistration;
use App\Models\IgdVisit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = InpatientRegistration::with(['patient', 'igdVisit', 'admittedByUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ward')) {
            $query->where('ward', $request->ward);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhere('ward', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('medical_record_number', 'like', "%{$search}%");
                  });
            });
        }

        $registrations = $query->orderBy('admission_date', 'desc')->paginate(15);

        $stats = [
            'total_active'  => InpatientRegistration::where('status', 'Aktif')->count(),
            'admitted_today'=> InpatientRegistration::whereDate('admission_date', today())->count(),
            'discharged_today' => InpatientRegistration::whereDate('discharge_date', today())->count(),
            'from_igd'      => InpatientRegistration::where('admission_source', 'IGD')->where('status', 'Aktif')->count(),
        ];

        $wards = InpatientRegistration::distinct()->pluck('ward')->filter()->values();

        return view('inpatient.index', compact('registrations', 'stats', 'wards'));
    }

    public function create(Request $request)
    {
        $patients = Patient::orderBy('name')->get();
        $nextRegNumber = $this->generateRegNumber();
        $igdVisit = null;

        // If coming from IGD referral
        if ($request->filled('igd_visit_id')) {
            $igdVisit = IgdVisit::with('patient')->find($request->igd_visit_id);
        }

        return view('inpatient.create', compact('patients', 'nextRegNumber', 'igdVisit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'          => 'required|exists:patients,id',
            'igd_visit_id'        => 'nullable|exists:igd_visits,id',
            'admission_date'      => 'required|date',
            'admission_source'    => 'required|in:IGD,Poliklinik,Rujukan Eksternal,Langsung',
            'ward'                => 'required|string|max:100',
            'room_number'         => 'nullable|string|max:20',
            'bed_number'          => 'nullable|string|max:20',
            'room_class'          => 'required|in:Kelas 1,Kelas 2,Kelas 3,VIP,VVIP,ICU,HCU',
            'doctor_in_charge'    => 'nullable|string|max:255',
            'admission_diagnosis' => 'required|string|max:500',
            'treatment_notes'     => 'nullable|string',
        ]);

        $validated['registration_number'] = $this->generateRegNumber();
        $validated['status'] = 'Aktif';
        $validated['admitted_by'] = Auth::id();

        $registration = InpatientRegistration::create($validated);

        // Update IGD status if linked
        if (!empty($validated['igd_visit_id'])) {
            IgdVisit::where('id', $validated['igd_visit_id'])
                ->update(['status' => 'Dirujuk Rawat Inap']);
        }

        return redirect()->route('inpatient.index')
            ->with('success', 'Pasien berhasil didaftarkan ke Rawat Inap.');
    }

    public function show(InpatientRegistration $inpatient)
    {
        $inpatient->load(['patient', 'igdVisit', 'admittedByUser']);
        return view('inpatient.show', compact('inpatient'));
    }

    public function edit(InpatientRegistration $inpatient)
    {
        $inpatient->load('patient');
        $patients = Patient::orderBy('name')->get();
        return view('inpatient.edit', compact('inpatient', 'patients'));
    }

    public function update(Request $request, InpatientRegistration $inpatient)
    {
        $validated = $request->validate([
            'admission_date'      => 'required|date',
            'admission_source'    => 'required|in:IGD,Poliklinik,Rujukan Eksternal,Langsung',
            'ward'                => 'required|string|max:100',
            'room_number'         => 'nullable|string|max:20',
            'bed_number'          => 'nullable|string|max:20',
            'room_class'          => 'required|in:Kelas 1,Kelas 2,Kelas 3,VIP,VVIP,ICU,HCU',
            'doctor_in_charge'    => 'nullable|string|max:255',
            'admission_diagnosis' => 'required|string|max:500',
            'final_diagnosis'     => 'nullable|string|max:500',
            'treatment_notes'     => 'nullable|string',
            'discharge_date'      => 'nullable|date|after_or_equal:admission_date',
            'discharge_type'      => 'nullable|in:Sembuh,Pulang Atas Permintaan,Dirujuk,Meninggal',
            'status'              => 'required|in:Aktif,Selesai,Dipindah',
        ]);

        // Auto-set discharge date if status is Selesai
        if ($validated['status'] === 'Selesai' && empty($validated['discharge_date'])) {
            $validated['discharge_date'] = now();
        }

        $inpatient->update($validated);

        return redirect()->route('inpatient.index')
            ->with('success', 'Data rawat inap berhasil diperbarui.');
    }

    public function destroy(InpatientRegistration $inpatient)
    {
        $inpatient->delete();
        return redirect()->route('inpatient.index')
            ->with('success', 'Data rawat inap berhasil dihapus.');
    }

    private function generateRegNumber(): string
    {
        $last = InpatientRegistration::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'RI-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
