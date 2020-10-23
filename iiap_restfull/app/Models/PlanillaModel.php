<?php 

namespace App\Models;
use CodeIgniter\Model;

class PlanillaModel extends Model{

	protected $table ='planilla_remuneraciones';
	protected $id ='idplanilla';
	protected $returnType='array';
	protected $allowedFields = ['codigo_planilla','nombres_planilla','id_cargo_ocupacion','asig_familiar_planilla','sueldo_basico_planilla','monto_asig_familiar_planilla','otros_planilla','total_remunera_bruta_planilla','snp_onp_planilla','monto_onp','id_afp','aporte_obligatorio_planilla','comision_sobre_ra_planilla','prima_seguro_planilla','total_descuento_planilla','remuneracion_neta_planilla','aporte_salud_planilla','aporte_sctr_planilla','aporte_total_planilla','fecha_planilla'];

	
	public function get_usuarios(){

		return $this->db->table('persona p')
		->select(' p.idpersona,p.nombre_persona,p.apellidos_persona')
		->where('p.estado_persona ',1)
		->get()->getResultArray();
	}

	public function get_afp(){

		return $this->db->table('afp p')
		->select(' p.idafp,p.nombre_afp')
		->get()->getResultArray();
	}

	public function get_cargo(){

		return $this->db->table('cargo p')
		->select(' p.idcargo,p.nombre_cargo')
		->get()->getResultArray();
	}

	

	public function getpedido_prenda(){

		return $this->db->table('pedido_prenda pp')
		->select('pp.idpedido_prenda, pp.numero_pedido, pp.id_tipo_comprobante, tc.nombre_tipo_comprobante,pp.serie_comprobante,pp.numero_comprobante,pp.fecha_pedido_prenda,pp.total_pedido')

		->join('tipo_comprobante tc','pp.id_tipo_comprobante=tc.idtipo_comprobante')

		->get()->getResultArray();
	}

	public function getlibroContable(){

		return $this->db->table('libro_contable lc')
		->select('lc.idlibrocontable, lc.codigoCont, lc.nombrelibroCont')
		->get()->getResultArray();
	}

	
	public function get_porcentajes_pago(){

		return $this->db->table('porcentajes_de_pago pg')
		
			->WHERE('pg.idporcentajes_de_pago>=4') 

		
		->get()->getResultArray();
	}

		public function getplanilla(){

		return $this->db->table('planilla_remuneraciones pr')
		->select('pr.idplanilla, pr.codigo_planilla, c.nombre_cargo,p.nombre_persona,pr.asig_familiar_planilla,pr.sueldo_basico_planilla,pr.monto_asig_familiar_planilla,pr.otros_planilla,pr.total_remunera_bruta_planilla,pr.snp_onp_planilla,pr.monto_onp,a.nombre_afp,pr.aporte_obligatorio_planilla,pr.comision_sobre_ra_planilla,pr.prima_seguro_planilla,pr.total_descuento_planilla,pr.remuneracion_neta_planilla,pr.aporte_salud_planilla,pr.aporte_sctr_planilla,pr.aporte_total_planilla')
		->join('cargo c','pr.id_cargo_ocupacion=c.idcargo')
		->join('persona p','pr.nombres_planilla=p.idpersona')
		->join('afp a','pr.id_afp=a.idafp')
		->get()->getResultArray();
	}



}
