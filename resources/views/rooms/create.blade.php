@extends('layouts.app')

@section('title', 'Add Room - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Master Data</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Add Room</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Register a new room or ward</p>
        </div>
        <x-ui.button href="{{ route('rooms.index') }}" variant="secondary" size="md">
            Back to Rooms
        </x-ui.button>
    </div>

    <div class="max-w-2xl">
        <x-ui.card padding="none">
            <div class="p-10">
                <form method="POST" action="{{ route('rooms.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-3">
                        <label for="department_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Department <span class="text-danger">*</span></label>
                        <select id="department_id" name="department_id" required class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label for="name" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Room Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                            placeholder="e.g. Melati 1"
                            class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <label for="room_class" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Class <span class="text-danger">*</span></label>
                            <select id="room_class" name="room_class" required class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                                <option value="">-- Select Class --</option>
                                <option value="VIP" {{ old('room_class') == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Class I" {{ old('room_class') == 'Class I' ? 'selected' : '' }}>Class I</option>
                                <option value="Class II" {{ old('room_class') == 'Class II' ? 'selected' : '' }}>Class II</option>
                                <option value="Class III" {{ old('room_class') == 'Class III' ? 'selected' : '' }}>Class III</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label for="price_per_night" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Price per Night (Rp) <span class="text-danger">*</span></label>
                            <input type="number" id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" required min="0"
                                placeholder="e.g. 500000"
                                class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded text-accent focus:ring-accent/20">
                            <span class="text-sm font-bold text-text">Active</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <x-ui.button type="submit" variant="primary" size="lg" class="w-full shadow-xl shadow-accent/20">
                            Save Room
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </x-ui.card>
    </div>
@endsection
