<?php

	class crud{
		public function agregar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into campaign (NAME,DESCRIPTION,USERID)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]')";
			return mysqli_query($conexion,$sql);
		}

		public function agregarLote($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into lot (NAME,DESCRIPTION,IDMESSAGE,IDSEGMENT,USERID)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]',
											'$datos[3]',
											'$datos[4]')";
			return mysqli_query($conexion,$sql);
		}

		public function agregarmsj($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into message (NAME,MESSAGE,MEDIAPATH,USERID)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]',
											'$datos[3]')";
			error_log("¡QUERY! $sql", 3, "my-errors.log");								
			return mysqli_query($conexion,$sql);
		}

		public function agregarcontacto($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into person (NAME,LASTNAME,NICKNAME,PHONE,DNI,ADDRESS,LOCATION,USERID)
				  values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]')";
			return mysqli_query($conexion,$sql);
		}

		public function agregarsegmento($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into segment (NAME,DESCRIPTION,USERID)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]')";
			return mysqli_query($conexion,$sql);
		}

		public function agregarcontactosegmento($ListaContactos,$idsegment){
			$obj= new conectar();
			$conexion=$obj->conexion();

			
			foreach ($ListaContactos as $idcontacto) {


				
				$sql="INSERT into segment_person (IDSEGMENT,IDPERSON)
									values ('$idsegment','$idcontacto')";

				//error_log("¡QUERY! $sql", 3, "my-errors.log");

				mysqli_query($conexion,$sql);							

			}


			
			return 0;
		}		



		public function obtenDatos($idcampana){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDCAMPAIGN,name,description
					from  campaign
					where IDCAMPAIGN='$idcampana'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id' => $ver[0],
				'name' => $ver[1],
				'description' => $ver[2]
				);
			return $datos;
		}

		

		public function obtenDatoslote($idlote){

			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDLOT,NAME,DESCRIPTION,IDMESSAGE,IDSEGMENT
					from  lot
					where IDLOT='$idlote'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id' => $ver[0],
				'name' => $ver[1],
				'description' => $ver[2],
				'idmessage' => $ver[3],
				'idsegment' => $ver[4]
				);
			return $datos;
		}

		public function obtenDatosmsj($idmensaje){

			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDMESSAGE,NAME,MESSAGE,MEDIAPATH
					from  message
					where IDMESSAGE='$idmensaje'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id' => $ver[0],
				'name' => $ver[1],
				'message' => $ver[2],
				'mediapath' => $ver[3]
				);
			return $datos;
		}

		public function obtenDatoscontacto($idcontacto){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT ID,NAME,LASTNAME,NICKNAME,PHONE,DNI,ADDRESS,LOCATION
					from  person
					where ID='$idcontacto'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id' => $ver[0],
				'name' => $ver[1],
				'lastname' => $ver[2],
				'nickname' => $ver[3],
				'phone' => $ver[4],
				'dni' => $ver[5],
				'address' => $ver[6],
				'location' => $ver[7]
				);
			return $datos;
		}

		public function obtenDatossegmento($idsegmento){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDSEGMENT,name,description
					from  segment
					where IDSEGMENT='$idsegmento'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
				'id' => $ver[0],
				'name' => $ver[1],
				'description' => $ver[2]
				);
			return $datos;
		}

		
		//return: la lista de personas en el segment id
		public function obtenListaSegmento($idsegmento){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT 
				        s.NAME as segmentname,
				        person.NAME as personname,
						  person.NICKNAME as personnickname,
						  PHONE as phone
			    FROM segment AS s
				 RIGHT JOIN segment_person ON segment_person.IDSEGMENT = s.IDSEGMENT 
				 RIGHT JOIN person ON segment_person.IDPERSON = person.ID
				 WHERE segment_person.IDSEGMENT = '$idsegmento'";
			$result=mysqli_query($conexion,$sql);
			//$ver=mysqli_fetch_row($result);
			//error_log("¡query! $sql", 3, "my-errors.log");
			
			$rawdata = array(); //creamos un array
			//guardamos en un array multidimensional todos los datos de la consulta
    		//$i=0;

    		 while($row = mysqli_fetch_assoc($result))
			    {
			        $rawdata[] = $row;
			        //$i++;
			    }
						
			return $rawdata;
		}


		//return: lista de segmentos por usuario
		public function listaSegmentos($user_id){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDSEGMENT,NAME from segment where USERID ='$user_id'";
			$result=mysqli_query($conexion,$sql);
			/*$ver=mysqli_fetch_row($result);*/
			//error_log("¡query! $sql", 3, "my-errors.log");
			return mysqli_query($conexion,$sql);
		}


		//return: lista de Mensajes por usuario
		public function listaMensajes($user_id){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="SELECT IDMESSAGE,NAME from message where USERID ='$user_id'";
			$result=mysqli_query($conexion,$sql);
			/*$ver=mysqli_fetch_row($result);*/
			//error_log("¡query! $sql", 3, "my-errors.log");
			return mysqli_query($conexion,$sql);
		}


		public function actualizar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE campaign set name='$datos[1]',description='$datos[2]' where IDCAMPAIGN='$datos[0]'";
			/*error_log("¡Lo echaste a perder! $sql", 3, "my-errors.log");*/
			return mysqli_query($conexion,$sql);
		}

		public function actualizarmsj($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE message set name='$datos[1]',MESSAGE='$datos[2]',MEDIAPATH='$datos[3]' where IDMESSAGE='$datos[0]'";
			/*error_log("¡Lo echaste a perder! $sql", 3, "my-errors.log");*/
			return mysqli_query($conexion,$sql);
		}

		public function actualizarcontacto($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE person set NAME='$datos[1]',LASTNAME='$datos[2]',
			NICKNAME='$datos[3]',PHONE='$datos[4]',DNI='$datos[5]',
			ADDRESS='$datos[6]',LOCATION='$datos[7]' 
			where ID='$datos[0]'";
			//error_log("Query: $sql", 3, "my-errors.log");
			return mysqli_query($conexion,$sql);
		}
		
		public function actualizarsegmento($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE segment set name='$datos[1]',description='$datos[2]' where IDSEGMENT='$datos[0]'";
			/*error_log("¡QUERY! $sql", 3, "my-errors.log");*/
			return mysqli_query($conexion,$sql);
		}

		public function actualizarlote($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE lot set name='$datos[1]',description='$datos[2]',idmessage='$datos[3]',idsegment='$datos[4]' where IDLOT='$datos[0]'";
			//error_log("¡QUERY! $sql", 3, "my-errors.log");
			return mysqli_query($conexion,$sql);
		}

		public function eliminar($idcampana){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from campaign where IDCAMPAIGN='$idcampana'";
			return mysqli_query($conexion,$sql);
		}

		public function eliminarmsj($idmensaje){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from message where IDMESSAGE='$idmensaje'";
			return mysqli_query($conexion,$sql);
		}

		public function eliminarcontacto($idcontacto){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from person where ID='$idcontacto'";
			return mysqli_query($conexion,$sql);
		}

		public function eliminarsegmento($idsegmento){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from segment where IDSEGMENT='$idsegmento'";
			return mysqli_query($conexion,$sql);
		}

		public function eliminarContSegmento($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from segment_person where IDPERSON = '$datos[0]' and IDSEGMENT='$datos[1]'";
			/*error_log("¡QUERY! $sql", 3, "my-errors.log");*/
			return mysqli_query($conexion,$sql);
		}

		public function eliminarlote($idlote){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from lot where IDLOT='$idlote'";
			return mysqli_query($conexion,$sql);
		}

		public function ActivarLote($idlote,$userid){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE lot SET STATUS = 0 WHERE USERID = '$userid'";
			mysqli_query($conexion,$sql);

			$sql1="UPDATE lot SET STATUS = 1 WHERE IDLOT = '$idlote' and USERID = '$userid'";
			//error_log("¡QUERY! $sql", 3, "my-errors.log");
			return mysqli_query($conexion,$sql1);
		}
	}

 ?>