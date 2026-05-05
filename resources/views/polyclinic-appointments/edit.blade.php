@extends('layouts.app')

@section('title', 'Edit Appointment - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Clinical Operations</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Edit Appointment</h1>
        </div>
        <x-ui.button href="{{ route('polyclinic-appointments.index') }}" variant="secondary" size="lg">
            Back to Appointments
        </x-ui.button>
    </div>

    @php
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    @endphp

    <form method="POST" action="{{ route('polyclinic-appointments.update', $polyclinicAppointment) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <x-ui.card>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center text-accent">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text">Appointment Details</h2>
                            <p class="text-sm text-text-faint font-medium">Update details for the selected appointment.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="patient_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Patient</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <select id="patient_id" name="patient_id" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                    <option value="" disabled>Select a patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ (old('patient_id') ?? $polyclinicAppointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} - {{ $patient->medical_record_number }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('patient_id')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="doctor_schedule_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Doctor & Schedule</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                                <select id="doctor_schedule_id" name="doctor_schedule_id" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                    <option value="" disabled>Select a schedule</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}" {{ (old('doctor_schedule_id') ?? $polyclinicAppointment->doctor_schedule_id) == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->department->name ?? 'Dept' }} | {{ $schedule->doctor->user->name ?? 'Dr.' }} | {{ $days[$schedule->day_of_week] }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('doctor_schedule_id')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="appointment_date" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Appointment Date</label>
                                <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', \Carbon\Carbon::parse($polyclinicAppointment->appointment_date)->format('Y-m-d')) }}" required
                                    class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all">
                                @error('appointment_date')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="status" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Status</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                        </svg>
                                    </div>
                                    <select id="status" name="status" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                        <option value="scheduled" {{ (old('status') ?? $polyclinicAppointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="completed" {{ (old('status') ?? $polyclinicAppointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ (old('status') ?? $polyclinicAppointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('status')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all placeholder:text-text-muted/50 placeholder:font-medium resize-none"
                                placeholder="Any additional notes for the appointment...">{{ old('notes', $polyclinicAppointment->notes) }}</textarea>
                            @error('notes')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card class="bg-gradient-to-br from-bg to-bg/50 border-accent/10">
                    <h3 class="text-sm font-bold text-text mb-2">Instructions</h3>
                    <p class="text-xs text-text-faint font-medium leading-relaxed mb-4">
                        The queue number remains unchanged when editing the appointment. Change the status to 'Completed' once the doctor has seen the patient.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-xs text-text-muted font-medium">
                            <svg class="w-4 h-4 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Current Queue Number: <strong class="ml-1 text-accent">{{ str_pad($polyclinicAppointment->queue_number, 3, '0', STR_PAD_LEFT) }}</strong>
                        </li>
                    </ul>
                </x-ui.card>

                <div class="flex flex-col gap-3">
                    <x-ui.button type="submit" variant="primary" size="lg" class="w-full shadow-xl shadow-accent/20">
                        Update Appointment
                    </x-ui.button>
                    <x-ui.button href="{{ route('polyclinic-appointments.index') }}" variant="secondary" size="lg" class="w-full">
                        Cancel
                    </x-ui.button>
                </div>
            </div>
        </div>
    </form>
@endsection
