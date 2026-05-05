@extends('layouts.app')

@section('title', 'Daftarkan Rawat Inap - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-success rounded-full"></span>
                <p class="text-success text-[0.7rem] font-black tracking-[0.2em] uppercase">Inpatient Unit</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Pendaftaran Rawat Inap</h1>
            <p class="text-sm text-text-faint font-medium mt-1">
                @if($igdVisit)
                    Rujukan dari IGD: <span class="font-mono font-black text-danger">{{ $igdVisit->visit_number }}</span>
                @else
                    Isi formulir pendaftaran pasien rawat inap
                @endif
            </p>
        </div>
        <x-ui.button href="{{ route('inpatient.index') }}" variant="secondary" size="md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </x-ui.button>
    </div>

    {{-- IGD Referral Banner --}}
    @if($igdVisit)
        <div class="mb-6 p-5 rounded-2xl bg-danger/5 border border-danger/20 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-danger/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-black text-danger mb-1">Rujukan dari IGD</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-[0.7rem] font-bold text-text-muted">
                    <div><span class="text-text-faint">Pasien:</span><br>{{ $igdVisit->patient->name }}</div>
                    <div><span class="text-text-faint">No. Kunjungan:</span><br><span class="font-mono text-danger">{{ $igdVisit->visit_number }}</span></div>
                    <div><span class="text-text-faint">Triase:</span><br>{{ $igdVisit->triage_category }}</div>
                    <div><span class="text-text-faint">Keluhan:</span><br>{{ $igdVisit->chief_complaint }}</div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('inpatient.store') }}" id="form-rawat-inap">
        @csrf
        @if($igdVisit)
            <input type="hidden" name="igd_visit_id" value="{{ $igdVisit->id }}">
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">

                {{-- Data Pasien --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-success/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Data Pasien & Penerimaan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Pasien <span class="text-danger">*</span></label>
                            @if($igdVisit)
                                <div class="px-5 py-3.5 bg-bg border border-border/60 rounded-2xl text-sm font-black text-text">
                                    {{ $igdVisit->patient->name }} ({{ $igdVisit->patient->medical_record_number }})
                                </div>
                                <input type="hidden" name="patient_id" value="{{ $igdVisit->patient_id }}">
                            @else
                                <div class="relative">
                                    <select name="patient_id" required
                                        class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none appearance-none cursor-pointer @error('patient_id') border-danger/60 @enderror">
                                        <option value="">— Pilih Pasien —</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} ({{ $patient->medical_record_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                                </div>
                                @error('patient_id')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                            @endif
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Registrasi</label>
                            <input type="text" value="{{ $nextRegNumber }}" disabled
                                class="block w-full px-5 py-3.5 bg-bg border border-border/60 rounded-2xl text-sm font-mono font-bold text-success">
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Tanggal & Jam Masuk <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="admission_date" value="{{ old('admission_date', now()->format('Y-m-d\TH:i')) }}" required
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all">
                            @error('admission_date')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Sumber Masuk <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="admission_source" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['IGD', 'Poliklinik', 'Rujukan Eksternal', 'Langsung'] as $src)
                                        <option value="{{ $src }}" {{ old('admission_source', $igdVisit ? 'IGD' : '') == $src ? 'selected' : '' }}>{{ $src }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Diagnosis Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="admission_diagnosis" required
                                value="{{ old('admission_diagnosis', $igdVisit?->diagnosis ?? $igdVisit?->chief_complaint) }}"
                                placeholder="Diagnosis saat pasien masuk rawat inap..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all @error('admission_diagnosis') border-danger/60 @enderror">
                            @error('admission_diagnosis')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </x-ui.card>

                {{-- Ruangan & Kamar --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-info/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Penempatan Kamar</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Bangsal / Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="ward" value="{{ old('ward') }}" required
                                placeholder="Cth: Bangsal Interna, ICU, Mawar..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all @error('ward') border-danger/60 @enderror">
                            @error('ward')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Kelas Kamar <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="room_class" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['Kelas 1', 'Kelas 2', 'Kelas 3', 'VIP', 'VVIP', 'ICU', 'HCU'] as $rc)
                                        <option value="{{ $rc }}" {{ old('room_class') == $rc ? 'selected' : '' }}>{{ $rc }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Kamar</label>
                            <input type="text" name="room_number" value="{{ old('room_number') }}" placeholder="Cth: 101"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Tempat Tidur</label>
                            <input type="text" name="bed_number" value="{{ old('bed_number') }}" placeholder="Cth: B3"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Dokter Penanggung Jawab</label>
                            <input type="text" name="doctor_in_charge" value="{{ old('doctor_in_charge') }}" placeholder="Nama dokter DPJP..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                    </div>
                </x-ui.card>

                {{-- Catatan Perawatan --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Catatan Perawatan</h2>
                    </div>
                    <textarea name="treatment_notes" rows="4" placeholder="Catatan awal perawatan, rencana terapi, instruksi perawatan..."
                        class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-medium text-text focus:ring-4 focus:ring-accent/10 focus:border-accent/40 outline-none transition-all resize-none">{{ old('treatment_notes') }}</textarea>
                </x-ui.card>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">
                <x-ui.card class="sticky top-24">
                    <h3 class="text-sm font-black text-text mb-5">Simpan Pendaftaran</h3>
                    <div class="space-y-3">
                        <x-ui.button type="submit" variant="primary" size="lg" class="w-full justify-center shadow-xl shadow-success/20">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Daftarkan Rawat Inap
                        </x-ui.button>
                        <x-ui.button href="{{ route('inpatient.index') }}" variant="secondary" size="lg" class="w-full justify-center">Batal</x-ui.button>
                    </div>

                    @if($igdVisit)
                        <div class="mt-5 p-4 rounded-2xl bg-success/5 border border-success/10">
                            <p class="text-[0.65rem] font-black text-success uppercase tracking-widest mb-2">ℹ️ Proses Otomatis</p>
                            <p class="text-[0.7rem] font-bold text-text-muted leading-relaxed">Status kunjungan IGD <span class="font-mono text-danger">{{ $igdVisit->visit_number }}</span> akan otomatis diperbarui menjadi <strong>"Dirujuk Rawat Inap"</strong>.</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mt-5">
                            <p class="text-xs font-black text-danger mb-2">Perbaiki kesalahan berikut:</p>
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-[0.7rem] text-danger font-bold flex gap-2"><span>•</span>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </x-ui.card>
            </div>
        </div>
    </form>
@endsection
