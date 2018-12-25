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
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANTIDAD</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>EXISTENCIA A MODIFICAR</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from productos, tmp where productos.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$precioUnitario=$row['precio_producto'];	
	$precio_venta=$row['precio_tmp'];
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$cantidadActual=$row['cantidad_producto'];
	//$cantidad=number_format($precio_venta/$precioUnitario,2);
	$nombre_producto=$row['nombre_producto'];
	
	
	$precio_venta_actual=number_format($cantidadActual,2);//Formateo variables
	$precio_venta_actualr=str_replace(",","",$precio_venta_actual);//Reemplazo las comas
	$precio_venta_f=number_format($cantidad,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	//$precio_total=$precio_venta_r*$cantidad;
	$precio_total=$precio_venta_r+$precio_venta_actualr;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador

	if($cantidad<0){
	   $precio_venta_f=0;
       $precio_total_r=0;
       $cantidad='NEGATIVO';
       $codigo_producto='ERROR';
    }
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal /1.1 )*0.1;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal;

?>

</table>
