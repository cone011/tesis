<?php
include('conexion.php');//CONEXION A LA BD

$fecha1=$_POST['fecha1'];
$fecha2=$_POST['fecha2'];

if(isset($_POST['generar_reporte']))
{
	// NOMBRE DEL ARCHIVO Y CHARSET
	header('Content-Type:text/xls; charset=latin1');
	header('Content-Disposition: attachment; filename="Reporte_Fechas_Venta.xls"');

	// SALIDA DEL ARCHIVO
	$salida=fopen('php://output', 'w');
	// ENCABEZADOS
	fputcsv($salida, array('Numero de Documento', 'Timbrado', 'Codigo Cliente', 'Nombre Cliente','Ruc', 'Precio', 'Fecha Facturacion'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM venta,cliente where (fecha_factura BETWEEN '$fecha1' AND '$fecha2') and venta.id_cliente=cliente.id_cliente ORDER BY numero_factura");
	while($filaR= $reporteCsv->fetch_assoc()){
		//$iva_status=$filaR['iva_producto'];
		$codigo=$filaR['numero_factura'];
		$iva10=0;
		$iva05=0;
		$timbrado='89455126';
		fputcsv($salida, array('001'.'-'.'001'.'-'.$filaR['numero_factura'], 
			                    $timbrado,
								$filaR['id_cliente'],
								$filaR['telefono_cliente'],
								$filaR['nombre_cliente'],
								$filaR['total_venta'],
								$filaR['fecha_factura']));
    }
}

?>