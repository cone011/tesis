<?php


	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        // $id_cliente=intval($_GET['id_cliente']);
         //echo $id_cliente;
		 /*$aColumns = array('codigo_producto', 'nombre_producto', 'status_producto');//Columnas de busqueda
		 $sTable = "productos";
		 $sWhere = "";*/
		 //echo $_GET['term'];
           $sTable = "compra,proveedores";
		    $sWhere = "";
		    $sWhere.=" WHERE compra.id_cliente=proveedores.id_cliente and compra.saldo_factura>0 and estado_factura=2";

		  
		if ( $_GET['q'] != "" )
		{
			/*$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			proveedores.nombre_cliente like '%$q%' or 
			$sWhere .= ')';*/
			$sWhere.= " and  (compra.numero_factura like '%$q%' or compra.fecha like '%$q%' or proveedores.nombre_cliente like '%$q%' or compra.fecha_factura like '%$q%' or compra.pf1 like '%$q%' or compra.pf2 like '%$q%' or compra.nrodoc like '%$q%')";
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
					<th>Fecha Cargada.</th>
					<th>Nro Factura.</th>
					<th><span class="pull-right">Saldo a Cobrar</span></th>
					<th><span class="pull-right">Total Saldo</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$precio_venta=$row["saldo_factura"];
                    if(strlen($row["pf1"])==1){
                       $wpf1='00';
                    }else{
                       $wpf1='0';
                    }
                    //CEROS PARA EL PREFIJO 2
                    if(strlen($row["pf2"])==1){
                       $wpf2='00';
                    }else{
                        $wpf2='0';
                    }
					 $id_producto=$row['numero_factura'];
					 $factura= $wpf1.$row['pf1'].'-'.$wpf2.$row['pf2'].'-'.$row['nrodoc'];
					 $codigo_producto=$row['id_cliente'];
					 $nombre_producto=$row['nombre_cliente'];					
					 $tipo=$row['estado_factura'];
					 $fecha=$row['fecha_factura'];
					 $ruc=$row['ruc_cliente'];
					?>
					<tr>
					<?php if($tipo==2){ ?>
						<td><?php echo $fecha; ?></td>
						<td><a href="#" data-toggle="tooltip" data-placement="top" title="<?php echo $nombre_producto;?> - <?php echo $ruc;?>" ><?php echo $factura;?></a></td>
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