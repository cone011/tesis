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
$res = "SELECT * FROM detalle_ajuste,ajuste,productos WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and detalle_ajuste.numero_factura=ajuste.numero_factura AND detalle_ajuste.id_producto=productos.id_producto ORDER BY fecha_factura DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="100">Nro Ajuste</th>
                <th width="220">Producto</th>
                <th width="50">Cant. Ant.</th>
                <th width="100">Cant Ajust.</th>
                <th width="70">Cant Actu.</th>
                <th width="70">Tipo Ajuste</th>
                <th width="150">Fecha Registro</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
       /* $res_ajuste = "SELECT * FROM ajuste,motivoajuste WHERE ajuste.id_cliente=motivoajuste.id_cliente ORDER BY id_cliente DESC";
        $registro_ajuste = $conexion->query($res_ajuste);
          while($registro100 = mysqli_fetch_array($registro_ajuste)){
               $nombre=$registro100['nombre_cliente'];
          }*/
        $total=0;
        $nroFormat=number_format($registro2['total_venta']);
        $condiciones=$registro2['condiciones'];
        if($condiciones==1){
           $leyenda='AJUSTE MAS';
           $total=$registro2['total_venta']+$registro2['cantidad'];
        }elseif($condiciones==2){
           $leyenda='AJUSTE MENOS';
           $total=$registro2['total_venta']-$registro2['cantidad'];
        }
		echo '<tr>
				<td>'.$registro2['numero_factura'].'</td>
				<td>'.$registro2['nombre_producto'].'</td>
				<td>'.$nroFormat.'</td>
				<td>'.$registro2['cantidad'].'</td>
				<td>'.$total.'</td>
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