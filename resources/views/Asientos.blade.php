@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Selecciona tus Asientos</h2>
    <div class="screen">PANTALLA</div>
    <div class="seats">
        @foreach($availableSeats as $seat)
            <div class="seat available">{{ $seat['codigoAsientoEvento'] }}</div>
        @endforeach

        @foreach($occupiedSeats as $seat)
            <div class="seat unavailable">{{ $seat['codigoAsientoEvento'] }}</div>
        @endforeach
    </div>
</div>

<style>
.screen { 
text-align: center;
 margin: 10px 0;
 font-weight: bold;
 }
 
.seats { 
display: grid;
 grid-template-columns: repeat(10, 1fr);
 gap: 5px;
 max-width: 500px;
 margin: 20px auto;
 }
 
.seat { 
width: 50px;
 height: 50px;
 background-color: #ddd;
 text-align: center;
 line-height: 50px;
 border-radius: 5px;
 cursor: pointer;
 }
 
.seat.available { 
background-color: green;
 }
 
.seat.unavailable { 
background-color: red;
 cursor: not-allowed;
 }
 
</style>
@endsection
