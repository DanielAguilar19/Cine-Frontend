<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tus Asientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <style>
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
            <button onclick="cambiarColorAsiento(event)" class="seat available col-3 m-2 btn btn-success">
                {{ $asiento['numeroAsiento'] }}
            </button>
            @endforeach
        </div>

        <div class="next-section mt-5">
            <button class="boton btn btn-danger" type="button">Siguiente</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script><script>
    function cambiarColorAsiento(event) {
        const seat = event.target;

        if (seat.classList.contains('available')) {
            seat.classList.remove('available', 'btn-success');
            seat.classList.add('selected', 'btn-secondary');
        } else if (seat.classList.contains('selected')) {
            seat.classList.remove('selected', 'btn-secondary');
            seat.classList.add('available', 'btn-success');
        }
    }
</script>

</body>
</html>
