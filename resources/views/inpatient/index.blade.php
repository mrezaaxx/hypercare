@extends('layouts.app')

@section('title', 'Rawat Inap - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-success rounded-full"></span>
                <p class="text-success text-[0.7rem] font-black tracking-[0.2em] uppercase">Inpatient Unit</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Rawat Inap</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Manajemen pendaftaran dan perawatan pasien rawat inap</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('inpatient.create') }}" variant="primary" size="md" class="shadow-xl shadow-success/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Daftarkan Pasien
            </x-ui.button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $statCards = [
                ['label' => 'Pasien Aktif',        'value' => $stats['total_active'],     'color' => 'text-success', 'bg' => 'bg-success/10', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                ['label' => 'Masuk Hari Ini',      'value' => $stats['admitted_today'],   'color' => 'text-info',    'bg' => 'bg-info/10',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['label' => 'Keluar Hari Ini',     'value' => $stats['discharged_today'], 'color' => 'text-accent',  'bg' => 'bg-accent/10',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>'],
                ['label' => 'Dari IGD (Aktif)',    'value' => $stats['from_igd'],         'color' => 'text-danger',  'bg' => 'bg-danger/10',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'],
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

    <x-ui.card padding="none" class="overflow-hidden">
        {{-- Filters --}}
        <div class="p-8 border-b border-border/40 bg-bg/20 backdrop-blur-sm">
            <form method="GET" action="{{ route('inpatient.index') }}" class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-text-faint group-focus-within:text-success transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor registrasi atau nama pasien..."
                        class="block w-full pl-12 pr-6 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text placeholder-text-faint/50 focus:ring-4 focus:ring-success/10 focus:border-success/40 transition-all outline-none"
                        id="search-rawat-inap">
                </div>

                <div class="flex gap-3">
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()"
                            class="px-4 py-3 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text-muted focus:ring-4 focus:ring-success/10 focus:border-success/40 outline-none cursor-pointer appearance-none pr-10">
                            <option value="">Semua Status</option>
                            @foreach(['Aktif', 'Selesai', 'Dipindah'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 pr-3 flex items-center"><svg class="h-4 w-4 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></div>
                    </div>
                    <x-ui.button type="submit" variant="dark" size="md">Cari</x-ui.button>
                    @if(request()->hasAny(['search','status','ward']))
                        <x-ui.button href="{{ route('inpatient.index') }}" variant="secondary" size="md">Reset</x-ui.button>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-bg/10">
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">No. Registrasi</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Pasien</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Ruangan / Kelas</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Sumber Masuk</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Diagnosa</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Lama</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/40">
                    @forelse($registrations as $reg)
                        @php
                            $statusVariants = ['Aktif' => 'success', 'Selesai' => 'info', 'Dipindah' => 'warning'];
                            $sourceVariants = ['IGD' => 'danger', 'Poliklinik' => 'info', 'Rujukan Eksternal' => 'warning', 'Langsung' => 'success'];
                            $statusV = $statusVariants[$reg->status] ?? 'accent';
                            $sourceV = $sourceVariants[$reg->admission_source] ?? 'accent';
                        @endphp
                        <tr class="group hover:bg-bg/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-mono text-success font-black text-xs tracking-tight">{{ $reg->registration_number }}</span>
                                    <span class="text-[0.65rem] text-text-faint font-bold mt-1">{{ $reg->admission_date->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-bg border border-border/60 flex items-center justify-center text-[0.65rem] font-black text-text-faint group-hover:bg-success group-hover:text-white group-hover:border-success transition-all duration-500">
                                        {{ substr($reg->patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-text leading-tight group-hover:text-success transition-colors">{{ $reg->patient->name }}</p>
                                        <span class="text-[0.65rem] text-text-faint font-mono font-bold">{{ $reg->patient->medical_record_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-text">{{ $reg->ward }}</span>
                                    @if($reg->room_number)<span class="text-[0.65rem] text-text-faint font-bold">Kamar {{ $reg->room_number }}, Bed {{ $reg->bed_number }}</span>@endif
                                    <span class="text-[0.6rem] font-black text-text-faint/70 uppercase tracking-widest mt-1">{{ $reg->room_class }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <x-ui.badge :variant="$sourceV" dot="true">{{ $reg->admission_source }}</x-ui.badge>
                            </td>
                            <td class="px-8 py-6 max-w-[180px]">
                                <p class="text-xs font-bold text-text-muted line-clamp-2">{{ $reg->admission_diagnosis }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-text-muted">{{ $reg->length_of_stay }} <span class="text-[0.65rem] font-bold text-text-faint">hari</span></span>
                            </td>
                            <td class="px-8 py-6">
                                <x-ui.badge :variant="$statusV" :pulse="$reg->status === 'Aktif'" dot="true">{{ $reg->status }}</x-ui.badge>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    <x-ui.button href="{{ route('inpatient.edit', $reg) }}" variant="secondary" size="sm" class="!p-2.5 !rounded-xl" title="Edit">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('inpatient.destroy', $reg) }}" class="inline-block" onsubmit="return confirm('Hapus data rawat inap ini?')">
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
                            <td colspan="8" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 rounded-3xl bg-bg border border-border/60 flex items-center justify-center mb-8 shadow-inner">
                                        <svg class="h-12 w-12 opacity-20 text-text-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-text mb-3">Tidak Ada Data Rawat Inap</h3>
                                    <p class="text-sm text-text-faint font-bold leading-relaxed mb-10">Belum ada pasien yang terdaftar di rawat inap. Tambahkan pasien baru atau rujuk dari IGD.</p>
                                    <x-ui.button href="{{ route('inpatient.create') }}" variant="primary" size="lg">
                                        Daftarkan Pasien
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="px-8 py-8 border-t border-border/40 bg-bg/10">
                {{ $registrations->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </x-ui.card>
@endsection
