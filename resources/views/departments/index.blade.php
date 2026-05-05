@extends('layouts.app')

@section('title', 'Departments Master Data - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Master Data</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">Departments</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Manage hospital departments and polyclinics</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('departments.create') }}" variant="primary" size="lg" class="shadow-xl shadow-accent/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Add Department
            </x-ui.button>
        </div>
    </div>

    <x-ui.card class="mb-8" padding="none">
        <div class="overflow-x-auto p-8 pt-4">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Name</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em]">Description</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-6 pb-4 text-[0.6rem] font-bold text-text-faint uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr class="group hover:bg-bg/40 transition-all duration-300">
                            <td class="px-6 py-5 bg-white group-hover:bg-bg/10 rounded-l-2xl border-y border-l border-border/40 group-hover:border-accent/20 transition-all">
                                <p class="text-sm font-bold text-text leading-tight mb-1 group-hover:text-accent transition-colors">{{ $department->name }}</p>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 transition-all">
                                <span class="text-xs font-medium text-text-muted">{{ $department->description ?? '---' }}</span>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 text-center transition-all">
                                <x-ui.badge variant="{{ $department->is_active ? 'success' : 'danger' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-5 bg-white border-y border-r border-border/40 group-hover:bg-bg/10 group-hover:border-accent/20 rounded-r-2xl text-right transition-all">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    <x-ui.button href="{{ route('departments.edit', $department) }}" variant="secondary" size="xs" class="w-9 h-9 !p-0 flex items-center justify-center">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('departments.destroy', $department) }}" class="inline-block" onsubmit="return confirm('Delete this department?')">
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
                            <td colspan="4" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center max-w-sm mx-auto">
                                    <h3 class="text-xl font-black text-text mb-2">No Departments Found</h3>
                                    <p class="text-sm text-text-faint font-medium mb-10 leading-relaxed text-balance">Get started by creating a new department.</p>
                                    <x-ui.button href="{{ route('departments.create') }}" variant="primary" size="md" class="px-8 shadow-lg shadow-accent/20">
                                        Add Department
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($departments->hasPages())
            <div class="px-8 py-8 border-t border-border/40 bg-bg/10 rounded-b-[2.5rem]">
                {{ $departments->links('pagination.simple') }}
            </div>
        @endif
    </x-ui.card>
@endsection
