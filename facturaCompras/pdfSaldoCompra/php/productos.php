<?php

if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];

	$verDesde = date('d/m/Y', strtotime($desde));
	$verHasta = date('d/m/Y', strtotime($hasta));
}else{
	$desde = '1111-01-01';
	$hasta = '9999-12-30';

	$verDesde = '__/__/____';
	$verHasta = '__/__/____';
}
require('../fpdf/fpdf.php');
require('conexion.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../recursos/tienda.gif' , 10 ,8, 10 , 13,'GIF');
$pdf->Cell(18, 10, '', 0);
$pdf->Cell(150, 10, '', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Hoy: '.date('d-m-Y').'', 0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(70, 8,'LISTADO DE NC PROVEEDOR', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cantidad', 0);
$pdf->Cell(20, 8, 'Nro NC', 0);
$pdf->Cell(40, 8, 'Nombre', 0);
$pdf->Cell(20, 8, 'Ruc', 0);
$pdf->Cell(20, 8, 'Nro O.C.', 0);
$pdf->Cell(23, 8, 'Saldo Original', 0);
$pdf->Cell(20, 8, 'Monto Apli.', 0);
$pdf->Cell(20, 8, 'Saldo Sobr.', 0);
$pdf->Cell(30, 8, 'Fech. Venci.', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM detalle_np WHERE fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha DESC";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	$codigo=$productos2['id_producto'];
        //$saldo=$registro2['cantidad'];
		 $res_factura = "SELECT * FROM compra,proveedores WHERE numero_factura=$codigo and compra.id_cliente=proveedores.id_cliente";
         $registro_factura = $conexion->query($res_factura);
         while($registro_fact = mysqli_fetch_array($registro_factura)){
            $monto=$registro_fact['total_venta'];
            //$telefono_cliente=$registro_fact['telefono_cliente'];
            $nombre_cliente=$registro_fact['nombre_cliente'];
            $ruc_cliente=$registro_fact['ruc_cliente'];
         }
	$nroFormat=number_format($productos2['precio_venta']);
	/*$condiciones=$productos2['condiciones'];
	$fecha=$productos2['fecha_vencimiento'];*/
	$item = $item+1;
	$pdf->Cell(15, 8, $item, 0);
	$pdf->Cell(20, 8,$productos2['numero_factura'], 0);
	$pdf->Cell(40, 8, $nombre_cliente, 0);
	$pdf->Cell(20, 8, $ruc_cliente, 0);
	$pdf->Cell(20, 8, $productos2['id_producto'], 0);
	$pdf->Cell(23, 8, $monto, 0);
	$pdf->Cell(20, 8, $productos2['cantidad'], 0);
	$pdf->Cell(20, 8, $nroFormat.'.Gs', 0);
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha'])), 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteCtaCteCliente.pdf','D');


?>