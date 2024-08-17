<div class="container">

    <div class="seat-selection">
        <h2>Selecciona tus Asientos</h2>
        <div class="screen">PANTALLA</div>
        <div class="seats" style="display: flex; justify-content: center;">
            @foreach($disponibleAsientos as $asientoDisponible)
                <button onclick="cambiarColorAsiento(event)" class="seat available">{{ $asientoDisponible['numeroAsiento'] }}</button>
            @endforeach

            @foreach($ocupadoAsientos as $asientoOcupado)
                <button class="seat unavailable" disabled>{{ $asientoOcupado['numeroAsiento'] }}</button>
            @endforeach
        </div>
    </div>
</div>


<style>
    .container {
        display: flex;
        justify-content: center
    }

    h2 {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .screen {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .seats {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        gap: 10px;
        max-width: 500px;
        margin: 0 auto;
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
        background-color: green;
    }

    .seat.unavailable {
        background-color: red;
        cursor: not-allowed;
    }
</style>
