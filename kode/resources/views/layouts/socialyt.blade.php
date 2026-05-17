<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Osivoo')</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --slate-900: #0f172a;
            --slate-600: #475569;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        h1, h2, .font-syne {
            font-family: 'Syne', sans-serif;
        }
        .bg-indigo-600 { background-color: var(--primary); }
        .text-indigo-600 { color: var(--primary); }
        .hover\:bg-indigo-700:hover { background-color: var(--primary-hover); }
    </style>
</head>
<body class="bg-slate-50">
    @yield('content')
</body>
</html>
