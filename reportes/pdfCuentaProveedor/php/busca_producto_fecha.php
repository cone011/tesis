<?php
include('conexion.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

//COMPROBAMOS QUE LAS FECHAS EXISTAN
if(isset($desde)==false){
	$desde = $hasta;
}

if(isset($hasta)==false){
	$hasta = $desde;
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$res = "SELECT * FROM detalle_cuenta_cliente,cliente WHERE FECHA BETWEEN '$desde' AND '$hasta' and detalle_cuenta_cliente.ID_CLIENTE=cliente.id_cliente ORDER BY FECHA DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro Documento</th>
                <th width="50">Codigo</th>
                <th width="220">Nombre</th>
                <th width="100">Ruc</th>
                <th width="70">Total Importe</th>
                <th width="70">Estado</th>
                <th width="150">Fecha Registro</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
        $id_cliente=$registro2['ID_CLIENTE'];
        $nombre='';
		$res_cliente = "SELECT * FROM cliente WHERE id_cliente='$id_cliente'";
        $registro_cliente = $conexion->query($res_cliente);
        if(mysqli_num_rows($registro_cliente)>0){
           $nombre=$registro_cliente['nombre_cliente'];
        }
        $nroFormat=number_format($registro2['total_venta']);
        $condicion=$registro2['condiciones'];
        if($condicion==1){
            $leyenda='CONTADO';
        }elseif ($condicion==2) {
            $leyenda='CREDITO';
        }else{
            $leyenda='ANULADO';
        }
		echo '<tr>
				<td>'.$registro2['FECHA'].'</td>
                <td>'.$registro2['TIPO'].'</td>
                <td>'.$registro2['NRO_FACTURA'].'</td>
                <td>'.$registro2['NRO_PAGO'].'</td>
                <td>'.$nroFormat.'.Gs</td>
                <td>'.$leyenda.'</td>
                <td>'.fechaNormal($registro2['fecha_factura']).'</td>
                $pdf->Cell(30, 8, date('d/m/Y', strtotime($productos2['FECHA'])), 0);
    $pdf->Cell(20, 8, $productos2['TIPO'], 0);
    $pdf->Cell(20, 8, $productos2['NRO_FACTURA'], 0);
    $pdf->Cell(20, 8, $productos2['NRO_PAGO'], 0);
    $pdf->Cell(30, 8, $nroFormat.'.Gs', 0);
    $pdf->Cell(20, 8, $saldo.'.Gs', 0);
    $pdf->Cell(20, 8, $productos2['FORMA_DE_PAGO'], 0);
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>