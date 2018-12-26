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
$pdf->Cell(65, 8, '', 0);
$pdf->Cell(100, 8, 'LISTADO DE COMPRAS PROVEEDOR', 0);
$pdf->Ln(10);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(10);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(10, 8, 'Proveedor: '.$dato, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, 'Fech. Registro', 0);
$pdf->Cell(20, 8, 'Nro Doc.', 0);
$pdf->Cell(20, 8, 'Cod Proveed', 0);
$pdf->Cell(50, 8, 'Nombre.', 0);
$pdf->Cell(30, 8, 'Total Factura', 0);
$pdf->Cell(20, 8, 'Tipo Pago', 0);
$pdf->Cell(20, 8, 'Condicion', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM compra,proveedores WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and nombre_cliente LIKE '%$dato%' and compra.id_cliente=proveedores.id_cliente order by numero_factura desc";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$mostrar='';
	$leyenda='';
	$nroFormat=number_format($productos2['total_venta']);
	$condiciones=$productos2['condiciones'];
	if($condiciones==1){
       $mostrar='CONTADO';
	}elseif($condiciones==2){
       $mostrar='CREDITO';
	}else{
	   $mostrar='ANULADO';
	}
	$tipo=$productos2['tipo_pago'];
	if($tipo==1){
       $leyenda='EFECTIVO';
	}elseif($tipo==2){
	   $leyenda='TARJETA';
	}elseif($tipo==3){
	   $leyenda='CHEQUE';
	}elseif($tipo==4){
	   $leyenda='TRANSFERENCIA';
	}elseif($tipo==5){
       $leyenda='COMBINADO';
	}
	$saldo=$productos2['saldo_factura'];
	//$item = $item+1;
	$totaluni = $totaluni + $productos2['total_venta'];
	
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha_factura'])), 0);
	$pdf->Cell(20, 8, $productos2['pf1'].'-'.$productos2['pf2'].'-'.$productos2['nrodoc'], 0);
	$pdf->Cell(20, 8, $productos2['id_cliente'], 0);
	$pdf->Cell(50, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(30, 8, $nroFormat.'.Gs', 0);
	$pdf->Cell(20, 8, $leyenda, 0);
	$pdf->Cell(20, 8, $mostrar, 0);
	$pdf->Ln(8);
}

$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(64,8,'',0);
$pdf->Cell(25,14,'Total Compra: '.number_format($totaluni,0).'.GS',0);
$pdf->Ln(8);

$pdf->Output('reporteCompraxProveedor.pdf','D');


?>