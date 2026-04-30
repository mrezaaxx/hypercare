@extends('layouts.app')

@section('title', 'Dashboard | Hypercare')

@section('content')
    <div class="space-y-8 pb-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-text">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
                <p class="text-text-faint font-medium">Here's what's happening in your clinic today.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="glass px-4 py-2.5 rounded-2xl flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center text-accent">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[0.6rem] font-bold text-text-faint uppercase tracking-wider leading-none mb-1">Current Date</p>
                        <p class="text-xs font-bold text-text">{{ date('d M, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-ui.stats-card 
                title="Total Patients" 
                value="{{ $summary['registeredPatients'] }}" 
                trend="12%" 
                :trendUp="true"
                color="accent">
                <x-slot name="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </x-slot>
            </x-ui.stats-card>

            <x-ui.stats-card 
                title="Lab Orders" 
                value="{{ $summary['pendingLabOrders'] }}" 
                trend="5.4%" 
                :trendUp="true"
                color="info">
                <x-slot name="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                </x-slot>
            </x-ui.stats-card>

            <x-ui.stats-card 
                title="Radiology Orders" 
                value="{{ $summary['pendingRadiologyOrders'] }}" 
                trend="2.1%" 
                :trendUp="false"
                color="warning">
                <x-slot name="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
                </x-slot>
            </x-ui.stats-card>

            <x-ui.stats-card 
                title="Completed" 
                value="{{ $summary['completedOrders'] }}" 
                trend="8%" 
                :trendUp="true"
                color="success">
                <x-slot name="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </x-slot>
            </x-ui.stats-card>
        </div>


        <!-- Main Chart & Timeline Grid -->
        <div class="grid lg:grid-cols-3 gap-8">
            <x-ui.card class="lg:col-span-2 relative overflow-hidden group/chart" padding="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-black tracking-tight text-text">Patient Traffic</h2>
                        <p class="text-sm text-text-faint font-medium">Daily statistics of incoming patients</p>
                    </div>
                    <div class="flex gap-2">
                        <x-ui.button variant="secondary" size="xs">Week</x-ui.button>
                        <x-ui.button variant="primary" size="xs">Month</x-ui.button>
                    </div>
                </div>
                
                <!-- SVG Line Chart with Gradient -->
                <div class="relative h-[240px] w-full mt-4">
                    <svg viewBox="0 0 1000 240" class="w-full h-full" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="var(--color-accent)" stop-opacity="0.2" />
                                <stop offset="100%" stop-color="var(--color-accent)" stop-opacity="0" />
                            </linearGradient>
                            <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                <feGaussianBlur stdDeviation="4" result="blur" />
                                <feComposite in="SourceGraphic" in2="blur" operator="over" />
                            </filter>
                        </defs>
                        <!-- Grid Lines -->
                        <line x1="0" y1="60" x2="1000" y2="60" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="4" opacity="0.3" />
                        <line x1="0" y1="120" x2="1000" y2="120" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="4" opacity="0.3" />
                        <line x1="0" y1="180" x2="1000" y2="180" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="4" opacity="0.3" />
                        
                        <!-- Area Fill -->
                        <path d="M0,240 L0,140 C100,120 200,180 300,160 C400,140 500,40 600,60 C700,80 800,150 900,130 L1000,110 L1000,240 Z" fill="url(#chartGradient)" class="transition-opacity duration-500" />
                        
                        <!-- Smooth Line -->
                        <path d="M0,140 C100,120 200,180 300,160 C400,140 500,40 600,60 C700,80 800,150 900,130 L1000,110" fill="none" stroke="var(--color-accent)" stroke-width="4" stroke-linecap="round" class="chart-path" filter="url(#glow)" />
                        
                        <!-- Interactive Data Points -->
                        <g class="cursor-pointer group/point">
                            <circle cx="300" cy="160" r="10" fill="var(--color-accent)" fill-opacity="0.1" class="animate-ping" />
                            <circle cx="300" cy="160" r="5" fill="var(--color-accent)" stroke="white" stroke-width="2.5" class="shadow-lg" />
                        </g>
                        <g class="cursor-pointer group/point">
                            <circle cx="600" cy="60" r="10" fill="var(--color-accent)" fill-opacity="0.1" class="animate-ping" style="animation-delay: 1s" />
                            <circle cx="600" cy="60" r="5" fill="var(--color-accent)" stroke="white" stroke-width="2.5" class="shadow-lg" />
                        </g>
                    </svg>
                </div>
                <div class="flex justify-between mt-8 px-2 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span>
                </div>
            </x-ui.card>

            <x-ui.card class="flex flex-col" padding="p-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-lg font-black tracking-tight text-text">Distribution</h2>
                    <x-ui.button variant="ghost" size="xs" class="w-9 h-9 !p-0 flex items-center justify-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </x-ui.button>
                </div>
                <div class="relative flex items-center justify-center flex-1 min-h-[220px] mb-8">
                    <svg viewBox="0 0 36 36" class="w-48 h-48 transform -rotate-90">
                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--color-surface-soft)" stroke-width="4.5"></circle>
                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--color-accent)" stroke-width="4.5" stroke-dasharray="75 100" stroke-linecap="round" class="transition-all duration-1000"></circle>
                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--color-info)" stroke-width="4.5" stroke-dasharray="20 100" stroke-dashoffset="-75" stroke-linecap="round" class="transition-all duration-1000"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-black tracking-tighter text-text">{{ number_format(1248) }}</span>
                        <span class="text-[0.6rem] text-text-faint font-bold uppercase tracking-[0.2em]">Total Visit</span>
                    </div>
                </div>
                <div class="mt-auto grid grid-cols-2 gap-3">
                    <div class="p-4 rounded-2xl bg-bg/40 border border-border/40 hover:border-accent/30 transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-accent shadow-[0_0_8px_rgba(99,102,241,0.5)]"></div>
                            <span class="text-[0.65rem] font-bold text-text-faint uppercase tracking-wider">Inpatient</span>
                        </div>
                        <span class="text-lg font-black text-text">75%</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-bg/40 border border-border/40 hover:border-info/30 transition-all">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full bg-info shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <span class="text-[0.65rem] font-bold text-text-faint uppercase tracking-wider">Outpatient</span>
                        </div>
                        <span class="text-lg font-black text-text">25%</span>
                    </div>
                </div>
            </x-ui.card>
        </div>


        <!-- Recent Patients & Integrations -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <x-ui.card class="lg:col-span-2 overflow-hidden" padding="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-black tracking-tight text-text">Priority Patients</h2>
                        <p class="text-xs text-text-faint font-medium">Patients requiring immediate clinical attention</p>
                    </div>
                    <x-ui.button variant="secondary" size="sm" :href="route('patients.index')">View Directory</x-ui.button>
                </div>
                <div class="overflow-x-auto -mx-8 px-8">
                    <table class="w-full text-left border-separate border-spacing-y-3">
                        <thead>
                            <tr>
                                <th class="px-4 pb-2 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Patient Details</th>
                                <th class="px-4 pb-2 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Unit</th>
                                <th class="px-4 pb-2 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Status</th>
                                <th class="px-4 pb-2 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em] text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr class="group hover:bg-surface-soft transition-all duration-300">
                                    <td class="px-4 py-4 bg-transparent rounded-l-[1.25rem] border-y border-l border-transparent group-hover:border-border">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-xl bg-surface-soft border border-border flex items-center justify-center text-sm font-black group-hover:bg-accent group-hover:text-white group-hover:border-accent transition-all duration-300">
                                                {{ substr($patient['name'], 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-text leading-tight mb-1 group-hover:text-accent transition-colors">{{ $patient['name'] }}</p>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[0.6rem] text-text-faint font-mono bg-bg px-1.5 py-0.5 rounded border border-border/40 font-bold">{{ $patient['mrn'] }}</span>
                                                    <span class="text-[0.65rem] text-text-faint font-black uppercase tracking-tighter">{{ $patient['payer'] ?? 'Umum' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 border-y border-transparent group-hover:border-border">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-text-muted">{{ $patient['service'] }}</span>
                                            <span class="text-[0.65rem] text-text-faint font-bold">Poliklinik Lt. 2</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 border-y border-transparent group-hover:border-border">
                                        @php
                                            $isUrgent = str_contains(strtolower($patient['status']), 'urgent') || str_contains(strtolower($patient['status']), 'menunggu');
                                        @endphp
                                        <x-ui.badge :variant="$isUrgent ? 'warning' : 'success'" :dot="true" :pulse="$isUrgent">
                                            {{ $patient['status'] }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="px-4 py-4 text-right rounded-r-[1.25rem] border-y border-r border-transparent group-hover:border-border">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <button class="w-9 h-9 flex items-center justify-center bg-white shadow-sm hover:shadow-md rounded-xl transition-all text-text-faint hover:text-accent border border-border/50 hover:border-accent/20">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-8" class="flex flex-col overflow-hidden relative">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-lg font-black tracking-tight text-text">External Sync</h2>
                    <x-ui.badge variant="success" :dot="true" :pulse="true">Active</x-ui.badge>
                </div>
                <div class="space-y-6 flex-1">
                    @foreach ($integrations as $integration)
                        <div class="flex items-start gap-4 group cursor-pointer p-1 rounded-2xl transition-all hover:bg-surface-soft">
                            <div class="w-12 h-12 rounded-2xl bg-surface border border-border flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg group-hover:shadow-accent/20 relative">
                                @if(str_contains(strtolower($integration['name']), 'satusehat'))
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                @elseif(str_contains(strtolower($integration['name']), 'bpjs'))
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM12 8v8M8 12h8"/></svg>
                                @else
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                @endif
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-success border-2 border-surface rounded-full shadow-sm"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <h4 class="text-sm font-black text-text truncate group-hover:text-accent transition-colors">{{ $integration['name'] }}</h4>
                                    <span class="text-[0.65rem] font-bold {{ $integration['status'] == 'Sehat' ? 'text-success' : 'text-warning' }} uppercase tracking-tighter">{{ $integration['status'] }}</span>
                                </div>
                                <p class="text-[0.7rem] text-text-faint leading-relaxed line-clamp-1 mb-3 font-bold">{{ $integration['description'] }}</p>
                                <div class="w-full h-1.5 bg-bg rounded-full overflow-hidden border border-border/50 p-[1px]">
                                    <div class="h-full bg-accent rounded-full transition-all duration-[2000ms] shadow-[0_0_8px_rgba(99,102,241,0.3)]" style="width: {{ rand(75, 95) }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-ui.button variant="dark" size="lg" class="w-full mt-10">Run System Diagnostic</x-ui.button>
            </x-ui.card>
        </div>
    </div>

    <style>
        .chart-path {
            stroke-dasharray: 2000;
            stroke-dashoffset: 2000;
            animation: draw 3s ease-out forwards;
        }
        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }
    </style>
@endsection

