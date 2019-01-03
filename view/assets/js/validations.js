(function ($) {
    $.fn.validate = function (options) {
        var settings = $.extend({
            empty: false
        }, options);
        this.each(function () {
            $(this).submit(function () {
                var error = false;
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
                            regex = /[a-zA-Z_]{1,255}$/;
                            break;
                        default:
                            regex = /[a-zA-Z0-9_]{1,255}/;
                    }

                    if (settings.empty && val !== "" && !val.match(regex)) {
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                        error = true;
                    } else if (!settings.empty && !val.match(regex)) {
                        $(this).removeClass("is-valid");
                        $(this).addClass("is-invalid");
                        error = true;
                    } else {
                        $(this).removeClass("is-invalid");
                        $(this).addClass("is-valid");
                    }
                });
                return !error;
            });
        });
    };
    $.fn.checkMatch = function () {
        this.each(function () {
            var form = this;
            $((".password", form), (".password2", form)).keyup(function () {
                if ($(".password", form).val() === $(".password2", form).val()) {
                    $(".password", form).removeClass("is-invalid");
                    $(".password", form).addClass("is-valid");
                    $(".password2", form).removeClass("is-invalid");
                    $(".password2", form).addClass("is-valid");
                } else {
                    $(".password", form).removeClass("is-valid");
                    $(".password", form).addClass("is-invalid");
                    $(".password2", form).removeClass("is-valid");
                    $(".password2", form).addClass("is-invalid");
                }
            });
        });
    };
    $.fn.matchPasswords = function (options) {
        var settings = $.extend({
            empty: false
        }, options);
        this.each(function () {
            $(this).submit(function () {
                var prev = null;
                var error = false;
                $(':input[type=password]', this).each(function () {
                    if (prev === null) {
                        prev = $(this);
                    } else {
                        if (settings.empty && ($.trim(prev.val()) !== "" || $.trim($(this).val()) !== "")
                                && $.trim(prev.val()) !== $.trim($(this).val())) {
                            $(this).removeClass("is-valid");
                            $(this).addClass("is-invalid");
                            prev.removeClass("is-valid");
                            prev.addClass("is-invalid");
                            error = true;

                        } else if ($.trim(prev.val()) !== $.trim($(this).val())) {
                            $(this).removeClass("is-valid");
                            $(this).addClass("is-invalid");
                            prev.removeClass("is-valid");
                            prev.addClass("is-invalid");
                            error = true;
                        } else {
                            $(this).removeClass("is-invalid");
                            $(this).addClass("is-valid");
                            prev.removeClass("is-invalid");
                            prev.addClass("is-valid");

                        }
                    }
                });
                return !error;
            });
        });
    };
})(jQuery);



$(document).ready(function () {
    $(".formUser").checkMatch();
    $(".formUser").validate();
    $(".formUser").matchPasswords();
    $(".formUpdateUser").validate({empty: true});
    $(".formUpdateUser").matchPasswords({empty: true});
    $(".formUpdateUser").checkMatch();
});


