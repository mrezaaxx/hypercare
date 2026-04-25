<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('medical_record_number', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $nextMrn = $this->generateMrn();
        return view('patients.create', compact('nextMrn'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'required|in:A,B,AB,O,-',
            'insurance_type' => 'required|in:BPJS,Umum,Asuransi',
            'insurance_number' => 'nullable|string|max:50',
        ]);

        $validated['medical_record_number'] = $this->generateMrn();

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Pasien berhasil didaftarkan.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|size:16',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'blood_type' => 'required|in:A,B,AB,O,-',
            'insurance_type' => 'required|in:BPJS,Umum,Asuransi',
            'insurance_number' => 'nullable|string|max:50',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }

    private function generateMrn(): string
    {
        $last = Patient::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'RM-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}
