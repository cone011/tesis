<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
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
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
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
		$active_facturas="";
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
	   $active_funcion="active";
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
	$title="Gestion Acciones | E.M.R.";
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
		    <div class="btn-group pull-right">
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Usuarios/Acciones</h4>
		</div>
		<div class="panel-body">
		
			
			
			<?php
				include("modal/registro_clientes.php");
				include("modal/editar_clientes.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Usuario</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Usuario" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			
		
	
			
			
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/clientes.js"></script>
  </body>
</html>
