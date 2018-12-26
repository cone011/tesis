<?php
if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	//$dato = $_GET['dato'];
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
$pdf->Cell(67, 8, '', 0);
$pdf->Cell(100, 8, 'LISTADO DE PRODUCT x FECHA', 0);
$pdf->Ln(10);
$pdf->Cell(65, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, 'Codig Product.', 0);
$pdf->Cell(50, 8, 'Nombre.', 0);
$pdf->Cell(30, 8, 'Cantidad', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA


$res = "SELECT * FROM productos";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$cantidad=0;
	$codigo=$productos2['id_producto'];
	$res_producto = "SELECT * FROM detalle_compra WHERE fecha BETWEEN '$desde' AND '$hasta' and id_producto='$codigo' order by numero_factura desc";
	$productos_compra = $conexion->query($res_producto);
    while($productos_comprado = mysqli_fetch_array($productos_compra)){
         $cantidad+=$productos_comprado['cantidad'];
    }
	
	$pdf->Cell(30, 8, $productos2['id_producto'], 0);
	$pdf->Cell(50, 8, $productos2['nombre_producto'], 0);
	$pdf->Cell(30, 8, $cantidad, 0);
	$pdf->Ln(8);
}

$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(64,8,'',0);
/*$pdf->Cell(25,14,'Total Compra: '.number_format($totaluni,0).'.GS',0);
$pdf->Ln(8);*/

$pdf->Output('reporteCompraXcantidad.pdf','D');


?>