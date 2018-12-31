<?php
include('conexion.php');

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
/*$dato = $_POST['dato'];
echo $dato;*/

//COMPROBAMOS QUE LAS FECHAS EXISTAN
if(isset($desde)==false){
	$desde = $hasta;
}

if(isset($hasta)==false){
	$hasta = $desde;
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$res = "SELECT * FROM compra,proveedores WHERE fecha_factura BETWEEN '$desde' AND '$hasta' and compra.id_cliente=proveedores.id_cliente ORDER BY fecha_factura DESC";
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
                <th width="150">Fecha Factura</th>
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
        if(strlen($registro2["pf1"])==1){
        $wpf1='00';
    }else{
         $wpf1='0';
   }
    //CEROS PARA EL PREFIJO 2
   if(strlen($registro2["pf2"])==1){
        $wpf2='00';
    }else{
        $wpf2='0';
    }
		echo '<tr>
				<td>'.$wpf1.$registro2['pf1'].'-'.$wpf1.$registro2['pf2'].'-'.$registro2['nrodoc'].'</td>
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