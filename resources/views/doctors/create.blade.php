@extends('layouts.app')

@section('title', 'Add Doctor - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Master Data</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Add Doctor</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Register a new doctor</p>
        </div>
        <x-ui.button href="{{ route('doctors.index') }}" variant="secondary" size="md">
            Back to Doctors
        </x-ui.button>
    </div>

    <div class="max-w-2xl">
        <x-ui.card padding="none">
            <div class="p-10">
                <form method="POST" action="{{ route('doctors.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-3">
                        <label for="user_id" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">User Account <span class="text-danger">*</span></label>
                        <select id="user_id" name="user_id" required class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            <option value="">-- Select User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label for="name" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Doctor Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                            placeholder="e.g. Dr. John Doe"
                            class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <label for="specialization" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Specialization</label>
                            <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" 
                                placeholder="e.g. Cardiology"
                                class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                        </div>

                        <div class="space-y-3">
                            <label for="phone" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                placeholder="e.g. 0812345678"
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
                            Save Doctor
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </x-ui.card>
    </div>
@endsection
