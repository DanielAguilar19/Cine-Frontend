<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Método de Pago</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('peliculas') }}">
                @csrf
                <div class="form-group">
                    <label for="numeroTarjeta">Número de Tarjeta</label>
                    <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Confirmar Pago</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
