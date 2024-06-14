$(document).ready(function () {
    $('.card-body').on('click', function() {
        alert('TOTO');
    });

    $('#btnLink').on('click', function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        evt.stopImmediatePropagation();

        console.log(this);
    });
});