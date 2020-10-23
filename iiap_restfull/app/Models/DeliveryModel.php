<?php 

namespace App\Models;
use CodeIgniter\Model;

class DeliveryModel extends Model{

	protected $table ='delivery';
	protected $id ='id';
	protected $returnType='array';
	protected $allowedFields = ['nombre'];
}



