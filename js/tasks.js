document.addEventListener('DOMContentLoaded', function () {
    var carta1 = document.getElementById('idCard1');
    var modal1 = new bootstrap.Modal(document.getElementById('exampleModal1'));

    carta1.addEventListener('click', function () {
        modal1.show();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var carta2 = document.getElementById('idCard2');
    var modal2 = new bootstrap.Modal(document.getElementById('exampleModal1'));

    carta2.addEventListener('click', function () {
        modal2.show();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var carta3 = document.getElementById('idCard3');
    var modal3 = new bootstrap.Modal(document.getElementById('exampleModal1'));

    carta3.addEventListener('click', function () {
        modal3.show();
    });
});