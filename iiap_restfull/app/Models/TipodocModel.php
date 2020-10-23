<?php 

namespace App\Models;
use CodeIgniter\Model;

class TipodocModel extends Model{

	protected $table ='tipo_doc';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['nombre'];
}



