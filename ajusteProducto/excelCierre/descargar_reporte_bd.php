<?php
///// INCLUIR LA CONEXIÓN A LA BD /////////////////
include('conexion.php');
///// CONSULTA A LA BASE DE DATOS /////////////////
$alumnos="SELECT * FROM cierre where year(fecha_add) = 2018";
$resAlumnos=$conexion->query($alumnos);
?>

<html lang="es">
	<head>
		<title>Excel de Cierre Turno Realizadas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link href="css/estilos.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>
	<body>

		<?php include "navbar.php"; ?>
		<header>
			<div class="alert alert-info">
			<h2>Excel de Cierre Turno Realizadas</h2>
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
					<th>Numero Cierre</th>
					<th>Factura Inicial</th>
					<th>Factura Final</th>
					<th>Monto Contado</th>
					<th>Monto Credito</th>
					<th>Monto Anulado</th>
					<th>Total.</th>
					<th>Fecha de Cierre</th>
				</tr>
				<?php
				while ($registroAlumnos = $resAlumnos->fetch_array(MYSQLI_BOTH))
				{
					$incial=$registroAlumnos['factura_incial'];
					$final=$registroAlumnos['factura_final'];
					$total=0;
					$monto_contado=0;
					$monto_credito=0;
					$monto_anulado=0;
					$total=0;
					$datosCliente=$conexion->query("SELECT *  FROM  venta where numero_factura>=$incial and numero_factura<=$final");
		           while($fila= $datosCliente->fetch_assoc()){
                     $condicion=$fila['condiciones'];
                     $monto=$fila['total_venta'];
                     if($condicion==1){
                       $monto_contado+=$monto;
                       $total+=$monto;
                     }elseif($condicion==2){
                       $monto_credito+=$monto;
                       $total+=$monto;
                     }else{
                     	$monto_anulado+=$monto;
                        $total+=$monto;
                     }
		            }
					$factura = $registroAlumnos['id_cierre'];
					echo'<tr>
						 <td>'.$factura.'</td>
						 <td>'.$incial.'</td>
						 <td>'.$final.'</td>
						 <td>'.$monto_contado.'</td>
						 <td>'.$monto_credito.'</td>
						 <td>'.$monto_anulado.'</td>
						 <td>'.$total.'</td>
						 <td>'.$registroAlumnos['fecha_add'].'</td>
						 </tr>';
				}
				?>
			</table>
		</section>

	</body>
</html>


