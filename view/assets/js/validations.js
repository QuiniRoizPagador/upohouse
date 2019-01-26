(function ($) {
    $.fn.validate = function (options) {
        var settings = $.extend({
            empty: false
        }, options);
        this.each(function () {
            var form = this;
            $(this).submit(function () {
                var error = false, errorPassw = 0;
                $(':input:not(:submit)', this).each(function () {
                    var regex;
                    var val = $.trim($(this).val());
                    switch ($(this)[0].type) {
                        case "tel":
                            regex = /^\d{9}$/;
                            break;
                        case "email":
                            regex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
                            break;
                        case "text":
                            regex = /[a-zA-Z0-9_]{1,255}$/;
                            break;
                        case "textarea":
                            regex = /^[A-Za-z0-9_\s\n.áéíóúÁÉÍÓÚ]{1,3000}$/;
                            break;
                        case "select-one":
                            regex = /[0-9]/;
                            break;
                        default:
                            regex = /[a-zA-Z0-9_]{1,255}$/;
                    }
                    if ($(this)[0].getAttribute("class").indexOf("can-be-empty") < 0 && 
                            !settings.empty && val.length === 0 || (val.length !== 0 && !val.match(regex))) {
                        if ($(this)[0].type === "password") {
                            errorPassw++;
                        }
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                        if (!settings.empty && $.trim(val) === "") {
                            $(this).next().text(LANG['requerido']);
                        } else {
                            $(this).next().text(LANG['formato_incorrecto']);
                        }
                        error = true;
                    } else {
                        $(this).removeClass("is-invalid");
                        $(this).addClass("is-valid");
                    }
                });

                var match = $(".password", form).val() === $(".password2", form).val();
                var vacias = true;
                if (!settings.empty) {
                    vacias = $(".password", form).val() !== "" && $(".password2", form).val() !== "";
                }
                if (vacias && match) {
                    $(":password", form).removeClass("is-invalid");
                    $(":password", form).addClass("is-valid");
                } else {
                    $(":password", form).removeClass("is-valid");
                    $(":password", form).addClass("is-invalid");
                    if (!match) {
                        $(":password", form).next().text(LANG['no_match']);
                    }
                    error = true;
                }
                return !error;
            });

            $(":password", form).each(function () {
                $(this).keyup(function () {
                    var vacioOk = true;
                    if (!settings.empty) {
                        vacioOk = $.trim($(this).val()) !== "" && $.trim($(this).val() !== "");
                    }
                    if (!vacioOk) {
                        $(this).next().text(LANG['requerido']);
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                    } else if ($(".password", form).val() !== $(".password2", form).val()) {
                        $(":password", form).next().text(LANG['no_match']);
                        $(":password", form).removeClass("is-valid");
                        $(":password", form).addClass("is-invalid");
                    } else if ($(".password", form).val() === $(".password2", form).val()) {
                        $(":password", form).removeClass("is-invalid");
                        $(":password", form).addClass("is-valid");
                    } else {
                        $(this).removeClass("is-invalid");
                        $(this).addClass("is-valid");
                    }
                });
            });
        });
    };
})(jQuery);



$(document).ready(function () {
    $(".formUser").validate();
    $(".formUpdateUser").validate({empty: true});
});


