<?php 

namespace App\Models;
use CodeIgniter\Model;

class LibromayorModel extends Model{

	protected $table ='libro_diario';
	protected $id ='idlibrodiario';
	protected $returnType='array';
	protected $allowedFields = ['n_operacion','fecha','glosa','id_libro_contable','doc_sustet','id_plan_contable','debe','haber','estado'];

	public function getlibro_mayor($codigo){

		return $this->db->table('libro_diario ld, plan_contable pc')
		->select('pc.codigo_plan_contable,pc.descripcion_plan_contable,ld.n_operacion,ld.fecha,ld.glosa,ld.debe,ld.haber')
		->where('ld.id_plan_contable=pc.codigo_plan_contable')
		->where('ld.id_plan_contable', $codigo)
		->get()->getResultArray();
	}

	public function get_total_debe_haber_ld($total){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', $total)
		//->where dpp.id_pedido_prenda=2
		->get()->getResultArray();
	}

	public function get_total_debehaber(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		//->where('ld.id_plan_contable', $total)
		//->where dpp.id_pedido_prenda=2
		->get()->getResultArray();
	}

	/*public function getpedido_prenda(){

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
	}*/

	public function get_total_pedido_ld($total){

		return $this->db->table('pedido_prenda pp')

		->select('pp.total_pedido')

		->where('pp.idpedido_prenda', $total)
		//->where dpp.id_pedido_prenda=2
		->get()->getResultArray();
	}


}



