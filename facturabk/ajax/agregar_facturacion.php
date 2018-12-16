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
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
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
	<th class='text-center'>CANT./LITROS</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
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
	$sql=mysqli_query($con, "select * from productos, tmp where productos.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$precioUnitario=$row['precio_producto'];	
	$precio_venta=$row['precio_tmp'];
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	//$cantidad=$row['cantidad_tmp'];
	$cantidad=number_format($precio_venta/$precioUnitario,2);
	$nombre_producto=$row['nombre_producto'];
	$tipo=$row['tipo'];
	$iva=$row['iva_producto'];
	$cantidadtmp=$row['cantidad_tmp'];

	/*$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	//$precio_total=$precio_venta_r*$cantidad;
	$precio_total=$precio_venta_r;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador*/

	if($tipo==1){
      $cantidad=number_format($precio_venta/$precioUnitario,2); 
      $precio_venta_f=number_format($precio_venta,2);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      //$precio_total=$precio_venta_r*$cantidad;
      $precio_total=$precio_venta_r;
      $precio_total_f=number_format($precio_total,2);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $sumador_total+=$precio_total_r;//Sumador
    }else{
      $cantidad=$row['cantidad_tmp'];
      $precio_venta_f=number_format($precio_venta,2);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      $precio_total=$precio_venta_r*$cantidad;
      //$precio_total=$precio_venta_r;
      $precio_total_f=number_format($precio_total,2);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $sumador_total+=$precio_total_r;//Sumador
    }

    if($iva==1){
      $ivaux=($precio_total_r / 1.1 )*0.1;
      $ivaux=number_format($ivaux,2,'.','');
      $auxiva10=($precio_total_r / 1.1 )*0.1;
      $auxiva10=number_format($auxiva10,2,'.','');
      $monto10+=$precio_total_r;
      $iva10+=$auxiva10;
      $ivatotal+=$ivaux;
    }elseif($iva==2){
      $ivaux=($precio_total_r / 1.05 )*0.1;
      $ivaux=number_format($ivaux,2,'.','');
      $auxiva05=($precio_total_r / 1.05 )*0.1;
      $auxiva05=number_format($auxiva05,2,'.','');
      $monto5+=$precio_total_r;
      $iva5+=$auxiva05;
      $ivatotal+=$ivaux;
    }

    if($cantidadtmp<0){
       $sumador_total=0;
       $ivatotal=0;
       $monto5=0;
       $iva5=0;
       $monto10=0;
       $iva10=0;
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
			<td class='text-right'><?php echo $precio_total_f;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$print10=10;
    $print05=5;
    $print0=0;
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal /1.1 )*0.1;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal;

?>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>

<tr>
	<td class='text-right' colspan=4>IVA (<?php echo $print10;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($iva10,2);?></td>
	<td></td>
</tr>

<tr>
	<td class='text-right' colspan=4>IVA (<?php echo $print05;?>)% <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($iva5,2);?></td>
	<td></td>
</tr>

<tr>
	<td class='text-right' colspan=4>TOTAL IVA <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($ivatotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>TOTAL <?php echo $simbolo_moneda;?></td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<td></td>
</tr>

</table>
