@extends('layouts.app')

@section('title', 'IGD - Instalasi Gawat Darurat - hypercare')

@section('content')
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-danger rounded-full"></span>
                <p class="text-danger text-[0.7rem] font-black tracking-[0.2em] uppercase">Emergency Unit</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">IGD — Instalasi Gawat Darurat</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Triase, pemeriksaan, dan manajemen pasien gawat darurat</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('igd.create') }}" variant="primary" size="md" class="shadow-xl shadow-danger/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Daftarkan Pasien IGD
            </x-ui.button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $statCards = [
                ['label' => 'Kunjungan Hari Ini', 'value' => $stats['total_today'], 'color' => 'text-info', 'bg' => 'bg-info/10', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'],
                ['label' => 'Pasien Aktif', 'value' => $stats['active'], 'color' => 'text-warning', 'bg' => 'bg-warning/10', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />'],
                ['label' => 'P1 Kritis (Aktif)', 'value' => $stats['p1_critical'], 'color' => 'text-danger', 'bg' => 'bg-danger/10', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'],
                ['label' => 'Dirujuk Rawat Inap', 'value' => $stats['referred'], 'color' => 'text-success', 'bg' => 'bg-success/10', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />'],
            ];
        @endphp
        @foreach($statCards as $card)
            <x-ui.card padding="none" class="p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl {{ $card['bg'] }} flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 {{ $card['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        {!! $card['icon'] !!}
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-black {{ $card['color'] }}">{{ $card['value'] }}</p>
                    <p class="text-[0.65rem] font-bold text-text-faint uppercase tracking-wider mt-0.5">{{ $card['label'] }}</p>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    {{-- Triase Legend --}}
    <div class="flex flex-wrap gap-3 mb-6">
        @foreach([
            ['P1 - Merah', 'danger', 'Segera - Mengancam Jiwa'],
            ['P2 - Kuning', 'warning', 'Mendesak - Tidak Stabil'],
            ['P3 - Hijau', 'success', 'Tidak Mendesak - Stabil'],
            ['P4 - Hitam', 'accent', 'Harapan Tipis / Meninggal'],
        ] as [$label, $color, $desc])
            <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-border/40 text-xs font-bold">
                <span class="w-3 h-3 rounded-full bg-{{ $color }} shrink-0"></span>
                <span class="text-text">{{ $label }}</span>
                <span class="text-text-faint font-normal hidden sm:inline">— {{ $desc }}</span>
            </div>
        @endforeach
    </div>

    <x-ui.card padding="none" class="overflow-hidden">
        {{-- Search & Filters --}}
        <div class="p-8 border-b border-border/40 bg-bg/20 backdrop-blur-sm">
            <form method="GET" action="{{ route('igd.index') }}" class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-text-faint group-focus-within:text-danger transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor kunjungan atau nama pasien..."
                        class="block w-full pl-12 pr-6 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text placeholder-text-faint/50 focus:ring-4 focus:ring-danger/10 focus:border-danger/40 transition-all outline-none"
                        id="search-igd">
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @php
                        $triageFilters = [
                            ['label' => 'Semua', 'value' => null, 'color' => 'text-text-faint', 'activeBg' => 'bg-text text-white'],
                            ['label' => 'P1 Merah', 'value' => 'P1 - Merah', 'color' => 'text-danger', 'activeBg' => 'bg-danger text-white shadow-danger/20'],
                            ['label' => 'P2 Kuning', 'value' => 'P2 - Kuning', 'color' => 'text-warning', 'activeBg' => 'bg-warning text-white shadow-warning/20'],
                            ['label' => 'P3 Hijau', 'value' => 'P3 - Hijau', 'color' => 'text-success', 'activeBg' => 'bg-success text-white shadow-success/20'],
                        ];
                    @endphp
                    @foreach($triageFilters as $tf)
                        <a href="{{ route('igd.index', $tf['value'] ? ['triage' => $tf['value']] : []) }}"
                           class="px-4 py-2.5 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all
                           {{ request('triage') == $tf['value']
                               ? $tf['activeBg'] . ' shadow-lg'
                               : 'bg-white text-text-faint hover:border-border/80 border border-border/60' }}">
                            {{ $tf['label'] }}
                        </a>
                    @endforeach
                </div>

                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-3 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text-muted focus:ring-4 focus:ring-danger/10 focus:border-danger/40 outline-none cursor-pointer">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu', 'Dalam Pemeriksaan', 'Observasi', 'Dirujuk Rawat Inap', 'Pulang', 'Meninggal'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-bg/10">
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Kunjungan</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Pasien</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Triase</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Vital Signs</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Keluhan Utama</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/40">
                    @forelse($visits as $visit)
                        @php
                            $triageVariant = $visit->triage_color;
                            $statusVariants = [
                                'Menunggu'           => 'warning',
                                'Dalam Pemeriksaan'  => 'info',
                                'Observasi'          => 'accent',
                                'Dirujuk Rawat Inap' => 'success',
                                'Pulang'             => 'success',
                                'Meninggal'          => 'danger',
                            ];
                            $statusV = $statusVariants[$visit->status] ?? 'accent';
                        @endphp
                        <tr class="group hover:bg-bg/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-mono text-danger font-black text-xs tracking-tight">{{ $visit->visit_number }}</span>
                                    <span class="text-[0.65rem] text-text-faint font-bold mt-1">{{ $visit->arrival_time->format('d M Y, H:i') }}</span>
                                    <span class="text-[0.6rem] text-text-faint/70 mt-0.5">{{ $visit->arrival_method }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-bg border border-border/60 flex items-center justify-center text-[0.65rem] font-black text-text-faint group-hover:bg-danger group-hover:text-white group-hover:border-danger transition-all duration-500">
                                        {{ substr($visit->patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-text leading-tight group-hover:text-danger transition-colors">{{ $visit->patient->name }}</p>
                                        <span class="text-[0.65rem] text-text-faint font-mono font-bold">{{ $visit->patient->medical_record_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <x-ui.badge :variant="$triageVariant" pulse="{{ $triageVariant === 'danger' }}" dot="true">
                                    {{ $visit->triage_category }}
                                </x-ui.badge>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-0.5 text-[0.7rem] font-bold text-text-muted">
                                    @if($visit->systolic_bp)
                                        <span>BP: {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }} mmHg</span>
                                    @endif
                                    @if($visit->pulse_rate)
                                        <span>HR: {{ $visit->pulse_rate }} bpm</span>
                                    @endif
                                    @if($visit->temperature)
                                        <span>T: {{ $visit->temperature }}°C</span>
                                    @endif
                                    @if($visit->oxygen_saturation)
                                        <span>SpO2: {{ $visit->oxygen_saturation }}%</span>
                                    @endif
                                    @if(!$visit->systolic_bp && !$visit->pulse_rate)
                                        <span class="text-text-faint italic">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 max-w-[200px]">
                                <p class="text-xs font-bold text-text-muted line-clamp-2">{{ $visit->chief_complaint }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <x-ui.badge :variant="$statusV" :pulse="$visit->status === 'Dalam Pemeriksaan'" dot="true">
                                    {{ $visit->status }}
                                </x-ui.badge>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    {{-- Rujuk ke Rawat Inap --}}
                                    @if($visit->status !== 'Dirujuk Rawat Inap' && $visit->status !== 'Pulang' && $visit->status !== 'Meninggal')
                                        <a href="{{ route('inpatient.create', ['igd_visit_id' => $visit->id]) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-[0.65rem] font-black uppercase tracking-wider bg-success/10 text-success border border-success/20 hover:bg-success hover:text-white transition-all"
                                           title="Rujuk ke Rawat Inap">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                            Rawat Inap
                                        </a>
                                    @endif
                                    <x-ui.button href="{{ route('igd.edit', $visit) }}" variant="secondary" size="sm" class="!p-2.5 !rounded-xl" title="Edit">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('igd.destroy', $visit) }}" class="inline-block" onsubmit="return confirm('Hapus data kunjungan IGD ini?')">
                                        @csrf @method('DELETE')
                                        <x-ui.button type="submit" variant="secondary" size="sm" class="!p-2.5 !rounded-xl text-danger hover:!bg-danger/10 hover:!border-danger/20" title="Hapus">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 rounded-3xl bg-bg border border-border/60 flex items-center justify-center mb-8 text-text-faint shadow-inner">
                                        <svg class="h-12 w-12 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-text mb-3">Tidak Ada Kunjungan IGD</h3>
                                    <p class="text-sm text-text-faint font-bold leading-relaxed mb-10">Belum ada data kunjungan IGD. Daftarkan pasien baru untuk memulai.</p>
                                    <x-ui.button href="{{ route('igd.create') }}" variant="primary" size="lg">
                                        Daftarkan Pasien IGD
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visits->hasPages())
            <div class="px-8 py-8 border-t border-border/40 bg-bg/10">
                {{ $visits->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </x-ui.card>
@endsection
