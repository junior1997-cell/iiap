<?php 

namespace App\Models;
use CodeIgniter\Model;

class TipoLavadoModel extends Model{

	protected $table ='tipo_lavado';
	protected $primaryKey ='idtipo_lavado';
	protected $returnType='array';
	protected $allowedFields = ['nombre_tipo_lavado','precio_tipo_lavado','estado_tipo_lavado'];

	public function getTipoLavadoOne($idtipolav){
        return $this->db->table('tipo_lavado tl')   
        ->where('tl.idtipo_lavado', $idtipolav)
        ->get()->getResultArray();
    }  

}



