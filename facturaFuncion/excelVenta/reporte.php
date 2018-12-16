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
	fputcsv($salida, array('Numero de Documento', 'Timbrado', 'Codigo Producto', 'Nombre Producto', 'Codigo Cliente', 'Nombre Cliente','Ruc', 'Precio', 'Iva 10%', 'Iva 05%', 'Fecha Facturacion'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM detalle_venta,productos where (fecha BETWEEN '$fecha1' AND '$fecha2') and detalle_venta.id_producto=productos.codigo_producto ORDER BY numero_factura");
	while($filaR= $reporteCsv->fetch_assoc()){
		$iva_status=$filaR['iva_producto'];
		$codigo=$filaR['numero_factura'];
		$iva10=0;
		$iva05=0;
		$timbrado='89455126';
	    if($iva_status==1){
			$iva10=($filaR['precio_venta']/1.1)*0.1;
		}elseif($iva_status==2){
            $iva05=($filaR['precio_venta']/1.05)*0.1;
		}elseif($iva_status==3){
			$iva=0;
		}
		$datosCliente=$conexion->query("SELECT *  FROM  venta,cliente where numero_factura=$codigo and venta.id_cliente=cliente.id_cliente ORDER BY numero_factura");
		while($fila= $datosCliente->fetch_assoc()){
             $nombre=$fila['nombre_cliente'];
             $ruc=$fila['ruc_cliente'];
             $status=$fila['condiciones'];
             $codigo_cliente=$fila['id_cliente'];
		}
		fputcsv($salida, array('001'.'-'.'001'.'-'.$filaR['numero_factura'], 
			                    $timbrado,
								$filaR['codigo_producto'],
								$filaR['nombre_producto'],
								$codigo_cliente,
								$nombre,
								$ruc,
								$filaR['precio_venta'],
								$iva10,
								$iva05,
								$filaR['fecha']));
    }
}

?>