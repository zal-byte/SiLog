<?php
	require_once '../../../fpdf/fpdf.php';

	class REPORT extends FPDF{
		private static $instance = null;
		public static function getInstance(){
			if(self::$instance == null){
				self::$instance = new REPORT();
			}
			return self::$instance;
		}
		static $pdf = null;
		public function __construct(){
			self::$pdf = new FPDF('P', 'cm', 'A4');
			self::$pdf->SetLeftMargin(5);
			self::$pdf->AddPage();
			self::$pdf->Ln();
			self::$pdf->SetFont('Arial', 'B',9);
			self::$pdf->Text(7.5, 1, 'LAPORAN PENGGUNAAN BARANG');
			self::$pdf->Text(8.3,1.5,"PUSKESMAS IDI NAHUJ");
			self::$pdf->Line(15.6,2.1,5,2.1);             
			self::$pdf->Ln(1.6);

		}

		public static function CETAK( $tanggal, $data ){
			self::$pdf->write(0, "Tanggal : $tanggal");
			self::$pdf->Ln(0.3);
			self::$pdf->Cell(1,0.5, 'NO', 1.0, 'C');
			self::$pdf->Cell(2,0.5, 'Tanggal', 1.0, 'L');
			self::$pdf->Cell(5,0.5, 'Nama Barang', 1.0, 'L');
			self::$pdf->Cell(3,0.5, 'Jumlah', 1.0, 'L');
			self::$pdf->Ln();
			for($i=0; $i < count($data);$i++){
				self::$pdf->Cell(1, 0.5, $i+1, 1.0, 'C');
				self::$pdf->Cell(2, 0.5, $data[$i]['tanggal'], 1.0, 'C');
				self::$pdf->Cell(5, 0.5, $data[$i]['nama_barang'], 1.0, 'C');
				self::$pdf->Cell(3, 0.5, $data[$i]['jumlah'], 1.0, 'C');
				self::$pdf->Ln();
			}
			self::$pdf->Output();
		}
	}
?>