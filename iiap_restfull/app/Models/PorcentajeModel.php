<?php 

namespace App\Models;
use CodeIgniter\Model;

class PorcentajeModel extends Model{

	protected $table ='porcentajes_de_pago';
	protected $id ='idporcentajes_de_pago';
	protected $returnType='array';
	protected $allowedFields = ['nombre_porcentajes_de_pago','porcentaje_porcentajes_de_pago','aporte_obligatorio','comision_sobre_ra','prima_seguro'];



	public function get_porcentajes_des(){

		return $this->db->table('porcentajes_de_pago pg')
		
			->WHERE('pg.idporcentajes_de_pago<5') 

		
		->get()->getResultArray();
	}

	public function get_porcentajes_pago(){

		return $this->db->table('porcentajes_de_pago pg')
		
			->WHERE('pg.idporcentajes_de_pago>4') 

		
		->get()->getResultArray();
	}

}
