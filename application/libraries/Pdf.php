	<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH."/third_party/fpdf/rounded_rect_class.php";

	class Pdf extends rounded_rect {
		function Header() {
			$this->SetFont('Courier', 'B', 20);
			$this->Image(base_url('assets/images/logo.jpeg'), 25, 25, 48.45, 26.9);
			$this->MultiCell(0, 8, utf8_decode("LONCHERÍA \"EL CORRAL\""), 0, 'R', false);
			$this->SetFont('Courier', 'B', 16);
			$this->MultiCell(0, 8, utf8_decode("Vizarrón de Montes, Cadereyta Qro"), 0, 'R', false);
		}
		function Footer() {
			$this->setY(-25);
			$this->SetFont('Courier', '', 8);
			$this->MultiCell(0, 5, utf8_decode("LONCHERÍA \"EL CORRAL\""), 0, 'C', false);
			$this->MultiCell(0, 5, utf8_decode("Vizarron de Montes Cadereyta Qro (Av Rosalio Herrera #31) 76509 Queretaro, Querétaro de Arteaga México"), 0, 'C', false);
			$this->MultiCell(0, 5, utf8_decode("Lugar de Expedición Vizarrón, Qro"), 0, 'C', false);
		}

		var $widths;
		var $aligns;

		function SetWidths($w)
		{
			//Set the array of column widths
			$this->widths=$w;
		}

		function SetAligns($a)
		{
			//Set the array of column alignments
			$this->aligns=$a;
		}

		function Row($data)
		{
			//Calculate the height of the row
			$nb=0;
			for($i=0;$i<count($data);$i++)
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=5*$nb;
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++)
			{
				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
					//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
					//Draw the border
				//$this->Rect($x,$y,$w,$h);
					//Print the text
				$this->MultiCell($w,10,$data[$i],0,$a);
					//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			//Go to the next line
			$this->Ln($h);
		}

		function CheckPageBreak($h)
		{
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
				$this->AddPage($this->CurOrientation);
		}

		function NbLines($w,$txt)
		{
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
				$c=$s[$i];
				if($c=="\n")
				{
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
							$i++;
					}
					else
						$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}



	}
