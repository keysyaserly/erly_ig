<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            background-color: #fff;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin: auto;
        }

        .card-header {
            background: #007bff;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
