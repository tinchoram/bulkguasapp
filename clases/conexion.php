<?php 
	
  class conectar{
		  
      public function conexion(){
          $conexion=mysqli_connect( 'localhost:3306',
										                'admin',
										                'password',
										                'bulk_db');
			
          $conexion->set_charset('utf8');
			    return $conexion;
		}
    
	}

 ?>
