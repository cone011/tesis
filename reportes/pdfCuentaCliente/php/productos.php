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
$pdf->Cell(100, 8, 'LISTADO DE CUENTA CLIENTE', 0);
$pdf->Ln(10);
$pdf->Cell(65, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(10);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(10, 8, 'Cliente: '.$dato, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, 'Fech. Registro', 0);
$pdf->Cell(20, 8, 'Tipo', 0);
$pdf->Cell(20, 8, 'Nro Factura', 0);
$pdf->Cell(20, 8, 'Nro Pago.', 0);
$pdf->Cell(30, 8, 'Monto Factura', 0);
$pdf->Cell(20, 8, 'Saldo Factura', 0);
$pdf->Cell(20, 8, 'Pago', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM detalle_cuenta_cliente,cliente WHERE FECHA BETWEEN '$desde' AND '$hasta' and telefono_cliente LIKE '%$dato%' and detalle_cuenta_cliente.ID_CLIENTE=cliente.id_cliente";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$mostrar='';
	$nroFormat=number_format($productos2['MONTO_TOTAL']);
	$saldo=number_format($productos2['SALDO_FACTURA']);
	

	
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['FECHA'])), 0);
	$pdf->Cell(20, 8, $productos2['TIPO'], 0);
	$pdf->Cell(20, 8, $productos2['NRO_FACTURA'], 0);
	$pdf->Cell(20, 8, $productos2['NRO_PAGO'], 0);
	$pdf->Cell(30, 8, $nroFormat.'.Gs', 0);
	$pdf->Cell(20, 8, $saldo.'.Gs', 0);
	$pdf->Cell(20, 8, $productos2['FORMA_DE_PAGO'], 0);
	$pdf->Ln(8);
}

$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(64,8,'',0);
/*$pdf->Cell(25,14,'Total Venta: '.number_format($totaluni,0).'.GS',0);
$pdf->Ln(8);*/

$pdf->Output('reporteCuentaXcliente.pdf','D');


?>