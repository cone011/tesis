	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">E.M.R.</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_facturas;?>"><a href="http://localhost/tesis/facturaCompras/facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Ordenes de Compras <span class="sr-only">(current)</span></a></li>
        <?php if($factura==1 || $compra==1){ ?>
          <li class="dropdown">  
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nota Credito<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_ncliente;?>"><a href="http://localhost/tesis/notaCliente/facturas.php"><i class='glyphicon glyphicon-user'></i> N.C Cliente</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_nproov;?>"><a href="http://localhost/tesis/notaProveedor/facturas.php"><i class='glyphicon glyphicon-user'></i> N.C Proveedor</a></li>       
          </ul>
        </li>
      <?php } ?>

      <?php if($gestion==1){ ?>  
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_productos;?>"><a href="http://localhost/tesis/ajusteProducto/productos.php"><i class='glyphicon glyphicon-copyright-mark'></i> Productos</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_clientes;?>"><a href="http://localhost/tesis/facturaVentas/clientes.php"><i class='glyphicon glyphicon-camera'></i> Clientes</a></li>
            <li class="<?php echo $active_prooveedor;?>"><a href="http://localhost/tesis/facturaProveedor/clientes.php"><i class='glyphicon glyphicon-camera'></i> Proveedores</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_usuarios;?>"><a href="http://localhost/tesis/facturaVentas/usuarios.php"><i class='glyphicon glyphicon-user'></i> Usuarios</a></li>
            <li class="<?php echo $active_funcion;?>"><a href="http://localhost/tesis/facturaFuncion/clientes.php"><i class='glyphicon glyphicon-user'></i> Gestion Roles</a></li>      
          </ul>
        </li>
      <?php } ?>

       <?php if($reporte==1){ ?>  
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_reporte_venta;?>"><a href="http://localhost/tesis/facturaVentas/pdfVentas/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF Ventas </a></li>
            <li class="<?php echo $active_reporte_compra;?>"><a href="http://localhost/tesis/facturaCompras/pdfCompras/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF O.C. </a></li>
            <li role="separator" class="divider"></li>

            <li class="<?php echo $active_reporte_cliente;?>"><a href="http://localhost/tesis/facturaVentas/pdfCliente/vistas/index.php"><i class='glyphicon glyphicon-user'></i> PDF Cta. Cliente</a></li>   
            <li class="<?php echo $active_reporte_prov;?>"><a href="http://localhost/tesis/facturaCompras/pdfProveedor/vistas/index.php"><i class='glyphicon glyphicon-user'></i> PDF Cta. Proveedor</a></li>    
            <li role="separator" class="divider"></li> 
   
            <li class="<?php echo $active_ajuste;?>"><a href="http://localhost/tesis/ajusteProducto/pdfAjuste/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF Ajuste</a></li>   
            <li class="<?php echo $active_cierre;?>"><a href="http://localhost/tesis/facturaFuncion/pdfCierre/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF Cierre</a></li>   

            <li class="<?php echo $active_ncliente;?>"><a href="http://localhost/tesis/facturaVentas/pdfSaldoCliente/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF NC Cliente</a></li>   

            <li class="<?php echo $active_nproveedor;?>"><a href="http://localhost/tesis/facturaCompras/pdfSaldoCompra/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF NC Proveedores</a></li>    
            

            <li role="separator" class="divider"></li>   
            <li class="<?php echo $active_venta_ex;?>"><a href="http://localhost/tesis/facturaVentas/excelVenta/descargar_reporte_bd.php"><i class='glyphicon glyphicon-user'></i> Excel Venta</a></li>   
            <li class="<?php echo $active_compra_ex;?>"><a href="http://localhost/tesis/facturaCompras/excelCompra/descargar_reporte_bd.php"><i class='glyphicon glyphicon-user'></i>Excel Compra</a></li>  
            <li class="<?php echo $active_venta_det;?>"><a href="http://localhost/tesis/facturaVentas/excelVentaDet/descargar_reporte_bd.php"><i class='glyphicon glyphicon-user'></i> Excel Venta Det</a></li>   
            <li class="<?php echo $active_compra_det;?>"><a href="http://localhost/tesis/facturaCompras/excelCompraDet/descargar_reporte_bd.php"><i class='glyphicon glyphicon-user'></i>Excel Compra Det</a></li>  

            <li class="<?php echo $active_excelcierre;?>"><a href=http://localhost/tesis/ajusteProducto/excelCierre/descargar_reporte_bd.php"><i class='glyphicon glyphicon-save-file'></i>Excel Cierre</a></li> 
            <li class="<?php echo $active_excelnproveedor;?>"><a href="http://localhost/tesis/facturaCompras/excelProveedor/descargar_reporte_bd.php"><i class='glyphicon glyphicon-save-file'></i>Excel NC Proveedor</a></li> 
            <li class="<?php echo $active_excelncliente;?>"><a href="http://localhost/tesis/facturaVentas/excelcliente/descargar_reporte_bd.php"><i class='glyphicon glyphicon-save-file'></i>Excel NC Cliente</a></li>     

            <li role="separator" class="divider"></li>

          </ul>
        </li>
      <?php } ?>

        <li class="<?php echo $active_venta;?>"><a href="http://localhost/tesis/facturaVentas/facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Facturacion <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_ajuste;?>"><a href="http://localhost/tesis/ajusteProducto/facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Ajuste de Inventario <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_bk;?>"><a href="http://localhost/tesis/generarBK/bk.php"><i class='glyphicon glyphicon-import'></i> Copia de Datos <span class="sr-only">(current)</span></a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        
		<li><a href="http://localhost/tesis/facturaVentas/login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>