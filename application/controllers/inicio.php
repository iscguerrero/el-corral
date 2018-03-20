<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inicio extends Base_Controller {
	public function index() {
		$this->load->view('inicio/index');
	}
}
