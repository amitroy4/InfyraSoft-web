<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Login</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #111827;
            --line: #1f2937;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --brand: #f7941d;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: radial-gradient(circle at top right, #1e293b 0%, var(--bg) 45%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 440px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, #111827, #0b1222);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.35);
        }
        h1 {
            margin: 0 0 8px;
            font-size: 28px;
            font-weight: 700;
        }
        p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.5;
        }
        label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-weight: 600;
        }
        input {
            width: 100%;
            border: 1px solid #334155;
            background: #0b1322;
            color: var(--text);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            outline: none;
        }
        input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.2);
        }
        .error {
            margin-bottom: 16px;
            border: 1px solid #7f1d1d;
            background: #450a0a;
            color: #fecaca;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
        }
        button {
            width: 100%;
            border: 0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            background: linear-gradient(135deg, #f7941d, #ffcf70);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Dashboard Login</h1>
        <p>Sign in to manage your landing page content and leads.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
