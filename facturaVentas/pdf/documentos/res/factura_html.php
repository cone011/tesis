<?php 
//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO GUARANIES ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN GUARANIES  ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " GUARANIES "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

?>

<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?php echo ""; echo  $anio=date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <?php include("encabezado_factura.php");?>
    <br>
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURAR A</td>
        </tr>
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from cliente where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo $rw_cliente['telefono_cliente'];
				echo "<br>";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> Ruc: ";
				echo $rw_cliente['nombre_cliente'];
				echo "<br> Telefono: ";
				echo $rw_cliente['email_cliente'];
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:25%;" class='midnight-blue'>VENDEDOR</td>
		  <td style="width:20%;" class='midnight-blue'>FECHA</td>
		   <td style="width:20%;" class='midnight-blue'>FORMA DE PAGO</td>
            <td style="width:20%;" class='midnight-blue'>TIPO PAGO</td>
        </tr>
		<tr>
           <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['firstname']." ".$rw_user['lastname'];
                $quien=$rw_user['firstname']." ".$rw_user['lastname'];
			?>
		   </td>
		  <td style="width:20%;"><?php echo date("d/m/Y");?></td>
		   <td style="width:20%;" >
				<?php 
				if ($condiciones==1){echo "Contado";
                    $cuota=0;}
				elseif ($condiciones==2){echo "Credito a 30 dias";}
				?>      
		   </td>
           <td style="width:20%;">
                <?php 
                if ($pago==1){echo "Efectivo";}
                elseif ($pago==2){echo "Tarjeta";}
                elseif ($pago==3){echo "Cheque";}
                elseif ($pago==4){echo "Transferencia bancaria";}
                elseif ($pago==5){echo "Pago Combinado";

                   // echo $efectivo;
                }
                ?>      
           </td>


        </tr>
		
        
   
    </table>

<?php if($pago==5){ ?>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:20%;" class='midnight-blue'>PAGO EFECTIVO</td>
          <td style="width:20%;" class='midnight-blue'>PAGO TARJETA</td>
           <td style="width:20%;" class='midnight-blue'>PAGO CHEQUE</td>
            <td style="width:20%;" class='midnight-blue'>PAGO TRANSFERENCIA</td>
        </tr>
        <tr>
           <td style="width:20%;"><?php echo $efectivo;?></td>
          <td style="width:20%;"><?php echo $tarjeta;?></td>
           <td style="width:20%;"><?php echo $cheque;?></td>
           <td style="width:20%;"><?php echo $transferencia;?></td>
           <?php $parcial=$efectivo+$tarjeta+$cheque+$transferencia;
                 //echo $parcial;?>

        </tr>
        
        
   
    </table>
<?php } ?>

	<br>
  
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT./LITROS</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$nums=1;
$sumador_total=0;
$verificador_pago=0;
$ivatotal=0;
$iva10=0;
$iva5=0;
$exenta=0;
$auxiva05=0;
$auxiva10=0;
$monto10=0;
$monto5=0;
$monto0=0;
$verificador_factura=0;
$verificador_combinado=0;
$total_aux=0;


