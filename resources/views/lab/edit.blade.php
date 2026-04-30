@extends('layouts.app')

@section('title', 'Edit Order Lab - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-info rounded-full"></span>
                <p class="text-info text-[0.7rem] font-black tracking-[0.2em] uppercase">Laboratory Services</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Edit Lab Order & Results</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Update request details or input examination results</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('lab-orders.index') }}" variant="secondary" size="md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Registry
            </x-ui.button>
        </div>
    </div>

    <div class="max-w-5xl">
        <x-ui.card padding="none">
            <div class="p-8 md:p-10 border-b border-border/50 bg-bg/20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-info/10 flex items-center justify-center text-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-text">Order Information</h2>
                        <p class="text-text-faint text-sm font-medium mt-0.5">Update patient request or complete clinical findings.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('lab-orders.update', $labOrder) }}" class="p-8 md:p-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Order Info Section -->
                    <div class="space-y-8">
                        <div>
                            <label class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Order Identity</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-info">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ $labOrder->order_number }}" disabled 
                                    class="w-full pl-12 pr-4 py-4 bg-bg-elevated/50 border border-border/60 rounded-2xl text-info font-mono font-black text-sm cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Patient Identity</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" value="{{ $labOrder->patient->medical_record_number }} - {{ $labOrder->patient->name }}" disabled 
                                    class="w-full pl-12 pr-4 py-4 bg-bg-elevated/50 border border-border/60 rounded-2xl text-text font-bold text-sm cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label for="status" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Order Status <span class="text-danger">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select id="status" name="status" required
                                    class="appearance-none w-full pl-12 pr-12 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none cursor-pointer">
                                    <option value="Menunggu" {{ old('status', $labOrder->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diproses" {{ old('status', $labOrder->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ old('status', $labOrder->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-text-faint">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Info Section -->
                    <div class="space-y-8">
                        <div>
                            <label for="test_type" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Test Category <span class="text-danger">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <select id="test_type" name="test_type" required
                                    class="appearance-none w-full pl-12 pr-12 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none cursor-pointer">
                                    @foreach(['Hematologi Lengkap', 'Kimia Darah', 'Urinalisa', 'Serologi', 'Gula Darah', 'Profil Lipid', 'Fungsi Hati', 'Fungsi Ginjal', 'Elektrolit', 'Koagulasi', 'Lainnya'] as $type)
                                        <option value="{{ $type }}" {{ old('test_type', $labOrder->test_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-text-faint">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Service Priority <span class="text-danger">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex items-center justify-center p-4 bg-white border border-border/60 rounded-2xl cursor-pointer hover:border-info/30 transition-all has-[:checked]:bg-info/5 has-[:checked]:border-info group overflow-hidden">
                                    <input type="radio" name="priority" value="Normal" class="sr-only" {{ old('priority', $labOrder->priority) == 'Normal' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-info/40 group-has-[:checked]:bg-info transition-all group-has-[:checked]:scale-125"></span>
                                        <span class="text-sm font-black text-text-muted group-has-[:checked]:text-info tracking-tight">Normal</span>
                                    </div>
                                    <div class="absolute top-0 right-0 w-8 h-8 bg-info/5 -mr-4 -mt-4 rounded-full group-has-[:checked]:scale-[3] transition-transform duration-500"></div>
                                </label>
                                <label class="relative flex items-center justify-center p-4 bg-white border border-border/60 rounded-2xl cursor-pointer hover:border-danger/30 transition-all has-[:checked]:bg-danger/5 has-[:checked]:border-danger group overflow-hidden">
                                    <input type="radio" name="priority" value="Cito" class="sr-only" {{ old('priority', $labOrder->priority) == 'Cito' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-danger/40 group-has-[:checked]:bg-danger transition-all group-has-[:checked]:scale-125 group-has-[:checked]:animate-pulse"></span>
                                        <span class="text-sm font-black text-text-muted group-has-[:checked]:text-danger tracking-tight">Cito (Urgent)</span>
                                    </div>
                                    <div class="absolute top-0 right-0 w-8 h-8 bg-danger/5 -mr-4 -mt-4 rounded-full group-has-[:checked]:scale-[3] transition-transform duration-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="clinical_notes" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Clinical Notes & Instructions</label>
                        <div class="relative group">
                            <textarea id="clinical_notes" name="clinical_notes" rows="3" 
                                placeholder="Enter clinical indications..."
                                class="block w-full px-5 py-5 bg-white border border-border/60 rounded-[2rem] text-sm font-medium text-text placeholder-text-faint focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none resize-none">{{ old('clinical_notes', $labOrder->clinical_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="mt-12 pt-12 border-t border-border/50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-success/10 flex items-center justify-center text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-text">Examination Results</h3>
                            <p class="text-text-faint text-sm font-medium mt-0.5">Finalize findings after laboratory analysis.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label for="result_value" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Finding Values</label>
                            <div class="relative group">
                                <textarea id="result_value" name="result_value" rows="4" 
                                    placeholder="Enter test values and metrics..."
                                    class="block w-full px-5 py-5 bg-white border border-border/60 rounded-[2rem] text-sm font-bold text-text placeholder-text-faint focus:ring-4 focus:ring-success/10 focus:border-success/40 transition-all outline-none resize-none">{{ old('result_value', $labOrder->result_value) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label for="result_notes" class="text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em] mb-3 block">Interpretations & Remarks</label>
                            <div class="relative group">
                                <textarea id="result_notes" name="result_notes" rows="3" 
                                    placeholder="Add clinical interpretation or additional remarks..."
                                    class="block w-full px-5 py-5 bg-white border border-border/60 rounded-[2rem] text-sm font-medium text-text placeholder-text-faint focus:ring-4 focus:ring-success/10 focus:border-success/40 transition-all outline-none resize-none">{{ old('result_notes', $labOrder->result_notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between gap-6 pt-10 border-t border-border/50">
                    <p class="text-[0.65rem] text-text-faint font-medium flex items-center gap-2">
                        <span class="text-danger font-black text-xs">*</span> Required fields must be completed.
                    </p>
                    <div class="flex items-center gap-4">
                        <x-ui.button href="{{ route('lab-orders.index') }}" variant="ghost" size="md">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="dark" size="lg" id="btn-update-lab" class="group">
                            Update Order &amp; Results
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
