@extends('layouts.app')

@section('title', 'Patient Registry - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Clinical Module</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Patient Registry</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Comprehensive directory of medical records and hospital patients</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('patients.create') }}" variant="primary" size="lg" class="shadow-xl shadow-accent/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Register New Patient
            </x-ui.button>
        </div>
    </div>

    <x-ui.card class="mb-8" padding="none">
        <div class="p-8 border-b border-border/50 bg-bg/20">
            <form method="GET" action="{{ route('patients.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-text-faint group-focus-within:text-accent transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search by name, MRN, or identity number..." 
                        class="block w-full pl-12 pr-4 py-4 bg-white border border-border/60 rounded-2xl text-sm font-medium text-text placeholder-text-faint focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none"
                        id="search-pasien">
                </div>
                <div class="flex gap-2">
                    <x-ui.button type="submit" variant="dark" size="md" class="px-10">
                        Search
                    </x-ui.button>
                    @if(request('search'))
                        <x-ui.button href="{{ route('patients.index') }}" variant="secondary" size="md">
                            Reset
                        </x-ui.button>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto p-8 pt-4">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Patient Profile</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Identity Number</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em] text-center">Gender</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Birth Date</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Payer Type</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr class="group hover:bg-bg/40 transition-all duration-300">
                            <td class="px-6 py-5 bg-white group-hover:bg-bg/10 rounded-l-2xl border-y border-l border-border/40 group-hover:border-accent/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-surface-soft border border-border/60 flex items-center justify-center text-sm font-black text-text-muted group-hover:bg-accent group-hover:text-white group-hover:border-accent transition-all duration-500 shadow-sm">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-text leading-tight mb-1 group-hover:text-accent transition-colors">{{ $patient->name }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[0.65rem] text-accent font-black bg-accent/5 px-2 py-0.5 rounded border border-accent/10">{{ $patient->medical_record_number }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 transition-all">
                                <span class="text-xs font-bold text-text-muted">{{ $patient->nik ?? '---' }}</span>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 text-center transition-all">
                                <x-ui.badge variant="{{ $patient->gender == 'Laki-laki' ? 'info' : 'accent' }}">
                                    {{ $patient->gender == 'Laki-laki' ? 'Male' : 'Female' }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 transition-all">
                                <span class="text-xs font-bold text-text-muted">{{ $patient->birth_date ? $patient->birth_date->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 transition-all">
                                @php
                                    $variant = match(strtolower($patient->insurance_type)) {
                                        'umum' => 'success',
                                        'bpjs' => 'info',
                                        'asuransi' => 'warning',
                                        default => 'info'
                                    };
                                @endphp
                                <x-ui.badge variant="{{ $variant }}" dot="true">
                                    {{ $patient->insurance_type }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-r border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 rounded-r-2xl text-right transition-all">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    <x-ui.button href="{{ route('patients.edit', $patient) }}" variant="secondary" size="xs" class="w-9 h-9 !p-0 flex items-center justify-center">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline-block" onsubmit="return confirm('Archive this patient record?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="danger" size="xs" class="w-9 h-9 !p-0 flex items-center justify-center">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 rounded-[2rem] bg-surface-soft border border-border/60 flex items-center justify-center mb-6 text-text-faint shadow-inner">
                                        <svg class="h-12 w-12 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-text mb-2">No Patients Found</h3>
                                    <p class="text-sm text-text-faint font-medium mb-10 leading-relaxed text-balance">We couldn't find any patient records matching your criteria. Start by registering a new patient to the clinical directory.</p>
                                    <x-ui.button href="{{ route('patients.create') }}" variant="primary" size="md" class="px-8 shadow-lg shadow-accent/20">
                                        Register Patient
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($patients->hasPages())
            <div class="px-8 py-8 border-t border-border/40 bg-bg/10 rounded-b-[2.5rem]">
                {{ $patients->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </x-ui.card>
@endsection

