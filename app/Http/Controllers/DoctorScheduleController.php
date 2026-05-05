<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with(['doctor', 'department'])->paginate(10);
        return view('doctor-schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        return view('doctor-schedules.create', compact('doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'quota' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        DoctorSchedule::create($validated);

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule created successfully.');
    }

    public function edit(DoctorSchedule $doctorSchedule)
    {
        $doctors = Doctor::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        return view('doctor-schedules.edit', compact('doctorSchedule', 'doctors', 'departments'));
    }

    public function update(Request $request, DoctorSchedule $doctorSchedule)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'quota' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $doctorSchedule->update($validated);

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule updated successfully.');
    }

    public function destroy(DoctorSchedule $doctorSchedule)
    {
        $doctorSchedule->delete();
        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule deleted successfully.');
    }
}
