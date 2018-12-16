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
$insert_tmp=mysqli_query($con, "INSERT INTO detalle_np (numero_factura, id_producto,cantidad,precio_venta,accion) VALUES ('$numero_factura','$id','$cantidad','$precio_venta','$accion')");
$insert_auditoria=mysqli_query($con, "INSERT INTO audidetalle_np (numero_factura, id_producto,cantidad,precio_venta,accion) VALUES ('$numero_factura','$id','$cantidad','$precio_venta','$accion')");


}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id']);	

$sql=mysqli_query($con, "select * from  detalle_np where id_detalle='".$id_detalle."'");
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
$delete=mysqli_query($con, "DELETE FROM detalle_compra WHERE id_detalle='".$id_detalle."'");

 }

$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>NRO FACT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>MONTO  N.C.</th>
	<th class='text-right'>SALDO SOBRANTE</th>
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
	$sql=mysqli_query($con, "select * from ncliente, detalle_nc where ncliente.numero_factura=detalle_nc.numero_factura and ncliente.id_factura='$id_factura'");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto='001'.'-'.'001'.'-'.$row['id_producto'];
	$cantidad=$row['cantidad'];	
	$iva=$row['cantidad'];
	$saldo=$row['precio_venta'];
	$estado_factura=$row['estado_factura'];
	$sql_producto=mysqli_query($con, "select * from cliente, ncliente where ncliente.id_cliente=ncliente.id_cliente");
    while ($rw=mysqli_fetch_array($sql_producto))
    {
        $nombre=$rw['nombre_cliente'];
         $ruc_cliente=$rw['telefono_cliente'];
        $dato=$nombre.'  '.$ruc_cliente;
    }

	
	/*$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador*/

	/*if($iva==1){
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
    }*/
	
		?>
		<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td><?php echo $dato;?></td>
			<td class='text-right'><?php echo $iva;?></td>
			<td class='text-right'><?php echo $saldo;?></td>
		</tr>		
		<?php
	}
	/*$print10=10;
    $print05=5;
    $print0=0;
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	$update=mysqli_query($con,"update compra set total_venta='$total_factura' where id_factura='$id_factura'");*/
?>


</table>
