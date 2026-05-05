@extends('layouts.app')

@section('title', 'Create User - Hypercare')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('users.index') }}" class="p-2 text-text-muted hover:text-text hover:bg-surface-soft rounded-xl transition-all">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-text">New User</h1>
        <p class="text-sm text-text-muted mt-1">Create a new user account.</p>
    </div>
</div>

<div class="max-w-3xl">
    <form action="{{ route('users.store') }}" method="POST" class="bg-surface border border-border/60 rounded-2xl shadow-sm p-6 space-y-6">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-semibold text-text mb-1.5">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2.5 bg-bg border @error('name') border-danger @else border-border/60 @enderror rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all">
                @error('name') <p class="mt-1.5 text-xs text-danger">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-text mb-1.5">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 bg-bg border @error('email') border-danger @else border-border/60 @enderror rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all">
                @error('email') <p class="mt-1.5 text-xs text-danger">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="role" class="block text-sm font-semibold text-text mb-1.5">Role</label>
                <div class="relative">
                    <select id="role" name="role" required class="w-full px-4 py-2.5 bg-bg border @error('role') border-danger @else border-border/60 @enderror rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all appearance-none">
                        <option value="">Select Role</option>
                        <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                        <option value="doctor" @selected(old('role') == 'doctor')>Doctor</option>
                        <option value="nurse" @selected(old('role') == 'nurse')>Nurse</option>
                        <option value="staff" @selected(old('role') == 'staff')>Staff</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-text-muted">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
                @error('role') <p class="mt-1.5 text-xs text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-semibold text-text mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2.5 bg-bg border @error('password') border-danger @else border-border/60 @enderror rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all">
                    @error('password') <p class="mt-1.5 text-xs text-danger">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-text mb-1.5">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-4 py-2.5 bg-bg border border-border/60 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-border/60 flex justify-end gap-3">
            <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-semibold text-text hover:bg-surface-soft rounded-xl transition-all">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-accent text-white text-sm font-semibold rounded-xl shadow-lg shadow-accent/20 hover:bg-accent/90 transition-all">
                Save User
            </button>
        </div>
    </form>
</div>
@endsection
