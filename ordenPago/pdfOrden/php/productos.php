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
$pdf->Cell(55, 8, '', 0);
$pdf->Cell(100, 8, 'LISTADO DE PAGOS A PROVEEDORES', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Ln(23);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(5, 8, '   ', 0);
$pdf->Cell(20, 8, 'Nro Recibo', 0);
$pdf->Cell(25, 8, 'Fecha Recibo', 0);
$pdf->Cell(20, 8, 'Nro Fact.', 0);
$pdf->Cell(20, 8, 'Cod. Prov.', 0);
$pdf->Cell(40, 8, 'Nombre', 0);
$pdf->Cell(30, 8, 'Ruc', 0);
$pdf->Cell(20, 8, 'Total Recibido', 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM op,proveedores where op.id_cliente=proveedores.id_cliente and fecha BETWEEN '$desde' AND '$hasta'";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	
	//$condiciones=$productos2['condiciones'];
	$id_cliente=$productos2['id_cliente'];
	$nro=$productos2['numero_venta'];
	$res_factura = "SELECT * FROM compra where numero_factura='$nro'";
    $productos_factura = $conexion->query($res_factura);
    while($productos_factura2 = mysqli_fetch_array($productos_factura)){
       $fact=$productos_factura2['pf1'].'-'.$productos_factura2['pf2'].'-'.$productos_factura2['nrodoc'];
    } 
	$item = $item+1;
	//$totaluni = 0;
	$pdf->Cell(5, 8, '   ', 0);
	$pdf->Cell(20, 8,$productos2['numero_factura'], 0);
	$pdf->Cell(25, 8,$productos2['fecha'], 0);
	$pdf->Cell(20, 8,$fact, 0);
	$pdf->Cell(20, 8,$productos2['id_cliente'], 0);
	$pdf->Cell(40, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(30, 8, $productos2['ruc_cliente'], 0);
	$pdf->Cell(20, 8, $productos2['cantidad_op'].'.Gs', 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteVentas.pdf','D');


?>