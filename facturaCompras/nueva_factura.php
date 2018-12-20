<?php

	session_start();
	$id=$_SESSION['user_id'];

$host="localhost";
$user="root";
$password="";
$db="tesis";
$con = new mysqli($host,$user,$password,$db);

$sql1= "select * from users where user_id='$id'";
$query = $con->query($sql1);
while ($r=$query->fetch_array()){
    $factura=$r['factura'];
    $compra=$r['compra'];
    $ajuste=$r['inventario'];
    $reporte=$r['reporte'];
    $gestion=$r['gestion'];
 }
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	if ($factura==0) {
        $active_venta="hide";
        $active_ncliente="hide";
	}else{
		$active_venta="";
		$active_ncliente="";
	}

	if ($compra==0) {
        $active_facturas="hide";
        $active_nproov="hide";
	}else{
		$active_facturas="active";
		$active_nproov="";
	}

	if ($ajuste==0) {
        $active_ajuste="hide";
	}else{
		$active_ajuste="";
	}
    
    if($gestion==0){
       $active_productos="hide";
	   $active_clientes="hide";
	   $active_prooveedor="hide";
	   $active_usuarios="hide";
	   $active_funcion="hide";
    }else{
       $active_productos="";
	   $active_clientes="";
	   $active_prooveedor="";
	   $active_usuarios="";
	   $active_funcion="";
    }
    
    if($reporte==0){
    	//PDF
       $active_reporte_venta="hide";
	   $active_reporte_compra="hide";
	   $active_reporte_cliente="hide";
	   $active_reporte_prov="hide";  
	   $active_ajuste="hide";  
	   $active_cierre="hide";
	   $active_ncliente="hide";
	   $active_nproveedor="hide";
	  

	   //EXCEL
	   $active_venta_ex="hide";
	   $active_compra_ex="hide";
	   $active_compra_det="hide";
	   $active_venta_det="hide";
	   $active_excelcierre="hide";
	   $active_excelncliente="hide";
	   $active_excelnproveedor="hide";
	  

    }else{
    	//PDF
       $active_reporte_venta="";
	   $active_reporte_compra="";
	   $active_reporte_cliente="";
	   $active_reporte_prov="";
	   $active_ajuste="";   
	   $active_cierre="";
	   $active_ncliente="";
	   $active_nproveedor="";

	   //EXCEL
	   $active_venta_ex="";
	   $active_compra_ex="";
	   $active_compra_det="";
	   $active_venta_det="";
	   $active_excelcierre="";
	   $active_excelncliente="";
	   $active_excelnproveedor="";

    }
	
	$active_bk="";
	$title="Nueva Orden | Estacion E.M.R.";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	 <script>

    	function mostrar(id) {
   
    if (id == "0") {
		$("#pagocombinado").hide();
    }
	if (id == "5") {
		$("#pagocombinado").show();
    }
	if (id == "4") {
        $("#pagocombinado").hide();
    }
	if (id == "3") {
        $("#pagocombinado").hide();
    }
    if (id == "2") {
        $("#pagocombinado").hide();
    }
    if (id == "1") {
        $("#pagocombinado").hide();
    }
}

function mostrar_cuota(id) {
    if (id == "1") {
        $("#cargacuota").hide();
    }

    if (id == "2") {
        $("#cargacuota").show();
    }

}


	</script>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Orden</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Proveedor: </label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required>
					  <input id="id_cliente" type='hidden'>	
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono: </label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly>
							</div>
					<label for="mail" class="col-md-1 control-label">Ruc: </label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Ruc" readonly>
							</div>

					<label for="factura" class="col-md-1 control-label">Nro de Orden: </label>		
							<div class="col-md-1">
								<?php   
										$sql_factura=mysqli_query($con,"select max(numero_factura) as last from compra");
										while ($rw=mysqli_fetch_array($sql_factura)){
											$id_factura=$rw["last"]+1;
											?>
											<input type="text" class="form-control input-sm" id="factura" placeholder="factura" value="<?php echo $id_factura?>" readonly>
											<?php
										}
									?>
							</div>		

				 </div>

				 <div class="form-group row">
							<label for="pf1" class="col-md-1 control-label"> Pf1</label>
							<div class="col-md-1">
								<input type="number" class="form-control input-sm" id="pf1" required>
							</div>

							<label for="pf2" class="col-md-1 control-label"> Pf2</label>
							<div class="col-md-1">
								<input type="number" class="form-control input-sm" id="pf2" required>
							</div>

							<label for="nrodoc" class="col-md-1 control-label"> Nro Fact.</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="nrodoc" required>
							</div>

							<label for="timbrado" class="col-md-1 control-label"> Timbrado</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="timbrado" required>
							</div>
				</div>

						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Encargado: </label>
							<div class="col-md-2">
								<select class="form-control input-sm" id="id_vendedor">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$_SESSION['user_id']){
												$selected="selected";
											} else {
												$selected="";
											}
											?>
											<option value="<?php echo $id_vendedor?>" <?php echo $selected;?>><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha: </label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
							</div>
							<label for="email" class="col-md-1 control-label">Pago: </label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="condiciones" onChange="mostrar_cuota(this.value);">
									<option value="1">Contado</option>
									<option value="2" selected>Credito</option>
								</select>
							</div>
							<label for="pago" class="col-md-1 control-label">Tipo Pago: </label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="pago" onChange="mostrar(this.value);">
									<option value="1">Efectivo</option>
									<option value="2">Tarjeta</option>
									<option value="3">Cheque</option>
									<option value="4">Transferencia bancaria</option>
									<option value="5" selected>Pago Combinado</option>
								</select>
							</div>
						</div>

						<div class="form-group row" id="pagocombinado">

							
							<label for="efectivo" class="col-md-1 control-label">Pago Efectivo</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="efectivo">
							</div>

							<label for="tarjeta" class="col-md-1 control-label">Pago Tarjeta</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="tarjeta">
							</div>

							<label for="cheque" class="col-md-1 control-label">Pago Cheque</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="cheque">
							</div>

							<label for="transferencia" class="col-md-1 control-label">Pago Transferencia</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="transferencia">
							</div>
							
							
						</div>

						<div class="form-group row" id="cargacuota">
							<label for="cuota" class="col-md-1 control-label"> Cuotas</label>
							<div class="col-md-1">
								<input type="number" class="form-control input-sm" id="cuota">
							</div>
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/nueva_factura.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.ruc_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	
	</script>

  </body>
</html>