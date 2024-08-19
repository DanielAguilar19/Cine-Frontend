document.addEventListener('DOMContentLoaded', function () {
    const cantidadBoletosInput = document.getElementById('cantidadBoletos');
    const totalInput = document.getElementById('total');
    const precioBoleto = parseFloat("{{ $sala['tipoSala']['precio'] ?? 0 }}"); // Precio del boleto desde Blade
    
    if (cantidadBoletosInput) {
        cantidadBoletosInput.addEventListener('input', function () {
            const cantidadBoletos = parseInt(cantidadBoletosInput.value, 10) || 0;
            const total = cantidadBoletos * precioBoleto;
            totalInput.value = `$${total.toFixed(2)}`;
        });
    }
});