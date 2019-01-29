/**
 * Plugin que buscará en tiempo real mientras el usuario está escribiendo en el buscador
 * global
 */
(function ($) {
    $.fn.globalSearch = function () {
        this.each(function () {
            /**
             * Cuando pulsa intro se redirige al listado paginado
             */
            $(this).keypress(function (event) {
                if (event.which == 13) {
                    window.location = "index/Ad/paginate&query=" + $.trim($(".searcher").val());
                }
            });
            /**
             * Desaparición lenta
             */
            $(this).blur(function () {
                $(this).val("");
                $("#searchList").hide("slow");
            });
            /**
             * limpieza y aparición rápida
             */
            $(this).click(function () {
                $(this).val("");
                var lista = $("#searchList");
                lista.animate({
                    height: "hide"
                }, "fast", function () {
                    lista.empty();
                });
            });
            /**
             * Búsqueda global al escribir
             */
            $(this).keyup(function () {
                var lista = $("#searchList");
                if ($.trim($(".searcher").val()) != "") {
                    $.queue($.post("index/WS/globalSearch",
                            {
                                'str': $(".searcher").val()
                            },
                            function (data, status) {
                                if (data !== "" && data !== null) {
                                    lista.hide();
                                    lista.empty();
                                    $.map(data, function (k, v) {
                                        var li = "<a class='resultado dropdown-item' href='index/Ad/read&uuid=" + k.uuid + "'>"
                                                + "<img class='img img-thumbnail' src='" + (k.thumbnail ? k.thumbnail : 'view/images/home.png') + "' alt='" + k.uuid + "' style='width:50px;'/>"
                                                + " <b>" + LANG['descripcion'] + "</b>: " + k.name + " - " + "<b>" + LANG['m2'] + "</b>: " + k.m_2 +
                                                " - <b>" + LANG['habitaciones'] + "</b>: " + k.rooms + " - <b>" + LANG['precio'] + "</b>: " + k.price +
                                                "</a>";
                                        $($(".searcher").val().split(" ")).each(function () {
                                            $(li).html().replace($('#search').val(), "<span class='highlight'>" + $('#search').val() + "</span>");
                                        });
                                        lista.append(li);
                                    });
                                    if (lista.children().length > 0) {
                                        lista.show();
                                        $("a.resultado").click(function () {
                                            window.location = $(this).attr("href");
                                        });
                                    }
                                }
                            }
                    ));
                } else {
                    $(".searcher").val("");
                }
            });
        });
    };
})(jQuery);
$(document).ready(function () {
    $(".searcher").globalSearch();
});