<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .reset-box {
            background: #fff;
            width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .reset-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 22px;
            color: #333;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 6px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #2979ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .btn:hover {
            background: #155fd1;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #ffe0e0;
            color: #c62828;
        }

        .back-link {
            text-align: center;
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #555;
            font-size: 14px;
        }

        .back-link:hover {
            color: #000;
        }
    </style>
</head>

<body>

<div class="reset-box">
    <h2>Reset Password</h2>

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group">
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Masukkan password baru" required>
        </div>

        <div class="input-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn">Reset Password</button>
    </form>

    <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>
</div>

</body>
</html>
