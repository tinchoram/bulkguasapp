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
						CAMPAÑAS
					</div>
					<div class="card-body">
						<span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
							Nueva Campaña <span class="fa fa-plus-circle"></span>
						</span>
						<hr>
						<div id="tablaDatatable"></div>
					</div>
					<div class="card-footer">
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
					<h5 class="modal-title" id="exampleModalLabel">Nueva Campaña</h5>
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
						<input type="text" hidden="" id="idcampana" name="idcampana">
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
				url:"procesos/agregar.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatable').load('tablacampanas.php');
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
				url:"procesos/actualizar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablacampanas.php');
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
		$('#tablaDatatable').load('tablacampanas.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idcampana){
		$.ajax({
			type:"POST",
			data:"idcampana=" + idcampana,
			url:"procesos/obtenDatos.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idcampana').val(datos['id']);
				$('#nameU').val(datos['name']);
				$('#descriptionU').val(datos['description']);
				}
		});
	}

	function eliminarDatos(idcampana){
		alertify.confirm('Eliminar campaña', '¿Seguro de eliminar?', function(){ 

			$.ajax({
				type:"POST",
				data:"idcampana=" + idcampana,
				url:"procesos/eliminar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tablacampanas.php');
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

