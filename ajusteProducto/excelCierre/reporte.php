<?php
include('conexion.php');//CONEXION A LA BD

$fecha1=$_POST['fecha1'];
$fecha2=$_POST['fecha2'];

if(isset($_POST['generar_reporte']))
{
	// NOMBRE DEL ARCHIVO Y CHARSET
	header('Content-Type:text/xls; charset=latin1');
	header('Content-Disposition: attachment; filename="Reporte_Fechas_Cierre.xls"');

	// SALIDA DEL ARCHIVO
	$salida=fopen('php://output', 'w');
	// ENCABEZADOS
	fputcsv($salida, array('Numero de Cierre', 'Factura Inicial', 'Factura Final','Monto Contado','Monto Credito','Monto Anulado','Total', 'Fecha Cierre'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM cierre where (fecha_add BETWEEN '$fecha1' AND '$fecha2')");
	while($filaR= $reporteCsv->fetch_assoc()){
		//$codigo=$filaR['numero_factura'];
		$incial=$filaR['factura_incial'];
		$final=$filaR['factura_final'];
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
		fputcsv($salida, array($filaR['id_cierre'], 
			                    $filaR['factura_incial'],
			                    $filaR['factura_final'], 
								$monto_contado,
								$monto_credito,
								$monto_anulado,
								$total,
								$filaR['fecha_add']));
    }
}

?>