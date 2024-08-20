<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $evento['pelicula']['titulo'] ?? 'Título no disponible' }}</title>
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
            </ul>
        </div>
        <a href="/">Logout</a>
    </nav>
    <div class="container">
        <h1 class="text-center">{{ $evento['pelicula']['titulo'] ?? 'Título no disponible' }}</h1>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('movies/' . $evento['pelicula']['imagen']) ?? 'default.jpg' }}" class="img-fluid" alt="{{ $evento['pelicula']['titulo'] ?? 'Imagen no disponible' }}">
            </div>
            <div class="col-md-8">
                <h2>Detalles del Evento</h2>
                <p><strong>Fecha:</strong> {{ $evento['fechaEvento'] ?? 'Fecha no disponible' }}</p>
                <p><strong>Hora de Inicio:</strong> {{ $evento['horaInicio'] ?? 'Hora no disponible' }}</p>
                <p><strong>Idioma:</strong> {{ $evento['idioma'] ?? 'Idioma no disponible' }}</p>
                <p><strong>Película:</strong> {{ $pelicula['titulo'] ?? 'Título no disponible' }}</p>
                <p><strong>Descripción de la Película:</strong> {{ $pelicula['descripcion'] ?? 'Descripción no disponible' }}</p>
                <h3>Salas Disponibles</h3>
                <ul>
                    <li>{{ $sala['tipoSala']['descripcion'] ?? 'Descripción no disponible' }} - Precio: {{ $sala['tipoSala']['precio'] ?? 'Precio no disponible' }}</li>
                </ul>
                <h3>Horarios</h3>
                <ul>
                    @foreach($horarios as $horario)
                        <li>{{ $horario['horaInicio'] ?? 'Hora no disponible' }} - Sala: {{ $sala['tipoSala']['descripcion'] ?? 'Sala no disponible' }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <form method="GET" action="{{ route('asientos', ['codigoSala' => $sala['codigoSala'] ?? 0]) }}">
            <div class="form-group">
                <label for="cantidadBoletos">Cantidad de Boletos:</label>
                <input type="number" class="form-control" id="cantidadBoletos" name="cantidadBoletos" min="1" max="10" required>
            </div>
        
            <div class="form-group">
                <label for="total">Total a Pagar:</label>
                <input type="text" id="total" class="form-control" readonly>
            </div>
        
            <input type="hidden" name="codigoEvento" value="{{ $evento['codigoEvento'] ?? 0 }}">
            <button type="submit" class="btn btn-primary mt-3">Seleccionar Asientos</button>
        </form>
        <div class="text-center mt-4">
            <a href="/peliculas" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const precioPorBoleto = {{ $sala['tipoSala']['precio'] ?? 0 }};
            const cantidadBoletosInput = document.getElementById('cantidadBoletos');
            const totalInput = document.getElementById('total');
            const totalHiddenInput = document.getElementById('totalHidden');
            function actualizarTotal() {
                const cantidad = parseInt(cantidadBoletosInput.value) || 0;
                const total = cantidad * precioPorBoleto;
                totalInput.value = `$${total.toFixed(2)}`;
                totalHiddenInput.value = total.toFixed(2); 
            }
    
            cantidadBoletosInput.addEventListener('input', actualizarTotal);
    
            actualizarTotal();
        });
    </script>
    
</body>
</html>
