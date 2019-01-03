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
$res = "SELECT * FROM `compras_x_producto` WHERE FECHA BETWEEN '$desde' AND '$hasta' ORDER BY FECHA DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro Compra</th>
                <th width="50">Codigo</th>
                <th width="220">Nombre</th>
                <th width="100">Cantidad</th>
                <th width="70">Precio Unitario</th>
                <th width="70">Total</th>
                <th width="150">Fecha Registro</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		
        $nroFormat=number_format($registro2['PRECIO_UNITARIO']);
             
		echo '<tr>
				<td>'.$registro2['NUMERO_COMPRA'].'</td>
                <td>'.$registro2['ID_PRODUCTO'].'</td>
                <td>'.$registro2['PRODUCTO'].'</td>
                <td>'.$registro2['CANTIDAD'].'</td>
                <td>'.$nroFormat.'.Gs</td>
                <td>'.$nroFormat*$registro2['CANTIDAD'].'</td>
                <td>'.fechaNormal($registro2['FECHA']).'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>