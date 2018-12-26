<?php


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 /*$aColumns = array('codigo_producto', 'nombre_producto', 'status_producto');//Columnas de busqueda
		 $sTable = "productos";
		 $sWhere = "";*/
		  $sTable = "cuentacliente,cliente,venta";
		 $sWhere = "";
		 $sWhere.=" WHERE cuentacliente.id_cliente=cliente.id_cliente and venta.numero_factura=cuentacliente.numero_factura and cuentacliente.saldo_factura>0";
		if ( $_GET['q'] != "" )
		{
			/*$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';*/
			$sWhere.= " and  (cliente.nombre_cliente like '%$q%' or cuentacliente.numero_factura like '%$q%' or cuentacliente.fecha_vencimiento like '%$q%' or venta.fecha_factura like '%$q%')";
		}
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Fecha Factura.</th>
					<th>Nro Factura.</th>
					<th><span class="pull-right">Saldo a Cobrar</span></th>
					<th><span class="pull-right">Total Saldo</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$precio_venta=$row["saldo_factura"];
                       
					 $id_producto=$row['numero_factura'];
					 $factura='001'.'-'.'001'.'-'.$id_producto;
					 $codigo_producto=$row['id_cliente'];
					 $nombre_producto=$row['nombre_cliente'];
					 $telefono_cliente=$row['telefono_cliente'];
					 $email_cliente=$row['email_cliente'];				
					 $tipo=$row['estado_factura'];
					 $fecha_factura=$row['fecha_factura'];
					?>
					<tr>
					<?php if($tipo==2){ ?>
						<td><?php echo $fecha_factura; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo $nombre_producto;?> - <?php echo $telefono_cliente;?> - <?php echo $email_cliente;?>"><?php echo $factura;?></a></td>
						<td class='col-xs-2'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta; ?>" >
						</div></td>
						<td class='col-xs-2'><div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>" readonly>
						</div></td>
						<td class='text-center'><a class='btn btn-info'href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
					<?php } ?>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>