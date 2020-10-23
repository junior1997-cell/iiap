<?php 

namespace App\Models;
use CodeIgniter\Model;

class SexoModel extends Model{

	protected $table ='sexo';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['nombre'];
}



