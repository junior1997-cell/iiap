<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Saludo extends Controller
{
	public function index(){
		echo "Ella no te ama";
		
	}



	public function comentarios($id){

			if (!is_numeric($id)) {
					
					$respuesta = array('error'=>true, 'mensaje'=>"Debe ser númerico");
					echo json_encode($respuesta);
					return;
				}

			$comentarios = array(
    		array('id' => 1, 'mensaje' => 'Lorem ipsum dolor.'),
    		array('id' => 2, 'mensaje' => 'Lorem ipsum dolor sit.'),
    		array('id' => 3, 'mensaje' => 'Lorem ipsum.')
    	    );
    	

    	if ($id>=count($comentarios) or $id<0) {
    		$respuesta = array('error'=>true, 'mensaje'=>"id no  existe");
    		echo json_encode($respuesta);
					return;
    	}

    	echo json_encode($comentarios[$id]);
    }

   /* public function comentarios( $id ){

    }*/

	//--------------------------------------------------------------------

}
