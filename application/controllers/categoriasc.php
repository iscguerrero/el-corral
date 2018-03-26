<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class categoriasc extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('categorias');
	}
	public function inicio() {
		echo $this->templates->render('categoriasc/inicio');
	}
	# Funcion para obtener el catalogo de categorias
	public function obtenerCategorias() {
		if(!$this->input->is_ajax_request()) show_404();
		$campos = 'cve_categoria, categoria, resenia';
		$wheres = array('estatus' => 'A');
		exit(json_encode($this->categorias->filter($wheres, $campos)));
	}
	# Funcion para editar / dar de alta una categoria
	public function crudCategorias() {
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
