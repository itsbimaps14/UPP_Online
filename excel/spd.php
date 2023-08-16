<?php
include '../inc.php';
	$running_ddd = $_POST['untuk_spd'];
	$name_file = $running_ddd.'.pdf';

	$a=mysqli_query($conn, "
		SELECT * FROM ddd_tmp
			inner join master_ddd on ddd_tmp.pic_penyimpanan = master_ddd.no_master_ddd 
			WHERE no_running = '$running_ddd'");

	$b=mysqli_fetch_array($a);

require('fpdf.php');
	// Header
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(95,8,'PT. NUTRIFOOD INDONESIA','LT');
	$pdf->Cell(95,8,'KODE FORM : F.S.103','RT',1,'R');
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(0,5,'SURAT PENGANTAR / PENARIKAN DOKUMEN','RL',1,'C');
	$pdf->Cell(0,10,'(SPD)','RL',1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,'','L',0,'L');
	$pdf->Cell(30,5,$running_ddd,'1',0,'C');
	$pdf->Cell(0,5,'','R',1,'C');
	$pdf->Cell(0,3,'','LBR',1,'C');
	// Isi1
	$pdf->Cell(0,3,'','LTR',1,'C');
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(23,5,'Kepada Yth : ','1',0,'C');
	$pdf->Cell(35,5,$b['penerima'],'1',0);
	$pdf->Cell(0,5,'','R',1);
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(23,5,'','',0,'C');
	$pdf->Cell(35,5,$b['lokasi_penyimpanan'],'1',0);
	$pdf->Cell(0,5,'','R',1);
	$pdf->Cell(0,3,'','LR',1,'C');

	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(0,5,'Bersama ini kami kirimkan dokumen dengan no Copy : '.$b['nomor_copy'].', dengan rincian dokumen sbb : ','R',1);
	// Tabel1
	$pdf->Cell(0,3,'','LR',1,'C');
	$pdf->Cell(10,5,'','L',0);
	$pdf->SetFillColor('49','134','155');
	$pdf->Cell(170,5,'PERUBAHAN / PENERBITAN PROSEDUR','1',0,'C','TRUE');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->SetFillColor('146','205','220');
	$pdf->Cell(100,5,'Uraian','1',0,'C','TRUE');
	$pdf->Cell(10,5,'Rev','1',0,'C','TRUE');
	$pdf->Cell(30,5,'Berlaku','1',0,'C','TRUE');
	$pdf->Cell(30,5,'No. UPP','1',0,'C','TRUE');
	$pdf->Cell(10,5,'','R',1);

	$aa = mysqli_query($conn, "SELECT * FROM
									ddd_s3,
									master_ddd,
									prosedur,
									divisi_prosedur,
									master_prosedur,
									jenis_prosedur,
									upp
								WHERE
									no_running = '$running_ddd'
								AND ddd_s3.pic_penyimpanan = master_ddd.no_master_ddd
								AND ddd_s3.no_prosedur = prosedur.no_prosedur
								AND prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur
								AND prosedur.no_master_prosedur = master_prosedur.no_master_prosedur
								AND prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
								AND prosedur.no_divisi_prosedur = upp.no_divisi_prosedur
								AND prosedur.no_master_prosedur = upp.no_master_prosedur
								AND prosedur.no_jenis_prosedur = upp.no_jenis_prosedur
								AND prosedur.nama_folder = upp.nama_folder
								AND ddd_s3.ddd3_no_revisi = upp.no_revisi");
	while ($bb = mysqli_fetch_array($aa)) {
		$pdf->Cell(10,5,'','L',0);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(100,5,$bb['nm_prosedur'].' // '.$bb['nama_folder'],'1',0);
		$pdf->Cell(10,5,$bb['no_revisi'],'1',0,'C');
		$pdf->Cell(30,5,$bb['tgl_revisi'],'1',0,'C');
		$pdf->Cell(30,5,$bb['no_upp'],'1',0,'C');
		$pdf->Cell(10,5,'','R',1);
	}

	$pdf->Cell(0,3,'','RL',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(125,5,'','',0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(45,5,'Hormat Kami','1',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,15,'','L',0);
	$pdf->Cell(125,15,'','',0);
	$pdf->Cell(45,15,'','LR',0,'C');
	$pdf->Cell(10,15,'','R',1);

	$pdf->Cell(10,3,'','L',0);
	$pdf->Cell(125,3,'','',0);
	$pdf->Cell(45,3,'Ahmad Zaelani','LR',0,'C');
	$pdf->Cell(10,3,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(125,5,'','',0);
	$pdf->Cell(45,5,'SQB Departement','1',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(0,3,'','LRB',1);

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(0,4,'---POTONG--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------POTONG---','',1,'C');

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,3,'','LRT',1);
	$pdf->Cell(0,5,'SURAT PENGANTAR / PENARIKAN DOKUMEN','RL',1,'C');
	$pdf->Cell(0,5,'(SPD)','RL',1,'C');

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,3,'','LR',1);
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(0,5,'(Bagian ini dikembalikan ke Process Design Department selambat - lambatnya 2 (dua) minggu','R',1);
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(0,5,'setelah tanggal pengiriman).','R',1);

	$pdf->Cell(0,3,'','LR',1);
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(50,5,'Telah diterima SPD dengan : ','',0);
	$pdf->Cell(30,5,$running_ddd,'1',0,'C');
	$pdf->Cell(0,5,'','R',1,'C');

	$pdf->Cell(0,3,'','LR',1);
	$pdf->Cell(20,5,'','L',0,'C');
	$pdf->Cell(0,5,'Adapun dokumen yang ditarik adalah : ','R',1);

	//Tabel 2
	$pdf->Cell(0,3,'','LR',1,'C');
	$pdf->Cell(10,5,'','L',0);
	$pdf->SetFillColor('49','134','155');
	$pdf->Cell(170,5,'PERUBAHAN / PENERBITAN PROSEDUR','1',0,'C','TRUE');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->SetFillColor('146','205','220');
	$pdf->Cell(115,5,'Uraian','1',0,'C','TRUE');
	$pdf->Cell(10,5,'Rev','1',0,'C','TRUE');
	$pdf->Cell(45,5,'Keterangan','1',0,'C','TRUE');
	$pdf->Cell(10,5,'','R',1);

	$aa = mysqli_query($conn, "SELECT * FROM ddd_s3
						inner join master_ddd on ddd_s3.pic_penyimpanan = master_ddd.no_master_ddd 
						inner join prosedur on ddd_s3.no_prosedur = prosedur.no_prosedur
						inner join upp on prosedur.nama_file = upp.file_prosedur
						inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
						WHERE no_running = '$running_ddd'");
	while ($bb = mysqli_fetch_array($aa)) {
		$pdf->Cell(10,5,'','L',0);
		$pdf->SetFont('Arial','',7);
		$rev = $bb['no_revisi'] - 1;
		if ($rev == 0 OR $rev == '0') {
			$pdf->Cell(115,5,$bb['nm_prosedur'].' // '.$bb['nama_folder'].' -> Tidak ada penarikan','1',0);
			$pdf->Cell(10,5,$rev,'1',0,'C');
		}
		else{
			$pdf->Cell(115,5,$bb['nm_prosedur'].' // '.$bb['nama_folder'],'1',0);
			$pdf->Cell(10,5,$rev,'1',0,'C');
		}
		$pdf->Cell(45,5,$bb['s3_keterangan'],'1',0,'C');
		$pdf->Cell(10,5,'','R',1);
	}

	$pdf->SetFont('Arial','',10);

	$pdf->Cell(0,3,'','LR',1,'C');

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(30,5,'Tanggal Kembali','1',0,'C');
	$pdf->Cell(30,5,'Paraf Penerima','1',0,'C');
	$pdf->Cell(65,5,'','',0);
	$pdf->Cell(45,5,'Diterima Oleh','1',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(30,5,'','LR',0,'C');
	$pdf->Cell(30,5,'','LR',0,'C');
	$pdf->Cell(65,5,'','',0);
	$pdf->Cell(45,5,'','LR',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(30,5,'','LRB',0,'C');
	$pdf->Cell(30,5,'','LRB',0,'C');
	$pdf->Cell(65,5,'','',0);
	$pdf->Cell(45,5,'','LR',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(125,5,'','',0);
	$pdf->Cell(45,5,'','LR',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(10,3,'','L',0);
	$pdf->Cell(125,3,'','',0);
	$pdf->Cell(45,3,$b['penerima'],'LR',0,'C');
	$pdf->Cell(10,3,'','R',1);

	$pdf->Cell(10,5,'','L',0);
	$pdf->Cell(125,5,'','',0);
	$pdf->Cell(45,5,$b['lokasi_penyimpanan'],'1',0,'C');
	$pdf->Cell(10,5,'','R',1);

	$pdf->Cell(0,3,'','LBR',1,'C');
	$pdf->Cell(0,1,'','',1,'C');
	$pdf->Cell(0,2,'','LRT',1,'C');


	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'PERNYATAAN DOKUMEN TIDAK KEMBALI','L',0);
	$pdf->Cell(0,5,'REVISI / BERLAKU : 01/10.02.09','R',1,'R');
	$pdf->Cell(0,2,'','RL',1,'C');
	$pdf->Cell(72.5,5,'','L',0);
	$pdf->Cell(45,5,'TTD MANAGER','1',0,'C');
	$pdf->Cell(0,5,'LAMA SIMPAN : 1 TAHUN','R',1,'R');

	$pdf->Cell(72.5,10,'','L',0);
	$pdf->Cell(45,10,'','1',0,'C');
	$pdf->Cell(0,10,'','R',1,'R');

	$pdf->Cell(0,2,'','LBR',1,'C');

	$pdf->Output($name_file, 'I');
?>