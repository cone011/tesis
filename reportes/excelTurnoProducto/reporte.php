<?php
include('conexion.php');//CONEXION A LA BD

$fecha1=$_POST['fecha1'];
//$fecha2=$_POST['fecha2'];

if(isset($_POST['generar_reporte']))
{
	// NOMBRE DEL ARCHIVO Y CHARSET
	header('Content-Type:text/xls; charset=latin1');
	header('Content-Disposition: attachment; filename="Reporte_Fechas_Venta.xls"');

	// SALIDA DEL ARCHIVO
	$salida=fopen('php://output', 'w');
	// ENCABEZADOS
	fputcsv($salida, array('Numero de Factura', 'Timbrado', 'Codigo Producto', 'Nombre Producto','Cantidad','Fecha Facturacion'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM cierre where id_cierre=$fecha1");
	while($filaR= $reporteCsv->fetch_assoc()){
        $factura_incial=$filaR['factura_incial'];
        $factura_final=$filaR['factura_final'];
        echo $factura_incial;
        echo $factura_final;
		$timbrado='89455126';
		
		$datosCliente=$conexion->query("SELECT *  FROM  detalle_venta,productos where (numero_factura>=$factura_incial and numero_factura<=$factura_final) and detalle_venta.id_producto=productos.id_producto ORDER BY numero_factura");
		while($fila= $datosCliente->fetch_assoc()){
			 $nombre='';
			 $codigo_producto=$fila['codigo_producto'];
             $nombre=$fila['nombre_producto'];
             $cantidad=$fila['cantidad'];
             $factura=$fila['numero_factura'];
		    fputcsv($salida, array('001'.'-'.'001'.'-'.$factura, 
			                    $timbrado,
								$codigo_producto,
								$nombre,
								$cantidad,
								$filaR['fecha_add']));
    }
		}

}

?>