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
		
	$title="Editar O.C. | E.M.R.";
	$timbra="";

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

    $title="Editar O.C. | E.M.R.";
	
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_factura']))
	{
		$id_factura=intval($_GET['id_factura']);
		$campos="proveedores.id_cliente, proveedores.nombre_cliente, proveedores.telefono_cliente, proveedores.ruc_cliente, compra.id_vendedor, compra.fecha_factura, compra.condiciones, compra.estado_factura, compra.numero_factura,compra.tipo_pago,compra.saldo_factura,compra.pf1,compra.efectivo,compra.tarjeta,compra.cheque,compra.transferencia,compra.pf2,compra.nrodoc,compra.timbrado";
		$sql_factura=mysqli_query($con,"select $campos from compra, proveedores where compra.id_cliente=proveedores.id_cliente and id_factura='".$id_factura."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
				$rw_factura=mysqli_fetch_array($sql_factura);
				$id_cliente=$rw_factura['id_cliente'];
				$nombre_cliente=$rw_factura['nombre_cliente'];
				$telefono_cliente=$rw_factura['telefono_cliente'];
				$email_cliente=$rw_factura['ruc_cliente'];
				$id_vendedor_db=$rw_factura['id_vendedor'];
				$fecha_factura=date("d/m/Y", strtotime($rw_factura['fecha_factura']));
				$condiciones=$rw_factura['condiciones'];
				$estado_factura=$rw_factura['estado_factura'];
				$numero_factura=$rw_factura['numero_factura'];
				$saldo=$rw_factura['saldo_factura'];
				$tipo=$rw_factura['tipo_pago'];
				$cobrar=$rw_factura['tipo_pago'];
				$efectivo=$rw_factura['efectivo'];
				$tarjeta=$rw_factura['tarjeta'];
				$cheque=$rw_factura['cheque'];
				$transferencia=$rw_factura['transferencia'];
                $pf1=$rw_factura['pf1'];
                $pf2=$rw_factura['pf2'];
                $nrodoc=$rw_factura['nrodoc'];
				$timbrado=$rw_factura['timbrado'];
				if ($tipo==1){$leyenda="Efectivo";}
                elseif ($tipo==2){$leyenda="Tarjeta";}
                elseif ($tipo==3){$leyenda="Cheque";}
                elseif ($tipo==4){$leyenda="Transferencia bancaria";}
                elseif ($tipo==5){$leyenda="Pago Combinado";}
				$_SESSION['id_factura']=$id_factura;
				$_SESSION['numero_factura']=$numero_factura;
				$_SESSION['cobrar']=$cobrar;
				$_SESSION['efectivo']=$efectivo;
				$_SESSION['tarjeta']=$tarjeta;
				$_SESSION['cheque']=$cheque;
				$_SESSION['transferencia']=$transferencia;
		}	
		else
		{
			header("location: facturas.php");
			exit;	
		}
	} 
	else 
	{
		header("location: facturas.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Orden</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_factura">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>" readonly>
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>" >	
				  </div>
				 
					<label for="mail" class="col-md-1 control-label">Ruc</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly value="<?php echo $email_cliente;?>">
							</div>
							 <label for="pago" class="col-md-1 control-label">Tipo de Pago</label>
							<div class="col-md-2">
									<input type="text" class="form-control input-sm" id="pago" value="<?php echo $leyenda;?>" readonly>
							</div>
									
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Vendedor</label>
							<div class="col-md-2">
								<select class="form-control input-sm" id="id_vendedor" name="id_vendedor" readonly>
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											if ($id_vendedor==$id_vendedor_db){
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
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo $fecha_factura;?>" readonly>
							</div>
							<label for="email" class="col-md-1 control-label">Pago</label>
							<div class="col-md-2">
								<select class='form-control input-sm ' id="condiciones" name="condiciones" readonly>
									<option value="1" <?php if ($condiciones==1){echo "selected";}?>>Contado</option>
									<option value="2" <?php if ($condiciones==2){echo "selected";}?>>Credito</option>
									<option value="3" <?php if ($condiciones==3){echo "selected";}?>>POS</option>
								</select>
							</div>
							<div class="col-md-2">
								<?php if($estado_factura==1){ ?> 
								<select class='form-control input-sm ' id="estado_factura" name="estado_factura" readonly>
									<option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>
								</select>
								<?php } ?>
								<?php if($estado_factura==2){ ?>
							       <input type="text" class="form-control input-sm" id="estado_factura"  name="estado_factura" value="<?php echo $saldo ?>" placeholder="Cantidad Gs.">								
								<?php } ?>
							</div>
						</div>


						<div class="form-group row">
							<label for="pf1" class="col-md-1 control-label"> Pf1</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" id="pf1" value="<?php echo $pf1 ?>;" readonly>
							</div>

							<label for="pf2" class="col-md-1 control-label"> Pf2</label>
							<div class="col-md-1">
								<input type="text" class="form-control input-sm" id="pf2" value="<?php echo $pf2 ?>;"readonly>
							</div>

							<label for="nrodoc" class="col-md-1 control-label"> Nro Fact.</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="nrodoc" value="<?php echo $nrodoc ?>;" readonly>
							</div>

							<label for="timbrado" class="col-md-1 control-label"> Timbrado</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="timbrado" value="<?php echo $timbrado ?>;" readonly>
							</div>
				</div>

						<div class="form-group row">
							 <div class="form-group row">
                    <label for="efectivo" class="col-md-1 control-label">Tipo Pago</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="cobrar" name="cobrar">
									<option value="1">Efectivo</option>
									<option value="2">Tarjeta</option>
									<option value="3">Cheque</option>
									<option value="4">Transferencia bancaria</option>
									<option value="5">Pago Combinado</option>
								</select>
							</div>
               </div>
                           

						</div>

						<div class="form-group row">
							<label for="efectivo" class="col-md-1 control-label">Pago Efectivo</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="efectivo" name="efectivo">
							</div>

							<label for="tarjeta" class="col-md-1 control-label">Pago Tarjeta</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="tarjeta" name="tarjeta">
							</div>

							<label for="cheque" class="col-md-1 control-label">Pago Cheque</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="cheque" name="cheque">
							</div>

							<label for="transferencia" class="col-md-1 control-label">Pago Transferencia</label>
							<div class="col-md-2">
								<input type="number" class="form-control input-sm" id="transferencia" name="transferencia">
							</div>
							
							
						</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
					  <?php if($estado_factura==2){ ?>	
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>
					 <?php } ?>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_factura.js"></script>
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
								$('#mail').val(ui.item.email_cliente);
																
								
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