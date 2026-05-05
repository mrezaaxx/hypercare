@extends('layouts.app')

@section('title', 'Edit Rawat Inap - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-success rounded-full"></span>
                <p class="text-success text-[0.7rem] font-black tracking-[0.2em] uppercase">Inpatient Unit</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Edit Rawat Inap</h1>
            <p class="text-sm text-text-faint font-medium mt-1">
                Perbarui data perawatan: <span class="font-mono font-black text-success">{{ $inpatient->registration_number }}</span>
            </p>
        </div>
        <x-ui.button href="{{ route('inpatient.index') }}" variant="secondary" size="md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </x-ui.button>
    </div>

    <form method="POST" action="{{ route('inpatient.update', $inpatient) }}">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">

                {{-- Data Penerimaan --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-success/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Data Penerimaan</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Pasien</label>
                            <div class="px-5 py-3.5 bg-bg border border-border/60 rounded-2xl text-sm font-black text-text">
                                {{ $inpatient->patient->name }} ({{ $inpatient->patient->medical_record_number }})
                            </div>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Tanggal & Jam Masuk <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="admission_date"
                                value="{{ old('admission_date', $inpatient->admission_date->format('Y-m-d\TH:i')) }}" required
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all">
                            @error('admission_date')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Sumber Masuk <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="admission_source" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['IGD', 'Poliklinik', 'Rujukan Eksternal', 'Langsung'] as $src)
                                        <option value="{{ $src }}" {{ old('admission_source', $inpatient->admission_source) == $src ? 'selected' : '' }}>{{ $src }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Status Rawat Inap <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="status" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['Aktif', 'Selesai', 'Dipindah'] as $s)
                                        <option value="{{ $s }}" {{ old('status', $inpatient->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Diagnosis Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="admission_diagnosis" required
                                value="{{ old('admission_diagnosis', $inpatient->admission_diagnosis) }}"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all @error('admission_diagnosis') border-danger/60 @enderror">
                            @error('admission_diagnosis')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Diagnosis Akhir</label>
                            <input type="text" name="final_diagnosis"
                                value="{{ old('final_diagnosis', $inpatient->final_diagnosis) }}"
                                placeholder="Diisi saat pasien keluar..."
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all">
                        </div>
                    </div>
                </x-ui.card>

                {{-- Kamar --}}
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
                            <input type="text" name="ward" value="{{ old('ward', $inpatient->ward) }}" required
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                            @error('ward')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Kelas Kamar <span class="text-danger">*</span></label>
                            <div class="relative">
                                <select name="room_class" required
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none appearance-none cursor-pointer">
                                    @foreach(['Kelas 1', 'Kelas 2', 'Kelas 3', 'VIP', 'VVIP', 'ICU', 'HCU'] as $rc)
                                        <option value="{{ $rc }}" {{ old('room_class', $inpatient->room_class) == $rc ? 'selected' : '' }}>{{ $rc }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Kamar</label>
                            <input type="text" name="room_number" value="{{ old('room_number', $inpatient->room_number) }}"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">No. Tempat Tidur</label>
                            <input type="text" name="bed_number" value="{{ old('bed_number', $inpatient->bed_number) }}"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Dokter Penanggung Jawab (DPJP)</label>
                            <input type="text" name="doctor_in_charge" value="{{ old('doctor_in_charge', $inpatient->doctor_in_charge) }}"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-info/10 focus:border-info/40 outline-none transition-all">
                        </div>
                    </div>
                </x-ui.card>

                {{-- Catatan & Keluar --}}
                <x-ui.card>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-base font-black text-text">Catatan Perawatan & Data Keluar</h2>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Catatan Perawatan</label>
                            <textarea name="treatment_notes" rows="4"
                                class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-medium text-text focus:ring-4 focus:ring-accent/10 focus:border-accent/40 outline-none transition-all resize-none">{{ old('treatment_notes', $inpatient->treatment_notes) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-border/40">
                            <div>
                                <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Tanggal & Jam Keluar</label>
                                <input type="datetime-local" name="discharge_date"
                                    value="{{ old('discharge_date', $inpatient->discharge_date?->format('Y-m-d\TH:i')) }}"
                                    class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none transition-all">
                                @error('discharge_date')<p class="text-[0.7rem] text-danger font-bold mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-[0.7rem] font-black text-text-faint uppercase tracking-widest mb-2">Cara Keluar</label>
                                <div class="relative">
                                    <select name="discharge_type"
                                        class="block w-full px-5 py-3.5 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none appearance-none cursor-pointer">
                                        <option value="">— Belum Keluar —</option>
                                        @foreach(['Sembuh', 'Pulang Atas Permintaan', 'Dirujuk', 'Meninggal'] as $dt)
                                            <option value="{{ $dt }}" {{ old('discharge_type', $inpatient->discharge_type) == $dt ? 'selected' : '' }}>{{ $dt }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 pr-4 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">
                <x-ui.card class="sticky top-24">
                    <h3 class="text-sm font-black text-text mb-5">Simpan Perubahan</h3>
                    <div class="space-y-3">
                        <x-ui.button type="submit" variant="primary" size="lg" class="w-full justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </x-ui.button>
                        <x-ui.button href="{{ route('inpatient.index') }}" variant="secondary" size="lg" class="w-full justify-center">Batal</x-ui.button>
                    </div>

                    <div class="mt-6 pt-5 border-t border-border/40 space-y-2 text-[0.7rem] font-bold text-text-muted">
                        <p class="text-[0.65rem] font-black text-text-faint uppercase tracking-widest mb-3">Info Registrasi</p>
                        <div class="flex justify-between"><span>No. Registrasi</span><span class="font-mono text-success">{{ $inpatient->registration_number }}</span></div>
                        <div class="flex justify-between"><span>Lama Rawat</span><span>{{ $inpatient->length_of_stay }} hari</span></div>
                        @if($inpatient->igdVisit)
                            <div class="flex justify-between"><span>Dari IGD</span><span class="font-mono text-danger">{{ $inpatient->igdVisit->visit_number }}</span></div>
                        @endif
                        <div class="flex justify-between"><span>Didaftarkan</span><span>{{ $inpatient->created_at->format('d M Y H:i') }}</span></div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </form>
@endsection
