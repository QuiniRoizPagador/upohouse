(function ($) {
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
})(jQuery);

$(document).ready(function () {
    $(".pagUser").paginate();
});




