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
/*$res = "SELECT * FROM ventasbk WHERE fecfac BETWEEN '$desde' AND '$hasta' ORDER BY fecfac DESC";*/
$res = "SELECT * FROM cuentaproveedor,proveedores WHERE fecha_vencimiento BETWEEN '$desde' AND '$hasta' and cuentaproveedor.id_cliente=proveedores.id_cliente";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro O.C</th>
                <th width="50">Codigo</th>
                <th width="220">Nombre</th>
                <th width="100">Ruc</th>
                <th width="70">Total Importe</th>
                <th width="70">Iva</th>
                <th width="150">Fecha Registro</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		//CEROS PARA EL PREFIJO 1
        /*if(strlen($registro2["pf1"])==1){
          $wpf1='00';
        }else{
          $wpf1='0';
        }
        //CEROS PARA EL PREFIJO 2
        if(strlen($registro2["pf2"])==1){
          $wpf2='00';
        }else{
          $wpf2='0';
        }*/
        $nroFormat=number_format($registro2['total_venta']);
        //$nroIva=number_format($registro2['iva10']);
		echo '<tr>
				<td>'.$registro2['numero_factura'].'</td>
				<td>'.$registro2['id_cliente'].'</td>
				<td>'.$registro2['nombre_cliente'].'</td>
				<td>'.$registro2['ruc_cliente'].'</td>
				<td>'.$nroFormat.'.Gs</td>
				<td>'.fechaNormal($registro2['fecha_vencimiento']).'.Gs</td>
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