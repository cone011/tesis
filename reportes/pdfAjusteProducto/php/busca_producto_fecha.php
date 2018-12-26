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
$res = "SELECT * FROM detalle_ajuste,productos WHERE fecha BETWEEN '$desde' AND '$hasta' and detalle_ajuste.id_producto=productos.id_producto ORDER BY numero_factura DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="50">Fecha Ajuste</th>
                <th width="30">Nro Ajuste</th>
                <th width="30">Nro Respaldo</th>
                <th width="170">Nombre Producto</th>
                <th width="70">Exist Ant.</th>
                <th width="70">Exist Act</th>
                <th width="80">Tipo Ajuste</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		
        $mostrar='';
    $numero_factura=$registro2['numero_factura'];
    $cantidad=0;
    $res_ajuste = "SELECT * FROM ajuste WHERE numero_factura='$numero_factura'";
     $productos_ajuste = $conexion->query($res_ajuste);
     while($ajustado = mysqli_fetch_array($productos_ajuste)){
           $condiciones=$ajustado['condiciones'];
           if($condiciones==1){
              $cantidad=$registro2['precio_venta']+$registro2['cantidad'];
              $mostrar='AJUSTE MAS';
              $respaldo=$ajustado['respaldo'];
           }elseif($condiciones==2){
              $cantidad=$registro2['precio_venta']-$registro2['cantidad'];
              $mostrar='AJUSTE MENOS';
              $respaldo=$ajustado['respaldo'];
           }
     }
		echo '<tr>
				<td>'.$registro2['fecha'].'</td>
                <td>'.$registro2['numero_factura'].'</td>
                <td>'.$respaldo.'</td>
                <td>'.$registro2['nombre_producto'].'</td>
                <td>'.$registro2['precio_venta'].'.Gs</td>
                <td>'.$cantidad.'</td>
                <td>'.$mostrar.'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>