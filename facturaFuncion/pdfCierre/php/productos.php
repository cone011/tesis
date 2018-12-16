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
$pdf->Cell(100, 8, 'LISTADO DE CIERRE', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(2, 8, '', 0);
$pdf->Cell(20, 8, 'Cantidad', 0);
$pdf->Cell(20, 8, 'Nro Cierre', 0);
$pdf->Cell(20, 8, 'Fact. Inicial.', 0);
$pdf->Cell(20, 8, 'Fact. Final.', 0);
$pdf->Cell(20, 8, 'Mont. Cont.', 0);
$pdf->Cell(20, 8, 'Mont Credito', 0);
$pdf->Cell(20, 8, 'Mont Anulado', 0);
$pdf->Cell(20, 8, 'Total.', 0);
$pdf->Cell(20, 8, 'Estado', 0);
$pdf->Cell(30, 8, 'Fech. Regis.', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA

$res = "SELECT * FROM cierre WHERE fecha_add BETWEEN '$desde' AND '$hasta'";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	$factura_incial=$productos2['factura_incial'];
        $factura_final=$productos2['factura_final'];
        $monto_contado=0;
        $monto_credito=0;
        $monto_anulado=0;
        $total=0;
        $res_factura = "SELECT * FROM venta WHERE numero_factura>=$factura_incial and numero_factura<=$factura_final";
       $registro_factura = $conexion->query($res_factura);
       while($registro_fact = mysqli_fetch_array($registro_factura)){
            $condicion=$registro_fact['condiciones'];
            $monto=$registro_fact['total_venta'];
            if($condicion==1){
               $monto_contado+=$monto;
               $total+=$monto;
            }elseif($condicion==2){
                $monto_credito+=$monto;
                $total+=$monto;
            }else{
                $monto_anulado+=$monto;
                $total+=$monto;
            }
       }
	$leyenda='APROBADO';
	$item+=1;
	$pdf->Cell(2, 8, '', 0);
	$pdf->Cell(20, 8, $item, 0);
	$pdf->Cell(20, 8,$productos2['id_cierre'], 0);
	$pdf->Cell(20, 8, $productos2['factura_incial'], 0);
	$pdf->Cell(20, 8, $productos2['factura_final'], 0);
	$pdf->Cell(20, 8, $monto_contado, 0);
	$pdf->Cell(20, 8, $monto_credito, 0);
	$pdf->Cell(20, 8, $monto_anulado, 0);
	$pdf->Cell(20, 8, $total, 0);
	$pdf->Cell(20, 8, $leyenda, 0);
	$pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['fecha_add'])), 0);
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteCierre.pdf','D');


?>