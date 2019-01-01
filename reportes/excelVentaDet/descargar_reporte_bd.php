<?php
///// INCLUIR LA CONEXIÓN A LA BD /////////////////
include('conexion.php');
///// CONSULTA A LA BASE DE DATOS /////////////////
$alumnos="SELECT * FROM detalle_venta,productos where year(fecha) = 2018 and detalle_venta.id_producto=productos.id_producto ORDER BY numero_factura DESC";
$resAlumnos=$conexion->query($alumnos);
?>

<html lang="es">
	<head>
		<title>Excel de Detallada Ventas Realizadas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link href="css/estilos.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>
	<body>

		<?php include "navbar.php"; ?>
		<header>
			<div class="alert alert-info">
			<h2>Excel de Detallada Ventas Realizadas</h2>
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
					<th>Monto</th>
					<th>Fecha de Facturacion</th>
				</tr>
				<?php
				while ($registroAlumnos = $resAlumnos->fetch_array(MYSQLI_BOTH))
				{ 
					$codigo =$registroAlumnos['numero_factura'];
					$datosCliente=$conexion->query("SELECT *  FROM  venta,cliente where numero_factura=$codigo and venta.id_cliente=cliente.id_cliente ORDER BY numero_factura");
		           while($fila= $datosCliente->fetch_assoc()){
                     $nombre=$fila['telefono_cliente'];
                     $ruc=$fila['nombre_cliente'];
		            }
                    //$iva=($registroAlumnos['total_venta']/1.1)*0.1;
                    $nroFormat=number_format($registroAlumnos['precio_venta']);
                    //$nroIva=number_format($iva);
					$factura = '001'.'-'.'001'.'-'.$registroAlumnos['numero_factura'];
					echo'<tr>
						 <td>'.$factura.'</td>
						 <td>'.$nombre.'</td>
						 <td>'.$ruc.'</td>
						 <td>'.$nroFormat.'</td>
						 <td>'.$registroAlumnos['fecha'].'</td>
						 </tr>';
				}
				?>
			</table>
		</section>

	</body>
</html>


