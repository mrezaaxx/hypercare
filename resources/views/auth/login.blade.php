<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - hypercare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center min-h-screen p-6 bg-bg text-text antialiased" style="background: radial-gradient(circle at top center, rgba(255, 255, 255, 0.06), transparent 24%), radial-gradient(circle at 0% 0%, rgba(96, 165, 250, 0.08), transparent 20%), linear-gradient(180deg, #060608 0%, #09090b 100%);">
    <div class="w-full max-w-[440px]">
        <div class="p-10 rounded-[32px] border border-border bg-linear-to-b from-white/8 to-white/2 backdrop-blur-2xl shadow-2xl">
            <div class="text-center mb-10">
                <div class="inline-flex mb-6">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect width="48" height="48" rx="14" fill="#FAFAFA"/>
                        <path d="M24 12v24M12 24h24" stroke="#09090B" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
                <p class="text-text-faint text-[0.72rem] font-bold tracking-[0.16em] uppercase mb-2">hypercare</p>
                <h1 class="text-3xl font-bold tracking-tight mb-4">hypercare</h1>
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
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@hypercare.test" class="min-h-[52px] px-5 rounded-2xl bg-white/5 border border-white/10 text-text placeholder:text-text-faint focus:outline-none focus:border-white/20 focus:bg-white/8 transition-all" required autofocus>
                </div>

                <div class="grid gap-2">
                    <label for="password" class="text-[0.74rem] font-bold text-text-muted uppercase tracking-widest px-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" class="min-h-[52px] px-5 rounded-2xl bg-white/5 border border-white/10 text-text placeholder:text-text-faint focus:outline-none focus:border-white/20 focus:bg-white/8 transition-all" required>
                </div>

                <div class="flex items-center px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-lg bg-white/5 border border-white/10 accent-white">
                        <span class="text-[0.88rem] text-text-muted group-hover:text-text transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="min-h-[52px] w-full bg-text text-bg font-bold rounded-full hover:scale-[1.02] active:scale-[0.98] transition-all" id="login-btn">
                    Masuk ke Workspace
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-white/5 text-center">
                <p class="text-text-faint text-[0.74rem] font-medium tracking-wide italic">&copy; {{ date('Y') }} hypercare HCI • SIMRS v1.0</p>
            </div>
        </div>
    </div>
</body>
</html>
