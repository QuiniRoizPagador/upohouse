/*(function ($) {
 $.fn.paginate = function () {
 this.each(function () {
 $(this).click(function () {
 $(".pagUser").parent().removeClass("active");
 $("#lockModal").modal('show');
 var url = "index.php?controller=WS&action=paginateUsers";
 var num = $(this).text();
 $.post(url,
 {
 'userPag': num
 },
 function (data, status) {
 var users = $.parseJSON(data);
 $("#cuerpo").empty();
 for (var i = 0; i < users.length; i++) {
 var lock = users[i].state == '2';
 $("#cuerpo").append("<tr" + (lock ? " class='alert alert-danger'>" : ">")
 + "<td>" + users[i].id + "</td>"
 + "<td>" + users[i].uuid + "</td>"
 + "<td>" + users[i].login + "</td>"
 + "<td>" + users[i].name + "</td>"
 + "<td>" + users[i].surname + "</td>"
 + "<td>" + users[i].email + "</td>"
 + "<td>" + users[i].user_role + "</td>"
 + "<td>" + users[i].timestamp + "</td>"
 + "<td><button type='button' data-toggle='modal' data-target='#remove" + users[i].uuid + "' class='btn btn-danger'><i class='fa fa-database'></i></button></td>"
 + "<td><button type='button' data-toggle='modal' data-target='#edit" + users[i].uuid + "' class='btn btn-warning'><i class='fa fa-user'></i></button></td>"
 + "<td><button type='button' data-toggle='modal' data-target='#block" + users[i].uuid + "' class='btn btn-danger'><i class='fa fa-ban'></i></button></td>"
 + "</tr>");
 }
 $("#lockModal").modal("hide");
 }
 );
 $(this).parent().addClass("active");
 });
 });
 };
 })(jQuery);*/

//Soporta traducción

function resetField(f, disabled = false) { //Limpia un campo de tipo selected, dando opción a deshabilitarlo.
    f.empty();
    if (disabled) {
        f.attr("disabled", "disabled");
    } else {
        f.removeAttr("disabled");
    }
}

function getProvincesList(id, dtext) { //Devuelve lista de provincias en base a una comunidad(id)
    var url = "index.php?controller=WS&action=provincesByCommunity";
    $.post(url, {
        'communityId': id
    },
            function (data, status) {
                var provinces = $.parseJSON(data);
                $("#province").append("<option selected='selected'>" + dtext + "</option>'");
                for (var i = 0; i < provinces.length; i++) {
                    $("#province").append("<option value='" + provinces[i].id + "'>" + provinces[i].province + "</option>");
                }
            });
}

function getMunicipalitiesList(id, dtext) { //Devuelve lista de municipios en base a una provinca(id)
    var url = "index.php?controller=WS&action=municipalitiesByProvince";
    $.post(url, {
        'provinceId': id
    },
            function (data, status) {
                var municipalities = $.parseJSON(data);
                $("#municipality").append("<option selected='selected'>" + dtext + "</option>'");
                for (var i = 0; i < municipalities.length; i++) {
                    $("#municipality").append("<option value='" + municipalities[i].id + "'>" + municipalities[i].municipality + "</option>");
                }
            });
}

$(document).ready(function () {//Al seleccionar una comunidad o provincia, carga la lista de provincias o municipios asociada.
    var cf = $("#community");
    var pf = $("#province");
    var mf = $("#municipality");
    var pdtext = pf.children("option:selected").val();
    var mftext = mf.children("option:selected").val();
    cf.change(function () {
        var val = $(this).children("option:selected").val();
        if ($.isNumeric(val)) {
            resetField(pf);
            getProvincesList(val, pdtext);
        } else {
            resetField(pf, true);
        }
        resetField(mf, true);
    });
    pf.change(function () {
        var val = $(this).children("option:selected").val();
        if ($.isNumeric(val)) {
            resetField(mf);
            getMunicipalitiesList(val, mftext);
        } else {
            resetField(mf, true);
        }
    });
}
);




