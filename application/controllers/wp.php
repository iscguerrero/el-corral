<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class wp extends Base_Controller {
	public function inicio() {
		$this->load->view('wp/inicio');
	}
}
