<?php 

namespace App\Models;
use CodeIgniter\Model;

class CargoModel extends Model{

	protected $table ='cargo';
	protected $id ='id_cargo';
	protected $returnType='array';
	protected $allowedFields = ['nombre_cargo','estado_cargo','fecha_cargo'];
}



