<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tus Asientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .screen {
            font-weight: bold;
            margin-bottom: 20px;
            background-color: #6fe4e4;
            border-radius: 4px;
            padding: 10px;
        }

        .seat {
            background-color: #ddd;
            width: 50px;
            height: 50px;
            text-align: center;
            line-height: 50px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .seat.available {
            background-color: rgb(0, 195, 0);
        }

        .seat.unavailable {
            background-color: red;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: rgb(62, 62, 62);
            color: #fff;
        }

        .boton {
            background-color: rgb(107, 43, 43);
            cursor: pointer;
            height: 2.75rem;
            width: 7rem;
            color: white;
            border-radius: 10px;
        }

        .next-section {
            margin-top: 5rem;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container mt-5 justify-content-center">
    <div class="seat-selection text-center">
        <h2 class="mb-4">Selecciona tus Asientos</h2>
        <div class="screen bg-info p-2 rounded mb-4">PANTALLA</div>
        <div class="seats row justify-content-center">
            @foreach($asientos as $asiento)
            <button onclick="cambiarColorAsiento(event, '{{ $asiento['codigoAsiento'] }}')" class="seat available col-3 m-2 btn btn-success" data-codigo="{{ $asiento['codigoAsiento'] }}">
                {{ $asiento['numeroAsiento'] }}
            </button>
            @endforeach
        </div>
        <form id="asientosForm" action="{{ route('pago.index') }}" method="GET">
            @csrf
            <input type="hidden" id="codigoAsientos" name="codigoAsientos" value="">
            <input type="hidden" name="codigoEvento" value="{{ $codigoEvento }}">
            <input type="hidden" name="cantidadBoletos" value="{{ $cantidadBoletos }}">
            <div class="next-section mt-5">
                <button id="submitAsientos" class="boton btn btn-danger" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
</div>
<script>
    let selectedAsientos = [];
    const maxAsientos = {{ $cantidadBoletos }};
    const submitButton = document.getElementById('submitAsientos');

    document.addEventListener('DOMContentLoaded', function() {
        submitButton.disabled = true;
        const seatButtons = document.querySelectorAll('.seat');

        seatButtons.forEach(button => {
            const codigoAsiento = button.dataset.codigo;

            fetch(`http://localhost:8080/api/asientoevento/obtener/disponibilidad/${codigoAsiento}`)
                .then(response => response.json())
                .then(data => {
                    if (data === true) {
                        button.classList.add('available', 'btn-success');
                    } else {
                        button.classList.add('unavailable', 'btn-danger');
                        button.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error al verificar la disponibilidad:', error);
                    button.classList.add('unavailable', 'btn-danger');
                    button.disabled = true;
                });
        });
    });

    function cambiarColorAsiento(event, codigoAsiento) {
        const seat = event.target;

        if (seat.classList.contains('available') && selectedAsientos.length < maxAsientos) {
            seat.classList.remove('available', 'btn-success');
            seat.classList.add('selected', 'btn-secondary');
            selectedAsientos.push(codigoAsiento);
        } else if (seat.classList.contains('selected')) {
            seat.classList.remove('selected', 'btn-secondary');
            seat.classList.add('available', 'btn-success');
            selectedAsientos = selectedAsientos.filter(asiento => asiento !== codigoAsiento);
        }

        document.getElementById('codigoAsientos').value = selectedAsientos.join(',');

        if (selectedAsientos.length === maxAsientos) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }
</script>
</body>
</html>
