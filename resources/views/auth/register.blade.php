<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <style>
        body { font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; color:#111827; }
        .container{max-width:460px;margin:48px auto;padding:24px;background:white;border:1px solid #e5e7eb;border-radius:8px}
        .field{margin-bottom:14px}
        label{display:block;margin-bottom:6px;font-weight:600}
        input[type="text"],input[type="email"],input[type="password"]{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
        .btn{display:inline-block;padding:10px 14px;background:#2563eb;color:white;border-radius:6px;border:none;cursor:pointer}
        .error{color:#dc2626;font-size:13px;margin-top:6px}
        .note{font-size:14px;color:#4b5563}
    </style>
</head>
<body>
    <main class="container" role="main">
        <h1 style="margin:0 0 18px 0;font-size:20px">Create an account</h1>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <button type="submit" class="btn">Register</button>

            @if ($errors->any())
                <div class="error" style="margin-top:16px">Please fix the highlighted fields and try again.</div>
            @endif

            <p class="note" style="margin-top:16px">Already have an account? <a href="{{ route('login') }}">Log in</a>.</p>
        </form>
    </main>
</body>
</html>
