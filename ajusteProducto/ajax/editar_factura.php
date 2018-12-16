<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_factura= $_SESSION['id_factura'];
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_cliente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['id_vendedor'])) {
           $errors[] = "Selecciona el vendedor";
        } else if (empty($_POST['condiciones'])){
			$errors[] = "Selecciona forma de pago";
		} else if ($_POST['estado_factura']==""){
			$errors[] = "Selecciona el estado de la factura";
		}else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['condiciones']) &&
			$_POST['estado_factura']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_cliente=intval($_POST['id_cliente']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$condiciones=intval($_POST['condiciones']);

		$estado_factura=intval($_POST['estado_factura']);
		
		$sql="UPDATE ajuste SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', condiciones='".$condiciones."', estado_factura='".$estado_factura."' WHERE id_factura='".$id_factura."'";
		$query_update = mysqli_query($con,$sql);
        
        $sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
	    $rw_user=mysqli_fetch_array($sql_user);
		//echo $rw_user['firstname']." ".$rw_user['lastname'];
        $quien=$rw_user['firstname']." ".$rw_user['lastname'];

		/*$sqlauditoria=mysqli_query($con, "select * from  compra where id_factura='".$id_factura."'");
	      while ($row=mysqli_fetch_array($sqlauditoria))
	      {
	       $cliente=$row["id_cliente"];
	       $numero_factura=$row['numero_factura'];
	       $vend=$row['id_vendedor'];
	       $condicion=$row['condiciones'];
	       $venta=$row['total_venta'];
	       echo "$venta";
	       $status=$row['estado_factura'];
           $fechaudi=date("Y-m-d H:i:s");
           $pcname=gethostname();
           $accion='MODIFCADO';
	       $insert_audi=mysqli_query($con, "INSERT INTO audicompra (numero_factura,fecha_factura,id_cliente,id_vendedor,condiciones,total_venta,estado_factura,fecha_realizada,quien,donde,accion) VALUES ('$numero_factura','$fechaudi','$cliente','$vend','$condicion','$venta','$status','$fechaudi','$quien','$pcname','$accion')");
          }*/
		
		if ($query_update){
				$messages[] = "Factura ha sido actualizada satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>