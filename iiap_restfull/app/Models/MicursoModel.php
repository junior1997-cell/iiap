<?php 

namespace App\Models;
use CodeIgniter\Model;

class MiCursoModel extends Model{

	protected $table ='curso_inscrito';
	protected $primaryKey ='id_curso_inscrito';
	protected $returnType='array';
	protected $allowedFields = ['idpersona','idcurso','fecha_curso_inscrito','avance_curso_inscrito','estado_curso_inscrito','calificacion_curso_inscrito','certificado_curso']; 

	public function getMiCursoAll(){
    	return $this->db->table('curso_inscrito c')    	     	 
    	->join('persona p', 'p.id_persona = c.idpersona')    	 
        ->orderby('c.id_curso_inscrito','DESC')
    	->get()->getResultArray();
    }
    public function getMiCursoUnic($id_curs_unic){
    	return $this->db->table('curso_inscrito c')    	     	 
    	->join('persona p', 'p.id_persona = c.idpersona')    	 
        ->orderby('c.id_curso_inscrito','DESC')
        ->where('c.idpersona',$id_curs_unic)
    	->get()->getResultArray();
    }
 
}

