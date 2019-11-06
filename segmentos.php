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

    <div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card text-left">
					<div class="card-header">
						SEGMENTOS
					</div>
					<div class="card-body">

						 <div class="row justify-content-between">
							<span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
								Nuevo Segmento <span class="fa fa-plus-circle"></span>
							</span>


							<select id="segment" name="segment" class="col-3 btn btn-dark" data-toggle="modal" name="listaSementos">
										<option value="0">seleccionar un segmento</option>	
										<?php require 'procesos/obtenSegmentos.php' ?>
										</select>
				
										<span class="col-3 btn btn-success" data-toggle="modal" onclick="ListaContactosSegmento()">Mostrar Contactos <span class="fa fa-plus-circle"></span></span>	

						</div>
						<hr>
						<div id="tablaDatatable"></div>
					</div>
					<div class="card-footer text-muted">
						<a class="row justify-content-center" target="_blank" href="http://tinchoram.com.ar/">By Tinchoram</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Nuevo Sengmento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevo">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="name" name="name">
						<label>Descripcion</label>
						<input type="text" class="form-control input-sm" id="description" name="description">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar nuevo</button>
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
						<input type="text" hidden="" id="idsegmento" name="idsegmento">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nameU" name="nameU">
						<label>Descripcion</label>
						<input type="text" class="form-control input-sm" id="descriptionU" name="descriptionU">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
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
				url:"procesos/agregarsegmento.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatable').load('tablasegmentos.php');
						alertify.success("La campaña se creo correctamente");
						$('#agregarnuevosdatosmodal').modal('hide');
					}else{
						alertify.error("Fallo al crear campaña");
					}
				}
			});
		});

		$('#btnActualizar').click(function(){
			datos=$('#frmnuevoU').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"procesos/actualizarsegmento.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablasegmentos.php');
						alertify.success("Actualizado con exito :D");
						$('#modalEditar').modal('hide');
					}else{
						alertify.error("Fallo al actualizar :(");
					}
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tablaDatatable').load('tablasegmentos.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idsegmento){
		$.ajax({
			type:"POST",
			data:"idsegmento=" + idsegmento,
			url:"procesos/obtenDatossegmento.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idsegmento').val(datos['id']);
				$('#nameU').val(datos['name']);
				$('#descriptionU').val(datos['description']);
				}
		});
	}


	function ListaContactosSegmento(){

		if ((document.getElementById("segment").value)=='0') {
		
			alertify.error("Seleccionar un Segmento");
		}
		else{

			var idsegment = document.getElementById("segment").value;
			//alertify.error(idsegment);
			
			$(document).ready(function(){
			$('#tablaDatatable').load('tablalistacontseg.php?segment='+idsegment);
			});

		}

	}

	function eliminarDatos(idsegmento){
		alertify.confirm('Eliminar segmento', '¿Seguro de eliminar?', function(){ 

			$.ajax({
				type:"POST",
				data:"idsegmento=" + idsegmento,
				url:"procesos/eliminarsegmento.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablasegmentos.php');
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

	function eliminarContSegmento(idcontacto,idsegmento){
		alertify.confirm('Eliminar segmento', '¿Seguro de eliminar?', function(){ 

			var segment = document.getElementById("segment").value;

			$.ajax({
				type:"POST",
				data:{idcontacto:idcontacto, idsegmento:idsegmento},
				url:"procesos/eliminarContsegmento.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablalistacontseg.php?segment='+segment);
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