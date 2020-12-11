<?php 

namespace App\Models;
use CodeIgniter\Model;

class UsuariosModel extends Model{

	protected $table ='persona';
	protected $primaryKey ='id_persona';
	protected $returnType='array';
	protected $allowedFields = ['nombre_persona','apellidos_persona','correo_persona','password_persona',
                                'foto_persona', 'idcargo', 'estado_persona','fecha_persona']; 

	public function getPersonaAll(){
    	return $this->db->table('persona p')    	     	 
    	->join('cargo c', 'c.id_cargo = p.idcargo')    	 
        ->orderby('p.id_persona','DESC')
        ->where('p.estado_persona',1)
    	->get()->getResultArray();
    }

    public function getPersonaOne($idpersona){
        return $this->db->table('persona p')   
        ->where('p.id_persona', $idpersona)        
        ->join('cargo c', 'c.id_cargo = p.idcargo')        
        ->get()->getResultArray();
    } 

    public function Login($email,$pass){
        return $this->db->table('persona p')   
        ->where('p.correo_persona', $email)
        ->where('p.password_persona', $pass)
        ->get()->getResultArray();
    }
    public function VerficarEmail($email){
        return $this->db->table('persona p')   
        ->where('p.correo_persona', $email)
        ->get()->getResultArray();
    }

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

