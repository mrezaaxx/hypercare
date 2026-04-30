<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'hypercare')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen bg-bg text-text font-sans">
    <aside class="fixed inset-y-0 left-0 w-[260px] flex flex-col bg-surface border-r border-border z-[100] transition-transform duration-300 -translate-x-full lg:translate-x-0" id="sidebar">
        <div class="flex items-center gap-3 px-6 py-8">
            <div class="w-10 h-10 rounded-xl bg-accent flex items-center justify-center text-white shadow-lg shadow-accent/20">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div>
                <span class="block text-lg font-bold tracking-tight">Hypercare</span>
                <small class="block text-text-faint text-[0.7rem] font-bold uppercase tracking-widest">SaaS Dashboard</small>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <p class="px-3 mb-2 text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em]">General</p>
            <a href="{{ route('home') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[0.9rem] font-semibold transition-all {{ request()->routeIs('home') || request()->routeIs('simrs.dashboard') ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'text-text-muted hover:bg-surface-soft hover:text-text' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ request()->routeIs('home') || request()->routeIs('simrs.dashboard') ? 'text-white' : 'text-text-faint group-hover:text-text' }}"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('patients.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[0.9rem] font-semibold transition-all {{ request()->routeIs('patients.*') ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'text-text-muted hover:bg-surface-soft hover:text-text' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ request()->routeIs('patients.*') ? 'text-white' : 'text-text-faint group-hover:text-text' }}"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span>Patients</span>
            </a>
            
            <p class="px-3 mt-6 mb-2 text-[0.65rem] font-bold text-text-faint uppercase tracking-[0.2em]">Management</p>
            <a href="{{ route('lab-orders.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[0.9rem] font-semibold transition-all {{ request()->routeIs('lab-orders.*') ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'text-text-muted hover:bg-surface-soft hover:text-text' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ request()->routeIs('lab-orders.*') ? 'text-white' : 'text-text-faint group-hover:text-text' }}"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span>Laboratory</span>
            </a>
            <a href="{{ route('radiology-orders.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-[0.9rem] font-semibold transition-all {{ request()->routeIs('radiology-orders.*') ? 'bg-accent text-white shadow-lg shadow-accent/20' : 'text-text-muted hover:bg-surface-soft hover:text-text' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ request()->routeIs('radiology-orders.*') ? 'text-white' : 'text-text-faint group-hover:text-text' }}"><rect x="2" y="2" width="20" height="20" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Radiology</span>
            </a>
        </nav>

        <div class="p-4 mt-auto">
            <div class="p-5 rounded-2xl bg-bg/50 border border-border/50 backdrop-blur-sm">
                <p class="text-xs font-bold text-text mb-1">Hypercare Pro</p>
                <p class="text-[0.7rem] text-text-faint leading-relaxed mb-3">Upgrade for advanced clinical analytics.</p>
                <a href="#" class="inline-block w-full py-2 bg-text text-white text-center text-xs font-bold rounded-lg shadow-lg shadow-text/10 hover:bg-text/90 transition-all">Upgrade Now</a>
            </div>
        </div>
    </aside>

    <div class="flex-1 min-h-screen lg:ml-[260px]">
        <header class="sticky top-0 z-40 flex items-center px-4 lg:px-8 py-4 bg-bg/80 backdrop-blur-xl border-b border-border/50">
            <button class="lg:hidden p-2 -ml-2 mr-2 text-text-muted hover:bg-surface-soft rounded-lg transition-colors" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="flex items-center gap-2 text-[0.8rem] font-bold">
                <span class="text-text-faint tracking-wide uppercase">Dashboard</span>
                <span class="text-border-strong">/</span>
                <span class="text-text tracking-wide uppercase">Overview</span>
            </div>
            
            <div class="flex items-center gap-4 ml-auto">
                <div class="relative hidden md:block">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-text-faint">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" placeholder="Search records..." class="w-64 pl-10 pr-4 py-2.5 bg-surface border border-border/60 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all placeholder:text-text-faint">
                </div>
                
                <button class="p-2.5 text-text-faint hover:text-text hover:bg-surface-soft rounded-xl transition-all relative">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-accent rounded-full border-2 border-bg"></span>
                </button>

                <div class="flex items-center gap-3 pl-4 border-l border-border">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-text leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[0.6rem] text-accent uppercase font-bold tracking-widest">Admin</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-accent/10 border border-accent/20 flex items-center justify-center text-accent font-bold shadow-sm shadow-accent/5">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-1">
                        @csrf
                        <button type="submit" class="p-2.5 text-text-faint hover:text-danger hover:bg-danger/5 rounded-xl transition-all">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="p-7">
            <div class="max-w-[1360px] mx-auto">
                @if (session('success'))
                    <div class="mb-5 p-3.5 border border-success/20 rounded-xl bg-success/12 text-[#bbf7d0] animate-fade-in" id="flash-success">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