$sql=mysqli_query($con, "select * from productos, tmp where productos.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql)){

    $precioUnitario=$row['precio_producto'];    
    $precio_venta=$row['precio_tmp'];   
    $id_tmp=$row["id_tmp"];
    $cantidadtmp=$row['cantidad_tmp'];
    //$cantidad=number_format($precio_venta/$precioUnitario,2);

    $tipo=$row['tipo'];;

    $totalcantidad=0;

    

    if($tipo==1){
      $cantidad=number_format($cantidadtmp/$precioUnitario,8); 
      $cantidad_imprimir=number_format($cantidadtmp/$precioUnitario,2); 
      $precio_venta_f=number_format($cantidadtmp,2);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      $precio_total=$precio_venta_r;
      $precio_total_f=number_format($precio_total,0);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $verificador_pago+=$precio_total_r;//Sumador
    }else{
      $cantidad=$row['cantidad_tmp'];
      $precio_venta_f=number_format($precio_venta,0);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      $precio_total=$precio_venta_r*$cantidad;
      $precio_total_f=number_format($precio_total,0);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $verificador_pago+=$precio_total_r;//Sumador
    }
    
}
$sql=mysqli_query($con, "select * from productos, tmp where productos.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql))
	{
	$precioUnitario=$row['precio_producto'];	
	$precio_venta=$row['precio_tmp'];	
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
    $cantidadtmp=$row['cantidad_tmp'];
	//$cantidad=number_format($precio_venta/$precioUnitario,2);
	$nombre_producto=$row['nombre_producto'];
    $cantidadProducto=$row['cantidad_producto'];
    $tipo=$row['tipo'];
    $iva=$row['iva_producto'];
    $cantidad_producto=$row['cantidad_producto'];
    $precio_aux=$row['precio_producto'];
    $totalcantidad=0;
	
	/*$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador*/
    if($tipo==1){
      $cantidad=number_format($cantidadtmp/$precioUnitario,8); 
      $cantidad_imprimir=number_format($cantidadtmp/$precioUnitario,2); 
      $precio_venta_f=number_format($cantidadtmp,2);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      //$precio_total=$precio_venta_r*$cantidad;
      $precio_total=$precio_venta_r;
      $totalcantidad=$cantidadProducto-$cantidad;
      $precio_total_f=number_format($precio_total,0);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $sumador_total+=$precio_total_r;//Sumador
      $monto0+=$precio_venta;
    }else{
      $cantidad=$row['cantidad_tmp'];
      $cantidad_imprimir=$row['cantidad_tmp'];
      $precio_venta_f=number_format($precio_venta,0);//Formateo variables
      $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
      $precio_total=$precio_venta_r*$cantidad;
      //$precio_total=$precio_venta_r;
      $totalcantidad=$cantidadProducto-$cantidad;
      $precio_total_f=number_format($precio_total,0);//Precio total formateado
      $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
      $sumador_total+=$precio_total_r;//Sumador
    }
    $accion='AGREGADO';
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}

    if($iva==1){
      $ivaux=($precio_total_r / 1.1 )*0.1;
      $ivaux=number_format($ivaux,2,'.','');
      $auxiva10=($precio_total_r / 1.1 )*0.1;
      $auxiva10=number_format($auxiva10,2,'.','');
      $monto10+=$precio_total_r;
      $iva10+=$auxiva10;
      $ivatotal+=$ivaux;
    }elseif($iva==2){
      $ivaux=($precio_total_r / 1.05 )*0.1;
      $ivaux=number_format($ivaux,2,'.','');
      $auxiva05=($precio_total_r / 1.05 )*0.1;
      $auxiva05=number_format($auxiva05,2,'.','');
      $monto5+=$precio_total_r;
      $iva5+=$auxiva05;
      $ivatotal+=$ivaux;
    }



    /*if($cantidad_producto<0 || $cantidadtmp<0 ){
       $sumador_total=0;
       $ivatotal=0;
       $monto5=0;
       $iva5=0;
       $monto10=0;
       $iva10=0;
       $cantidad='NEGATIVO';
       $cantidad_imprimir='NEGATIVO';
       $codigo_producto='ERROR';
       $verificador_factura=1;
    }*/

	?>

        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo number_format($cantidad_imprimir,2); ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <?php if($tipo==1){ ?>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo number_format($precioUnitario,0);?></td>
        <?php }else{ ?>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
        <?php } ?>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
        
            
        </tr>

	<?php 
    
    
     //echo $parcial;
     //echo $verificador_combinado;
     /*if($pago==5){
        $sql_verificar=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."'");
        while ($row_verificar=mysqli_fetch_array($sql_verificar)){
       $monto=$row_verificar['cantidad_tmp']*$row_verificar['precio_tmp'];
       $verificador_combinado+=$monto;
       //echo $verificador_combinado;
       } 
       if($verificador_combinado!=$parcial){
         $verificador_factura=1;
         $condiciones=89;
       }
     }*/


   if($verificador_factura==1){
       $messages[] = "Error de cantidad de en la factura porfavor intentelo de nuevo.";
    }else{   
        $fech=date("Y-m-d");
        //Insert en la tabla detalle_cotizacion
        $sqlproducto="UPDATE productos SET cantidad_producto='".$totalcantidad."' WHERE id_producto='".$id_producto."'";
        $query_update = mysqli_query($con,$sqlproducto);
        $insert_detail=mysqli_query($con, "INSERT INTO detalle_venta VALUES ('','$numero_factura','$id_producto','$cantidad','$precio_venta_r','$fech','$totalcantidad')");
       $insert_audidetail=mysqli_query($con, "INSERT INTO audidetalle_venta VALUES ('','$numero_factura','$id_producto','$cantidad','$precio_venta_r','$accion')");
       $insert_detail=mysqli_query($con, "INSERT INTO venta VALUES ('','$numero_factura')");
    }
	
	
    
	$nums++;


	}
   /* $ivatotal=0;
    $iva10=0;
    $iva5=0;
    $exenta=0;
    $auxiva05=0;
    $auxiva10=0;*/
    $print10=10;
    $print05=5;
    $print0=0;
    /*$monto10=0;
    $monto5=0;
    $monto0=0;*/
    //echo $sumador_total;
    $total_aux=$sumador_total;
    //echo $total_aux;
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
	$subtotal=number_format($total_aux,2,'.','');
    /*if($verificador_factura==1){
       $total_factura=0;
       $subtotal=0;
    }*/
    if($iva==1){
     /* $total_iva=($subtotal / 1.1 )*0.1;
      $total_iva=number_format($total_iva,2,'.','');
      $auxiva10=($subtotal / 1.1 )*0.1;
      $auxiva10=number_format($auxiva10,2,'.','');
      $monto10=+$subtotal;*/
      $total_factura=$subtotal;
      /*$iva10+=$auxiva10;
      $ivatotal+=$total_iva;*/
    }elseif($iva==2){
     /* $total_iva=($subtotal / 1.05 )*0.1;
      $total_iva=number_format($total_iva,2,'.','');
      $auxiva05=($subtotal / 1.1 )*0.1;
      $auxiva05=number_format($auxiva05,2,'.','');
      $monto5+=$subtotal;
      $iva5+=$auxiva05;
      $ivatotal+=$total_iva;*/
      $total_factura=$subtotal;
    }elseif ($iva==3) {
        # code...
       /* $total_iva=$subtotal -$subtotal;
        $total_iva=number_format($total_iva,2,'.','');*/
        $total_factura=$subtotal;
        //$ivatotal+=$total_iva;
        /*$monto0=$subtotal;*/
    }
    $total_aux=$total_factura;
    //echo $total_aux;
    $titulo_monto = numtoletras($total_factura);


	
