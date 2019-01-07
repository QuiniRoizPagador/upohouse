function create(type, data, clase) {
    var td = $("<" + type + " />");
    if (clase !== "") {
        td.addClass(clase);
    }
    td.append(data);
    return td;
}

function createTR(title, content) {
    var tr = $("<tr />");
    tr.append(create("th", title, ""));
    tr.append(create("td", content, ""));
    return tr;
}

function createModal(id, uuid, title, button, action, content) {
    var modal = create("div id='" + id + "' tabindex='-1'", "", "modal fade");
    var dialog = $("<div class='modal-dialog modal-dialog-centered' />");
    modal.append(dialog);
    var card = $("<div class='modal-content card' />");
    dialog.append(card);
    var header = $("<div class='card-header modal-header' />");
    header.append(create("h5", title, "modal-title"));
    header.append($("<button type='button' data-dismiss='modal'  data-toggle='modal' data-target='#search" + uuid + "' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    card.append(header);
    var body = $("<div class='card-body modal-body' />");
    body.append(content);
    card.append(body);
    var footer = create("div", "", "modal-footer");
    var form = $("<form method='post' action='" + action + "' />");
    form.append($("<input type='hidden' value='" + uuid + "' name='uuid' />"));
    form.append(button);
    form.append($("<button type='button' class='btn btn-secondary' data-target='#search" + uuid + "' data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    footer.append(form);
    card.append(footer);
    return modal;
}

function cargarUsuario(user) {
    var clase = "";
    if (user.state == '2') {
        clase = "table-warning";
    }
    var tr = $("<tr/>");
    tr.append(create("td", user.id, clase));
    tr.append(create("td", user.name, clase));
    tr.append(create("td", user.surname, clase));
    tr.append(create("td", user.email, clase));
    tr.append(create("td", ROLES[user.user_role], clase));
    tr.append(create("td", user.timestamp, clase));

    var td = create("td", "", clase);
    var button = $("<button data-toggle='modal' data-target='#search" + user.uuid + "' class='btn btn-info btn-sm' />");
    button.append($("<span class='fa fa-eye'/>"));
    td.append(button);

    var modal = create("div id='search" + user.uuid + "' tabindex='-1'", "", "modal fade");
    var modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    var modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    var modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", user.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    var modal_body = $("<div class='card-body modal-body' />");
    modal_card.append(modal_body);
    var tabla = create("table", "", "table table-striped");

    var tbody = $("<tbody/>");

    var tbody = $("<tbody />");
    tbody.append(createTR("ID", user.id));
    tbody.append(createTR("UUID", user.uuid));
    tbody.append(createTR(LANG['nombre'], user.name));
    tbody.append(createTR(LANG['apellido'], user.surname));
    tbody.append(createTR(LANG['email'], user.email));
    tbody.append(createTR(LANG['phone'], user.phone));
    tbody.append(createTR(LANG['fecha registro'], user.timestamp));
    tbody.append(createTR(LANG['rol'], ROLES[user.user_role]));

    tabla.append(tbody);
    modal_body.append(tabla);
    modal_body.append($("<br />"));

    var buttons = create("div", "", "text-center");
    modal_body.append(buttons);
    td.append(modal);
    if (user.user_role != ROLES['ADMIN']) {
        if (user.state == STATES['BLOQUEADO']) {
            buttons.append("<div class='alert alert-warning' role='alert'>" + LANG['BLOQUEADO'] + "</div>");
        } else {
            var span = $("<span class='btn' data-toggle='tooltip' title='" + LANG['bloquear'] + "'>");
            span.append("<button type='button' data-toggle='modal' data-target='#block" + user.uuid + "' data-dismiss='modal' class='btn btn-warning'><i class='fa fa-ban'></i></button></span>");
            buttons.append(span);
        }
        var span = $("<span class='btn' data-toggle='tooltip' title='" + LANG['eliminar'] + "'>");
        span.append("<button type='button' data-toggle='modal' data-target='#remove" + user.uuid + "' data-dismiss='modal' class='btn btn-danger'><i class='fa fa-remove'></i></button> </span>");
        buttons.append(span);
    }
    var span = $("<span class='btn' data-toggle='tooltip' title='" + LANG['editar'] + "'>");
    span.append("<button type='button' data-toggle='modal' data-target='#edit" + user.uuid + "' data-dismiss='modal' class='btn btn-success'><i class='fa fa-pencil'></i></button></span>");
    buttons.append(span);

    var form, modal_footer;

    if (user.user_role !== ROLES['ADMIN']) {
        if (user.state !== STATES['BLOQUEADO']) {
            button = $("<button type='submit' class='btn btn-warning'><i class='fa fa-ban'></i>" + LANG['bloquear'] + "</button>");
            modal = createModal("block" + user.uuid, user.uuid, LANG['bloquear'] + " " + LANG['user'] + " " + user.name, button, "index.php?controller=admin&action=blockUser", "¿Estás seguro?");
            td.append(modal);
        }
        button = $("<button type='submit' class='btn btn-danger'><i class='fa fa-remove'></i>" + LANG['eliminar'] + "</button>");
        modal = createModal("remove" + user.uuid, user.uuid, LANG['eliminar registro de'] + user.name, button, "index.php?controller=Admin&action=removeUser", "¿Estás seguro?");
        td.append(modal);
    }

    modal = create("div id='edit" + user.uuid + "' tabindex='-1'", "", "modal fade");
    td.append(modal);
    modal_dialog = $("<div class='modal-dialog modal-dialog-centered' />");
    modal.append(modal_dialog);
    modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['editar datos de'] + user.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' data-target='#search" + user.uuid + "' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    form = $("<form method='post' action='index.php?controller=Admin&action=updateUser' class='formUpdateUser' />");
    modal_card.append(form);
    modal_body = $("<div class='card-body modal-body' />");
    form.append(modal_body);
    var row = $("<div class='row' />");
    modal_body.append(row);

    var form_control = $("<div class='form-control has-success col-md-6 ml-auto' /;>");
    form_control.append(create("input type='hidden' value='" + user.uuid + "' name='uuid'"), "", "");
    form_control.append(create("label for='name'", LANG['nombre'], ""));
    form_control.append(create("input type='text' name='name' value='" + user.name + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'] , "invalid-feedback"));


    form_control.append(create("label for='surname'", LANG['apellido'], ""));
    form_control.append(create("input type='text' name='surname' value='" + user.surname + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));



    form_control.append(create("label for='phone'", LANG['phone'], ""));
    form_control.append(create("input type='tel' name='phone' value='" + user.phone + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));
    row.append(form_control);

    form_control = $("<div class='form-control has-success col-md-6 ml-auto' /;>");
    form_control.append(create("label for='password'", LANG['contraseña'], ""));
    form_control.append(create("input type='password' name='password'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));


    form_control.append(create("label for='password'", LANG['contraseña'], ""));
    form_control.append(create("input type='password' name='password2'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));


    form_control.append(create("label for='user_role'", LANG['rol'], ""));
    var select = create("select name='user_role'", "", "form-control");
    select.append(create("option value='0'", "USER", ""));
    select.append(create("option value='1'", "ADMIN", ""));
    form_control.append(select);
    row.append(form_control);


    var modal_footer = create("div", "", "modal-footer");

    modal_footer.append($("<input type='hidden' value='" + user.uuid + "' name='uuid' />"));
    modal_footer.append($("<button type='submit' class='btn btn-success'>Enviar</button>"));
    modal_footer.append($("<button type='button' class='btn btn-secondary' data-target='#search" + user.uuid + "' data-toggle='modal' data-dismiss='modal'>Cancelar</button>"));

    form.append(modal_footer);

    tr.append(td);

    return tr;
}

(function ($) {
    $.fn.paginateUsers = function () {
        this.each(function () {
            $(this).click(function () {
                $(".pagUser").parent().removeClass("active");
                $("#lockModal").modal('show');
                var url = "index.php?controller=WS&action=paginateUsers";
                var num = $(this).text();
                $.post(url,
                        {
                            'userPag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo").empty();
                                var users = $.parseJSON(data);
                                for (var i = 0; i < users.length; i++) {
                                    $("#cuerpo").append(cargarUsuario(users[i]));
                                }
                            } catch (Exception) {

                            }

                            $("#lockModal").modal("hide");
                        }
                );
                $(this).parent().addClass("active");
            });
        });
    };
})(jQuery);

$(document).ready(function () {
    $(".pagUser").paginateUsers();
    $('[data-toggle="tooltip"]').tooltip();
});
