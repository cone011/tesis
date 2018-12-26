<?php
include('conexion.php');

$dato = $_POST['dato'];

//EJECUTAMOS LA CONSULTA DE BUSQUEDA
$res = "SELECT * FROM cliente,venta WHERE nombre_cliente LIKE '%$dato%' and cliente.id_cliente=venta.id_cliente ORDER BY fecha_factura DESC";
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
		//CEROS PARA EL PREFIJO 1
        
        $nroFormat=number_format($registro2['total_venta']);
        $condicion=$registro2['condiciones'];
        if($condicion==1){
            $leyenda='CONTADO';
        }elseif ($condicion==2) {
            $leyenda='CREDITO';
        }elseif($condicion==3) {
            $leyenda='TARJ. POS';
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