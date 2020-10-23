<?php 

namespace App\Models;
use CodeIgniter\Model;

class ClientesModel extends Model{

	protected $table ='clientes';
	protected $primaryKey ='idclientes';
	protected $returnType='array';
	protected $allowedFields = ['imagen_clientes','nombre_clientes','apellidos_clientes','id_sexo_clientes','id_tipo_doc_clientes','num_doc_clientes','email_clientes','password_clientes','celular_clientes','id_cargo_clientes','id_distrito_clientes','direccion_clientes','estado_clientes']; 

	public function getclientesAll(){
    	return $this->db->table('clientes c')
        ->where('ca.nombre_cargo', 'Cliente')   
    	->join('sexo s', 'c.id_sexo_clientes = s.idsexo')
    	->join('tipo_doc td', 'td.idtipo_doc = c.id_tipo_doc_clientes')
    	->join('cargo ca', 'ca.idcargo = c.id_cargo_clientes')
    	->join('distrito d', 'd.iddistrito = c.id_distrito_clientes')
        ->orderby('c.idclientes','DESC')
    	->get()->getResultArray();
    }

    public function getclientesOne($idclientes){
        return $this->db->table('clientes c')   
        ->where('c.idclientes', $idclientes)
        ->join('sexo s', 'c.id_sexo_clientes = s.idsexo')
        ->join('tipo_doc td', 'td.idtipo_doc = c.id_tipo_doc_clientes')
        ->join('cargo ca', 'ca.idcargo = c.id_cargo_clientes')
        ->join('distrito d', 'd.iddistrito = c.id_distrito_clientes')
        ->get()->getResultArray();
    }  

    public function getClienteAll($id){
       return $this->db->table('clientes p')
       ->where('p.id_cargo',$id)
        ->join('sexo s', 'p.id_sexo = s.idsexo')
        ->join('tipo_doc td', 'td.idtipo_doc = p.id_tipo_doc')
        ->join('cargo c', 'c.idcargo = p.id_cargo')
        ->join('distrito d', 'd.iddistrito = p.id_distrito')
        ->orderby('p.idclientes','DESC')
        ->get()->getResultArray();
    }  

    public function getCargoCliente(){
       return $this->db->table('cargo c')
         ->where('c.nombre_cargo !=','Usuario/lavadores')
       ->where('c.nombre_cargo !=','Usuario/cajero')   
         ->where('c.nombre_cargo !=','Administrador')
          ->where('c.nombre_cargo !=','Usuario/Quimica')
          ->where('c.nombre_cargo !=','Usuario/Deliverista')
          ->where('c.nombre_cargo !=','Proveedores')
        ->orderby('c.idcargo','ASC')
        ->get()->getResultArray();
    }  

    
}

