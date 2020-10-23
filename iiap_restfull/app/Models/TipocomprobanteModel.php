<?php 

namespace App\Models;
use CodeIgniter\Model;

class TipocomprobanteModel extends Model{

	protected $table ='tipo_comprobante';
	protected $id ='idtipo_comprobante';
	protected $returnType='array';
	protected $allowedFields = ['nombre_tipo_comprobante'];

}



