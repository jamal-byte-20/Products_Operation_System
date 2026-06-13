
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<style>
		body { font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; color:#111827; }
		.container{max-width:420px;margin:48px auto;padding:24px;background:white;border:1px solid #e5e7eb;border-radius:8px}
		.field{margin-bottom:12px}
		label{display:block;margin-bottom:6px;font-weight:600}
		input[type="email"],input[type="password"]{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
		.btn{display:inline-block;padding:10px 14px;background:#2563eb;color:white;border-radius:6px;border:none;cursor:pointer}
		.error{color:#dc2626;font-size:13px;margin-top:6px}
		.links{margin-top:12px;font-size:14px}
	</style>
</head>
<body>
	<main class="container" role="main">
		<h1 style="margin:0 0 18px 0;font-size:20px">Sign in</h1>

		<form method="POST" action="{{ route('login') }}" novalidate>
			@csrf

			<div class="field">
				<label for="email">Email</label>
				<input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
				@error('email')
					<div class="error">{{ $message }}</div>
				@enderror
			</div>

			<div class="field">
				<label for="password">Password</label>
				<input id="password" type="password" name="password" required autocomplete="current-password" />
				@error('password')
					<div class="error">{{ $message }}</div>
				@enderror
			</div>

			<div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px">
				<label style="display:flex;align-items:center;font-weight:500">
					<input type="checkbox" name="remember" style="margin-right:8px" {{ old('remember') ? 'checked' : '' }} /> Remember me
				</label>
				<button type="submit" class="btn">Log in</button>
			</div>

			@if ($errors->any())
				<div class="error" style="margin-top:12px">Please correct the errors above.</div>
			@endif

			<div class="links">
				@if (Route::has('password.request'))
					<a href="{{ route('password.request') }}">Forgot your password?</a>
				@endif
			</div>
		</form>
	</main>
</body>
</html>
