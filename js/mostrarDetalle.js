function mostrarDetalles() {
    var detalles = document.getElementById("detallesCelda");
    if (detalles.style.display === "block") {
        detalles.style.display = "none"; // Si ya están visibles, ocultarlos
    } else {
        detalles.style.display = "block"; // Si no están visibles, mostrarlos
    }
}