<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class vn_gastos extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'vn_gastos';
		$this->primary_key = 'id';
	}


}