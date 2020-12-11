<?php 

namespace App\Models;
use CodeIgniter\Model;

class PlanillaModel extends Model{

	protected $table ='planilla_remuneraciones';
	protected $id ='idplanilla';
	protected $returnType='array';
	protected $allowedFields = ['codigo_plantilla','nombres_planilla','id_cargo_ocupacion','asig_familiar_planilla','sueldo_basico_planilla','monto_asig_familiar_planilla','otros_planilla','total_remuneracion_bruta_planilla','snp_onp_planilla','id_afp','aporte_obligatorio_planilla','comision_sobre_ra_planilla','prima_seguro_planilla','total_descuento_planilla','remuneracion_neta_planilla','aporte_salud_planilla','aporte_sctr_planilla','aporte_total_planilla','fecha_planilla'];

	public function getplanilla(){

		return $this->db->table('planilla_remuneraciones ld')
		->join('cargo lc','ld.id_cargo_ocupacion=lc.idcargo')
		->join('afp pc','ld.id_afp= pc.idafp')
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

	public function getdetalle_pedido_prenda($idpedido){

		return $this->db->table('detalle_pedido_prenda dpp')

		->select('dpp.iddetalle_pedido_prenda, 
			dpp.cantidad_detalle_pedido_prenda,
			p.idprenda, 
			p.nombre_prenda as Prenda')

		->join('pedido_prenda pp','dpp.id_pedido_prenda= pp.idpedido_prenda')
		->join('prenda p','dpp.id_prenda=p.idprenda')
		->where('dpp.id_pedido_prenda', $idpedido)
		//->where dpp.id_pedido_prenda=2
		->get()->getResultArray();
	}

	public function get_total_pedido_ld($total){

		return $this->db->table('pedido_prenda pp')

		->select('pp.total_pedido')

		->where('pp.idpedido_prenda', $total)
		//->where dpp.id_pedido_prenda=2
		->get()->getResultArray();
	}


	public function get_porcentajes_pago(){

		return $this->db->table('porcentajes_de_pago pg')
		
			->WHERE('pg.idporcentajes_de_pago>=4') 

		
		->get()->getResultArray();
	}

}
