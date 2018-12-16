<?php
include('conexion.php');//CONEXION A LA BD

$fecha1=$_POST['fecha1'];
$fecha2=$_POST['fecha2'];

if(isset($_POST['generar_reporte']))
{
	// NOMBRE DEL ARCHIVO Y CHARSET
	header('Content-Type:text/xls; charset=latin1');
	header('Content-Disposition: attachment; filename="Reporte_Fechas_NCPROVEEDOR.xls"');

	// SALIDA DEL ARCHIVO
	$salida=fopen('php://output', 'w');
	// ENCABEZADOS
	fputcsv($salida, array('Numero de NC', 'Timbrado', 'Nro O.C.','Nombre Proveedor','Ruc',' Total Factura', 'Monto Aplicado.', 'Saldo Sobrante', 'Fecha Facturacion'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM detalle_np where (fecha BETWEEN '$fecha1' AND '$fecha2') ORDER BY numero_factura");
	while($filaR= $reporteCsv->fetch_assoc()){
		$codigo=$filaR['numero_factura'];
		$datosCliente=$conexion->query("SELECT *  FROM  compra,proveedores where numero_factura=$codigo and compra.id_cliente=proveedores.id_cliente ORDER BY numero_factura");
		           while($fila= $datosCliente->fetch_assoc()){
                     $nombre=$fila['nombre_cliente'];
                     $ruc=$fila['ruc_cliente'];
                     $monto=$fila['total_venta'];
		            }
		$iva10=0;
		$iva05=0;
		$timbrado='89455126';
		fputcsv($salida, array($filaR['numero_factura'], 
			                    $timbrado,
			                    '001'.'-'.'001'.'-'.$filaR['id_producto'], 
								$nombre,
								$ruc,
								$monto,
								$filaR['cantidad'],
								$filaR['precio_venta'],
								$filaR['fecha']));
    }
}

?>