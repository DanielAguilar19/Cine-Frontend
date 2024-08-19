<div class="container">
    <div class="seat-selection">
        <h2>Selecciona tus Asientos</h2>
        <div class="screen">PANTALLA</div>
        <div class="seats" style="display: flex; justify-content: center;">
            @foreach($asientos as $asiento)
            <button class="seat available">
                {{ $asiento['numeroAsiento'] }}
            </button>
            @endforeach
        </div>

        <div class="next-section">
            <button class="boton" type="button">Siguiente</button>
        </div>
    </div>
</div>

<style>
    .container {
        display: flex;
        justify-content: center;
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
        background-color: rgb(111, 228, 228);
        border-radius: 4px;
    }

    .seats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        max-width: 400px;
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
        background-color: rgb(0, 195, 0);
    }

    .seat.unavailable {
        background-color: red;
        cursor: not-allowed;
    }

    .seat.selected {
        background-color: rgb(62, 62, 62);
        color: aliceblue;
    }

    .boton { 
        background-color: rgb(107, 43, 43);
        cursor: pointer;
        border-width: 0;
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

<script>
function cambiarColorAsiento(event) {
    const seat = event.target;

    if (seat.classList.contains('available')) {
        seat.classList.remove('available');
        seat.classList.add('selected');
    } else if (seat.classList.contains('selected')) {
        seat.classList.remove('selected');
        seat.classList.add('available');
    }
}
</script>
