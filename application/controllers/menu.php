<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('platillos');
	}
	public function inicio() {
		echo $this->templates->render('menu/inicio');
	}
	# Funcion para obtener el catalogo de platillos
	public function obtenerPlatillos() {
		if(!$this->input->is_ajax_request()) show_404();
		$categoria = $this->input->post('categoria');
		$campos = 'cve_platillo, platillo, p.resenia, precio_unitario, url_img, p.cve_categoria, categoria';
		exit(json_encode($this->platillos->customfilter($campos, $categoria)));
	}
	# Funcion para editar / dar de alta un platillo
	public function crudPlatillos() {
		if(!$this->input->is_ajax_request()) show_404();

		$data = array(
			'platillo' => $this->input->post('platillo'),
			'cve_categoria' => $this->input->post('cve_categoria'),
			'resenia' => $this->input->post('resenia'),
			'precio_unitario' => $this->input->post('precio_unitario'),
			'estatus' => $this->input->post('estatus'),
		);
		# Guardamos el archivo en la carpeta de uploads para futuras referencias
		$nombre = $_FILES['imagen']['name'];
		$file = 'assets/images/menu/' . date('YmdHis') . $nombre;
		if(move_uploaded_file($_FILES['imagen']['tmp_name'], $file)) $data['url_img'] = $file;

		if($this->input->post('cve_platillo') != '') $data['cve_platillo'] = $this->input->post('cve_platillo');

		$this->platillos->save($data) === false ? exit(json_encode(array('bandera'=>false, 'msj'=>'Se presento un error al procesar la petición'))) : exit(json_encode(array('bandera'=>true, 'msj'=>'Petición procesada con éxito')));
	}

}
