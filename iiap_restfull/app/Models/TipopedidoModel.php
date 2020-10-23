<?php 

namespace App\Models;
use CodeIgniter\Model;

class TipopedidoModel extends Model{

	protected $table ='tipo_pedido';
	protected $id ='idtipo_pedido';
	protected $returnType='array';
	protected $allowedFields = ['nombre_tipo_pedido'];

}



