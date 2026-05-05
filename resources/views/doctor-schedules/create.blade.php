@extends('layouts.app')

@section('title', 'Add Doctor Schedule - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Master Data</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Add Schedule</h1>
        </div>
        <x-ui.button href="{{ route('doctor-schedules.index') }}" variant="secondary" size="lg">
            Back to Schedules
        </x-ui.button>
    </div>

    @php
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    @endphp

    <form method="POST" action="{{ route('doctor-schedules.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <x-ui.card>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center text-accent">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text">Schedule Information</h2>
                            <p class="text-sm text-text-faint font-medium">Enter details for the doctor's new schedule.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="doctor_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Doctor</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                    <select id="doctor_id" name="doctor_id" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select a doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->user->name ?? 'Unknown' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('doctor_id')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="department_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Department (Polyclinic)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                        </svg>
                                    </div>
                                    <select id="department_id" name="department_id" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select a department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('department_id')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="day_of_week" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Day of Week</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                        </svg>
                                    </div>
                                    <select id="day_of_week" name="day_of_week" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select a day</option>
                                        @foreach($days as $index => $day)
                                            <option value="{{ $index }}" {{ old('day_of_week') == (string)$index ? 'selected' : '' }}>
                                                {{ $day }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('day_of_week')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="quota" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Quota (Patients)</label>
                                <input type="number" id="quota" name="quota" value="{{ old('quota', 20) }}" required min="1"
                                    class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all placeholder:text-text-muted/50 placeholder:font-medium">
                                @error('quota')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="start_time" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Start Time</label>
                                <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required 
                                    class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all">
                                @error('start_time')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="end_time" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">End Time</label>
                                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required 
                                    class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all">
                                @error('end_time')
                                    <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-4">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-accent border-2 border-border/50 rounded-lg focus:ring-accent focus:ring-offset-bg bg-bg transition-colors cursor-pointer">
                            <label for="is_active" class="text-sm font-bold text-text cursor-pointer select-none">Schedule is active</label>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card class="bg-gradient-to-br from-bg to-bg/50 border-accent/10">
                    <h3 class="text-sm font-bold text-text mb-2">Instructions</h3>
                    <p class="text-xs text-text-faint font-medium leading-relaxed mb-4">
                        Please review the schedule carefully. Polyclinic appointments will be generated against these schedules.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-xs text-text-muted font-medium">
                            <svg class="w-4 h-4 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            End time must be after the start time.
                        </li>
                    </ul>
                </x-ui.card>

                <div class="flex flex-col gap-3">
                    <x-ui.button type="submit" variant="primary" size="lg" class="w-full shadow-xl shadow-accent/20">
                        Save Schedule
                    </x-ui.button>
                    <x-ui.button href="{{ route('doctor-schedules.index') }}" variant="secondary" size="lg" class="w-full">
                        Cancel
                    </x-ui.button>
                </div>
            </div>
        </div>
    </form>
@endsection
