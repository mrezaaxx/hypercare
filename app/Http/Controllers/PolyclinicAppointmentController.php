<?php

namespace App\Http\Controllers;

use App\Models\PolyclinicAppointment;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class PolyclinicAppointmentController extends Controller
{
    public function index()
    {
        $appointments = PolyclinicAppointment::with(['patient', 'doctorSchedule.doctor', 'doctorSchedule.department'])->paginate(10);
        return view('polyclinic-appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $schedules = DoctorSchedule::with(['doctor', 'department'])->where('is_active', true)->get();
        return view('polyclinic-appointments.create', compact('patients', 'schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Automatically assign a queue number for the specific date and schedule
        $latestQueue = PolyclinicAppointment::where('doctor_schedule_id', $validated['doctor_schedule_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->max('queue_number');
            
        $validated['queue_number'] = $latestQueue ? $latestQueue + 1 : 1;

        PolyclinicAppointment::create($validated);

        return redirect()->route('polyclinic-appointments.index')->with('success', 'Polyclinic appointment created successfully. Queue Number: ' . $validated['queue_number']);
    }

    public function edit(PolyclinicAppointment $polyclinicAppointment)
    {
        $patients = Patient::all();
        $schedules = DoctorSchedule::with(['doctor', 'department'])->where('is_active', true)->get();
        return view('polyclinic-appointments.edit', compact('polyclinicAppointment', 'patients', 'schedules'));
    }

    public function update(Request $request, PolyclinicAppointment $polyclinicAppointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // We usually don't change queue numbers on update
        $polyclinicAppointment->update($validated);

        return redirect()->route('polyclinic-appointments.index')->with('success', 'Polyclinic appointment updated successfully.');
    }

    public function destroy(PolyclinicAppointment $polyclinicAppointment)
    {
        $polyclinicAppointment->delete();
        return redirect()->route('polyclinic-appointments.index')->with('success', 'Polyclinic appointment deleted successfully.');
    }
}
