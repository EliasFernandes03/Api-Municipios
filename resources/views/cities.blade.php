<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta de Municípios por UF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
    <h1 class="mb-4">Consulta de Municípios</h1>

    <form id="ufForm" class="w-100" style="max-width: 400px;">
        <div class="input-group mb-3">
            <input
                type="text"
                id="ufInput"
                name="uf"
                class="form-control text-uppercase"
                placeholder="Digite a sigla da UF (ex: SP)"
                maxlength="2"
                required
                pattern="[A-Za-z]{2}"
            />
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
        <div class="form-text text-danger" id="errorMsg" style="display:none;"></div>
    </form>

    <div id="results" class="w-100" style="max-width: 700px; margin-top: 20px;">
    </div>
</div>

<script src="{{ secure_asset('js/script.js') }}"></script>
</body>
</html>