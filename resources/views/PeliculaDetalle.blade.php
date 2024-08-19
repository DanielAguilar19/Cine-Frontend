<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $evento['titulo'] }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Cine App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/eventos">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Salas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Horarios</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">{{ $evento['titulo'] }}</h1>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $evento['imagen'] }}" class="img-fluid" alt="{{ $evento['titulo'] }}">
            </div>
            <div class="col-md-8">
                <h2>Detalles del Evento</h2>
                <p><strong>Fecha:</strong> {{ $evento['fecha'] }}</p>
                <p><strong>Hora de Inicio:</strong> {{ $evento['hora_inicio'] }}</p>
                <p><strong>Idioma:</strong> {{ $evento['idioma'] }}</p>
                <p><strong>Película:</strong> {{ $pelicula->titulo }}</p>
                <p><strong>Descripción de la Película:</strong> {{ $pelicula->descripcion }}</p>
                <h3>Salas Disponibles</h3>
                <ul>
                    @foreach($salas as $sala)
                        <li>{{ $sala->nombre }} - Capacidad: {{ $sala->capacidad }}</li>
                    @endforeach
                </ul>
                <h3>Horarios</h3>
                <ul>
                    @foreach($horarios as $horario)
                        <li>{{ $horario->hora }} - Sala: {{ $horario->sala->nombre }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/eventos" class="btn btn-secondary">Regresar</a>
            <a href="{{ route('facturacion', ['evento_id' => $evento['id']]) }}" class="btn btn-primary">
                Ir a Facturación
            </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
