<?php 

namespace App\Models;
use CodeIgniter\Model;

class DistritoModel extends Model{

	protected $table ='distrito';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['nombre'];
}



