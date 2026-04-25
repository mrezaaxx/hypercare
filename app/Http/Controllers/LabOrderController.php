<?php

namespace App\Http\Controllers;

use App\Models\LabOrder;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = LabOrder::with(['patient', 'orderedByUser']);

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

        return view('lab.index', compact('orders'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $nextOrderNumber = $this->generateOrderNumber();
        return view('lab.create', compact('patients', 'nextOrderNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type' => 'required|string|max:255',
            'clinical_notes' => 'nullable|string',
            'priority' => 'required|in:Normal,Cito',
        ]);

        $validated['order_number'] = $this->generateOrderNumber();
        $validated['status'] = 'Menunggu';
        $validated['ordered_by'] = Auth::id();

        LabOrder::create($validated);

        return redirect()->route('lab-orders.index')
            ->with('success', 'Order laboratorium berhasil dibuat.');
    }

    public function edit(LabOrder $labOrder)
    {
        $labOrder->load('patient');
        $patients = Patient::orderBy('name')->get();
        return view('lab.edit', compact('labOrder', 'patients'));
    }

    public function update(Request $request, LabOrder $labOrder)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|max:255',
            'clinical_notes' => 'nullable|string',
            'priority' => 'required|in:Normal,Cito',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'result_value' => 'nullable|string',
            'result_notes' => 'nullable|string',
        ]);

        $labOrder->update($validated);

        return redirect()->route('lab-orders.index')
            ->with('success', 'Order laboratorium berhasil diperbarui.');
    }

    public function destroy(LabOrder $labOrder)
    {
        $labOrder->delete();

        return redirect()->route('lab-orders.index')
            ->with('success', 'Order laboratorium berhasil dihapus.');
    }

    private function generateOrderNumber(): string
    {
        $last = LabOrder::orderBy('id', 'desc')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'LAB-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}
