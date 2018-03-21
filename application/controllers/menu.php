<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends Base_Controller {
	public function index() {
		echo $this->templates->render('menu/index');
	}
}
