$('.editbtn').on('click',function(){
	$tr=$(this).closest('tr');
	var datos=$tr.children('td').map(function() {
		return $(this).text();
	});
	console.log(datos);
	$('#update_id').val(datos[0]);
	$('#nombre').val(datos[1]);
	$('#detalle').val(datos[2]);
	$('#vehiculo').val(datos[3]);
	$('#categoria').val(datos[4]);
	$('#costo').val(datos[4]);
	$('#anticipo').val(datos[6]);
	$('#total').val(datos[7]);
	$('#descuento').val(datos[8]);
});
