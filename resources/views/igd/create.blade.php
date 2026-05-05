@extends('layouts.app')

@section('title', 'Daftarkan Pasien IGD - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-danger rounded-full"></span>
                <p class="text-danger text-[0.7rem] font-black tracking-[0.2em] uppercase">Emergency Unit</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Pendaftaran Pasien IGD</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Isi formulir triase dan data kunjungan pasien gawat darurat</p>
        </div>
        <x-ui.button href="{{ route('igd.index') }}" variant="secondary" size="md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </x-ui.button>
    </div>

    <form method="POST" action="{{ route('igd.store') }}" id="form-igd">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- LEFT COLUMN --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Nomor Kunjungan & Data Dasar --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-danger/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Data Kunjungan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Kunjungan</label>
                            <input type="text" value="{{ $nextVisitNumber }}" disabled
                                class="block w-full px-5 py-3.5 bg-bg border border-border/60 rounded-2xl text-sm font-mono font-bold text-danger">
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Waktu Kedatangan <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="arrival_time" value="{{ old('arrival_time', now()->format('Y-m-d\TH:i')) }}" required
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-danger/10 focus:border-danger/40 outline-none transition-all @error('arrival_time') border-danger/60 @enderror">
                            @error('arrival_time')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Pasien <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="patient_id" required id="patient-select"
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-danger/10 focus:border-danger/40 outline-none appearance-none cursor-pointer @error('patient_id') border-danger/60 @enderror">
                                    <option value="">— Pilih Pasien —</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->medical_record_number }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('patient_id')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Cara Datang <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="arrival_method" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-danger/10 focus:border-danger/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['Jalan Kaki', 'Ambulans', 'Kendaraan Pribadi', 'Diantar Keluarga'] as $m)
                                        <option value="{{ $m }}" {{ old('arrival_method') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>

                {{-- TRIASE --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-danger/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Klasifikasi Triase</h2>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                        @foreach([
                            ['P1 - Merah', 'danger', 'Segera', 'Mengancam Jiwa'],
                            ['P2 - Kuning', 'warning', 'Mendesak', 'Tidak Stabil'],
                            ['P3 - Hijau', 'success', 'Tidak Mendesak', 'Kondisi Stabil'],
                            ['P4 - Hitam', 'accent', 'Harapan Tipis', 'Meninggal / Tidak Dapat Ditangani'],
                        ] as [$val, $color, $title, $desc])
                            <label class="cursor-pointer group">
                                <input type="radio" name="triage_category" value="{{ $val }}" class="sr-only peer" {{ old('triage_category') == $val ? 'checked' : '' }} required>
                                <div class="p-4 rounded-2xl border-2 border-border/40 text-center transition-all peer-checked:border-{{ $color }} peer-checked:bg-{{ $color }}/10 group-hover:border-{{ $color }}/40">
                                    <span class="block w-4 h-4 rounded-full bg-{{ $color }} mx-auto mb-2 shadow-lg shadow-{{ $color }}/30"></span>
                                    <p class="text-xs font-black text-text">{{ $title }}</p>
                                    <p class="text-[0.6rem] text-text-faint font-bold mt-0.5 leading-tight">{{ $val }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('triage_category')<p class="text-[0.7rem] text-danger font-bold -mt-3 mb-4">{{ $message }}</p>@enderror

                    <div>
                        <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Keluhan Utama <span class="text-danger">*</span></label>
                        <input type="text" name="chief_complaint" value="{{ old('chief_complaint') }}" required
                            placeholder="Nyeri dada, sesak napas, penurunan kesadaran..."
                            class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-danger/10 focus:border-danger/40 outline-none transition-all @error('chief_complaint') border-danger/60 @enderror">
                        @error('chief_complaint')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                    </div>
                </x-ui.card>

                {{-- Vital Signs --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-info/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Tanda-Tanda Vital</h2>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        @php
                            $vitals = [
                                ['name' => 'systolic_bp',       'label' => 'Tekanan Sistolik',   'unit' => 'mmHg', 'placeholder' => '120'],
                                ['name' => 'diastolic_bp',      'label' => 'Tekanan Diastolik',  'unit' => 'mmHg', 'placeholder' => '80'],
                                ['name' => 'pulse_rate',        'label' => 'Nadi',               'unit' => 'bpm',  'placeholder' => '80'],
                                ['name' => 'respiratory_rate',  'label' => 'Frekuensi Napas',    'unit' => '/mnt', 'placeholder' => '20'],
                                ['name' => 'temperature',       'label' => 'Suhu Tubuh',         'unit' => '°C',   'placeholder' => '36.5'],
                                ['name' => 'oxygen_saturation', 'label' => 'Saturasi Oksigen',   'unit' => '%',    'placeholder' => '98'],
                                ['name' => 'gcs_score',         'label' => 'GCS (3–15)',         'unit' => 'poin', 'placeholder' => '15'],
                            ];
                        @endphp
                        @foreach($vitals as $vital)
                            <div>
                                <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">
                                    {{ $vital['label'] }}
                                    <span class="normal-case font-bold text-text-faint/60 tracking-normal">({{ $vital['unit'] }})</span>
                                </label>
                                <div class="relative">
                                    <input type="{{ $vital['name'] === 'temperature' ? 'number' : 'number' }}"
                                        step="{{ $vital['name'] === 'temperature' ? '0.1' : '1' }}"
                                        name="{{ $vital['name'] }}" value="{{ old($vital['name']) }}"
                                        placeholder="{{ $vital['placeholder'] }}"
                                        class="block w-full pl-5 pr-16 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                                    <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-[0.65rem] font-black text-text-faint pointer-events-none">{{ $vital['unit'] }}</span>
                                </div>
                                @error($vital['name'])<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>

                {{-- Pemeriksaan Fisik & Tindakan --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Pemeriksaan & Tindakan</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Pemeriksaan Fisik</label>
                            <textarea name="physical_exam" rows="3" placeholder="Hasil pemeriksaan fisik..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-medium text-text focus:ring-4 focus:ring-accent/10 focus:border-accent/40 outline-none transition-all resize-none">{{ old('physical_exam') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Diagnosis Sementara</label>
                            <input type="text" name="diagnosis" value="{{ old('diagnosis') }}"
                                placeholder="Diagnosis awal di IGD..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-accent/10 focus:border-accent/40 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Tindakan yang Dilakukan</label>
                            <textarea name="action_taken" rows="3" placeholder="Infus, oksigen, resusitasi, dll..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-medium text-text focus:ring-4 focus:ring-accent/10 focus:border-accent/40 outline-none transition-all resize-none">{{ old('action_taken') }}</textarea>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-6">
                {{-- Submit --}}
                <x-ui.card class="sticky top-24">
                    <h3 class="text-sm font-black text-text mb-5">Simpan Kunjungan IGD</h3>
                    <div class="space-y-3">
                        <x-ui.button type="submit" variant="primary" size="lg" class="w-full justify-center shadow-xl shadow-danger/20">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Daftarkan Pasien IGD
                        </x-ui.button>
                        <x-ui.button href="{{ route('igd.index') }}" variant="secondary" size="lg" class="w-full justify-center">
                            Batal
                        </x-ui.button>
                    </div>

                    <div class="mt-6 p-4 rounded-2xl bg-danger/5 border border-danger/10">
                        <p class="text-[0.65rem] font-black text-danger uppercase tracking-widest mb-2">⚡ Panduan Triase</p>
                        <ul class="space-y-2 text-[0.7rem] font-bold text-text-muted">
                            <li class="flex gap-2"><span class="w-3 h-3 rounded-full bg-danger shrink-0 mt-0.5"></span>P1 Merah — Prioritas tertinggi, tangani segera</li>
                            <li class="flex gap-2"><span class="w-3 h-3 rounded-full bg-warning shrink-0 mt-0.5"></span>P2 Kuning — Kondisi serius, tangani sesegera mungkin</li>
                            <li class="flex gap-2"><span class="w-3 h-3 rounded-full bg-success shrink-0 mt-0.5"></span>P3 Hijau — Kondisi ringan, dapat menunggu</li>
                            <li class="flex gap-2"><span class="w-3 h-3 rounded-full bg-accent shrink-0 mt-0.5"></span>P4 Hitam — Harapan tipis / sudah meninggal</li>
                        </ul>
                    </div>
                </x-ui.card>

                @if($errors->any())
                    <x-ui.card>
                        <p class="text-xs font-black text-danger mb-3">Mohon perbaiki kesalahan berikut:</p>
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-[0.7rem] text-danger font-bold flex gap-2"><span>•</span>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-ui.card>
                @endif
            </div>
        </div>
    </form>
@endsection
