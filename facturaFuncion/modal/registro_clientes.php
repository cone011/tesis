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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Estado del Usuario</label>
				<div class="col-sm-5">
				  <select class="form-control" id="nombre" name="nombre" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0" selected>Activo</option>
					<option value="1">Inactivo</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Gestion de Datos</label>
				<div class="col-sm-8">
				  <select class="form-control" id="telefono" name="telefono" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0" selected>Activo</option>
					<option value="1">Inactivo</option>
				  </select>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Accion Fact.</label>
				<div class="col-sm-5">
				    <select class="form-control" id="email" name="email" required>
					   <option value="">-- Selecciona estado --</option>
					   <option value="0" selected>Activo</option>
					   <option value="1">Inactivo</option>
				  </select>
				</div>
			  </div>
			 <div class="form-group">
				<label for="Ruc" class="col-sm-3 control-label">Accion Compra</label>
				<div class="col-sm-8">
				     <select class="form-control" id="ruc" name="ruc" required>
					   <option value="">-- Selecciona estado --</option>
					   <option value="0" selected>Activo</option>
					   <option value="1">Inactivo</option>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Accion Ajuste</label>
				<div class="col-sm-8">
					<select class="form-control" id="direccion" name="direccion" required>
					   <option value="">-- Selecciona estado --</option>
					   <option value="0" selected>Activo</option>
					   <option value="1">Inactivo</option>
				  </select>
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Reportes</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0" selected>Activo</option>
					<option value="1">Inactivo</option>
				  </select>
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