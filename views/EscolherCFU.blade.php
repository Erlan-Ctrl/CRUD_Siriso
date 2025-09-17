<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siriso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #000000, #434343, #808080);
        }

        #btn {
            display: flex;
            gap: 20px;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: bold;
            background: #ffffffcc;
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: #f1f1f1;
            transform: translateY(-3px);
            box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div id="btn">
    <a href="{{ route('cargo.index') }}" class="btn btn-custom">Cargos</a>
    <a href="{{ route('unidade.index') }}" class="btn btn-custom">Unidades</a>
    <a href="{{ route('funcionario.index') }}" class="btn btn-custom">Funcionários</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
