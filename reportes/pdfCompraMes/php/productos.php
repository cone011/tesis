<?php

/*if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$dato = $_GET['dato'];
    //echo $dato;

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

$leyenda_mes=date("F");

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
$pdf->Cell(70, 8,'LISTADO COMPRA MES', 0);
$pdf->Ln(10);
$pdf->Cell(75, 8, '', 0);
$pdf->Cell(100, 8, 'Mes: '.$leyenda_mes, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8,'     ', 0);
$pdf->Cell(15, 8, 'Cantidad', 0);
$pdf->Cell(20, 8, 'Fecha Factura.', 0);
$pdf->Cell(20, 8, 'Cod. Prov', 0);
$pdf->Cell(50, 8, 'Nombre', 0);
$pdf->Cell(20, 8, 'Ruc', 0);
$pdf->Cell(30, 8, 'Nro Doc.', 0);
$pdf->Cell(20, 8, 'Monto', 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA
$mes=date("m");
$res = "SELECT * FROM proveedores,compra WHERE month(fecha)='$mes' and compra.id_cliente=proveedores.id_cliente order by numero_factura desc";
$productos = $conexion->query($res);

$item = 0;
$totaluni = 0;
$totaldis = 0;
$condiciones=0;
while($productos2 = mysqli_fetch_array($productos)){
	$nroFormat=number_format($productos2['total_venta']);
	$condiciones=$productos2['condiciones'];
	$fecha=$productos2['fecha'];
	$item = $item+1;
	$totaluni = $totaluni + $productos2['total_venta'];
	if(strlen($productos2["pf1"])==1){
        $wpf1='00';
    }else{
         $wpf1='0';
   }
    //CEROS PARA EL PREFIJO 2
   if(strlen($productos2["pf2"])==1){
        $wpf2='00';
    }else{
         $wpf2='0';
    }
	$pdf->Cell(15, 8,'     ', 0);
	$pdf->Cell(15, 8, $item, 0);
	$pdf->Cell(20, 8, date('d/m/Y', strtotime($productos2['fecha_factura'])), 0);
	$pdf->Cell(20, 8,$productos2['id_cliente'], 0);
	$pdf->Cell(50, 8, $productos2['nombre_cliente'], 0);
	$pdf->Cell(20, 8, $productos2['ruc_cliente'], 0);
	$pdf->Cell(30, 8, $wpf1.$productos2['pf1'].'-'.$wpf2.$productos2['pf2'].'-'.$productos2['nrodoc'], 0);
	$pdf->Cell(20, 8, $nroFormat.'.Gs', 0);	
	$pdf->Ln(8);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);
//$pdf->Cell(25,14,'Total Unitario: '.$totaluni '.GS',0);
//$pdf->Ln(8);
//$pdf->Cell(25,14,'Total Dist: S/. '.$totaldis,0);

$pdf->Output('reporteCompraMes.pdf','D');


?>