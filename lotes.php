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
            LOTES
          </div>
          <div class="card-body">
            <span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
              Nuevo Lote <span class="fa fa-plus-circle"></span>
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
          <h5 class="modal-title" id="exampleModalLabel">Nuevo Lote</h5>
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
            <label>Mensaje</label>
            <select id="idmessage" name="idmessage" class="form-control input-sm" data-toggle="modal" name="listaSementos">
                    <option value="0">seleccionar un mensaje</option>  
                    <?php require 'procesos/obtenMensajes.php' ?>
            </select>
            <label>Segmento</label>
            <select id="idsegment" name="idsegment" class="form-control input-sm" data-toggle="modal" name="listaSementos">
                    <option value="0">seleccionar un segmento</option>  
                    <?php require 'procesos/obtenSegmentos.php' ?>
            </select>
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
          <h5 class="modal-title" id="exampleModalLabel">Actualizar Lote</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="frmUpdate">
            <input type="text" hidden="" id="idlote" name="idlote">
            <label>Nombre</label>
            <input type="text" class="form-control input-sm" id="nameU" name="nameU">
            <label>Descripcion</label>
            <input type="text" class="form-control input-sm" id="descriptionU" name="descriptionU">
            <label>Mensaje</label>
            <select id="idmessageU" name="idmessageU" class="form-control input-sm" data-toggle="modal" name="listaSementos">
                    <option value="0">seleccionar un mensaje</option>  
                    <?php require 'procesos/obtenMensajes.php' ?>
            </select>
            <label>Segmento</label>
            <select id="idsegmentU" name="idsegmentU" class="form-control input-sm" data-toggle="modal" name="listaSementos">
                    <option value="0">seleccionar un segmento</option>  
                    <?php require 'procesos/obtenSegmentos.php' ?>
            </select>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Moda Mensaje -->
  <div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" hidden="" id="idmessage" name="idmessage">
            <label>Nombre</label>
            <input type="text" readonly class="form-control input-sm" id="nameM" name="nameM">
            <label>Descripcion</label>
            <textarea readonly class="form-control" rows="5" id="message" name="message"></textarea>
            <label>Media Path</label>
            <textarea readonly class="form-control" rows="2" id="mediapathM" name="mediapathM"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


   <!-- Moda Segmentos -->
  <div class="modal fade" id="modalSegmento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Segmento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" hidden="" id="idsegment" name="idsegment">
            <label>Segmento</label>
            <input type="text" readonly class="form-control input-sm" id="nameS" name="nameS">
            <label>Contactos</label>
            <div class="table table-responsive table-lista-contactos" id="tablelista"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiartabla()" >Cerrar</button>
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
        url:"procesos/agregarlote.php",
        success:function(r){
          if(r==1){
            $('#frmnuevo')[0].reset();
            $('#tablaDatatable').load('tablalotes.php');
            alertify.success("El lote se creo correctamente");
            $('#agregarnuevosdatosmodal').modal('hide');
          }else{
            alertify.error("Fallo al crear lote");
          }
        }
      });
    });

    $('#btnActualizar').click(function(){
      datos=$('#frmUpdate').serialize();

      $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/actualizarlote.php",
        success:function(r){
          if(r==1){
            $('#tablaDatatable').load('tablalotes.php');
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
    $('#tablaDatatable').load('tablalotes.php');
  });
</script>

<script type="text/javascript">
  function agregaFrmActualizar(idlote){
    $.ajax({
      type:"POST",
      data:"idlote=" + idlote,
      url:"procesos/obtenDatoslote.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#idlote').val(datos['id']);
        $('#nameU').val(datos['name']);
        $('#descriptionU').val(datos['description']);
        $('#idmessageU').val(datos['idmessage']);
        $('#idsegmentU').val(datos['idsegment']);
        }
    });
  }

   function MostrarMensaje(idmensaje){
    $.ajax({
      type:"POST",
      data:"idmensaje=" + idmensaje,
      url:"procesos/obtenDatosmsj.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#idmensaje').val(datos['id']);
        $('#nameM').val(datos['name']);
        $('#message').val(datos['message']);
        $('#mediapathM').val(datos['mediapath']);
        }
    });
  }

   function MostrarSegmento(idsegmento){
    $.ajax({
      type:"POST",
      data:"idsegmento=" + idsegmento,
      url:"procesos/obtenListaSegmento.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        
        //$('#nameS').val(datos['segmentname']);
        $('#nameS').val(datos[0].segmentname);

        var rows = [];
        for(var i = 0; i< datos.length; i++){
           rows.push(drawRow(datos[i]));
        }
        $("#tablelista").append(rows);

        }
    });
  }


function drawRow(rowData) {
    var row = $("<tr />")
    row.append($("<td>" + rowData.personname + "</td>"));
    row.append($("<td>" + rowData.personnickname + "</td>"));
    row.append($("<td>" + rowData.phone + "</td>"));
    return row;
}

function limpiartabla(){
  //alertify.error("limpiando");
  $("#tablelista").children().remove() 
}

function ActivarLote(idlote){
    $.ajax({
      type:"POST",
      data:"idlote=" + idlote,
      url:"procesos/activarLote.php",
      success:function(r){
          if(r==1){
            $('#tablaDatatable').load('tablalotes.php');
            alertify.success("Activado con exito :D");
          }else{
            alertify.error("Fallo al Activar :(");
          }
        }
    }); 
}


  function eliminarDatos(idlote){
    alertify.confirm('Eliminar lote', '¿Seguro de eliminar este lote :(?', function(){ 

      $.ajax({
        type:"POST",
        data:"idlote=" + idlote,
        url:"procesos/eliminarlote.php",
        success:function(r){
          if(r==1){
            $('#tablaDatatable').load('tablalotes.php');
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

