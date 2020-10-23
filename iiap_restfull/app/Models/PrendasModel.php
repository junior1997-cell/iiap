<?php 

namespace App\Models;
use CodeIgniter\Model;

class PrendasModel extends Model{

	protected $table ='prenda';
	protected $primaryKey ='idprenda';
	protected $returnType='array';
	protected $allowedFields = ['imagen_prenda','nombre_prenda','precio_prenda','estado_prenda'];



	public function getPrendaOne($idprenda){
        return $this->db->table('prenda p') 
        //->select('p.imagen_prenda')  
        ->where('p.idprenda', $idprenda)
        ->get()->getResultArray();
    }  


}



