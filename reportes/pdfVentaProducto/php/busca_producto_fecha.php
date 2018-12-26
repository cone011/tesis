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
$res = "SELECT * FROM productos";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="50">Codigo Producto</th>
                <th width="220">Nombre Producto</th>
                <th width="100">Cantidad Comprada</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		$cantidad=0;
    $codigo=$registro2['id_producto'];
    $res_producto = "SELECT * FROM detalle_venta WHERE fecha BETWEEN '$desde' AND '$hasta' and id_producto='$codigo' order by numero_factura desc";
    $productos_compra = $conexion->query($res_producto);
    while($productos_comprado = mysqli_fetch_array($productos_compra)){
         $cantidad+=$productos_comprado['cantidad'];
    }
		echo '<tr>
				<td>'.$codigo.'</td>
                <td>'.$registro2['nombre_producto'].'</td>
                <td>'.$cantidad.'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>