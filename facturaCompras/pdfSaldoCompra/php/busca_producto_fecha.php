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
/*$res = "SELECT * FROM ncliente,detalle_nc WHERE fecha BETWEEN '$desde' AND '$hasta' and ncliente.numero_factura=detalle_nc.numero_factura ORDER BY fecha DESC";*/
$res = "SELECT * FROM detalle_np WHERE fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro NC</th>
                <th width="50">Codigo</th>
                <th width="220">Nombre Cliente</th>
                <th width="100">Ruc Cliente</th>
                <th width="70">Total Monto</th>
                <th width="70">Pago Aplicado</th>
                <th width="70">Saldo Sobrante</th>
                <th width="150">Fecha Registro</th>
            </tr>';
            
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
        $codigo=$registro2['id_producto'];
        //$saldo=$registro2['cantidad'];
		 $res_factura = "SELECT * FROM compra,proveedores WHERE numero_factura=$codigo and compra.id_cliente=proveedores.id_cliente";
         $registro_factura = $conexion->query($res_factura);
         while($registro_fact = mysqli_fetch_array($registro_factura)){
            $monto=$registro_fact['total_venta'];
           // $nombre_cliente=$registro_fact['telefono_cliente'];
            $nombre_cliente=$registro_fact['nombre_cliente'];
            $ruc_cliente=$registro_fact['ruc_cliente'];
         }
        $nroFormat=number_format($registro2['precio_venta']);
		echo '<tr>
				<td>'.'001'.'-'.'001'.'-'.$registro2['numero_factura'].'</td>
                <td>'.$registro2['id_producto'].'</td>
                <td>'.$nombre_cliente.'</td>
                <td>'.$ruc_cliente.'</td>
                <td>'.$monto.'</td>
                <td>'.$registro2['cantidad'].'</td>
                <td>'.$nroFormat.'.Gs</td>
                <td>'.fechaNormal($registro2['fecha']).'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>