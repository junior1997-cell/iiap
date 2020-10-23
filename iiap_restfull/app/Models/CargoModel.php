<?php 

namespace App\Models;
use CodeIgniter\Model;

class CargoModel extends Model{

	protected $table ='cargo';
	protected $id ='idcargo';
	protected $returnType='array';
	protected $allowedFields = ['nombre_cargo','estado_cargo'];
}



