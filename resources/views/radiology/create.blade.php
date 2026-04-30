@extends('layouts.app')

@section('title', 'Order Radiologi Baru - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-info rounded-full"></span>
                <p class="text-info text-[0.7rem] font-black tracking-[0.2em] uppercase">Radiology Services</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">New Radiology Order</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Create a new diagnostic imaging request</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('radiology-orders.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-text-muted hover:text-text font-bold rounded-2xl border border-border/60 transition-all duration-300 shadow-sm active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Registry
            </a>
        </div>
    </div>

    <div class="max-w-5xl">
        <div class="bg-surface border border-border rounded-[2.5rem] shadow-premium overflow-hidden backdrop-blur-md">
            <div class="p-8 md:p-10 border-b border-border/50 bg-bg/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-info/10 flex items-center justify-center text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-text">Radiology Request Form</h2>
                        <p class="text-text-faint text-sm font-medium mt-0.5">Please fill in the diagnostic requirements for the patient.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('radiology-orders.store') }}" class="p-8 md:p-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Order Info -->
                    <div class="space-y-8">
                        <div>
                            <label class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Order Identity</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-info">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ $nextOrderNumber }}" disabled 
                                    class="w-full pl-12 pr-4 py-4 bg-bg-elevated/50 border border-border/60 rounded-2xl text-info font-mono font-black text-sm cursor-not-allowed">
                            </div>
                            <p class="mt-2.5 text-[0.65rem] text-text-faint font-medium flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Automatically generated order reference number.
                            </p>
                        </div>

                        <div>
                            <label for="patient_id" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Patient Information <span class="text-danger">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <select id="patient_id" name="patient_id" required
                                    class="appearance-none w-full pl-12 pr-12 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none cursor-pointer">
                                    <option value="">Select Patient</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->medical_record_number }} - {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-text-faint">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('patient_id')
                                <p class="mt-2 text-[0.65rem] font-bold text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Exam Details -->
                    <div class="space-y-8">
                        <div>
                            <label for="exam_type" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Examination Type <span class="text-danger">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <select id="exam_type" name="exam_type" required
                                    class="appearance-none w-full pl-12 pr-12 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none cursor-pointer">
                                    <option value="">Select Imaging Type</option>
                                    @foreach(['X-Ray', 'CT-Scan', 'MRI', 'USG', 'Mammografi', 'Fluoroskopi', 'Lainnya'] as $type)
                                        <option value="{{ $type }}" {{ old('exam_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-text-faint">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('exam_type')
                                <p class="mt-2 text-[0.65rem] font-bold text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="body_part" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Anatomical Region</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" id="body_part" name="body_part" value="{{ old('body_part') }}" 
                                    placeholder="e.g. Thorax, Abdomen, Cranial"
                                    class="block w-full pl-12 pr-4 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none">
                            </div>
                            @error('body_part')
                                <p class="mt-2 text-[0.65rem] font-bold text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Service Priority <span class="text-danger">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center justify-center p-4 bg-white border border-border/60 rounded-2xl cursor-pointer hover:border-info/30 transition-all has-[:checked]:bg-info/5 has-[:checked]:border-info group overflow-hidden">
                                <input type="radio" name="priority" value="Normal" class="sr-only" {{ old('priority', 'Normal') == 'Normal' ? 'checked' : '' }}>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-info/40 group-has-[:checked]:bg-info transition-all group-has-[:checked]:scale-125"></span>
                                    <span class="text-sm font-black text-text-muted group-has-[:checked]:text-info tracking-tight">Normal</span>
                                </div>
                                <div class="absolute top-0 right-0 w-8 h-8 bg-info/5 -mr-4 -mt-4 rounded-full group-has-[:checked]:scale-[3] transition-transform duration-500"></div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 bg-white border border-border/60 rounded-2xl cursor-pointer hover:border-danger/30 transition-all has-[:checked]:bg-danger/5 has-[:checked]:border-danger group overflow-hidden">
                                <input type="radio" name="priority" value="Cito" class="sr-only" {{ old('priority') == 'Cito' ? 'checked' : '' }}>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-danger/40 group-has-[:checked]:bg-danger transition-all group-has-[:checked]:scale-125 group-has-[:checked]:animate-pulse"></span>
                                    <span class="text-sm font-black text-text-muted group-has-[:checked]:text-danger tracking-tight">Cito (Urgent)</span>
                                </div>
                                <div class="absolute top-0 right-0 w-8 h-8 bg-danger/5 -mr-4 -mt-4 rounded-full group-has-[:checked]:scale-[3] transition-transform duration-500"></div>
                            </label>
                        </div>
                        @error('priority')
                            <p class="mt-2 text-[0.65rem] font-bold text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Clinical Notes -->
                    <div class="md:col-span-2">
                        <label for="clinical_notes" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Clinical Indications & Instructions</label>
                        <div class="relative group">
                            <textarea id="clinical_notes" name="clinical_notes" rows="5" 
                                placeholder="Enter clinical symptoms, diagnosis, or special technical instructions here..."
                                class="block w-full px-5 py-5 bg-white border border-border/60 rounded-[2rem] text-sm font-medium text-text placeholder-text-faint focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none resize-none">{{ old('clinical_notes') }}</textarea>
                        </div>
                        @error('clinical_notes')
                            <p class="mt-2 text-[0.65rem] font-bold text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between gap-6 pt-10 border-t border-border/50">
                    <p class="text-[0.65rem] text-text-faint font-medium flex items-center gap-2">
                        <span class="text-danger font-black text-xs">*</span> Required fields must be completed.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('radiology-orders.index') }}" class="px-8 py-4 text-sm font-black text-text-faint hover:text-text transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-10 py-4 bg-info text-white font-black rounded-2xl hover:bg-info/90 transition-all shadow-xl shadow-info/20 active:scale-95 flex items-center gap-2 group" id="btn-simpan-rad">
                            Create Radiology Order
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
