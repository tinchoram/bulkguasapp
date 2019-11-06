<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
}
else {	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>BulkGuasapp</title>
    <link rel="shortcut icon" href="static/img/bulkguasapp-logo.ico" />
    <?php require_once "scripts.php";  ?>
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <div>

				<div class="card-header">
						CONTACTOS
					</div>
					<div class="card-body">
						
								<div class="container">

								 <div class="row justify-content-between">	

									<span class="col-3 btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
										Nuevo contacto <span class="fa fa-plus-circle"></span>
									</span>

									
									<select id="segment" name="segment" class="col-3 btn btn-dark" data-toggle="modal" name="listaSementos">
									<option value="0">seleccionar un segmento</option>	
									<?php require 'procesos/obtenSegmentos.php' ?>
									</select>
			
									<span class="col-3 btn btn-success" data-toggle="modal" data-target="#addsegmentmodal" onclick="AddSegment()">Agregar a segmento <span class="fa fa-plus-circle"></span></span>
									
								</div>
								</div>	
						<hr>
						<div  id="tablaDatatable"></div>

					</div>
						
					<div class="card-footer text-muted">
						<a class="row justify-content-center" target="_blank" href="http://tinchoram.com.ar/">By Tinchoram</a>
					</div>
	</div>				

	<!-- Modal -->
	<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nuevo contacto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevo">
						<label>Nombre *</label>
						<input type="text" class="form-control input-sm" id="name" name="name">
						<label>Apellido</label>
            <input type="text" class="form-control input-sm" id="apellido" name="apellido">
            <label>ApodoMSJ</label>
            <input type="text" class="form-control input-sm" id="apodomsj" name="apodomsj">
            <label>Telefono (solo numeros) *</label>
            <input type="text" class="form-control input-sm" id="telefono" name="telefono">
            <label>DNI (solo numeros)</label>
            <input type="text" class="form-control input-sm" id="dni" name="dni">
            <label>Direccion</label>
            <input type="text" class="form-control input-sm" id="direccion" name="direccion">
            <label>Localidad</label>
						<input type="text" class="form-control input-sm" id="localidad" name="localidad">
					</form>
				</div>
				<div class="modal-footer">
          <label>* Campos Obligatorios</label>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" id="btnAgregarnuevo" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Actualizar Campaña</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevoU">
            <input type="text" hidden="" id="idcontacto" name="idcontacto"> 
            <label>Nombre *</label>
						<input type="text" class="form-control input-sm" id="nameU" name="nameU">
						<label>Apellido</label>
            <input type="text" class="form-control input-sm" id="apellidoU" name="apellidoU">
            <label>ApodoMSJ</label>
            <input type="text" class="form-control input-sm" id="apodomsjU" name="apodomsjU">
            <label>Telefono (solo numeros) *</label>
            <input type="text" class="form-control input-sm" id="telefonoU" name="telefonoU">
            <label>DNI (solo numeros)</label>
            <input type="text" class="form-control input-sm" id="dniU" name="dniU">
            <label>Direccion</label>
            <input type="text" class="form-control input-sm" id="direccionU" name="direccionU">
            <label>Localidad</label>
						<input type="text" class="form-control input-sm" id="localidadU" name="localidadU">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal AddSegment-->
	<div class="modal fade" id="addsegmentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Carga de Segmento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmAddSegment">
						<input type="text" hidden="" id="idsegment" name="idsegment">
						<label>ID de Segmento</label>
						<input type="text" readonly="readonly" class="form-control input-sm" id="nameSegment" name="nameSegment">
						<label>Contactos a Agregar</label>
						<input type="text" readonly="readonly" class="form-control input-sm" id="descriptionU" name="descriptionU">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnAgregar">Agregar</button>
				</div>
			</div>
		</div>
	</div>


  </body>
</html>





<script type="text/javascript">
	$(document).ready(function(){
		$('#btnAgregarnuevo').click(function(){
			datos=$('#frmnuevo').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/agregarcontacto.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatable').load('tablacontactos.php');
						alertify.success("Se creo el contacto");
						//$('#agregarnuevosdatosmodal').modal('hide');
					}else{
						alertify.error("Fallo al crear");
					}
				}
			});
		});

		$('#btnActualizar').click(function(){
			datos=$('#frmnuevoU').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/actualizarcontacto.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablacontactos.php');
						alertify.success("Actualizado con exito!");
						$('#modalEditar').modal('hide');
					}else{
						alertify.error("Fallo al actualizar :(");
					}
				}
			});
		});

		
		$('#btnAgregar').click(function(){

			if(document.getElementById("segment").value !=='0') {

						var idsegment = document.getElementById("segment").value;
						var ListaContactos = [];
						$("input[name='check[]']").each(function(indice, elemento) {

						//console.log('El elemento con el índice '+indice+'chk'+$(elemento).val());
						var checkID = 'chk'+$(elemento).val();
						var checkistrue = document.getElementById(checkID).checked;
						if (checkistrue) {//alertify.success("true");
						ListaContactos.push($(elemento).val());
						}
    				
														});

						if(ListaContactos.length>0){
							//$('#descriptionU').val(ListaContactos.length +" Contactos Seleccionados ok");
							//alertify.success("Voy a cargar registros");


									 $.post('procesos/agregarcontactosegmento.php', {
								              dataArray: ListaContactos,
								              "idsegment": idsegment
								            },function(data) {
								            	alertify.success("Contactos agregados", data);
								             
								          });





							$('#frmAddSegment')[0].reset();
							$('#addsegmentmodal').modal('toggle');
						}
						else{alertify.error("Falta Seleccion de contactos");}	

			}
			else{alertify.error("Falta Seleccion Segmento");}	

		});



	});

