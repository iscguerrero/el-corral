<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pedido extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'pedido';
		$this->primary_key = 'folio';
	}
	# Funcion para obtener las ventas del dia por hora
	public function ventasxhora($fi, $ff) {
		$this->db->select("SUM(total) AS total, DATE_FORMAT(fecha, '%H') as fecha")
		->from($this->table)
		->where("DATE_FORMAT(fecha, '%Y-%m-%d') = ", date('Y-m-d'))
		->group_by("DATE_FORMAT(fecha, '%H')");
		$query = $this->db->get();
		return $query->result();
	}
	# Funcion para obtener las ventas del mes por día
	public function ventasxdia($fi, $ff) {
		$this->db->select("SUM(total) AS total, DATE_FORMAT(fecha, '%d-%b') as fecha")
		->from($this->table)
		->where("fecha >=", "DATE_SUB('$ff 00:00:00', INTERVAL 30 DAY)")
		->where("fecha <=", "$ff 23:59:59")
		->group_by("DATE_FORMAT(fecha, '%d-%b')");
		$query = $this->db->get();
		return $query->result();
	}
	# Funcion para obtener las ventas del año por mes
	public function ventasxmes($fi, $ff) {
		$this->db->select("SUM(total) AS total, DATE_FORMAT(fecha, '%b-%Y') as fecha")
		->from($this->table)
		->where("fecha >=", "DATE_SUB('$ff 00:00:00', INTERVAL 1 YEAR)")
		->where("fecha <=", "$ff 23:59:59")
		->group_by("DATE_FORMAT(fecha, '%b-%Y')");
		$query = $this->db->get();
		return $query->result();
	}
	# Funcion para obtener las ventas por año del periodo seleccionado
	public function ventasxanio($fi, $ff) {
		$this->db->select("SUM(total) AS total, DATE_FORMAT(fecha, '%Y') as fecha")
		->from($this->table)
		->where("fecha >=", "$fi 00:00:00")
		->where("fecha <=", "$ff 23:59:59")
		->group_by("DATE_FORMAT(fecha, '%Y')");
		$query = $this->db->get();
		return $query->result();
	}

}