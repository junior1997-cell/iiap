<?php 

namespace App\Models;
use CodeIgniter\Model;

class PedidosModel extends Model{

	protected $table ='pedido_prenda';
	protected $primaryKey ='idpedido_prenda';
	protected $returnType='array';
	protected $allowedFields = ['numero_pedido','id_tipo_pedido','id_usuario','id_cliente','id_tipo_comprobante','serie_comprobante','numero_comprobante','id_tipo_lavado','fecha_pedido_prenda','id_estado_lavado','impuesto','comision_por_recogo','total_pedido','estado_boleta','estado_pedido_prenda','momento_pago','fecha_entrega','id_delivery']; 

	public function getPedidosAll(){
    	return $this->db->table('pedido_prenda pp')
    	->join('tipo_pedido tp', 'pp.id_tipo_pedido = tp.idtipo_pedido')
    	->join('persona p', 'pp.id_usuario = p.idpersona')
        ->join('clientes c', 'pp.id_cliente = c.idclientes') 
        ->join('tipo_comprobante tc', 'tc.idtipo_comprobante = pp.id_tipo_comprobante')
        ->join('tipo_lavado tl', 'tl.idtipo_lavado = pp.id_tipo_lavado')
        ->join('estado_lavado et', 'et.idestado_lavado = pp.id_estado_lavado')
        ->join('delivery d', 'd.iddelivery = pp.id_delivery')
        ->orderby('pp.idpedido_prenda','DESC')
    	->get()->getResultArray();
    }	
    public function getPedidosOne($idpedido){
        return $this->db->table('pedido_prenda pp')
        ->join('tipo_pedido tp', 'pp.id_tipo_pedido = tp.idtipo_pedido')
        ->join('persona p', 'pp.id_usuario = p.idpersona')
        ->join('clientes c', 'pp.id_cliente = c.idclientes') 
        ->join('tipo_comprobante tc', 'tc.idtipo_comprobante = pp.id_tipo_comprobante')
        ->join('tipo_lavado tl', 'tl.idtipo_lavado = pp.id_tipo_lavado')
        ->join('estado_lavado et', 'et.idestado_lavado = pp.id_estado_lavado')
        ->join('delivery d', 'd.iddelivery = pp.id_delivery')
        ->orderby('pp.idpedido_prenda','DESC')
        ->where('pp.idpedido_prenda',$idpedido)
        ->get()->getResultArray();
    } 

    public function getTipoLvadoAll(){
        return $this->db->table('tipo_lavado tl')   

        ->where('tl.estado_tipo_lavado',1)
       
        ->get()->getResultArray();
    }
    public function getTipoPedidoAll(){
        return $this->db->table('tipo_pedido tp')   

        ->where('tp.idtipo_pedido >',1)
       
        ->get()->getResultArray();
    }   

    public function getTipoComprobanteAll(){
        return $this->db->table('tipo_comprobante tc')   

        ->where('tc.idtipo_comprobante >',1)
       
        ->get()->getResultArray();
    }  

    public function getUltimoReg(){
        return $this->db->table('pedido_prenda pp')
         ->select('pp.idpedido_prenda')
         ->limit(1)
        ->orderby('pp.idpedido_prenda','DESC')
        ->get()->getResultArray();
    } 

    
}

