	<?php
		if (isset($con))
		{


	?>
	
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Registracion de Factura y Timbrado</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  <?php
										$sql_vendedor=mysqli_query($con,"select * from factura where nombre_cliente='".$id_factura."'");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$pf1=$rw["telefono_cliente"];
											$pf2=$rw["email_cliente"];
											$nro=$rw["ruc_cliente"];
											$timbrado=$rw["direccion_cliente"];
											$status=$rw["status_cliente"];
										}
				?>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Numero de Orden: </label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo $id_factura?>" readonly>
				</div>
			  </div>

			<?php if(!empty($pf1)){?>
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Prefijo 1</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $pf1?>">
				</div>
			  </div>
			<?php }else{?>  
				<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Prefijo 1</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="telefono" name="telefono" required>
				</div>
			  </div>
			<?php	}?>

            <?php if(!empty($pf2)){?>
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Prefijo 2</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $pf1?>">
				</div>
			  </div>
            <?php }else{?> 
                 <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Prefijo 2</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="email" name="email" required>
				</div>
			  </div>
            <?php	}?>

            <?php if(!empty($nro)){?> 
			 <div class="form-group">
				<label for="Ruc" class="col-sm-3 control-label">Numero de Factura</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $nro?>"> 
				</div>
			  </div>
			<?php }else{?>   
                <div class="form-group">
				<label for="Ruc" class="col-sm-3 control-label">Numero de Factura</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="ruc" name="ruc" required> 
				</div>
			  </div>
            <?php	}?>
            
            <?php if(!empty($timbrado)){?>
			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Timbrado</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $timbrado?>">
				</div>
			  </div>
			<?php }else{?>
               <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Timbrado</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="direccion" name="direccion" required>
				</div>
			  </div>
			<?php	}?>

			<?php if(!empty($status)){?> 
               <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
				 	<?php if($status==1){ ?>
					   <option value="1" selected>Activo</option>
					<?php }else{?>  
					   <option value="0">Inactivo</option>
					<?php	}?>
				  </select>
				</div>
			  </div>
            <?php }else{?>  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			<?php	}?> 
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<?php if(empty($pf1)&&empty($pf2)&&empty($nro)&&empty($timbrado)){?>
			   <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
			<?php }?>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>