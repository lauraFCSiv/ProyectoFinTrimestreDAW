document.addEventListener('DOMContentLoaded', function () {
    // Obtenemos el modal de x carta
    var cards = document.querySelectorAll('.card');
    cards.forEach(function (card) {
        // Agregamos un evento click a cada carta
        card.addEventListener('click', function () {
            // Obtenemos el ID del modal 
            var modalId = card.getAttribute('data-bs-target');
            // Abrimos modal
            var modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });
});
