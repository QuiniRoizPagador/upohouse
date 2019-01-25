$(document).ready(function () {
    $(".zoom").wrap('<span style="display:inline-block"></span>')
            .css('display', 'block')
            .parent()
            .zoom({on: 'grab'});
});