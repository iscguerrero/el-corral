<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class partidas extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'partidas';
		$this->primary_key = 'id';
	}

	# Listar las partidas del pedido
	public function customfilter($campos, $folio) {
		$this->db->select($campos)
		->from('partidas p')
		->join('platillos pp', 'p.cve_platillo = pp.cve_platillo', 'INNER')
		->where('p.folio', $folio);
		$query = $this->db->get();
		return $query->result();
	}


}