<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hypercare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen p-6 bg-bg text-text font-sans antialiased">
    <div class="w-full max-w-[440px]">
        <div class="p-10 rounded-[32px] bg-surface glass shadow-premium">
            <div class="text-center mb-10">
                <div class="inline-flex mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-accent flex items-center justify-center text-white shadow-lg shadow-accent/20">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                </div>
                <p class="text-text-faint text-[0.72rem] font-bold tracking-[0.16em] uppercase mb-2">Hypercare</p>
                <h1 class="text-3xl font-bold tracking-tight mb-4 text-text">Hypercare</h1>
                <p class="text-text-muted text-[0.9rem] leading-relaxed">Clinical workspace untuk operasional rumah sakit, registrasi, laboratorium, radiologi, dan monitoring integrasi.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-danger/10 border border-danger/20 text-danger text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="grid gap-6">
                @csrf
                <div class="grid gap-2">
                    <label for="email" class="text-[0.74rem] font-bold text-text-muted uppercase tracking-widest px-1">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@hypercare.test" class="min-h-[52px] px-5 rounded-2xl bg-surface border border-border text-text placeholder:text-text-faint focus:outline-none focus:border-accent/40 focus:ring-4 focus:ring-accent/10 transition-all" required autofocus>
                </div>

                <div class="grid gap-2">
                    <label for="password" class="text-[0.74rem] font-bold text-text-muted uppercase tracking-widest px-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" class="min-h-[52px] px-5 rounded-2xl bg-surface border border-border text-text placeholder:text-text-faint focus:outline-none focus:border-accent/40 focus:ring-4 focus:ring-accent/10 transition-all" required>
                </div>

                <div class="flex items-center px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-md border-border text-accent focus:ring-accent/20">
                        <span class="text-[0.88rem] text-text-muted group-hover:text-text transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="min-h-[52px] w-full bg-accent text-white font-bold rounded-xl hover:bg-accent-hover shadow-lg shadow-accent/20 transition-all" id="login-btn">
                    Masuk ke Workspace
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-border text-center">
                <p class="text-text-faint text-[0.74rem] font-medium tracking-wide italic">&copy; {{ date('Y') }} hypercare HCI • SIMRS v1.0</p>
            </div>
        </div>
    </div>
</body>
</html>
