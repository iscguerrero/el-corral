<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pedido extends Base_Model {
	public function  __construct() {
		parent::__construct();
		$this->table = 'pedido';
		$this->primary_key = 'folio';
	}


}