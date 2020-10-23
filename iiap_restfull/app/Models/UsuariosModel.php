<?php 

namespace App\Models;
use CodeIgniter\Model;

class UsuariosModel extends Model{

	protected $table ='persona';
	protected $primaryKey ='idpersona';
	protected $returnType='array';
	protected $allowedFields = ['imagen_persona','nombre_persona','apellidos_persona','id_sexo','id_tipo_doc','num_doc_persona','email','password','celular','id_cargo','id_distrito','direccion','estado_persona']; 

	public function getPersonaAll(){
    	return $this->db->table('persona p')
    	 ->where('p.id_cargo !=',7)
    	 ->where('p.id_cargo !=',8)
    	->join('sexo s', 'p.id_sexo = s.idsexo')
    	->join('tipo_doc td', 'td.idtipo_doc = p.id_tipo_doc')
    	->join('cargo c', 'c.idcargo = p.id_cargo')
    	->join('distrito d', 'd.iddistrito = p.id_distrito')
        ->orderby('p.idpersona','DESC')
    	->get()->getResultArray();
    }

    public function getPersonaOne($idpersona){
        return $this->db->table('persona p')   
        ->where('p.idpersona', $idpersona)
        ->join('sexo s', 'p.id_sexo = s.idsexo')
        ->join('tipo_doc td', 'td.idtipo_doc = p.id_tipo_doc')
        ->join('cargo c', 'c.idcargo = p.id_cargo')
        ->join('distrito d', 'd.iddistrito = p.id_distrito')
        ->get()->getResultArray();
    }  

    public function getCargoPersona($id){
       return $this->db->table('cargo c')
       ->where('c.idcargo >',$id)   
       ->where('c.nombre_cargo !=','Cliente')   
       ->where('c.nombre_cargo !=','Proveedores')    
        ->orderby('c.idcargo','ASC')
        ->get()->getResultArray();
    }  

    // public function getPermisoAll($id){
    //    return $this->db->table('permiso p')
    //    ->where('c.idcargo >',$id)   
    //    ->where('c.nombre_cargo !=','Cliente')   
    //    ->where('c.nombre_cargo !=','Proveedores')    
    //     ->orderby('c.idcargo','ASC')
    //     ->get()->getResultArray();
    // } 

     public function getUltimoUsu(){
        return $this->db->table('persona p')
         ->select('p.idpersona')
         ->limit(1)
        ->orderby('p.idpersona','DESC')
        ->get()->getResultArray();
    }

    
}

