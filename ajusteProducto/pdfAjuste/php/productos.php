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
$pdf->Cell(100, 8, 'LISTADO DE AJUSTE', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cantidad', 0);
$pdf->Cell(20, 8, 'Cod. Ajuste.', 0);
$pdf->Cell(50, 8, 'Motivo', 0);
$pdf->Cell(20, 8, 'Cant. Ant', 0);
$pdf->Cell(20, 8, 'Cant. Ajust..', 0);
$pdf->Cell(20, 8, 'Cant. Act.', 0);
$pdf->Cell(20, 8, 'Tipo Ajust.', 0);
$pdf->Cell(30, 8, 'Fech. Registro', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM detalle_ajuste,ajuste,productos WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and detalle_ajuste.numero_factura=ajuste.numero_factura AND detalle_ajuste.id_producto=productos.id_producto ORDER BY fecha_factura DESC";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	$nroFormat=number_format($productos2['total_venta']);
	$condiciones=$productos2['condiciones'];
	$item = $item+1;
	$totaluni = $totaluni + $productos2['total_venta'];
	$total=0;
	if($condiciones==1){
           $leyenda='AJUSTE MAS';
           $total=$productos2['total_venta']+$productos2['cantidad'];
    }elseif($condiciones==2){
           $leyenda='AJUSTE MENOS';
           $total=$productos2['total_venta']-$productos2['cantidad'];
    }
	$pdf->Cell(15, 8, $item, 0);
	$pdf->Cell(20, 8,$productos2['id_producto'], 0);
	$pdf->Cell(50, 8, $productos2['nombre_producto'], 0);
	$pdf->Cell(25, 8, $nroFormat, 0);
	$pdf->Cell(20, 8, $productos2['cantidad'], 0);
	$pdf->Cell(15, 8, $total, 0);
	$pdf->Cell(25, 8, $leyenda, 0);
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha_factura'])), 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteAjuste.pdf','D');


?>