<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class escritorio extends Base_Controller {
	function __construct(){
		parent::__construct();
	}

	public function Inicio() {
		echo $this->templates->render('escritorio/inicio');
	}

	public function ObtenerData() {
		$this->load->model('pedido');
		$this->load->model('vn_gastos');

		$fi = new DateTime('first day of this month');
		$fi = $fi->format('Y-m-d');
		$ff = date('Y-m-d');

		# ventas totales del periodo seleccionado
		$where = array('fecha > ' => $fi . ' 00:00:00', 'fecha <= ' => $ff . ' 23:59:59');
		$campos = 'sum(total) as total';
		$ventas = $this->pedido->get($where, $campos);
		# gastos totales del periodo seleccionado
		$campos = 'sum(importe) as total';
		$gastos = $this->vn_gastos->get($where, $campos);
		# venta por dia para graficas
		$ventasxhora = $this->pedido->ventasxhora($fi, $ff);
		$ventasxdia = $this->pedido->ventasxdia($fi, $ff);
		$ventasxmes = $this->pedido->ventasxmes($fi, $ff);
		$ventasxanio = $this->pedido->ventasxanio($fi, $ff);

		exit(json_encode(array(
			'ventas' => $ventas->total,
			'gastos' => $gastos->total,
			'ventasxhora' => $ventasxhora,
			'ventasxdia' => $ventasxdia,
			'ventasxmes' => $ventasxmes,
			'ventasxanio' => $ventasxanio
		)));
	}

	public function ObtenerResumen() {
		$this->load->model('pedido');
		$this->load->model('vn_gastos');

		$fi = $this->str_to_date($this->input->post('fi'));
		$ff = $this->str_to_date($this->input->post('ff'));

		# ventas
		$where = array('fecha > ' => $fi . ' 00:00:00', 'fecha <= ' => $ff . ' 23:59:59');
		$campos = "folio, total, efectivo, date_format(fecha, '%d-%M-%Y') as fecha";
		$rventas = $this->pedido->filter($where, $campos);
		# gastos
		$campos = "id, gasto, importe, date_format(fecha, '%d-%M-%Y') as fecha";
		$rgastos = $this->vn_gastos->filter($where, $campos);

		exit(json_encode(array(
			'rventas' => $rventas,
			'rgastos' => $rgastos
		)));
	}

	public function nuevoGasto() {
		$this->load->model('vn_gastos');

		$data = array(
			'importe' => $this->input->post('importe'),
			'gasto' => $this->input->post('gasto'),
		);

		$this->vn_gastos->save($data) === false ? exit(json_encode(array('bandera' => false, 'msj' => 'Se presento un error al procesar la petición'))) : exit(json_encode(array('bandera' => true, 'msj' => 'Hecho')));
	}

	public function borrarVenta() {
		$folio = $this->input->post('folio');
		$this->load->model('pedido');
		$this->load->model('partidas');
		$this->db->trans_begin();
			$where = array('folio' => $folio);
			$campos = 'id';
			$partidas = $this->partidas->filter($where, $campos);
			foreach($partidas as $partida) {
				$this->partidas->delete($partida->id);
			}
			$this->pedido->delete($folio);
		if($this->db->trans_status() == false) {
			$this->db->trans_rollback();
			exit(json_encode(array('bandera'=>false, 'msj'=>'Se presento un error al procesar la petición')));
		} else {
			$this->db->trans_commit();
			exit(json_encode(array('bandera'=>true, 'msj'=>'Petición procesada con éxito')));
		}


	}

	public function borrarGasto() {
		$id = $this->input->post('id');
		$this->load->model('vn_gastos');

		if($this->vn_gastos->delete($id) === true) 
			exit(json_encode(array('bandera'=>true, 'msj'=>'Petición procesada con éxito')));
		else
			exit(json_encode(array('bandera'=>false, 'msj'=>'Se presento un error al procesar la petición')));
	}

}
