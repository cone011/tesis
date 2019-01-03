<?php


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $sTable = "cierre_detalle";
		 $sWhere = "";
		 $sWhere.=" WHERE cierre_detalle.nro_factura > (select max(factura_final)from cierre)" ;
		 $sWhere.=" or cierre_detalle.nro_compra > (select max(compra_final)from cierre)" ;	
		 $sWhere.=" or cierre_detalle.NRO_PAGO > (select max(op_final)from cierre)" ;			 
		if ( $_GET['q'] != "" )
		{
		//$sWhere.= " and  (cliente.nombre_cliente like '%$q%' or ncliente.numero_factura like '%$q%' or ncliente.fecha like '%$q%')";
			
		} 
		
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
					
					<th>Tipo</th>
					<th>Forma de Pago</th>
					<th>Nro. Factura</th>
					<th>Nro. Compra</th>
					<th>Nro. Pago</th>
					<th>Nro. Nota Credito</th>
					<th>Saldo Factura</th>
					<th>Total</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$TIPO=$row['TIPO'];
						$FORMA_DE_PAGO=$row['FORMA_DE_PAGO'];
						$NRO_FACTURA=$row['NRO_FACTURA'];
						$NRO_COMPRA=$row['NRO_COMPRA'];
						$NRO_PAGO=$row['NRO_PAGO'];
						$NRO_NC=$row['NRO_NC'];
						$SALDO_FACTURA=$row['SALDO_FACTURA'];
						$MONTO_TOTAL=$row['MONTO_TOTAL'];

					?>
					<tr>
						<td><?php echo $TIPO; ?></td>
						<td><?php echo $FORMA_DE_PAGO; ?></td>
						<td><?php echo $NRO_FACTURA; ?></td>
						<td><?php echo $NRO_COMPRA; ?></td>
						<td><?php echo $NRO_PAGO; ?></td>
						<td><?php echo $NRO_NC; ?></td>
						<td><?php echo $SALDO_FACTURA; ?></td>
						<td><?php echo $MONTO_TOTAL; ?></td>
						
					</tr>
					<?php
				}
				?>
				
			  </table>
			  <div align="center">
				<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
				?>
			  </div>
			</div>
			<?php
		}
	}
?>