?>
    <?php if($verificador_factura==1){ ?>

        <td style="width: 25%; color: #444444;">
                <img style="width: 100%;" src="../../<?php echo get_row('perfil','marca_url', 'id_perfil', 1);?>" alt="Logo"><br>
                
            </td>
    <?php } ?>        

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,0);?></td>
        </tr>
		<tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL GRAV. (<?php echo $print10; ?>)% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($monto10,0);?></td>
        </tr>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL GRAV. (<?php echo $print05; ?>)% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($monto5,0);?></td>
        </tr>
        
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL GRAV. 0% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($monto0,0);?></td>
        </tr>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo $print10; ?>)% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($iva10,2);?></td>
        </tr>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">IVA (<?php echo $print05; ?>)% <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($iva5,2);?></td>
        </tr>
        
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL IVA <?php echo $simbolo_moneda;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($ivatotal,2);?></td>
        </tr>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $simbolo_moneda; echo $efectivo?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($sumador_total,0);?></td>
        </tr>
    </table>
	
	<div style="font-size:09pt;text-align:center;font-weight:bold"><?php echo $titulo_monto;?></div>

    <?php if($verificador_factura==1){ ?>
        <div style="font-size:09pt;text-align:center;font-weight:bold"><?php echo 'ERROR DE CANTIDAD VERIFICAR CON LA ADMINISTRACION';?></div>
    <?php } ?>    
	
	<br>
	<div style="font-size:11pt;text-align:center;font-weight:bold">Gracias por su compra!</div>
	
	
	  

</page>

<?php
$date=date("Y-m-d H:i:s");
$fecha=date("Y-m-d");
$fechaudi=date("Y-m-d H:i:s");
$pcname=gethostname();
$acc='AGREGADO';


//echo $sumador_total;

if($condiciones==1){
    $saldo_cliente=0;
   $insert=mysqli_query($con,"INSERT INTO venta VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$sumador_total','$condiciones','$acc','$fecha','$saldo_cliente','$pago','$efectivo','$tarjeta','$cheque','$transferencia','$cuota')");
   $insert_audi=mysqli_query($con,"INSERT INTO audiventa VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$sumador_total','$condiciones','$fechaudi','$quien','$pcname')");
}elseif($condiciones==2){
    $fecha=date("Y-m-d");
    $fecha_vencimiento=date("Y-m-d",strtotime($date."+ 1 month"));
    $insert=mysqli_query($con,"INSERT INTO venta VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$sumador_total','$condiciones','$acc','$fecha','$sumador_total','$pago','$efectivo','$tarjeta','$cheque','$transferencia','$cuota')");
    $insert_audi=mysqli_query($con,"INSERT INTO audiventa VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$sumador_total','$condiciones','$fechaudi','$quien','$pcname','$acc')");
     $insert=mysqli_query($con,"INSERT INTO cuentacliente VALUES (NULL,'$numero_factura','$date','$id_cliente','$id_vendedor','$condiciones','$sumador_total','$condiciones','$fecha_vencimiento','$sumador_total')");

}

$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");

?>