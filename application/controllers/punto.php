<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class punto extends Base_Controller {
	public function index() {
		echo $this->templates->render('punto/index');
	}
}
