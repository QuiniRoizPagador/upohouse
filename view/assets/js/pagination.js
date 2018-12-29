(function ($) {
    $.fn.paginate = function () {
        this.each(function () {
            $(this).click(function () {
                var url = "http://localhost" + base + "controller=WebService&action=paginateUsers";
                $.get(url,
                        {
                            userPag: $(this).val()
                        },
                        function (data, status) {
                            console.log(data);
                        }
                );
            });
        });
    };
})(jQuery);

$(document).ready(function () {
    $(".pagUser").paginate();
});




