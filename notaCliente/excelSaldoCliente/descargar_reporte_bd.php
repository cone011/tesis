<?php
///// INCLUIR LA CONEXIÓN A LA BD /////////////////
include('conexion.php');
///// CONSULTA A LA BASE DE DATOS /////////////////
$alumnos="SELECT * FROM saldo_cliente,cliente where year(fecha) = 2018 and saldo_cliente.id_cliente=cliente.id_cliente order by id_factura DESC";
$resAlumnos=$conexion->query($alumnos);
?>

<html lang="es">
	<head>
		<title>Excel de Saldo Nro Factura Realizadas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link href="css/estilos.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>
	<body>

		<?php include "navbar.php"; ?>
		<header>
			<div class="alert alert-info">
			<h2>Excel de Saldo Nro Factura Realizadas</h2>
			</div>
		</header>
		<section>
			<form method="post" class="form" action="reporte.php">
		    <input type="date" name="fecha1">
		    <input type="date" name="fecha2">
		    <input type="submit" class="btn btn-primary" name="generar_reporte">
		    </form>

			<table class="table">
				<tr class="bg-primary">
					<th>Numero Factura</th>
					<th>Cliente</th>
					<th>Ruc</th>
					<th>Total Doc.</th>
					<th>Fecha de Facturacion</th>
				</tr>
				<?php
				while ($registroAlumnos = $resAlumnos->fetch_array(MYSQLI_BOTH))
				{
					//CEROS PARA EL PREFIJO 1
                    /*if(strlen($registroAlumnos["pf1"])==1){
                       $wpf1='00';
                    }else{
                       $wpf1='0';
                    }
                    //CEROS PARA EL PREFIJO 2
                    if(strlen($registroAlumnos["pf2"])==1){
                       $wpf2='00';
                    }else{
                        $wpf2='0';
                    }*/
                    //$iva=($registroAlumnos['total_venta']/1.1)*0.1;
                    //$nroFormat=number_format($registroAlumnos['total_venta']);
                    //$nroIva=number_format($iva);
					$factura = '001'.'-'.'001'.'-'.$registroAlumnos['numero_factura'];
					echo'<tr>
						 <td>'.$factura.'</td>
						 <td>'.$registroAlumnos['telefono_cliente'].'</td>
						 <td>'.$registroAlumnos['ruc_cliente'].'</td>
						 <td>'.$registroAlumnos['total_venta'].'</td>
						 <td>'.$registroAlumnos['fecha_factura'].'</td>
						 </tr>';
				}
				?>
			</table>
		</section>

	</body>
</html>


