<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .forgot-box {
            background: #fff;
            padding: 35px 30px;
            border-radius: 12px;
            width: 360px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .forgot-box h2 {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }

        label {
            font-weight: 600;
            color: #4a5568;
            font-size: 14px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(66,153,225,0.4);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2b6cb0;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
        }

        button:hover {
            background: #1e4e7a;
        }

        .back-link {
            text-align: center;
            display: block;
            margin-top: 18px;
            color: #2d3748;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 600;
        }

        .success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 5px solid #38a169;
        }

        .error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 5px solid #e53e3e;
        }
    </style>
</head>

<body>

<div class="forgot-box">
    <h2>Forgot Password</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="message error">
            <ul style="margin: 0; padding-left: 17px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('forgot.password.post') }}">
        @csrf

        <label>No Handphone (WhatsApp)</label>
        <input type="text" name="noHP" placeholder="Contoh: 6281234567890" required>

        <button type="submit">Kirim Link Reset</button>
    </form>

    <a class="back-link" href="{{ route('login') }}">← Kembali ke Login</a>
</div>

</body>
</html>
