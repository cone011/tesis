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
        <li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Facturacion <span class="sr-only">(current)</span></a></li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_productos;?>"><a href="productos.php"><i class='glyphicon glyphicon-copyright-mark'></i> Productos</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-camera'></i> Clientes</a></li>
            <li class="<?php echo $active_prooveedor;?>"><a href="http://localhost/tesis/facturabk/clientes.php"><i class='glyphicon glyphicon-camera'></i> Proveedores</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i class='glyphicon glyphicon-user'></i> Usuarios</a></li>         
          </ul>
        </li>
    
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="<?php echo $active_reporte_venta;?>"><a href="http://localhost/tesis/facturaVentas/pdfVentas/vistas/index.php"><i class='glyphicon glyphicon-save-file'></i> PDF Ventas </a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-camera'></i> Clientes</a></li>
            <li class="<?php echo $active_prooveedor;?>"><a href="http://localhost/tesis/facturabk/clientes.php"><i class='glyphicon glyphicon-camera'></i> Proveedores</a></li>
            <li role="separator" class="divider"></li>
            <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i class='glyphicon glyphicon-user'></i> Usuarios</a></li>         
          </ul>
        </li>

        <li class="<?php echo $active_compra;?>"><a href="http://localhost/tesis/facturaCompras/facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Ordenes de Compra <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_ajuste;?>"><a href="http://localhost/tesis/ajusteProducto/facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Ajuste de Inventario <span class="sr-only">(current)</span></a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">

		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>