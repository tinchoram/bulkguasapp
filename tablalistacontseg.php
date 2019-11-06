<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
}
else {

require_once "clases/conexion.php";
$obj= new conectar();
$conexion=$obj->conexion();


$idsegment = "0";
if (isset($_GET['segment'])) {
  $idsegment = $_GET['segment'];  
  
  settype($idsegment, 'integer');
}

//$idsegment = $_GET['segment'];
//$idsegment = '1';

$sql="SELECT p.ID,p.NAME,p.LASTNAME,p.NICKNAME,p.PHONE,p.DNI,p.ADDRESS,p.LOCATION from person p,segment_person s WHERE s.IDPERSON = p.ID and s.IDSEGMENT ='$idsegment'";

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
				<td>Eliminar</td>
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
						<span class="btn btn-danger btn-sm" onclick="eliminarContSegmento('<?php echo $mostrar[0] ?>','<?php echo $idsegment ?>')">
							<span class="fa fa-trash"></span>
						</span>
					</td>
					
				<?php 
			}
			?>
		</tbody>

		<tfoot class="classbulkwtablesfoot">
			<tr>
                <td>ID</td>
				<td>Nombre</td>
				<td>Apellido</td>
                <td>ApodoMSJ</td>
                <td>Telefono</td>
                <td>DNI</td>
                <td>Direccion</td>
                <td>Localidad</td>
				<td>Eliminar</td>
			</tr>
		</tfoot>

	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();
	} );
</script>

<?php }?>