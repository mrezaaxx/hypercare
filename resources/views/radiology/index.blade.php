@extends('layouts.app')

@section('title', 'Radiology Registry - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-info rounded-full"></span>
                <p class="text-info text-[0.7rem] font-black tracking-[0.2em] uppercase">Diagnostic Imaging</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Radiology Order Registry</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Monitor and manage clinical imaging requests</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('radiology-orders.create') }}" variant="primary" size="md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Radiology Order
            </x-ui.button>
        </div>
    </div>

    <x-ui.card padding="none" class="mb-8 overflow-hidden">
        <!-- Search & Filters -->
        <div class="p-8 border-b border-border/40 bg-bg/20 backdrop-blur-sm">
            <form method="GET" action="{{ route('radiology-orders.index') }}" class="flex flex-col lg:flex-row gap-6">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-text-faint group-focus-within:text-info transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search by order ID or patient name..." 
                        class="block w-full pl-12 pr-6 py-4 bg-white border border-border/60 rounded-2xl text-sm font-bold text-text placeholder-text-faint/50 focus:ring-4 focus:ring-info/10 focus:border-info/40 transition-all outline-none"
                        id="search-radiology">
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @php
                        $filters = [
                            ['label' => 'All Orders', 'status' => null, 'variant' => 'info'],
                            ['label' => 'Pending', 'status' => 'Menunggu', 'variant' => 'warning'],
                            ['label' => 'Processing', 'status' => 'Diproses', 'variant' => 'info'],
                            ['label' => 'Completed', 'status' => 'Selesai', 'variant' => 'success'],
                        ];
                    @endphp

                    @foreach ($filters as $filter)
                        <a href="{{ route('radiology-orders.index', $filter['status'] ? ['status' => $filter['status']] : []) }}" 
                           class="px-5 py-3 rounded-xl text-[0.65rem] font-black uppercase tracking-widest transition-all 
                           {{ request('status') == $filter['status'] 
                               ? "bg-{$filter['variant']} text-white shadow-lg shadow-{$filter['variant']}/20" 
                               : "bg-white text-text-faint hover:text-{$filter['variant']} border border-border/60" }}">
                            {{ $filter['label'] }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-bg/10">
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Order Details</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Patient</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Modality & Region</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Priority</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[0.6rem] font-black text-text-faint uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/40">
                    @forelse ($orders as $order)
                        <tr class="group hover:bg-bg/30 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-mono text-info font-black text-xs tracking-tight">{{ $order->order_number }}</span>
                                    <span class="text-[0.65rem] text-text-faint font-bold mt-1 uppercase tracking-wider">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-bg border border-border/60 flex items-center justify-center text-[0.65rem] font-black text-text-faint group-hover:bg-info group-hover:text-white group-hover:border-info transition-all duration-500 shadow-inner">
                                        {{ substr($order->patient->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-sm font-black text-text leading-tight group-hover:text-info transition-colors">{{ $order->patient->name }}</p>
                                        <span class="text-[0.65rem] text-text-faint font-mono font-bold tracking-tight mt-0.5">{{ $order->patient->medical_record_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-text-muted">{{ $order->exam_type }}</span>
                                    <span class="text-[0.6rem] text-text-faint font-black uppercase tracking-widest mt-1">{{ $order->body_part ?? 'General' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($order->priority == 'Cito')
                                    <x-ui.badge variant="danger" pulse="true" dot="true">URGENT</x-ui.badge>
                                @else
                                    <x-ui.badge variant="info">ROUTINE</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $variants = [
                                        'Menunggu' => 'warning',
                                        'Diproses' => 'info',
                                        'Selesai' => 'success',
                                    ];
                                    $labels = [
                                        'Menunggu' => 'PENDING',
                                        'Diproses' => 'PROCESSING',
                                        'Selesai' => 'COMPLETED',
                                    ];
                                    $variant = $variants[$order->status] ?? 'accent';
                                    $label = $labels[$order->status] ?? strtoupper($order->status);
                                @endphp
                                <x-ui.badge :variant="$variant" :pulse="$order->status == 'Diproses'" dot="true">
                                    {{ $label }}
                                </x-ui.badge>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    <x-ui.button href="{{ route('radiology-orders.edit', $order) }}" variant="secondary" size="sm" class="!p-2.5 !rounded-xl" title="Edit Order">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('radiology-orders.destroy', $order) }}" class="inline-block" onsubmit="return confirm('Delete this radiology order?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="secondary" size="sm" class="!p-2.5 !rounded-xl text-danger hover:!bg-danger/10 hover:!border-danger/20" title="Delete Order">
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
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center max-w-sm mx-auto">
                                    <div class="w-24 h-24 rounded-3xl bg-bg border border-border/60 flex items-center justify-center mb-8 text-text-faint shadow-inner">
                                        <svg class="h-12 w-12 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-text mb-3">No Radiology Orders</h3>
                                    <p class="text-sm text-text-faint font-bold leading-relaxed mb-10">The radiology registry is currently empty. Initiate diagnostic workflows by creating a new imaging request.</p>
                                    <x-ui.button href="{{ route('radiology-orders.create') }}" variant="primary" size="lg" class="shadow-xl shadow-info/20">
                                        Initialize First Order
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="px-8 py-8 border-t border-border/40 bg-bg/10 backdrop-blur-sm">
                {{ $orders->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </x-ui.card>
@endsection
