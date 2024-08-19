<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peliculas</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Películas <span class="sr-only">(current)</span></a>
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
        <h1 class="text-center">Películas en cartelera</h1>
        <div class="row">
            @foreach($peliculas as $pelicula)
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img class="card-img-top" src="{{ asset('movies/' . $pelicula->imagen) }}" alt="{{ $pelicula->titulo }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pelicula->titulo }}</h5>
                            <p class="card-text">Duración: {{ $pelicula->duracion }} minutos</p>
                            <p class="card-text">Disponible: {{ $pelicula->disponible ? 'Sí' : 'No' }}</p>
                            <p class="card-text">{{ $pelicula->descripcion }}</p>
                            <a href="{{ route('evento.show', ['titulo' => $pelicula->titulo]) }}" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>