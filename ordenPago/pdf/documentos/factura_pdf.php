<?php
	
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
	echo "<script>alert('No hay Factura Compras agregadas a la Orden')</script>";
	echo "<script>window.close();</script>";
	$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
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
	//$factura=intval($_GET['factura']);
	//$cuota=intval($_GET['cuota']);
	//$pago=mysqli_real_escape_string($con,(strip_tags($_REQUEST['pago'], ENT_QUOTES)));
	$total=0;
	$monto=0;
	$validacion=0;
	$cobranza=0;
       $sql_venta=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."'");
       while($row_venta=mysqli_fetch_array($sql_venta)){
       	    $monto+=$row_venta['cantidad_tmp'];
       	    //$monto=number_format($monto,0);
       }
       //$total=$efectivo+$tarjeta+$cheque+$transferencia;
       //$total=number_format($total,2);
       if($efectivo<0){
           echo "<script>alert('Los montos de los pagos combinados no son correctos')</script>";
	       echo "<script>window.close();</script>";
	       $delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
	       exit;
       }
       if($efectivo!=$monto){
           echo "<script>alert('Los montos de los pagos combinados no son correctos')</script>";
	       echo "<script>window.close();</script>";
	       $delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
	       exit;
       }
       
    $sql_cobranza=mysqli_query($con, "select max(numero_factura) as last from op");
       while($row_cobranza=mysqli_fetch_array($sql_cobranza)){
       	    $cobranza=$row_cobranza["last"]+1;
       }
	//Fin de variables por GET
	/*$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from ncliente order by id_factura desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	$numero_factura=$rw['last']+1;*/	
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
