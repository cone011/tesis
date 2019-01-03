<?php
if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$dato = $_GET['dato'];
	//$tipo = $_GET['tipo'];

	//echo $tipo;

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
$pdf->Cell(100, 8, 'LISTADO DE COMPRA PRODUCTO', 0);
$pdf->Ln(10);
$pdf->Cell(65, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(10);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(10, 8, 'PRODUCTO: '.$dato, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, 'Fech. Registro', 0);
$pdf->Cell(20, 8, 'Nro Compra.', 0);
$pdf->Cell(20, 8, 'Cod Prodc', 0);
$pdf->Cell(50, 8, 'Nombre.', 0);
$pdf->Cell(30, 8, 'Cantidad', 0);
$pdf->Cell(20, 8, 'Precio Unit.', 0);
$pdf->Cell(20, 8, 'Total', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM compras_x_producto  WHERE FECHA BETWEEN '$desde' AND '$hasta' and PRODUCTO LIKE '%$dato%' order by NUMERO_COMPRA desc";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$nroFormat=number_format($productos2['PRECIO_UNITARIO']);
	$total=number_format($productos2['PRECIO_UNITARIO']*$productos2['CANTIDAD']);	
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['FECHA'])), 0);
	$pdf->Cell(20, 8, $productos2['NUMERO_COMPRA'], 0);
	$pdf->Cell(20, 8, $productos2['ID_PRODUCTO'], 0);
	$pdf->Cell(50, 8, $productos2['PRODUCTO'], 0);
	$pdf->Cell(30, 8, number_format($productos2['CANTIDAD'],2), 0);
	$pdf->Cell(20, 8, $nroFormat, 0);
	$pdf->Cell(20, 8, $total, 0);
	$pdf->Ln(8);
	$totaluni+=$total;
}

$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(64,8,'',0);
/*$pdf->Cell(25,14,'Total Venta: '.number_format($totaluni,0).'.GS',0);
$pdf->Ln(8);*/

$pdf->Output('reporteCompraXProducto.pdf','D');


?>