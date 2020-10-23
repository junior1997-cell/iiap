<?php 

namespace App\Models;
use CodeIgniter\Model;

class UsuariopermisoModel extends Model{

	protected $table ='usuario_permiso';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['id_usuario','id_permiso'];
}



