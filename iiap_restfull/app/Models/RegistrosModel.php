<?php 

namespace App\Models;
use CodeIgniter\Model;

class RegistrosModel extends Model{

	protected $table ='registros';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['nombres','apellidos','email','estado','cliente_id','llave_secreta'];

}