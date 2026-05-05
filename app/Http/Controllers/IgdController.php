<?php

namespace App\Http\Controllers;

use App\Models\IgdVisit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IgdController extends Controller
{
    public function index(Request $request)
    {
        $query = IgdVisit::with(['patient', 'handledByUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('triage')) {
            $query->where('triage_category', $request->triage);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('visit_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('medical_record_number', 'like', "%{$search}%");
                  });
            });
        }

        $visits = $query->orderBy('arrival_time', 'desc')->paginate(15);

        // Stats
        $stats = [
            'total_today'   => IgdVisit::whereDate('arrival_time', today())->count(),
            'active'        => IgdVisit::whereIn('status', ['Menunggu', 'Dalam Pemeriksaan', 'Observasi'])->count(),
            'p1_critical'   => IgdVisit::where('triage_category', 'P1 - Merah')->whereIn('status', ['Menunggu', 'Dalam Pemeriksaan'])->count(),
            'referred'      => IgdVisit::where('status', 'Dirujuk Rawat Inap')->whereDate('arrival_time', today())->count(),
        ];

        return view('igd.index', compact('visits', 'stats'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $nextVisitNumber = $this->generateVisitNumber();
        return view('igd.create', compact('patients', 'nextVisitNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|exists:patients,id',
            'arrival_time'      => 'required|date',
            'arrival_method'    => 'required|in:Jalan Kaki,Ambulans,Kendaraan Pribadi,Diantar Keluarga',
            'triage_category'   => 'required|in:P1 - Merah,P2 - Kuning,P3 - Hijau,P4 - Hitam',
            'systolic_bp'       => 'nullable|integer|min:0|max:300',
            'diastolic_bp'      => 'nullable|integer|min:0|max:200',
            'pulse_rate'        => 'nullable|integer|min:0|max:300',
            'respiratory_rate'  => 'nullable|integer|min:0|max:60',
            'temperature'       => 'nullable|numeric|min:30|max:45',
            'oxygen_saturation' => 'nullable|integer|min:0|max:100',
            'gcs_score'         => 'nullable|integer|min:3|max:15',
            'chief_complaint'   => 'required|string|max:500',
            'physical_exam'     => 'nullable|string',
            'diagnosis'         => 'nullable|string',
            'action_taken'      => 'nullable|string',
        ]);

        $validated['visit_number'] = $this->generateVisitNumber();
        $validated['status'] = 'Menunggu';
        $validated['handled_by'] = Auth::id();

        IgdVisit::create($validated);

        return redirect()->route('igd.index')
            ->with('success', 'Kunjungan IGD berhasil didaftarkan.');
    }

    public function show(IgdVisit $igd)
    {
        $igd->load(['patient', 'handledByUser', 'inpatientRegistration']);
        return view('igd.show', compact('igd'));
    }

    public function edit(IgdVisit $igd)
    {
        $igd->load('patient');
        $patients = Patient::orderBy('name')->get();
        return view('igd.edit', compact('igd', 'patients'));
    }

    public function update(Request $request, IgdVisit $igd)
    {
        $validated = $request->validate([
            'arrival_time'      => 'required|date',
            'arrival_method'    => 'required|in:Jalan Kaki,Ambulans,Kendaraan Pribadi,Diantar Keluarga',
            'triage_category'   => 'required|in:P1 - Merah,P2 - Kuning,P3 - Hijau,P4 - Hitam',
            'systolic_bp'       => 'nullable|integer|min:0|max:300',
            'diastolic_bp'      => 'nullable|integer|min:0|max:200',
            'pulse_rate'        => 'nullable|integer|min:0|max:300',
            'respiratory_rate'  => 'nullable|integer|min:0|max:60',
            'temperature'       => 'nullable|numeric|min:30|max:45',
            'oxygen_saturation' => 'nullable|integer|min:0|max:100',
            'gcs_score'         => 'nullable|integer|min:3|max:15',
            'chief_complaint'   => 'required|string|max:500',
            'physical_exam'     => 'nullable|string',
            'diagnosis'         => 'nullable|string',
            'action_taken'      => 'nullable|string',
            'status'            => 'required|in:Menunggu,Dalam Pemeriksaan,Observasi,Dirujuk Rawat Inap,Pulang,Meninggal',
        ]);

        $igd->update($validated);

        return redirect()->route('igd.index')
            ->with('success', 'Data kunjungan IGD berhasil diperbarui.');
    }

    public function destroy(IgdVisit $igd)
    {
        $igd->delete();
        return redirect()->route('igd.index')
            ->with('success', 'Data kunjungan IGD berhasil dihapus.');
    }

    private function generateVisitNumber(): string
    {
        $last = IgdVisit::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'IGD-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
