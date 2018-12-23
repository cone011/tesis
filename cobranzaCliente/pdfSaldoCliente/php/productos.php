<?php

/*if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];

	$verDesde = date('d/m/Y', strtotime($desde));
	$verHasta = date('d/m/Y', strtotime($hasta));
}else{
	$desde = '1111-01-01';
	$hasta = '9999-12-30';

	$verDesde = '__/__/____';
	$verHasta = '__/__/____';
}*/
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
$pdf->Cell(100, 8, 'SALDO DE CLIENTES', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, '        ', 0);
$pdf->Cell(15, 8, '        ', 0);
$pdf->Cell(15, 8, '        ', 0);
$pdf->Cell(20, 8, 'Codigo', 0);
$pdf->Cell(40, 8, 'Nombre', 0);
$pdf->Cell(30, 8, 'Ruc', 0);
$pdf->Cell(20, 8, 'Monto', 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM cliente";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	
	//$condiciones=$productos2['condiciones'];
	$id_cliente=$productos2['id_cliente'];
	$item = $item+1;
	$totaluni = 0;
	$res_producto = "SELECT * FROM venta WHERE id_cliente='$id_cliente' and venta.estado_factura=2";
    $productos_cantidad = $conexion->query($res_producto);
    while($productos_precio = mysqli_fetch_array($productos_cantidad)){
    	//$nroFormat=number_format($productos_precio['saldo_factura']);
    	$totaluni = $totaluni + $productos_precio['saldo_factura'];
    }
	
	$pdf->Cell(15, 8, '', 0);
	$pdf->Cell(15, 8, '', 0);
	$pdf->Cell(15, 8, '', 0);
	$pdf->Cell(20, 8,$productos2['id_cliente'], 0);
	$pdf->Cell(40, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(30, 8, $productos2['ruc_cliente'], 0);
	$pdf->Cell(20, 8, $totaluni.'.Gs', 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteVentas.pdf','D');


?>