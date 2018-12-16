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
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		$query=mysqli_query($con, "select * from cierre where id_cierre='".$id_producto."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM cierre WHERE id_cierre='".$id_producto."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  producto. Existen cotizaciones vinculadas a éste producto. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('id_cierre','factura_incial','factura_final','fecha_add');//Columnas de busqueda
		 $sTable = "cierre";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by id_cierre desc";
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
		$reload = './productos.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>	
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th># Cierre</th>
					<th>Factura Inicial</th>
					<th>Factura Final</th>
					<th>Monto Contado</th>
					<th>Monto Credito</th>
					<th>Monto Anulado</th>
					<th>Total Recaudado</th>
					<th>Fecha/Hora Cierre</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					    $monto_contado=0;
					    $monto_credito=0;
					    $monto_anulado=0;
					    $total=0;
						$id_producto=$row['id_cierre'];
						$codigo_producto=$row['factura_incial'];
						$nombre_producto=$row['factura_final'];
						$status_producto=$row['fecha_add'];
						$sql_monto=mysqli_query($con, "select total_venta,condiciones from venta where venta.numero_factura>='".$codigo_producto."' and venta.numero_factura<='".$nombre_producto."'");
                        while ($row2=mysqli_fetch_array($sql_monto))
	                    {
	                    	$condicion=$row2['condiciones'];
	                    	$monto=$row2['total_venta'];
	                    	if($condicion==1){
                               $monto_contado+=$monto;
                               $total+=$monto;
	                    	}elseif($condicion==2){
                                $monto_credito+=$monto;
                                $total+=$monto;
	                    	}else{
                                $monto_anulado+=$monto;
                                $total+=$monto;
	                    	}
	                    	
	                    }
						
					?>
					
					<tr>
					  
						<td><?php echo $id_producto; ?></td>
						<td ><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto;?></td>
						<td><?php echo $monto_contado;?></td>
						<td><?php echo $monto_credito;?></td>
						<td><?php echo $monto_anulado;?></td>
                        <td><?php echo $total;?></td>
                        <td><?php echo $status_producto;?></td>
	
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right">
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