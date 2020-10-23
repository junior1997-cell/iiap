<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class Meses extends Controller{

	public function mes($id){
		helper('utilidades');
		echo json_encode(obtener_mes($id));
	}
}