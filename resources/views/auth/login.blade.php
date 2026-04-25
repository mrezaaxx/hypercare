<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - hypercare</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                        <rect width="48" height="48" rx="14" fill="#FAFAFA"/>
                        <path d="M24 12v24M12 24h24" stroke="#09090B" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
                <p class="login-kicker">hypercare</p>
                <h1>hypercare</h1>
                <p class="login-subtitle">Clinical workspace untuk operasional rumah sakit, registrasi, laboratorium, radiologi, dan monitoring integrasi.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@hypercare.test" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group form-check">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="login-btn">
                    Masuk
                </button>
            </form>

            <div class="login-footer">
                <p>&copy; {{ date('Y') }} hypercare HCI</p>
            </div>
        </div>
    </div>
</body>
</html>
