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

$sql="SELECT ID,NAME,LASTNAME,NICKNAME,PHONE,DNI,ADDRESS,LOCATION from person where USERID = '$user_id'";
$result=mysqli_query($conexion,$sql);
?>

<div class="table table-responsive">
	<table id="iddatatable" class="display table table-sm table-hover table-condensed table-bordered">
		<thead class="classbulkwtableshead" >
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>Apellido</td>
                <td>ApodoMSJ</td>
                <td>Telefono</td>
                <td>DNI</td>
                <td>Direccion</td>
                <td>Localidad</td>
				<td>Editar</td>
				<td>Eliminar</td>
				<td>check</td>
			</tr>
		</thead>
		
		<tbody style="cursor: pointer">
			<?php 
			while ($mostrar=mysqli_fetch_row($result)) {
				?>
				<tr onclick="selectcont(this,'<?php echo $mostrar[0] ?>')">
					<td><?php echo $mostrar[0] ?></td>
					<td><?php echo $mostrar[1] ?></td>
					<td><?php echo $mostrar[2] ?></td>
                    <td><?php echo $mostrar[3] ?></td>
                    <td><?php echo $mostrar[4] ?></td>
                    <td><?php echo $mostrar[5] ?></td>
                    <td><?php echo $mostrar[6] ?></td>
                    <td><?php echo $mostrar[7] ?></td>
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
					<td><input type="checkbox" name="check[]" value="<?php echo $mostrar[0]; ?>" id="<?php echo "chk".$mostrar[0]; ?>"></td>
				</tr>
				<?php 
			}
			?>
		</tbody>

		<tfoot class="classbulkwtablesfoot"">
			<tr>
                <td>ID</td>
				<td>Nombre</td>
				<td>Apellido</td>
                <td>ApodoMSJ</td>
                <td>Telefono</td>
                <td>DNI</td>
                <td>Direccion</td>
                <td>Localidad</td>
				<td>Editar</td>
				<td>Eliminar</td>
				<td>check</td>
			</tr>
		</tfoot>

	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();
	} );
</script>

<script>
	function selectcont(tr,value){
		$(function(){
			if ($("#chk"+value).attr("checked") == "checked") {
				$("#chk"+value).removeAttr("checked");
				$(tr).css("background-color","#FFFFFF");
			}
			else{
				$("#chk"+value).attr("checked",true);
				$(tr).css("background-color","#BEDAE8");
			}	
		})
	}
</script>


<?php }?>