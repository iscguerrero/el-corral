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

	public function EjecutarVenta() {
		$this->load->model('platillos');
		$this->load->model('pedido');
		$this->load->model('partidas');
		$partidas = $this->input->post('partidas');
		$efectivo = $this->input->post('efectivo');
		$total = 0;

		# Obtenemos el total de la remision
		foreach ($partidas as $key => $item) {
			$total += $item['total'];
		}

		if ($total > $efectivo) exit(json_encode(array('bandera' => false, 'msj' => 'El efectivo recibido es menor al total de la venta')));

		$this->db->trans_begin();

		$dpedido = array(
			'total' => $total,
			'efectivo' => $efectivo,
			'estatus' => 'V'
		);
		$folio = $this->pedido->save($dpedido);

		foreach ($partidas as $key => $partida) {
			$dpartida = array(
				'folio' => $folio,
				'partida' => $key + 1,
				'cve_platillo' => $partida['cve_platillo'],
				'piezas' => $partida['piezas'],
				'precio_unitario' => str_replace(array(',', '$', ' '), array('', '', ''), $partida['precio_unitario'])
			);
			$this->partidas->save($dpartida);
		}

		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			exit(json_encode(array('bandera' => false, 'msj' => 'Se presento un error al registrar la venta')));
		} else {
			$this->db->trans_commit();
			exit(json_encode(array('bandera' => true, 'msj' => 'El cambio para el cliente es de ' . number_format($efectivo - $total, 2), 'folio' => $folio)));
		}

	}

	public function Ticket($folio) {
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'letter');
		$pdf->SetMargins(25, 25, 25);
		$pdf->SetAutoPageBreak(true, 25);
		$pdf->AddPage();
		$pdf->setY(55);

		$pdf->SetFont('Courier', 'B', 14);
		$pdf->Cell(0, 5,'Detalle de la compra', 0, 1, 'L', false);
		$pdf->setY(65);

		# Leyendas del formato / partidas
		$pdf->SetFont('Courier', 'B', 10);
		$pdf->Cell(65, 5, '', 0, 0, 'L', false);
		$pdf->Cell(25, 5, 'Precio', 0, 0, 'R', false);
		$pdf->Cell(25, 5, 'Pedido', 0, 0, 'R', false);
		$pdf->Cell(25, 5, 'Total', 0, 1, 'R', false);

		# Obtenemos la informacion del pedido
		$this->load->model('pedido');
		$this->load->model('partidas');

		$campos = "date_format(fecha, '%d-%M-%Y') as fecha, folio, total, efectivo";
		$where = array('folio'=>$folio);
		$pedido = $this->pedido->get($where, $campos);

		$campos = "pp.platillo, p.precio_unitario, p.piezas, (p.precio_unitario * p.piezas) as total";
		$partidas = $this->partidas->customfilter($campos, $folio);

		$pdf->SetFont('Courier', '', 10);
		$pdf->SetWidths(array(65, 25, 25, 25));
		$pdf->SetAligns(array('L', 'R', 'R', 'R'));

		foreach($partidas as $partida) {
			$pdf->Row(array(
				$partida->platillo,
				$partida->precio_unitario,
				number_format($partida->piezas, 0),
				number_format($partida->total, 2),
			));
		}
		$pdf->SetFont('Courier', 'B', 10);

		$pdf->Ln();
		$pdf->Cell(115, 5, 'Total', 0, 0, 'R', false);
		$pdf->Cell(25, 5, number_format($pedido->total, 2), 0, 1, 'R', false);
		$pdf->Cell(115, 5, 'Efectivo', 0, 0, 'R', false);
		$pdf->Cell(25, 5, number_format($pedido->efectivo, 2), 0, 1, 'R', false);
		$pdf->Cell(115, 5, 'Cambio', 0, 0, 'R', false);
		$pdf->Cell(25, 5, number_format($pedido->efectivo - $pedido->total, 2), 0, 1, 'R', false);

		$pdf->Ln();
		$pdf->Cell(0, 5, 'Fecha' . $pedido->fecha, 0, 1, 'L', false);
		$pdf->Cell(0, 5, 'folio de compra F' . $pedido->folio, 0, 0, 'L', false);




		$pdf->Output();
	}

}
