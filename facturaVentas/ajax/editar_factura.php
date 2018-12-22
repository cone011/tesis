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
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['condiciones']) &&
			$_POST['estado_factura']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		require("fpdf/fpdf.php");
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_cliente=intval($_POST['id_cliente']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$condiciones=intval($_POST['condiciones']);
		$pago=intval($_POST['pago']);
		$efectivo=intval($_POST['efectivo']);
		$tarjeta=intval($_POST['tarjeta']);
		$cheque=intval($_POST['cheque']);
		$transferencia=intval($_POST['transferencia']);
		/*echo $pago;
		echo $efectivo;
		echo $tarjeta;
		echo $cheque;*/
		//echo $transferencia;
		$date=date("Y-m-d H:i:s");
		//$estado_factura=intval($_POST['estado_factura']);
        $estado_factura=intval($_POST['estado_factura']);
       //$insert=mysqli_query($con,"INSERT INTO saldo_cliente VALUES (NULL,'$id_factura','$estado_factura','1000','$id_cliente','$date')");
		$sql_user=mysqli_query($con,"select * from venta where id_factura='$id_factura'");
	    //$rw_user=mysqli_fetch_array($sql_user);
	     while ($rw_user=mysqli_fetch_array($sql_user))
	      {
               $monto=$rw_user['saldo_factura'];
               $factura=$rw_user['numero_factura'];
	      }

          //echo $desc;
          if($estado_factura<$monto){
          	//echo $monto_cuenta;
          	$total=$monto-$estado_factura;
          	$estado=2;
          }elseif($estado_factura==$monto){
            $total=0;
          	$estado=1;
          }
             if($estado_factura<=0){
               $validar=0;
             }else{
             	$date=date("Y-m-d H:i:s");
            //SALDO DE CLIETNES
             //$insert=mysqli_query($con,"INSERT INTO saldo VALUES (NULL,'$id_factura','$estado_factura','$total','$id_cliente','$date')");
             $insert=mysqli_query($con,"INSERT INTO saldo_cliente VALUES (NULL,'$id_factura','$estado_factura','$total','$id_cliente','$date','$date','$pago','$efectivo','$tarjeta','$cheque','$transferencia')");
		    $estado_factura=intval($_POST['estado_factura']);

		    //CUENTA CLIENTE
            $sql_cliente="UPDATE cuentacliente SET saldo_factura='".$total."' WHERE numero_factura='".$factura."'";
		    $query_update = mysqli_query($con,$sql_cliente);
     

             //FACTURA VENTA
		     $sql="UPDATE venta SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', condiciones='".$condiciones."', estado_factura='".$estado."', saldo_factura='".$total."' WHERE id_factura='".$id_factura."'";
		      $query_update = mysqli_query($con,$sql);
                 

		      $validar=1;
             }


			if ($validar==1){
				$messages[] = "Factura ha sido amortizada satisfactoriamente.";
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