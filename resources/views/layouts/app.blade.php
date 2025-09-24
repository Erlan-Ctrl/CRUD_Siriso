<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Admin')</title>

{{--Utilizando os aprendizados do @extends--}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #000000, #434343, #808080);
            min-height: 100vh;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        main.container {
            width: 100%;
            background: rgba(255,255,255,0.92);
            color: #212529;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.35);
        }

        .card {
            background: #ffffff;
            color: #212529;
            border: 0;
        }

        .card-header {
            background: #f8f9fa;
            color: #212529;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .table thead th { color: #212529; }
        .table tbody td { color: #212529; }
        .table-striped > tbody > tr:nth-of-type(odd) { background-color: rgba(0,0,0,0.02); }

        .navbar { background: transparent; }
        .navbar .navbar-brand { color: #fff; }
        .navbar .nav-link { color: rgba(255,255,255,0.85); }

        .btn-primary { background: #0d6efd; border-color: #0d6efd; }

        @media (max-width: 767px) {
            main.container { padding: 1rem; }
        }
    </style>


    @stack('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-transparent mb-4">
    <div class="container">
        <a class="navbar-brand text-white" href="{{ url('/EscolherCFU') }}">Siriso</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

