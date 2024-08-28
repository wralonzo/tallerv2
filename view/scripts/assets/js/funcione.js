
    $("#Categoria").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax1.php",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
          $("#idcliente").val(ui.item.id);
          $("#Categoria").val(ui.item.label);
          $("#Precio").val(ui.item.precio);
          $("#fecha").val(ui.item.fecha);
        }

    })
