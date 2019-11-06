
<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
}
else {

$user_id = $_SESSION['user_id']; 

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();

$sql="SELECT IDLOT,NAME,CREATIONDATE,DESCRIPTION,INITDATE,ENDDATE,IDMESSAGE,IDSEGMENT,STATUS from lot where USERID = '$user_id'";
//$result=mysqli_query($conexion,$sql);
?>


<div class="table table-responsive">
	<table class="table table-sm table table-striped table-hover table-condensed table-bordered" id="iddatatable">
		<thead class="classbulkwtableshead">
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>Creacion</td>
				<td>Descripcion</td>
				<td>INICIO</td>
				<td>FIN</td>
				<td>Mensaje</td>
				<td>Segmento</td>
				<td>Editar</td>
				<td>Eliminar</td>
				<td>Estado</td>
			</tr>
		</thead>
		<tfoot class="classbulkwtablesfoot">
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>Creacion</td>
				<td>Descripcion</td>
				<td>INICIO</td>
				<td>FIN</td>
				<td>Mensaje</td>
				<td>Segmento</td>
				<td>Editar</td>
				<td>Eliminar</td>
				<td>Estado</td>
			</tr>
		</tfoot>
		<tbody >
			<?php
			if ($result=mysqli_query($conexion,$sql)) { 
				while ($mostrar=mysqli_fetch_row($result)) {
				?>
				<tr >
					<td><?php echo $mostrar[0] ?></td>
					<td><?php echo $mostrar[1] ?></td>
					<td><?php echo $mostrar[2] ?></td>
					<td><?php echo $mostrar[3] ?></td>
					<td><?php echo $mostrar[4] ?></td>
					<td><?php echo $mostrar[5] ?></td>
					<td style="text-align: center;">
						<span class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalMensaje" onclick="MostrarMensaje('<?php echo $mostrar[6] ?>')">
							<span class="fa fa-sticky-note"></span>
						</span>
					</td>
					<td style="text-align: center;">
						<span class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalSegmento" onclick="MostrarSegmento('<?php echo $mostrar[7] ?>')">
							<span class="fa fa-users"></span>
						</span>
					</td>
					<td style="text-align: center;">
						<span class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar" onclick="agregaFrmActualizar('<?php echo $mostrar[0] ?>')">
							<span class="fa fa-pencil-square-o"></span>
						</span>
					</td>
					<td style="text-align: center;">
						<span class="btn btn-danger btn-sm" onclick="eliminarDatos('<?php echo $mostrar[0] ?>')">
							<span class="fa fa-trash"></span>
						</span>
					</td>
					<td style="text-align: center;">
						<span onclick="ActivarLote('<?php echo $mostrar[0] ?>')">
							<?php if ($mostrar[8]==1) {
								echo '<span class="btn btn-success fa fa-check"></span>';
							}else{echo '<span class="btn btn-secondary btn-sm fa fa-check"></span>';} 
							?>
							
						</span>
					</td>
				</tr>
				<?php 
				}
			}		
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();
	} );
</script>

<?php }?>