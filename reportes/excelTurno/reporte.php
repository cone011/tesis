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
	fputcsv($salida, array('Numero de Factura', 'Timbrado', 'Codigo Cliente', 'Nombre Cliente','Ruc', 'Total Venta', 'Tipo Pago','Fecha Facturacion'));
	// QUERY PARA CREAR EL REPORTE
	$reporteCsv=$conexion->query("SELECT *  FROM cierre where id_cierre=$fecha1");
	while($filaR= $reporteCsv->fetch_assoc()){
        $factura_incial=$filaR['factura_incial'];
        $factura_final=$filaR['factura_final'];
        echo $factura_incial;
        echo $factura_final;
		$timbrado='89455126';
		
		$datosCliente=$conexion->query("SELECT *  FROM  venta,cliente where (numero_factura>=$factura_incial and numero_factura<=$factura_final) and venta.id_cliente=cliente.id_cliente ORDER BY numero_factura");
		while($fila= $datosCliente->fetch_assoc()){
			 $leyenda='';
             $nombre=$fila['nombre_cliente'];
             $ruc=$fila['ruc_cliente'];
             $status=$fila['condiciones'];
             $codigo_cliente=$fila['id_cliente'];
             $tipo=$fila['tipo_pago'];
             $venta=$fila['total_venta'];
             $factura=$fila['numero_factura'];
		     if($tipo==1){
               $leyenda='EFECTIVO';
		    }elseif ($tipo==2) {
			   $leyenda='TARJETA';
		    }elseif ($tipo==3) {
		  	   $leyenda='CHEQUE';
		    }elseif($tipo==4){
			   $leyenda='TRANSACCION BANCARIA';
		    }
		    fputcsv($salida, array('001'.'-'.'001'.'-'.$factura, 
			                    $timbrado,
								$codigo_cliente,
								$nombre,
								$ruc,
								$venta,
								$leyenda,
								$filaR['fecha_add']));
    }
		}

}

?>