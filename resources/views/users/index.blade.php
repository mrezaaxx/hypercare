@extends('layouts.app')

@section('title', 'User Management - Hypercare')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-text">User Management</h1>
        <p class="text-sm text-text-muted mt-1">Manage user accounts and roles.</p>
    </div>
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-accent text-white font-semibold rounded-xl shadow-lg shadow-accent/20 hover:bg-accent/90 transition-all flex items-center gap-2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New User
    </a>
</div>

<div class="bg-surface border border-border/60 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-surface-soft/50 border-b border-border/60 text-text-muted text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Role</th>
                    <th class="px-6 py-4 font-semibold">Registered</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border/60">
                @forelse ($users as $user)
                <tr class="hover:bg-surface-soft/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-text">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-text-muted">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-[0.7rem] font-bold tracking-wider uppercase
                            @if($user->role === 'admin') bg-accent/10 text-accent
                            @elseif($user->role === 'doctor') bg-blue-500/10 text-blue-500
                            @elseif($user->role === 'nurse') bg-emerald-500/10 text-emerald-500
                            @else bg-gray-500/10 text-gray-500 @endif">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-text-muted hover:text-accent bg-surface border border-border rounded-lg shadow-sm hover:border-accent/30 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-text-muted hover:text-danger bg-surface border border-border rounded-lg shadow-sm hover:border-danger/30 transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-text-faint">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-3 opacity-20"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        <p>No users found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-border/60">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
