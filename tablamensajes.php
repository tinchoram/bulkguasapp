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

$sql="SELECT IDMESSAGE,IDCAMPANA,NAME,MESSAGE,MEDIAPATH from message where USERID = '$user_id'";
$result=mysqli_query($conexion,$sql);
?>


<div class="table table-responsive">
	<table class="table table-sm table table-striped table-hover table-condensed table-bordered" id="iddatatable">
		<thead class="classbulkwtableshead">
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>Mensaje</td>
				<td>Media Path</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>
		</thead>
		<tfoot class="classbulkwtablesfoot">
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>Mensaje</td>
				<td>Media Path</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>
		</tfoot>
		<tbody >
			<?php 
			while ($mostrar=mysqli_fetch_row($result)) {
				?>
				<tr >
					<td><?php echo $mostrar[0] ?></td>
					<td><?php echo $mostrar[2] ?></td>
					<td><?php echo $mostrar[3] ?></td>
					<td><?php echo $mostrar[4] ?></td>
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
				</tr>
				<?php 
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