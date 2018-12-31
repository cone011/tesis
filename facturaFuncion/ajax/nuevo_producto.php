<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado del producto";
		} else if (empty($_POST['precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (
			
			!empty($_POST['nombre']) &&
			$_POST['estado']!="" &&
			!empty($_POST['precio'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		//$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$estado=intval($_POST['estado']);
		$precio_venta=floatval($_POST['precio']);
		//$iva=intval($_POST['iva']);
		$date_added=date("Y-m-d H:i:s");
		//COBRANZA
		$sql_factura=mysqli_query($con,"SELECT * FROM cierre order by id_cierre desc limit 1");
		while ($rw=mysqli_fetch_array($sql_factura)){
			$cobranza_inicial=$rw["cobranza_final"]+1;
		}
		$sql_factura_venta=mysqli_query($con,"select * from cobranza order by numero_factura desc limit 1");
		while ($raw=mysqli_fetch_array($sql_factura_venta)){
				$cobranza_final=$raw["numero_factura"];
		}

        //COMPRAS
        $sql_compra=mysqli_query($con,"SELECT * FROM cierre order by id_cierre desc limit 1");
		while ($rw=mysqli_fetch_array($sql_compra)){
			$compra_inicial=$rw["compra_final"]+1;
		}
		$sql_factura_venta=mysqli_query($con,"select * from compra order by numero_factura desc limit 1");
		while ($raw=mysqli_fetch_array($sql_factura_venta)){
				$compra_final=$raw["numero_factura"];
		}

		$sql="INSERT INTO cierre (factura_incial, factura_final, fecha_add, cobranza_inicial, cobranza_final,compra_inicial,compra_final) VALUES ('$nombre','$estado','$date_added','$cobranza_inicial','$cobranza_final','$compra_inicial','$compra_final')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Cierre se ha sido concretado satisfactoriamente.";
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