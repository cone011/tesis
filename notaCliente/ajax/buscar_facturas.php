<?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		//$del1="delete from compra where numero_factura='".$numero_factura."'";
		$condiciones=999;
		$accion='ANULADO';
		$accionfact=999;
		$id_product=0;
		$cant='ANULADO';
		$vent='ANULADO';
		$id_clien='999';
		//$vendedor=1;
		$estado_factura=10;
		$facturadrop=0;
		$total=0;
		$sql=mysqli_query($con, "select * from detalle_nc where numero_factura='".$numero_factura."'");
       while ($row=mysqli_fetch_array($sql))
	   {
	        //$idprouc=$row['id_producto'];
	   	    $numero=$row['id_producto'];
	        $sql=mysqli_query($con, "select * from ncliente,detalle_nc where ncliente.numero_factura='".$numero_factura."' and detalle_nc.numero_factura='".$numero_factura."'");	
	        while ($row2=mysqli_fetch_array($sql))
	        {
               $monto=$row2['cantidad'];  
	        }
	        //$canti=$row['cantidad'];
	        //echo $monto;
	        $sqlproducto="UPDATE cuentacliente SET saldo_factura=saldo_factura+'".$monto."' WHERE numero_factura='".$numero."'";
            $query_update = mysqli_query($con,$sqlproducto);
            $sqlventa="UPDATE venta SET saldo_factura=saldo_factura+'".$monto."' WHERE numero_factura='".$numero."'";
            $query_update = mysqli_query($con,$sqlventa);
            $total+=$monto;
	    }
        $sql_anulado="UPDATE ncliente SET id_cliente='".$id_clien."', condiciones='".$condiciones."', estado_factura='".$estado_factura."', accion='".$accion."', saldo_original='".$total."' WHERE numero_factura='".$numero_factura."'";
	    if ($delete1=mysqli_query($con,$sql_anulado)){
       ?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> N.C anulada Correctamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo anular la N.C.
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "ncliente, detalle_nc, cliente, users";
		 $sWhere = "";
		 $sWhere.=" WHERE ncliente.id_cliente=cliente.id_cliente and ncliente.id_vendedor=users.user_id and ncliente.numero_factura=detalle_nc.numero_factura";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (cliente.nombre_cliente like '%$q%' or ncliente.numero_factura like '%$q%' or ncliente.fecha like '%$q%')";
			
		}
		
		$sWhere.=" order by ncliente.id_factura desc";
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
					<th>N.C.#</th>
					<th>Fecha</th>
					<th>Nro Fact.</th>
					<th>Cliente</th>
					<th>Encargado</th>
					<th>Total Factura</th>
					<th>Saldo Anterior</th>
					<th>Monto N.C.</th>
					<th class='text-right'>Saldo Existente</th>
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
						$estado_factura=$row['cantidad'];
						$condiciones=$row['estado_factura'];
						$total_venta=$row['total_venta'];
						$saldo=$row['saldo_original'];
						$saldo_anterior=$saldo+$estado_factura;
						$factura_venta=$row['id_producto'];
						if($condiciones==10){
                          $saldo=0;
                          $sql=mysqli_query($con, "select * from detalle_nc where numero_factura='".$numero_factura."'");
                         while ($row_det=mysqli_fetch_array($sql))
	                     {
	                     	$precio=$row_det['precio_venta'];
	                     	$cantidad=$row_det['cantidad'];
	                     	$saldo_anterior=$precio+$cantidad;
	                     	$saldo=$saldo_anterior;
	                     	$label_class='label-danger';
	                     }
						}
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						elseif($estado_factura==2){$text_estado="Pendiente";$label_class='label-danger';}
                        else{$text_estado="Anulado";$label_class='label-warning';}*/
						$total_venta=$row['total_venta'];
					?>
					<tr>
							
						<td ><?php echo $numero_factura; ?></td>

						<td><?php echo $fecha; ?></td>
			
						     <td><?php echo '001'.'-'.'001'.'-'.$factura_venta; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><?php echo number_format ($total_venta); ?></td>
						<td><?php echo number_format ($saldo_anterior); ?></td>
						<td><?php echo number_format ($estado_factura); ?></td>
						<td><?php echo number_format ($saldo); ?></td>
						
					<td class="text-right"> 
						<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-default' title='Editar N.C.' ><i class="glyphicon glyphicon-edit"></i></a>
					<?php if($condiciones!=10 and $saldo!=0){ ?>
						<a href="#" class='btn btn-default' title='Anular N.C.' onclick="eliminar('<?php echo $numero_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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