    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                if (data.result.errorText == "")
                    $('<p/>').attr("class", "success").text(data.result.name + " : " + "Успешно импортирован").appendTo($('#uploaded'));
                else
                    $('<p/>').attr("class", "error").text(data.result.name + " : " + data.result.errorText).appendTo($('#uploaded'));
            }
        });
    });