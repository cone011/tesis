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
$res = "SELECT * FROM compra,proveedores WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and compra.id_cliente=proveedores.id_cliente and estado_factura=2 ORDER BY fecha_factura DESC";
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
		
        $nroFormat=number_format($registro2['saldo_factura']);
        $condicion=$registro2['condiciones'];
        if($condicion==1){
            $leyenda='CONTADO';
        }elseif ($condicion==2) {
            $leyenda='CREDITO';
        }else{
            $leyenda='ANULADO';
        }
		echo '<tr>
				<td>'.'001'.'-'.'001'.'-'.$registro2['numero_factura'].'</td>
                <td>'.$registro2['id_cliente'].'</td>
                <td>'.$registro2['nombre_cliente'].'</td>
                <td>'.$registro2['ruc_cliente'].'</td>
                <td>'.$nroFormat.'.Gs</td>
                <td>'.$leyenda.'</td>
                <td>'.fechaNormal($registro2['fecha_factura']).'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>