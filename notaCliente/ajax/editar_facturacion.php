<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura= $_SESSION['id_factura'];
$numero_factura= $_SESSION['numero_factura'];
if (isset($_POST['id'])){$id=intval($_POST['id']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$accion='MODIFICADO';
$insert_tmp=mysqli_query($con, "INSERT INTO detalle_venta (numero_factura, id_producto,cantidad,precio_venta) VALUES ('$numero_factura','$id','$cantidad','$precio_venta')");
$insert_auditoria=mysqli_query($con, "INSERT INTO audidetalle_venta (numero_factura, id_producto,cantidad,precio_venta,accion) VALUES ('$numero_factura','$id','$cantidad','$precio_venta','$accion')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id']);	

$sql=mysqli_query($con, "select * from  detalle_compra where id_detalle='".$id_detalle."'");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$numero_factura=$row['numero_factura'];
	$id_producto=$row['id_producto'];
	$cantidad=$row['cantidad'];
	$precio_venta=$row['precio_venta'];
	$accion='ELIMINADO';
	$insert_audi=mysqli_query($con, "INSERT INTO audidetalle_compra (numero_factura, id_producto,cantidad,precio_venta,accion) VALUES ('$numero_factura','$id_producto','$cantidad','$precio_venta','$accion')");
    }
$delete=mysqli_query($con, "DELETE FROM detalle_venta WHERE id_detalle='".$id_detalle."'");
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
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
	$sql=mysqli_query($con, "select * from productos, venta, detalle_venta where venta.numero_factura=detalle_venta.numero_factura and  venta.id_factura='$id_factura' and productos.id_producto=detalle_venta.id_producto");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$iva=$row['iva_producto'];
	$estado_factura=$row['estado_factura'];
    $tipo=$row['tipo'];
	if($tipo==1){
		$precio_venta=$row['precio_producto'];
        
	}else{
		$precio_venta=$row['precio_venta'];
	}
	
	
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$cantidad_mostrar=number_format($cantidad,2);
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador

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
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td class='text-center'><?php echo $cantidad_mostrar;?></td>
			<td><?php echo $nombre_producto;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td>
			<td class='text-right'><?php echo $precio_total_f;?></td>
            <?php if($estado_factura>0){ ?>
		    	
		    <?php }else{ ?>
		    	<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		    <?php } ?>	
		</tr>		
		<?php
	}
	$print10=10;
    $print05=5;
    $print0=0;
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	/*$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');*/
	$total_factura=$subtotal;

	
	$update=mysqli_query($con,"update venta set total_venta='$total_factura' where id_factura='$id_factura'");
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