</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tablaDatatable').load('tablacontactos.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idcontacto){
		$.ajax({
			type:"POST",
			data:"idcontacto=" + idcontacto,
			url:"procesos/obtenDatoscontactos.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idcontacto').val(datos['id']);
				$('#nameU').val(datos['name']);
        $('#apellidoU').val(datos['lastname']);
        $('#apodomsjU').val(datos['nickname']);
        $('#telefonoU').val(datos['phone']);
        $('#dniU').val(datos['dni']);
        $('#direccionU').val(datos['address']);
				$('#localidadU').val(datos['location']);
				}
		});
	}

	
	function AddSegment(){

		var ListaContactos = [];
		$("input[name='check[]']").each(function(indice, elemento) {

				//console.log('El elemento con el índice '+indice+'chk'+$(elemento).val());
				var checkID = 'chk'+$(elemento).val();
				var checkistrue = document.getElementById(checkID).checked;
				if (checkistrue) {//alertify.success("true");
				ListaContactos.push($(elemento).val());
				}
   				
										});

				if(ListaContactos.length>0){
					$('#descriptionU').val(ListaContactos.length +" Contactos Seleccionados");
				}
				else{$('#descriptionU').val("No hay Contactos Seleccionados");}	 


		

		if ((document.getElementById("segment").value)=='0') {
		$('#nameSegment').val("Debe seleccionar un Segmento");
		alertify.error("Seleccionar un Segmento");
		}
		else{$('#nameSegment').val(document.getElementById("segment").value);}
		
	}


	function eliminarDatos(idcontacto){
		alertify.confirm('Eliminar contacto', '¿Seguro de eliminar contacto?', function(){ 

			$.ajax({
				type:"POST",
				data:"idcontacto=" + idcontacto,
				url:"procesos/eliminarcontacto.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablacontactos.php');
						alertify.success("Eliminado con exito !");
					}else{
						alertify.error("No se pudo eliminar...");
					}
				}
			});

		}
		, function(){

		});
	}
</script>

<?php }?>

