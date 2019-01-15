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

function cargarUsuario(user, pag) {
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
            var span = $("<span class='btn' data-toggle='tooltip' title='" + LANG['desbloquear'] + "'>");
            span.append("<button type='button' data-toggle='modal' data-target='#unlock" + user.uuid + "' data-dismiss='modal' class='btn btn-success'><i class='fa fa-check'></i></button></span>");
            buttons.append(span);
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
            modal = createModal("block" + user.uuid, user.uuid, LANG['bloquear'] + " " + LANG['user'] + " " + user.name, button, "index.php?controller=admin&action=blockUser&show=users", LANG['estas seguro']);
            td.append(modal);
        } else {
            button = $("<button type='submit' class='btn btn-success'><i class='fa fa-check'></i>" + LANG['desbloquear'] + "</button>");
            modal = createModal("unlock" + user.uuid, user.uuid, LANG['desbloquear'] + " " + LANG['user'] + " " + user.name, button, "index.php?controller=admin&action=unlockUser&show=users", LANG['estas seguro']);
            td.append(modal);
        }
        button = $("<button type='submit' class='btn btn-danger'><i class='fa fa-remove'></i>" + LANG['eliminar'] + "</button>");
        modal = createModal("remove" + user.uuid, user.uuid, LANG['eliminar registro de'] + user.name, button, "index.php?controller=Admin&action=removeUser&show=users", LANG['estas seguro']);
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
    form = $("<form method='post' action='index.php?controller=Admin&action=updateUser&show=users' class='formUpdateUser' />");
    modal_card.append(form);
    modal_body = $("<div class='card-body modal-body' />");
    form.append(modal_body);
    var row = $("<div class='row' />");
    modal_body.append(row);

    var form_control = $("<div class='form-control has-success col-md-6 ml-auto formUpdateUser' /;>");
    form_control.append(create("input type='hidden' value='" + pag + "' name='pag'"), "", "");
    form_control.append(create("input type='hidden' value='" + user.uuid + "' name='uuid'"), "", "");
    form_control.append(create("label for='name'", LANG['nombre'], ""));
    form_control.append(create("input type='text' name='name' value='" + user.name + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));


    form_control.append(create("label for='surname'", LANG['apellido'], ""));
    form_control.append(create("input type='text' name='surname' value='" + user.surname + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));



    form_control.append(create("label for='phone'", LANG['phone'], ""));
    form_control.append(create("input type='tel' name='phone' value='" + user.phone + "'", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));
    row.append(form_control);

    form_control = $("<div class='form-control has-success col-md-6 ml-auto' /;>");
    form_control.append(create("label for='password'", LANG['contraseña'], ""));
    form_control.append(create("input type='password' name='password'", "", "form-control password"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));


    form_control.append(create("label for='password'", LANG['contraseña'], ""));
    form_control.append(create("input type='password' name='password2'", "", "form-control password2"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));


    form_control.append(create("label for='user_role'", LANG['rol'], ""));
    var select = create("select name='user_role'", "", "form-control");
    select.append(create("option value='0'", "USER", ""));
    select.append(create("option value='1'", "ADMIN", ""));
    form_control.append(select);
    row.append(form_control);


    var modal_footer = create("div", "", "modal-footer");

    modal_footer.append($("<input type='hidden' value='" + user.uuid + "' name='uuid' />"));
    modal_footer.append($("<button type='submit' class='btn btn-success'>" + LANG['enviar'] + "</button>"));
    modal_footer.append($("<button type='button' class='btn btn-secondary' data-target='#search" + user.uuid + "' data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));

    form.append(modal_footer);

    tr.append(td);

    return tr;
}

function cargarAnuncio(ad) {
    var clase = "";
    if (ad.state == '2') {
        clase = "table-warning";
    }
    var tr = $("<tr>");
    var td = $("<td>");
    var a = $("<a>");
    var span = $("<span>");
    a.attr('href', 'index.php?controller=Ad&action=read&uuid=' + ad.uuid);
    a.addClass('btn btn-info btn-sm');
    span.addClass('fa fa-eye');
    a.append(span);
    td.append(a);
    tr.append(create("td", ad.id, clase));
    tr.append(create("td", ad.uuid, clase));
    tr.append(create("td", ad.price, clase));
    tr.append(create("td", ad.timestamp, clase));
    tr.append(td);
    return tr;
}

function cargarComentario(comment) {

    var clase = "";
    var tr = $("<tr/>");
    tr.append(create("td", comment.id, clase));
    tr.append(create("td", comment.ad_id, clase));
    tr.append(create("td", comment.user_id, clase));
    tr.append(create("td", comment.content, clase));
    tr.append(create("td", comment.timestamp, clase));
    var td = create("td", "", clase);
    var button = $("<button data-toggle='modal' data-target='#remove" + comment.uuid + "' class='btn btn-danger' />");
    button.append($("<i class='fa fa-remove'/>"));
    td.append(button);

    var modal = create("div id='remove" + comment.uuid + "' tabindex='-1'", "", "modal fade");
    modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    var modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    var modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['eliminar anuncio con id'] + " " + comment.id, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    var form = $("<form method='post' action='index.php?controller=Admin&action=removeComment&show=comentarios' />");
    modal_card.append(form);
    var modal_body = $("<div class='card-body modal-body'/>");
    form.append(modal_body);
    var row = $("<div class='row' />");
    modal_body.append(row);

    modal_body = $("<div class='card-body modal-body' />");
    modal_card.append(modal_body);

    var form_control = $("<div class='form-control has-success col-md-12 ml-auto'>" + LANG['estas seguro'] + "</div>");
    row.append(form_control);
    var modal_footer = create("div", "", "modal-footer");


    var form2 = $("<form method='post' action='index.php?controller=Admin&action=removeComment&show=comentarios' />");
    modal_footer.append($("<input type='hidden' value='" + comment.uuid + "' name='uuid' />"));
    modal_footer.append($("<button type='subbmit' class='btn btn-danger'><i class='fa fa-remove'></i>" + LANG['eliminar'] + "</button>"));
    modal_footer.append($("<button type='button' class='btn btn-secondary data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    modal_footer.append(form2);
    form.append(modal_footer);
    td.append(modal);



    tr.append(td);
    console.log(tr);
    return tr;
}


function cargarHousingType(housingType) {

    var clase = "";
    var tr = $("<tr/>");
    tr.append(create("td", housingType.id, clase));
    tr.append(create("td", housingType.name, clase));

    var td = create("td", "", clase);
    var button = $("<button data-toggle='modal' data-target='#edit" + housingType.uuid + "' class='btn btn-success' />");
    button.append($("<i class='fa fa-pencil'/>"));
    td.append(button);

    var modal = create("div id='edit" + housingType.uuid + "' tabindex='-1'", "", "modal fade");
    var modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    var modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    var modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['editar registro de'] + " " + housingType.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    form = $("<form method='post' action='index.php?controller=Admin&action=updateHousingTypes&show=tipos' class='formUpdateHousingTypes' />");
    modal_card.append(form);
    var modal_body = $("<div class='card-body modal-body' />");
    form.append(modal_body);
    var row = $("<div class='row' />");
    modal_body.append(row);
    modal_body = $("<div class='card-body modal-body' />");
    modal_card.append(modal_body);

    var form_control = $("<div class='form-control has-success col-md-12 ml-auto' /;>");
    form_control.append(create("input type='hidden' value='" + housingType.uuid + "' name='uuid'"), "", "");
    form_control.append(create("label for='name'", LANG['nombre'], ""));
    form_control.append(create("input type='text' name='name' value=''", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));
    row.append(form_control);
    var modal_footer = create("div", "", "modal-footer");
    modal_footer.append($("<input type='hidden' value='" + housingType.uuid + "' name='uuid' />"));
    modal_footer.append($("<button type='submit' class='btn btn-success'>Enviar</button>"));
    modal_footer.append($("<button type='button' class='btn btn-secondary data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    form.append(modal_footer);
    td.append(modal);
    tr.append(td);

    td = create("td", "", clase);
    button = $("<button data-toggle='modal' data-target='#remove" + housingType.uuid + "' class='btn btn-danger' />");
    button.append($("<i class='fa fa-remove'/>"));
    td.append(button);

    modal = create("div id='remove" + housingType.uuid + "' tabindex='-1'", "", "modal fade");
    modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['eliminar registro de'] + " " + housingType.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"));
    modal_card.append(modal_header);
    modal_body = $("<div class='card-body modal-body'>" + LANG['estas seguro'] + "</div>");
    modal_card.append(modal_body);
    modal_footer = create("div", "", "modal-footer");
    modal_card.append(modal_footer);

    form = $("<form method='post' action='index.php?controller=Admin&action=removeHousingType&show=tipos' />");
    form.append($("<input type='hidden' value='" + housingType.uuid + "' name='uuid' />"));
    form.append($("<button type='submit' class='btn btn-danger'><i class='fa fa-remove'></i>" + LANG['eliminar'] + "</button>"));
    form.append($("<button type='button' class='btn btn-secondary data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    modal_footer.append(form);

    td.append(modal);
    tr.append(td);


    return tr;
}

function cargarOperationType(operationType) {

    var clase = "";
    var tr = $("<tr/>");
    tr.append(create("td", operationType.id, clase));
    tr.append(create("td", operationType.name, clase));

    var td = create("td", "", clase);
    var button = $("<button data-toggle='modal' data-target='#edit2" + operationType.uuid + "' class='btn btn-success' />");
    button.append($("<i class='fa fa-pencil'/>"));
    td.append(button);

    var modal = create("div id='edit2" + operationType.uuid + "' tabindex='-1'", "", "modal fade");
    var modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    var modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    var modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['editar tipo operacion'] + " " + operationType.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    form = $("<form method='post' action='index.php?controller=Admin&action=updateOperationTypes&show=tipos' class='formUpdateOperationTypes' />");
    modal_card.append(form);
    var modal_body = $("<div class='card-body modal-body' />");
    form.append(modal_body);
    var row = $("<div class='row' />");
    modal_body.append(row);
    modal_body = $("<div class='card-body modal-body' />");
    modal_card.append(modal_body);

    var form_control = $("<div class='form-control has-success col-md-12 ml-auto' /;>");
    form_control.append(create("input type='hidden' value='" + operationType.uuid + "' name='uuid'"), "", "");
    form_control.append(create("label for='name'", LANG['nombre'], ""));
    form_control.append(create("input type='text' name='name' value=''", "", "form-control"));
    form_control.append(create("div", LANG['formato_incorrecto'], "invalid-feedback"));
    row.append(form_control);
    var modal_footer = create("div", "", "modal-footer");
    modal_footer.append($("<input type='hidden' value='" + operationType.uuid + "' name='uuid' />"));
    modal_footer.append($("<button type='submit' class='btn btn-success'>Enviar</button>"));
    modal_footer.append($("<button type='button' class='btn btn-secondary data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    form.append(modal_footer);
    td.append(modal);
    tr.append(td);

    td = create("td", "", clase);
    button = $("<button data-toggle='modal' data-target='#remove2" + operationType.uuid + "' class='btn btn-danger' />");
    button.append($("<i class='fa fa-remove'/>"));
    td.append(button);

    modal = create("div id='remove2" + operationType.uuid + "' tabindex='-1'", "", "modal fade");
    modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['eliminar registro de'] + " " + operationType.name, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' data-toggle='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"));
    modal_card.append(modal_header);
    modal_body = $("<div class='card-body modal-body'>" + LANG['estas seguro'] + "</div>");
    modal_card.append(modal_body);
    modal_footer = create("div", "", "modal-footer");
    modal_card.append(modal_footer);

    form = $("<form method='post' action='index.php?controller=Admin&action=removeOperationType&show=tipos' />");
    form.append($("<input type='hidden' value='" + operationType.uuid + "' name='uuid' />"));
    form.append($("<button type='submit' class='btn btn-danger'><i class='fa fa-remove'></i>" + LANG['eliminar'] + "</button>"));
    form.append($("<button type='button' class='btn btn-secondary data-toggle='modal' data-dismiss='modal'>" + LANG['cancelar'] + "</button>"));
    modal_footer.append(form);

    td.append(modal);
    tr.append(td);


    return tr;
}


function cargarRequests(request, pag) {
    var clase = "";
    var tr = $("<tr/>");
    tr.append(create("td", request.title, ""));
    var link = $("<a href='index/user/readUser?uuid=" + request.user_uuid + "'>" + request.name + "</a>");
    tr.append(create("td", link, ""));
    tr.append(create("td", request.timestamp, ""));
    var td = create("td", "", clase);
    var button = $("<button data-toggle='modal' data-target='#show" + request.ad + "' class='btn btn-info btn-sm' />");
    button.append($("<span class='fa fa-eye'/>"));
    td.append(button);

    var modal = create("div id='show" + request.ad + "' tabindex='-1'", "", "modal fade");
    var modal_dialog = $("<div class='modal-dialog modal-dialog-centered modal-lg' />");
    modal.append(modal_dialog);
    var modal_card = $("<div class='modal-content card' />");
    modal_dialog.append(modal_card);
    var modal_header = $("<div class='card-header modal-header' />");
    modal_header.append(create("h5", LANG['solicitud'] + " " + request.user, "modal-title"));
    modal_header.append($("<button type='button' data-dismiss='modal' aria-label='Close' class='close'><span aria-hidden='true'>&times;</span></button>"))
    modal_card.append(modal_header);
    var modal_body = $("<div class='card-body modal-body' />");
    modal_card.append(modal_body);

    var reportButton = $("<button class='btn btn-warning btn-sm float-lg-right'><i class='fa fa-ban'></i></button>");
    modal_body.append(reportButton);
    var p = create("p", $("<strong>" + LANG['user'] + "</strong>: <a href='index/user/readUser?uuid=" + request.user_uuid + "'>" + request.name + "</a>"), "");
    modal_body.append(p);
    modal_body.append(create("h4", LANG['contacto'], ""));

    p = create("p", $("<strong>" + LANG['phone'] + "</strong>"), "");
    p.append(": " + request.phone)
    modal_body.append(p);

    p = create("p", $("<strong>" + LANG['email'] + "</strong>:<a href='mailto:" + request.mail + "Subject=" + request.ad + "'> " + request.mail + "</a>"), "");
    modal_body.append(p);

    modal_body.append($("<hr />"));

    p = create("p", "<strong>" + LANG['contenido'] + ":</strong> <br />" + request.content, "");
    modal_body.append(p);

    var footer = create("div", "", "center-block float-lg-right");
    modal_body.append(footer);
    var btn_group = create("div", "", "btn-group");
    footer.append(btn_group);


    footer.append($("<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#refuse" + request.req_uuid + "' data-dismiss='modal'><i class='fa fa-remove'></i></button>"));
    footer.append($("<button class='btn btn-success btn-sm' data-toggle='modal' data-target='#accept" + request.req_uuid + "' data-dismiss='modal'><i class='fa fa-check'></i></button>"));


    td.append(modal);

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
                                var users = data;
                                for (var i = 0; i < users.length; i++) {
                                    $("#cuerpo").append(cargarUsuario(users[i], num - 1));
                                }
                                $(".formUpdateUser").validate({empty: true});
                            } catch (Exception) {

                            }

                            $("#lockModal").modal("hide");
                        }
                );
                $(this).parent().addClass("active");
            });
        });
    };
    $.fn.paginateAds = function () {
        this.each(function () {
            $(this).click(function () {
                $('.pagAd').parent().removeClass('active');
                $("#lockModal").modal('show');
                var url = 'index.php?controller=WS&action=paginateAds';
                var num = $(this).text();
                console.log(num);
                $.post(url,
                        {
                            'adPag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo").empty();
                                var ads = data;
                                console.log(ads);
                                for (var i = 0; i < ads.length; i++) {
                                    $("#cuerpo").append(cargarAnuncio(ads[i]));
                                }
                            } catch (Exception) {

                            }
                            ;
                            $("#lockModal").modal("hide");
                        });
                $(this).parent().addClass("active");
            });
        });
    };

    $.fn.paginateComments = function () {
        this.each(function () {
            $(this).click(function () {
                $(".pagComment").parent().removeClass("active");
                $("#lockModal").modal('show');
                var url = "index.php?controller=WS&action=paginateComments";
                var num = $(this).text();
                $.post(url,
                        {
                            'commentPag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo").empty();
                                var comments = data;
                                for (var i = 0; i < comments.length; i++) {
                                    $("#cuerpo").append(cargarComentario(comments[i]));
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

    $.fn.paginateHousingTypes = function ()
    {
        this.each(function () {
            $(this).click(function () {
                $(".pagHousingTypes").parent().removeClass("active");
                $("#lockModal").modal('show');
                var url = "index.php?controller=WS&action=paginateHousingTypes";
                var num = $(this).text();
                $.post(url,
                        {
                            'housingTypePag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo").empty();
                                var housingTypes = data;
                                for (var i = 0; i < housingTypes.length; i++) {
                                    $("#cuerpo").append(cargarHousingType(housingTypes[i]));
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

    $.fn.paginateOperationTypes = function ()
    {
        this.each(function () {
            $(this).click(function () {
                $(".pagOperationTypes").parent().removeClass("active");
                $("#lockModal").modal('show');
                var url = "index.php?controller=WS&action=paginateOperationTypes";
                var num = $(this).text();
                $.post(url,
                        {
                            'operationTypePag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo2").empty();
                                var operationTypes = data;
                                for (var i = 0; i < operationTypes.length; i++) {
                                    $("#cuerpo2").append(cargarOperationType(operationTypes[i]));
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
    $.fn.paginateRequests = function () {
        this.each(function () {
            $(this).click(function () {
                $(".pagRequest").parent().removeClass("active");
                $("#lockModal").modal('show');
                var url = "index.php?controller=WS&action=paginateRequests";
                var num = $(this).text();
                $.post(url,
                        {
                            'pag': num - 1
                        },
                        function (data, status) {
                            try {
                                $("#cuerpo").empty();
                                var requests = data;
                                for (var i = 0; i < requests.length; i++) {
                                    $("#cuerpo").append(cargarRequests(requests[i], num - 1));
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
    $(".pagAd").paginateAds();
    $(".pagComment").paginateComments();
    $(".pagHousingTypes").paginateHousingTypes();
    $(".pagOperationTypes").paginateOperationTypes();
    $(".pagRequest").paginateRequests();
    $('[data-toggle="tooltip"]').tooltip();
});
