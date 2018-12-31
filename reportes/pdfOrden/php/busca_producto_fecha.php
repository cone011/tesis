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

$res = "SELECT * FROM op,proveedores where op.id_cliente=proveedores.id_cliente and fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha_factura DESC";
$registro = $conexion->query($res);

//CREAMOS NUESTRA VISTA Y LA DEVOLVEMOS AL AJAX

echo '<table class="table table-striped table-condensed table-hover">
        	<tr>
            	<th width="50">Nro Recibo</th>
                <th width="100">Fecha Emitida</th>
                <th width="70">Nro Fact</th>
                <th width="50">Cod Prov</th>
                <th width="220">Nombre Prov</th>
                <th width="70">Ruc</th>
                <th width="150">Importe Recibo</th>
            </tr>';
if(mysqli_num_rows($registro)>0){
	while($registro2 = mysqli_fetch_array($registro)){
		$fact='';
        $wpf2='';
        $wpf1='';
        $nroFormat=number_format($registro2['total_venta']);
        $nro=$registro2['numero_venta'];
        
        $res_factura = "SELECT * FROM compra where numero_factura='$nro'";
        $productos_factura = $conexion->query($res_factura);
        while($productos_factura2 = mysqli_fetch_array($productos_factura)){
            if(strlen($productos_factura2["pf1"])==1){
                $wpf1='00';
            }else{
                $wpf1='0';
            }
            //CEROS PARA EL PREFIJO 2
            if(strlen($productos_factura2["pf2"])==1){
               $wpf2='00';
            }else{
               $wpf2='0';
            }
          $fact=$wpf1.$productos_factura2['pf1'].'-'.$wpf2.$productos_factura2['pf2'].'-'.$productos_factura2['nrodoc'];
        }
		echo '<tr>
				<td>'.$registro2['numero_factura'].'</td>
                <td>'.fechaNormal($registro2['fecha']).'</td>
                <td>'.$fact.'</td>
                <td>'.$registro2['id_cliente'].'</td>
                <td>'.$registro2['nombre_cliente'].'.Gs</td>
                <td>'.$registro2['ruc_cliente'].'</td>
                <td>'.number_format($registro2['cantidad_op'],0).'</td>
				</tr>';
	}
}else{
	echo '<tr>
				<td colspan="6">No se encontraron resultados</td>
			</tr>';
}
echo '</table>';
?>