<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class platillos extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'platillos';
		$this->primary_key = 'cve_platillo';
	}

	# Catalogo de platillos con categoria
	public function customfilter($campos, $categoria) {
		$this->db->select($campos)
		->from('platillos p')
		->join('categorias c', 'p.cve_categoria = c.cve_categoria', 'INNER')
		->where('p.estatus', 'A');
		if($categoria != '') $this->db->where('p.cve_categoria', $categoria);
		$query = $this->db->get();
		return $query->result();
	}


}