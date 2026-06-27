<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osvioo — Back in a moment</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: #f8f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #1a1a2e;
        }
        .container {
            text-align: center;
            padding: 40px;
            max-width: 480px;
        }
        .icon { font-size: 4rem; margin-bottom: 24px; }
        h1 { font-size: 1.8rem; font-weight: 800; margin-bottom: 12px; color: #111; }
        p { color: #666; font-size: 1rem; line-height: 1.6; margin-bottom: 28px; }
        .btn {
            display: inline-block;
            background: #6D28D9;
            color: #fff;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .btn:hover { background: #5B21B6; }
        .auto-refresh { margin-top: 16px; font-size: 0.8rem; color: #aaa; }
    </style>
    <meta http-equiv="refresh" content="15;url=/login">
</head>
<body>
    <div class="container">
        <div class="icon">⚡</div>
        <h1>We'll be right back!</h1>
        <p>Osvioo is warming up. This usually takes just a few seconds. The page will refresh automatically.</p>
        <a href="/login" class="btn">Try Again Now</a>
        <p class="auto-refresh">Auto-refreshing in 15 seconds...</p>
    </div>
</body>
</html>
