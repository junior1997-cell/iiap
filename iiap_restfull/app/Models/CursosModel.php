<?php 

namespace App\Models;
use CodeIgniter\Model;

class CursosModel extends Model{

	protected $table ='curso';
	protected $primaryKey ='id_curso';
	protected $returnType='array';
	protected $allowedFields = ['nombre_curso','descripcion_curso','calificacion_gnral_curso','idcategoria','cant_estudiantes_curso','id_docente','foto_curso','estado_curso','fecha_curso']; 

	public function getCursoAll(){
    	return $this->db->table('curso c')    	     	 
    	->join('persona p', 'p.id_persona = c.id_docente')    	 
        ->orderby('c.id_curso','DESC')
    	->get()->getResultArray();
    }
    public function getCursoOne($id){
        return $this->db->table('curso c')               
        ->join('persona p', 'p.id_persona = c.id_docente')       
        ->orderby('c.id_curso','DESC')
        ->where('c.id_curso',$id)
        ->get()->getResultArray();
    }
    public function getCursoCategoria($id_cat){
    	return $this->db->table('curso c')
    	->where('c.idcategoria',$id_cat)    	     	 
    	->join('persona p', 'p.id_persona = c.id_docente')  
    	->join('categorias ca', 'ca.id_categorias = c.idcategoria')
    	     	 
        ->orderby('c.id_curso','DESC')
    	->get()->getResultArray();
    }

    public function getCursoMejorValorados($id_cat){
    	return $this->db->table('curso c')
    	->where('c.calificacion_gnral_curso <=',$id_cat)
           	     	 
    	->join('persona p', 'p.id_persona = c.id_docente')  
    	->join('categorias ca', 'ca.id_categorias = c.idcategoria')    	     	 
        ->orderby('c.id_curso','DESC ')
    	->get()->getResultArray();
    }
    //estraemos cursos de ctegoria AGRICULTURAcon calificacion mayor  3S
    public function listaAgricultura($id_cat){
        return $this->db->table('curso c')
        ->where('c.calificacion_gnral_curso >=',$id_cat)  
        ->where('c.idcategoria',1)                
        ->join('persona p', 'p.id_persona = c.id_docente')  
        ->join('categorias ca', 'ca.id_categorias = c.idcategoria')              
        ->orderby('c.id_curso','DESC ')
        ->get()->getResultArray();
    }
    //estraemos cursos de ctegoria AGRICULTURAcon calificacion mayor  3S
    public function listaAcuicola($id_cat){
        return $this->db->table('curso c')
        ->where('c.calificacion_gnral_curso >=',$id_cat)
        ->where('c.idcategoria',2)                 
        ->join('persona p', 'p.id_persona = c.id_docente')  
        ->join('categorias ca', 'ca.id_categorias = c.idcategoria')              
        ->orderby('c.id_curso','DESC ')
        ->get()->getResultArray();
    }
    //estraemos cursos de ctegoria AGRICULTURAcon calificacion mayor  3S
    public function listaZootecnia($id_cat){
        return $this->db->table('curso c')
        ->where('c.calificacion_gnral_curso >=',$id_cat)
        ->where('c.idcategoria',3)                 
        ->join('persona p', 'p.id_persona = c.id_docente')  
        ->join('categorias ca', 'ca.id_categorias = c.idcategoria')              
        ->orderby('c.id_curso','DESC ')
        ->get()->getResultArray();
    }
    //cuantas categorias hay
    public function getCategoriaCount(){
    	return $this->db->table('categorias c')    	 
    	->get()->getResultArray();
    }   

    public function getCursoCount($id_cat){
    	return $this->db->table('curso c')
    	->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')
    	->where('c.calificacion_gnral_curso >=',$id_cat)    	     	 
    	->join('persona p', 'p.id_persona = c.id_docente')  
    	->join('categorias ca', 'ca.id_categorias = c.idcategoria')    	     	 
        ->orderby('c.id_curso','DESC')
    	->get()->getResultArray();
    }

    public function getCursoMasEstudiantes($id_cat){
    	return $this->db->table('curso c')
    	->where('c.calificacion_gnral_curso >=',$id_cat)    	     	 
    	->join('persona p', 'p.id_persona = c.id_docente')  
    	->join('categorias ca', 'ca.id_categorias = c.idcategoria')    	     	 
        ->orderby('c.id_curso','DESC')
    	->get()->getResultArray();
    }

     //cuales son CURSOS CON MAS ALUMNOS-------------------------------------------
    public function postCursoAlumno($id_cat){
    	return $this->db->table('curso c')     	
    	->where('c.idcategoria',$id_cat) 
    	->orderby('c.id_curso','DESC ')
    	->get()->getResultArray();
    }
    //extrayendo datos de los cursos que tienen mas alumnos
    public function postCursoAlumnoDatos($cant_alum){
    	return $this->db->table('curso c')
    	->where('c.cant_estudiantes_curso',$cant_alum)
    	->get()->getResultArray();
    }

    // public function getPersonaOne($idpersona){
    //     return $this->db->table('persona p')   
    //     ->where('p.id_persona', $idpersona)        
    //     ->join('cargo c', 'c.id_cargo = p.idcargo')        
    //     ->get()->getResultArray();
    // }  

    // public function getCargoPersona($id){
    //    return $this->db->table('cargo c')
    //    ->where('c.idcargo >',$id)   
    //    ->where('c.nombre_cargo !=','Cliente')   
    //    ->where('c.nombre_cargo !=','Proveedores')    
    //     ->orderby('c.idcargo','ASC')
    //     ->get()->getResultArray();
    // }  

    // public function getPermisoAll($id){
    //    return $this->db->table('permiso p')
    //    ->where('c.idcargo >',$id)   
    //    ->where('c.nombre_cargo !=','Cliente')   
    //    ->where('c.nombre_cargo !=','Proveedores')    
    //     ->orderby('c.idcargo','ASC')
    //     ->get()->getResultArray();
    // } 

    // public function getUltimoUsu(){
    //     return $this->db->table('persona p')
    //      ->select('p.idpersona')
    //      ->limit(1)
    //     ->orderby('p.idpersona','DESC')
    //     ->get()->getResultArray();
    // }

    
}

