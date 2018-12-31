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
$res = "SELECT * FROM cobranza,cliente WHERE fecha BETWEEN '$desde' AND '$hasta' and cobranza.id_cliente=cliente.id_cliente ORDER BY fecha DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="50">Nro Recibo</th>
                <th width="100">Fecha Recibo</th>
                <th width="80">Nro Fact</th>
                <th width="50">Cod Cliente</th>
                <th width="220">Nombre Cliente</th>
                <th width="70">Ruc Cliente</th>
                <th width="150">Importe Recibo</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		
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
                <td>'.$registro2['numero_factura'].'</td>
                <td>'.fechaNormal($registro2['fecha_factura']).'</td>
                <td>'.'001'.'-'.'001'.'-'.$registro2['numero_venta'].'</td>
                <td>'.$registro2['id_cliente'].'</td>
                <td>'.$registro2['nombre_cliente'].'</td>
                <td>'.$registro2['ruc_cliente'].'</td>
                <td>'.$nroFormat.'.Gs</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>