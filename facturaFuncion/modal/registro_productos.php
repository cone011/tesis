	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar Cierre</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Numero Cierre</label>
				<div class="col-sm-8">
				  <?php   
						$sql_factura=mysqli_query($con,"select max(id_cierre) as last from cierre");
						while ($rw=mysqli_fetch_array($sql_factura)){
								$id_factura=$rw["last"]+1;
					    }
					?>
				  <input type="text" class="form-control" id="codigo" placeholder="codigo" value="<?php echo $id_factura?>" readonly>
				</div>
			  </div>
			  
			  <div class="form-group">  	
				<label for="nombre" class="col-sm-3 control-label">Factura Inicial</label>
				<div class="col-sm-8">
					<?php   
						$sql_factura=mysqli_query($con,"select max(factura_final) as last from cierre");
						while ($rw=mysqli_fetch_array($sql_factura)){
								$id_inicial=$rw["last"]+1;
					    }
				    ?>
				    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="codigo" value="<?php echo $id_inicial?>" readonly>
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Factura Final</label>
				<div class="col-sm-8">
					<?php   
						$sql_factura=mysqli_query($con,"select max(numero_factura) as last from venta");
						while ($rw=mysqli_fetch_array($sql_factura)){
								$id_final=$rw["last"];
					    }
				?>
					<input type="text" class="form-control" id="estado" name="estado" placeholder="codigo" value="<?php echo $id_final?>" readonly>
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Fecha Cierre</label>
				<div class="col-sm-8">
                  <?php $date=date("Y-m-d H:i:s"); ?>
				  <input type="text" class="form-control" id="precio" name="precio" placeholder="codigo" value="<?php echo $date?>" readonly>
				</div>
			  </div>

			
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>