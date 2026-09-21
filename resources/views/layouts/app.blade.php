<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Manager</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; line-height: 1.5; }
        .card { border: 1px solid #ccc; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; background: #eee; border-radius: 4px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <header>
        <h1>Activity Manager v1</h1>
        <hr>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>