$(".editbtn").on("click", function () {
  $tr = $(this).closest("tr");
  var datos = $tr.children("td").map(function () {
    return $(this).text();
  });
  $("#update_id").val(datos[0]);
  $("#nombre").val(datos[1]);
  $("#detalle").val(datos[2]);
  $("#precio").val(datos[3]);
  $("#fecha").val(datos[4]);
});
