<?php 
 /* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();;
$id=$_POST['id'];
 $delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");

?>