<?php

if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$dato = $_GET['dato'];

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
$pdf->Cell(100, 8, 'LISTADO DE FACTURAS VENTAS', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Cantidad', 0);
$pdf->Cell(50, 8, 'Nombre', 0);
$pdf->Cell(20, 8, 'Ruc', 0);
$pdf->Cell(30, 8, 'Nro Doc.', 0);
$pdf->Cell(20, 8, 'Monto', 0);
$pdf->Cell(20, 8, 'Forma', 0);
$pdf->Cell(20, 8, 'Estado', 0);
$pdf->Cell(30, 8, 'Fech. Registro', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM venta,cliente WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and nombre_cliente LIKE '%$dato%' and venta.id_cliente=cliente.id_cliente order by numero_factura desc";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$mostrar='';
	$nroFormat=number_format($productos2['total_venta']);
	$condiciones=$productos2['condiciones'];
	$tipo=$productos2['tipo_pago'];
	$item = $item+1;
	$totaluni = $totaluni + $productos2['total_venta'];
	if($condiciones==1){
		$leyenda='CONTADO';
	}elseif($condiciones==2){
		$leyenda='CREDITO';
	}elseif($condiciones==999){
		$leyenda='ANULADA';
	}
	if($tipo==1){
       $mostrar='EFECTIVO';
	}elseif($tipo==2){
	   $mostrar='TARJETA';
	}elseif($tipo==3){
       $mostrar='CHEQUE';
	}elseif($tipo==4){
       $mostrar='TRANSFERENCIA';
	}elseif($tipo==5){
       $mostrar='COMBINADO';
	}
	$pdf->Cell(15, 8, $item, 0);	
	$pdf->Cell(50, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(20, 8, $productos2['ruc_cliente'], 0);
	$pdf->Cell(30, 8, '001'.'-'.'001'.'-'.$productos2['numero_factura'], 0);
	$pdf->Cell(20, 8, $nroFormat.'.Gs', 0);
	$pdf->Cell(20, 8,$mostrar, 0);
	$pdf->Cell(20, 8, $leyenda, 0);
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha_factura'])), 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteVentas.pdf','D');


?>