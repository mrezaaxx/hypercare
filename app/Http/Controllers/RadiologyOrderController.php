<?php

namespace App\Http\Controllers;

use App\Models\RadiologyOrder;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RadiologyOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = RadiologyOrder::with(['patient', 'orderedByUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('medical_record_number', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('radiology.index', compact('orders'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $nextOrderNumber = $this->generateOrderNumber();
        return view('radiology.create', compact('patients', 'nextOrderNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'exam_type' => 'required|string|max:255',
            'body_part' => 'nullable|string|max:255',
            'clinical_notes' => 'nullable|string',
            'priority' => 'required|in:Normal,Cito',
        ]);

        $validated['order_number'] = $this->generateOrderNumber();
        $validated['status'] = 'Menunggu';
        $validated['ordered_by'] = Auth::id();

        RadiologyOrder::create($validated);

        return redirect()->route('radiology-orders.index')
            ->with('success', 'Order radiologi berhasil dibuat.');
    }

    public function edit(RadiologyOrder $radiologyOrder)
    {
        $radiologyOrder->load('patient');
        $patients = Patient::orderBy('name')->get();
        return view('radiology.edit', compact('radiologyOrder', 'patients'));
    }

    public function update(Request $request, RadiologyOrder $radiologyOrder)
    {
        $validated = $request->validate([
            'exam_type' => 'required|string|max:255',
            'body_part' => 'nullable|string|max:255',
            'clinical_notes' => 'nullable|string',
            'priority' => 'required|in:Normal,Cito',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'result_findings' => 'nullable|string',
            'result_impression' => 'nullable|string',
        ]);

        $radiologyOrder->update($validated);

        return redirect()->route('radiology-orders.index')
            ->with('success', 'Order radiologi berhasil diperbarui.');
    }

    public function destroy(RadiologyOrder $radiologyOrder)
    {
        $radiologyOrder->delete();

        return redirect()->route('radiology-orders.index')
            ->with('success', 'Order radiologi berhasil dihapus.');
    }

    private function generateOrderNumber(): string
    {
        $last = RadiologyOrder::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'RAD-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
