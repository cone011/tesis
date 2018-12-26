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
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'LISTADO DE AJUSTE x FECHA', 0);
$pdf->Ln(10);
$pdf->Cell(65, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 8, 'Fech. Ajuste', 0);
$pdf->Cell(20, 8, 'Nro Ajust.', 0);
$pdf->Cell(20, 8, 'Nro Respaldo.', 0);
$pdf->Cell(20, 8, 'Cod Product.', 0);
$pdf->Cell(40, 8, 'Nombre.', 0);
$pdf->Cell(20, 8, 'Exist Ant.', 0);
$pdf->Cell(20, 8, 'Exist Act.', 0);
$pdf->Cell(20, 8, 'Tipo', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM detalle_ajuste,productos WHERE fecha BETWEEN '$desde' AND '$hasta'  and detalle_ajuste.id_producto=productos.id_producto order by numero_factura desc";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;

while($productos2 = mysqli_fetch_array($productos)){
	$mostrar='';
	$numero_factura=$productos2['numero_factura'];
	$cantidad=0;
	$res_ajuste = "SELECT * FROM ajuste WHERE numero_factura='$numero_factura'";
     $productos_ajuste = $conexion->query($res_ajuste);
     while($ajustado = mysqli_fetch_array($productos_ajuste)){
           $condiciones=$ajustado['condiciones'];
           if($condiciones==1){
              $cantidad=$productos2['precio_venta']+$productos2['cantidad'];
              $mostrar='AJUSTE MAS';
              $respaldo=$ajustado['respaldo'];
           }elseif($condiciones==2){
           	  $cantidad=$productos2['precio_venta']-$productos2['cantidad'];
              $mostrar='AJUSTE MENOS';
              $respaldo=$ajustado['respaldo'];
           }
     }
	
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha'])), 0);
	$pdf->Cell(20, 8, $productos2['numero_factura'], 0);
	$pdf->Cell(20, 8, $respaldo, 0);
	$pdf->Cell(20, 8, $productos2['id_producto'], 0);
	$pdf->Cell(40, 8, $productos2['nombre_producto'], 0);
	$pdf->Cell(20, 8, $productos2['precio_venta'], 0);
	$pdf->Cell(20, 8, $cantidad, 0);
	$pdf->Cell(20, 8, $mostrar, 0);
	$pdf->Ln(8);
}

$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(64,8,'',0);
/*$pdf->Cell(25,14,'Total Venta: '.number_format($totaluni,0).'.GS',0);
$pdf->Ln(8);*/

$pdf->Output('reporteAjusteXfecha.pdf','D');


?>