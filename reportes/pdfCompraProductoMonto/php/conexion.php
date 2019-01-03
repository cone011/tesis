<?php
$conexion = mysqli_connect('localhost', 'emr', 'x123456y', 'tesis');
function fechaNormal($fecha){
		$nfecha = date('d/m/Y',strtotime($fecha));
		return $nfecha;
}
?>