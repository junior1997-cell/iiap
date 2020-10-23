<?php 

namespace App\Models;
use CodeIgniter\Model;

class PermisoModel extends Model{

	protected $table ='permiso';
	protected $primaryKey ='idpermiso';
	protected $returnType='array';
	protected $allowedFields = ['nombre_permiso'];

	public function getPermisoAll(){
        return $this->db->table('permiso p')   
        ->where('p.nombre_permiso !=', 'SIN ACCESO')      
        ->get()->getResultArray();
    }
}



