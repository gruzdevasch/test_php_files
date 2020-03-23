$(document).ready(function () {
    $.contextMenu({
        selector: '.folder, .file',
        callback: function (key, options) {
            var element = this;
            var type = $(this).prop('class').split(' ')[0];
            var id = $(this).prop('id');
            var data = new FormData();
            data.append('type', type);
            data.append('id', id);
            if (key == 'delete') {

                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    dataType: "text",
                    data: data,
                    success: function (response) {
                        if (response == 1) {
                            $(element).fadeOut(800, function () {
                                $(this).remove();
                            });
                        } else {
                            alert(response);
                        }

                    }
                });

            } else {
                if (type === 'folder') {
                    window.location.href = "/changeDir.php?id=" + id;
                } else {
                    window.location.href = "/changeElement.php?id=" + id;
                }
            }
            /*window.console && console.log(type + id) || alert(type + id);*/
        },
        items: {
            "edit": {name: "Редактировать", icon: "edit"},
            "delete": {name: "Удалить", icon: "delete"},
        }
    });

});

