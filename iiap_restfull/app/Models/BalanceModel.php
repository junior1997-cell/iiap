<?php 

namespace App\Models;
use CodeIgniter\Model;

class BalanceModel extends Model{

	public function gettotaldebe(){
        return $this->db->table('libro_diario') 
        ->select('round(sum(debe),2) as totaldebe,round(sum(haber),2) as totalhaber')  
        ->get()->getResultArray();
    }  


    public function get_total_debehaber_10(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 10)
		->get()->getResultArray();
	}

	public function get_total_debehaber_12(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 12)
		->get()->getResultArray();
	}

	//--------------
	public function get_total_debehaber_14(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 14)
		->get()->getResultArray();
	}

	//----------
	public function get_total_debehaber_20(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 20)
		->get()->getResultArray();
	}

	public function get_total_debehaber_33(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 33)
		->get()->getResultArray();
	}

	public function get_total_debehaber_40(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 40)
		->get()->getResultArray();
	}

	public function get_total_debehaber_41(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 41)
		->get()->getResultArray();
	}

	public function get_total_debehaber_42(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 42)
		->get()->getResultArray();
	}

	public function get_total_debehaber_45(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 45)
		->get()->getResultArray();
	}

	public function get_total_debehaber_46(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 46)
		->get()->getResultArray();
	}

	public function get_total_debehaber_50(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 50)
		->get()->getResultArray();
	}

	public function get_total_debehaber_59(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 59)
		->get()->getResultArray();
	}

	public function get_total_debehaber_60(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 60)
		->get()->getResultArray();
	}

	public function get_total_debehaber_61(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 61)
		->get()->getResultArray();
	}
	public function get_total_debehaber_62(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 62)
		->get()->getResultArray();
	}

	public function get_total_debehaber_63(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 63)
		->get()->getResultArray();
	}

		public function get_total_debehaber_69(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 69)
		->get()->getResultArray();
	}

		public function get_total_debehaber_70(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 70)
		->get()->getResultArray();
	}

		public function get_total_debehaber_79(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 79)
		->get()->getResultArray();
	}

		public function get_total_debehaber_94(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 94)
		->get()->getResultArray();
	}

		public function get_total_debehaber_95(){

		return $this->db->table('libro_diario ld')

		->select('ROUND(SUM(ld.debe),1) as debe ,ROUND(SUM(ld.haber),1) as haber')

		->where('ld.id_plan_contable', 95)
		->get()->getResultArray();
	}


}



