<?php 
	ob_start();
	
	require_once "../modelos/usuario.php";

	$usuario=new Usuario_iiap();
	//$id=$GET["id"];
	//$id;
	switch ($_GET["op"]){
		case 'list_all_user':			
			//var_dump($dni); die;
			$rspta=$usuario->listar_all();				
			//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;
		case 'list_one_user':
			$id=$_GET["id"];
			//var_dump($ides);die;			
			//var_dump($dni); die;
			$rspta=$usuario->listar_one($id);				
			 		//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;
		
		case 'add_user':
			if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["correo"]) && !empty($_POST["password"]) ) {

				$nombre=$_POST["nombre"];
				$apellidos=$_POST["apellido"];	
				$correo=$_POST["correo"];	
				$password=$_POST["password"];
				$cargo="3";					
				//var_dump($nombre); die;
				$rspta=$usuario->add_user($nombre,$apellidos,$correo,$password,$cargo);			 		
			}else{
				//Vamos a declarar un srray	
				$rspta = array(
                    "Status" => 406,
                    "exito" => true,
                    "Detalle" => "Formato no Aceptable"
                    //"Paginador"=>$paginador
                );			
			} 		
			echo json_encode($rspta);
			break;
		case 'delete_user':	
			$id=$_GET["id"];		
			//var_dump($id); die;
			$rspta=$usuario->delete($id);				
			//Vamos a declarar un srray	 		
			echo json_encode($rspta);
			break;
		case 'update_user':
			if (!empty($_GET["id"]) && !empty($_GET["nom"]) && !empty($_GET["ape"]) && !empty($_GET["correo"]) && !empty($_GET["password"]) && !empty($_GET["foto"]) && !empty($_GET["id_cargo"])) {
				# code...
				$id=$_GET["id"];
				$nombre=$_GET["nom"];
				$apellidos=$_GET["ape"];	
				$correo=$_GET["correo"];	
				$password=$_GET["password"];	
				$foto=$_GET["foto"];
				$id_cargo=$_GET["id_cargo"];		
				// var_dump($nombre,$apellidos,$correo,$password,$foto); die;
				$rspta=$usuario->update_user($id,$nombre,$apellidos,$correo,$password,$foto,$id_cargo);				
				//Vamos a declarar un srray
			}else{
				$rspta = array(
                    "Status" => 406,
                    "Total_Resultados" => 0,
                    "Detalle" => "Formato no Aceptable"
                    //"Paginador"=>$paginador
                );			
			}
			echo json_encode($rspta);
			break;
		case 'login':
			# code...
			$nombre=$_POST["correo"];
			$apellidos=$_POST["password"];
			$rspta = $usuario->log_usuario($nombre,$apellidos);
			// var_dump($rspta);die();
			echo json_encode($rspta);
			break;
		default:
			$data = array(
                    "Status" => 404,
                    "exito" => false,
                    "Detalle" => "No Found"
                    //"Paginador"=>$paginador
                  );
			echo json_encode($data);
			break;
	}
	//Fin de las validaciones de acceso
	ob_end_flush();
?>