<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class punto extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('platillos');
		$this->load->model('pedido');
		$this->load->model('partidas');
	}
	public function inicio() {
		echo $this->templates->render('punto/inicio');
	}
	# Funcion para guardar el pedido
	public function guardarPedido() {
		if(!$this->input->is_ajax_request()) show_404();
		$data = array(
			'categoria' => $this->input->post('categoria'),
			'resenia' => $this->input->post('resenia'),
			'estatus' => $this->input->post('estatus'),
		);
		if($this->input->post('cve_categoria') != '') $data['cve_categoria'] = $this->input->post('cve_categoria');

		$this->categorias->save($data) === false ? exit(json_encode(array('bandera'=>false, 'msj'=>'Se presento un error al procesar la petición'))) : exit(json_encode(array('bandera'=>true, 'msj'=>'Petición procesada con éxito')));
	}

}
