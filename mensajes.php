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
						MENSAJES
					</div>
					<div class="card-body">
						<span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
							Nuevo Mensaje <span class="fa fa-plus-circle"></span>
						</span>
						<hr>
						<div id="tablaDatatableMSJ"></div>
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
					<h5 class="modal-title" id="exampleModalLabel">Nuevo Mensaje</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevo">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="name" name="name">
            <label>Mensaje</label>
            <textarea class="form-control" rows="5" id="message" name="message"></textarea>
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
					<h5 class="modal-title" id="exampleModalLabel">Actualizar Mensaje</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevoU">
						<input type="text" hidden="" id="idmensaje" name="idmensaje">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nameU" name="nameU">
            <label>Mensaje</label>
            <textarea class="form-control" rows="5" id="messageU" name="messageU"></textarea>
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
				url:"procesos/agregarmsj.php",
				success:function(r){
					if(r==1){
						$('#frmnuevo')[0].reset();
						$('#tablaDatatableMSJ').load('tablamensajes.php');
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
				url:"procesos/actualizarmsj.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatableMSJ').load('tablamensajes.php');
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
		$('#tablaDatatableMSJ').load('tablamensajes.php');
	});
</script>

<script type="text/javascript">
	function agregaFrmActualizar(idmensaje){
		$.ajax({
			type:"POST",
			data:"idmensaje=" + idmensaje,
			url:"procesos/obtenDatosmsj.php",
			success:function(r){
				datos=jQuery.parseJSON(r);
				$('#idmensaje').val(datos['id']);
				$('#nameU').val(datos['name']);
				$('#messageU').val(datos['message']);
				}
		});
	}

	function eliminarDatos(idmensaje){
		alertify.confirm('Eliminar mensaje', '¿Seguro de eliminar?', function(){ 

			$.ajax({
				type:"POST",
				data:"idmensaje=" + idmensaje,
				url:"procesos/eliminarmgs.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatableMSJ').load('tablamensajes.php');
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