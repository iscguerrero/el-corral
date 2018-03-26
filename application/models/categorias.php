<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class categorias extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'categorias';
		$this->primary_key = 'cve_categoria';
	}

}