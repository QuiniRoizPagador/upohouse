(function ($) {
    $.fn.globalSearch = function () {
        this.each(function () {
            $(this).keypress(function (event) {
                if (event.which == 13) {
                    window.location = "index/Ad/paginate&query=" + $.trim($(".searcher").val());
                }
            });
            $(this).blur(function () {
                $(this).val("");
                $("#searchList").hide("slow");
            });
            $(this).click(function () {
                $(this).val("");
                var lista = $("#searchList");
                lista.animate({
                    height: "hide"
                }, "fast", function () {
                    lista.empty();
                });
            });
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
                                                + LANG['descripcion'] + ": " + k.description + " - " + LANG['comunidad'] + ": " + k.community +
                                                " - " + LANG['provincia'] + ": " + k.province + " - " + LANG['localidad'] + ": " + k.municipality +
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