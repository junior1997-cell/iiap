<?php 
function obtener_mes($id){
	$id -=1;
	$meses = array (
		'enero',
		'febrero',
		'marzo',
		'abril',
		'Mayo',
		'junio',
		'julio',
		'agosto',
		'setiembre',
		'octubre',
		'noviembre',
		'diciembre'
	);

	return $meses[$id];
}

function mayusculas($data_cruda,$minusculas){

	
    $data_lista = $data_cruda;
    foreach ($data_cruda as $nombre_campo => $valor_campo) {
    	if ( in_array($nombre_campo, array_values($minusculas))) {
    		$data_lista[$nombre_campo] = strtoupper($valor_campo);
    	}
    }
  return  $data_lista;
}
		

 ?>