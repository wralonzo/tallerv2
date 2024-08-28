$('.editbtn').on('click',function(){
	$tr=$(this).closest('tr');
	var datos=$tr.children('td').map(function() {
		return $(this).text();
	});
	$('#update_id').val(datos[0]);
  	$('#nombre').val(datos[1]);
	$('#placa').val(datos[2]);
	$('#vin').val(datos[3]);
	$('#marca').val(datos[4]);
	$('#tipo').val(datos[5]);
	$('#color').val(datos[6]);
});
