<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	session_start();
	$validar=0;
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	
	
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	$session_id= session_id();


	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0 or $validar==1)
	{
	echo "<script>alert('No hay productos agregados a la factura')</script>";
	echo "<script>window.close();</script>";
	exit;
	}

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=intval($_GET['id_cliente']);
	$id_vendedor=intval($_GET['id_vendedor']);
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$pago=mysqli_real_escape_string($con,(strip_tags($_REQUEST['pago'], ENT_QUOTES)));
	//$parcial=intval($_GET['parcial']);
	$efectivo=intval($_GET['efectivo']);
	$tarjeta=intval($_GET['tarjeta']);
	$cheque=intval($_GET['cheque']);
	$transferencia=intval($_GET['transferencia']);
	$cuota=intval($_GET['cuota']);
	//$pago=mysqli_real_escape_string($con,(strip_tags($_REQUEST['pago'], ENT_QUOTES)));
	$total=0;
	$monto=0;
	if($condiciones==2){
		if($cuota<=0){
            echo "<script>alert('Las cuota no pueden tener valor negativo o nulo')</script>";
	       echo "<script>window.close();</script>";
	       exit;
		}
	}
    if($pago==5){
       $sql_venta=mysqli_query($con, "select * from tmp,productos where tmp.id_producto=productos.id_producto and tmp.session_id='".$session_id."'");
       while($row_venta=mysqli_fetch_array($sql_venta)){
       	    $validar=$row_venta['tipo'];
       	    if($validar==1){
               $monto+=$row_venta['cantidad_tmp'];
       	    }else{
               $monto+=$row_venta['cantidad_tmp']*$row_venta['precio_tmp'];
       	    }
            //echo $monto;
       }
       $total=$efectivo+$tarjeta+$cheque+$transferencia;
       //echo $total;
       //$total=number_format($total,2);
       if($cheque<0 || $efectivo<0 || $transferencia<0 || $tarjeta<0){
           echo "<script>alert('Los montos de los pagos combinados no son correctos')</script>";
	       echo "<script>window.close();</script>";
	       exit;
       }
       /*if($total!=$monto){
           echo "<script>alert('Los montos de los pagos combinados no son correctos')</script>";
	       echo "<script>window.close();</script>";
	       exit;
       }*/
       
    }
	//Fin de variables por GET
	$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from venta order by id_factura desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;	
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/factura_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
