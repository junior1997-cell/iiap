<?php 
	ob_start();
	
	require_once "../modelos/curso.php";

	$curso=new Curso_iiap();
	//$id=$GET["id"];
	//$id;
	switch ($_GET["op"]){
		case 'list_all_curso':			
			//var_dump($dni); die;
			$rspta=$curso->listar_curso_all();				
			//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;
		case 'list_one_curso':
			$id=$_GET["id"];
			//var_dump($ides);die;			
			//var_dump($dni); die;
			$rspta=$curso->listar_curso_one($id);				
			 		//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;
		case 'curso_mas_valorado':
			$id=$_GET["id"];
			//var_dump($ides);die;			
			//var_dump($dni); die;
			$rspta=$curso->listar_curso_valorado($id);				
			 		//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;

		case 'curso_agricultura':
			$rspta=$curso->listar_curso_agricultura();				 		
			echo json_encode($rspta);
			break;

		case 'curso_acuicola':
			$rspta=$curso->listar_curso_acuicola();				 		
			echo json_encode($rspta);
			break;

		case 'curso_zootecnia':
			$rspta=$curso->listar_curso_zootecnia();				 		
			echo json_encode($rspta);
			break;
		default:
			$data = array(
                    "Status" => 404,
                    "Total_Resultados" => 0,
                    "Detalle" => "No Found"
                    //"Paginador"=>$paginador
                  );
			echo json_encode($data);
			break;
	}
	//Fin de las validaciones de acceso
	ob_end_flush();
?>