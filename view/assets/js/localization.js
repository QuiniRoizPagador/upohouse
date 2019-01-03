//Soporta traducción

function resetField(f, disabled = false) { //Limpia un campo de tipo selected, dando opción a deshabilitarlo.
    f.empty();
    if (disabled) {
        f.attr("disabled", "disabled");
    } else {
        f.removeAttr("disabled");
    }
}

function getProvincesList(id) { //Devuelve lista de provincias en base a una comunidad(id)
    var url = "index.php?controller=WS&action=provincesByCommunity";
    $.post(url, {
        'communityId': id
    },
            function (data, status) {
                var provinces = $.parseJSON(data);
                $("#province").append("<option selected='selected'>" + LANG["eligeProvincia"] + "</option>'");
                for (var i = 0; i < provinces.length; i++) {
                    $("#province").append("<option value='" + provinces[i].id + "'>" + provinces[i].province + "</option>");
                }
            });
}

function getMunicipalitiesList(id) { //Devuelve lista de municipios en base a una provinca(id)
    var url = "index.php?controller=WS&action=municipalitiesByProvince";
    $.post(url, {
        'provinceId': id
    },
            function (data, status) {
                var municipalities = $.parseJSON(data);
                $("#municipality").append("<option selected='selected'>" + LANG["eligeMunicipio"] + "</option>'");
                for (var i = 0; i < municipalities.length; i++) {
                    $("#municipality").append("<option value='" + municipalities[i].id + "'>" + municipalities[i].municipality + "</option>");
                }
            });
}

$(document).ready(function () {//Al seleccionar una comunidad o provincia, carga la lista de provincias o municipios asociada.
    var cf = $("#community");
    var pf = $("#province");
    var mf = $("#municipality");
    cf.change(function () {
        var val = $(this).children("option:selected").val();
        if ($.isNumeric(val)) {
            resetField(pf);
            getProvincesList(val);
        } else {
            resetField(pf, true);
        }
        resetField(mf, true);
    });
    pf.change(function () {
        var val = $(this).children("option:selected").val();
        if ($.isNumeric(val)) {
            resetField(mf);
            getMunicipalitiesList(val);
        } else {
            resetField(mf, true);
        }
    });
}
);




