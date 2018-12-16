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
$res = "SELECT * FROM cierre WHERE fecha_add BETWEEN '$desde' AND '$hasta'  ORDER BY fecha_add DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro Cierre</th>
                <th width="100">Factura Inicial</th>
                <th width="100">Factura Final</th>
                <th width="100">Monto Contado</th>
                <th width="100">Monto Credito</th>
                <th width="100">Monto Anulado</th>
                <th width="100">Total</th>
                <th width="100">Estado</th>
                <th width="150">Fecha Registro</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
        $factura_incial=$registro2['factura_incial'];
        $factura_final=$registro2['factura_final'];
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
		echo '<tr>
				<td>'.$registro2['id_cierre'].'</td>
                <td>'.$registro2['factura_incial'].'</td>
                <td>'.$registro2['factura_final'].'</td>
                <td>'.$monto_contado.'</td>
                <td>'.$monto_credito.'</td>
                <td>'.$monto_anulado.'</td>
                <td>'.$total.'</td>
                <td>'.$leyenda.'</td>
                <td>'.fechaNormal($registro2['fecha_add']).'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>