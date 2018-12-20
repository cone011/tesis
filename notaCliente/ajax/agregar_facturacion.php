<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");

if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and $cantidad>0)
{
$insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','$session_id')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>Nro Factura.</th>
	<th class='text-center'>Datos Cliente</th>
	<th>Saldo Factura</th>
	<th class='text-right'>Monto N.C.</th>
	<th class='text-right'>Saldo a Existir</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$ivatotal=0;
    $iva10=0;
    $iva5=0;
    $exenta=0;
    $auxiva05=0;
    $auxiva10=0;
    $monto10=0;
    $monto5=0;
    $monto0=0;
	$sql=mysqli_query($con, "select * from cuentacliente, tmp where cuentacliente.numero_factura=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$precioUnitario=$row['total_venta'];	
	$precio_venta=$row['precio_tmp'];
	$id_tmp=$row["id_tmp"];
	$codigo_producto='001'.'-'.'001'.'-'.$row['numero_factura'];
	$cantidadtmp=$row['cantidad_tmp'];
	$sql_producto=mysqli_query($con, "select * from cliente, cuentacliente where cuentacliente.id_cliente=cliente.id_cliente");
	while ($rw=mysqli_fetch_array($sql_producto))
	{
        $nombre=$rw['nombre_cliente'];
        $ruc_cliente=$rw['telefono_cliente'];
        $dato=$nombre.'-'.$ruc_cliente;
	}
	$format=number_format($precio_venta,0);
	$diferencia=$precio_venta-$cantidadtmp;
	

	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $dato;?></td>
			<td><?php echo $format;?></td>
			<td class='text-right'><?php echo $cantidadtmp;?></td>
			<td class='text-right'><?php echo $diferencia;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	/*$print10=10;
    $print05=5;
    $print0=0;
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal /1.1 )*0.1;
	$total_iva=number_format($total_iva,2,'.','');*/
	//$total_factura=$subtotal;*/

?>


</table>
