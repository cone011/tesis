<?php


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		/*$del1="delete from venta where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_venta where numero_factura='".$numero_factura."'";*/
		$condiciones=999;
		$accion='ANULADO';
		$id_product=0;
		$cant='ANULADO';
		$vent='ANULADO';
		$id_clien='999';
		//$vendedor=1;
		$estado_factura=10;
		$factura=0;
		
        $sql=mysqli_query($con, "select * from detalle_venta where numero_factura='".$numero_factura."'");
       while ($row=mysqli_fetch_array($sql))
	   {
	        $idprouc=$row['id_producto'];	
	        $canti=$row['cantidad'];
	        $sqlproducto="UPDATE productos SET cantidad_producto=cantidad_producto+'".$canti."' WHERE id_producto='".$idprouc."'";
            $query_update = mysqli_query($con,$sqlproducto);
	    }
	    $sql_cliente="UPDATE cuentacliente SET id_cliente='".$id_clien."', condiciones='".$condiciones."', estado_factura='".$estado_factura."', saldo_factura=0 WHERE numero_factura='".$numero_factura."'";
	    $query_cliente=mysqli_query($con,$sql_cliente);

        $sql_anulado="UPDATE venta SET id_cliente='".$id_clien."', condiciones='".$condiciones."', estado_factura='".$estado_factura."', accion='".$accion."', saldo_factura=0  WHERE numero_factura='".$numero_factura."'";
        /*$insert_auditoria="INSERT INTO audiventa (numero_factura, id_producto,cantidad,precio_venta,accion) VALUES ('$numero_factura','$id_product','$cant','$vent','$accion')";*/
		/*if ($delete1=mysqli_query($con,$sql_anulado) and $delete2=mysqli_query($con,$insert_auditoria)){*/
	    if ($delete1=mysqli_query($con,$sql_anulado)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Factura Anulada Correctamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo Anular la Factura
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "venta, cliente, users";
		 $sWhere = "";
		 $sWhere.=" WHERE venta.id_cliente=cliente.id_cliente and venta.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (cliente.nombre_cliente like '%$q%' or venta.numero_factura like '%$q%' or venta.fecha like '%$q%')";
			
		}
		
		$sWhere.=" order by venta.id_factura desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Estado de la Factura</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Saldo Pendiente</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$estado_factura=$row['estado_factura'];					
						$aux_venta=$row['total_venta'];
						$saldo=$row['saldo_factura'];
						if ($estado_factura==1 and $saldo==0){
							$text_estado="Cobrada";
							$label_class='label-success';
						}
						elseif($estado_factura==2){$text_estado="Pendiente";$label_class='label-danger';}
						elseif($estado_factura==10){$text_estado="Anulada";$label_class='label-warning';}
						
					?>
					<tr>
						<td><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente.'-'.$telefono_cliente;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($aux_venta); ?></td>
						<td class='text-right'><?php echo number_format ($saldo); ?></td>					
					<td class="text-right"> 
						<?php 
                         if($estado_factura==1 || $estado_factura==2 || $estado_factura==10){
						?>
					 <?php 	} ?>
						<a href="#" class='btn btn-default' title='Mostrar factura' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
					<?php if($estado_factura==10){?>
						
					<?php }elseif($estado_factura==1 || $saldo==0){ ?>
					   
					<?php }else{ ?>
					     
					<?php } ?>    

					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>