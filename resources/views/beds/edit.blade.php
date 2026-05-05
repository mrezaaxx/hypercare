@extends('layouts.app')

@section('title', 'Edit Bed - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Master Data</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Edit Bed</h1>
        </div>
        <x-ui.button href="{{ route('beds.index') }}" variant="secondary" size="lg">
            Back to Beds
        </x-ui.button>
    </div>

    <form method="POST" action="{{ route('beds.update', $bed) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <x-ui.card>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center text-accent">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-text">Bed Information</h2>
                            <p class="text-sm text-text-faint font-medium">Update details for the selected bed.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="room_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Room</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </div>
                                <select id="room_id" name="room_id" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                    <option value="" disabled>Select a room</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ (old('room_id') ?? $bed->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->room_class }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('room_id')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="bed_number" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Bed Number</label>
                            <input type="text" id="bed_number" name="bed_number" value="{{ old('bed_number', $bed->bed_number) }}" required 
                                class="block w-full px-4 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all placeholder:text-text-muted/50 placeholder:font-medium"
                                placeholder="e.g. B-01">
                            @error('bed_number')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.2em]">Status</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                </div>
                                <select id="status" name="status" required class="block w-full pl-11 pr-10 py-4 bg-bg border-2 border-border/50 hover:border-accent/50 focus:border-accent focus:ring-0 rounded-2xl text-sm font-bold text-text transition-all appearance-none cursor-pointer">
                                    <option value="available" {{ (old('status') ?? $bed->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="occupied" {{ (old('status') ?? $bed->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                    <option value="maintenance" {{ (old('status') ?? $bed->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-text-muted">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-xs font-bold text-red-500 mt-2 flex items-center gap-1">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card class="bg-gradient-to-br from-bg to-bg/50 border-accent/10">
                    <h3 class="text-sm font-bold text-text mb-2">Instructions</h3>
                    <p class="text-xs text-text-faint font-medium leading-relaxed mb-4">
                        Please provide the accurate bed number to avoid conflicting data.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2 text-xs text-text-muted font-medium">
                            <svg class="w-4 h-4 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Ensure room class is correctly identified.
                        </li>
                    </ul>
                </x-ui.card>

                <div class="flex flex-col gap-3">
                    <x-ui.button type="submit" variant="primary" size="lg" class="w-full shadow-xl shadow-accent/20">
                        Update Bed
                    </x-ui.button>
                    <x-ui.button href="{{ route('beds.index') }}" variant="secondary" size="lg" class="w-full">
                        Cancel
                    </x-ui.button>
                </div>
            </div>
        </div>
    </form>
@endsection
