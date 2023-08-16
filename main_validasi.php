<script type="text/javascript">
	window.onload = function(){
		document.getElementById('ugg').style.display = "none";
		document.getElementById('ubr').style.display = "none";
		document.getElementById('ugg1').style.display = "none";
		document.getElementById('ubr1').style.display = "none";	}
</script>
<?php
	$hariini = date('Y-m-d');
	$awal=0;
	$year = date('Y');
	$month = date('m');

	// Filter
	$filter = "";
	if (isset($_POST['tahun']) OR isset($_POST['bulan']) OR isset($_POST['pengaju']) OR isset($_POST['d_prosedur']) OR isset($_POST['t_det_prosedur']) OR isset($_POST['nm_file'])
		OR isset($_POST['tgl_berlaku']) OR isset($_POST['status_ik']) OR isset($_POST['status_lj']) OR isset($_POST['no_upp'])) {
		if($_POST['tahun'] != ''){
			$filter = "";
			$filter = $filter."and tahun = '".$_POST['tahun']."'";
			$tahun = $_POST['tahun'];
		}
		if($_POST['bulan'] != ''){
			$filter = $filter."and bulan = '".$_POST['bulan']."'";
			$bulan = $_POST['bulan'];
		}
		if($_POST['pengaju'] != ''){
			$filter = $filter."and pengaju = '".$_POST['pengaju']."'";
			$pengaju = $_POST['pengaju'];
		}
		if($_POST['d_prosedur'] != ''){
			$filter = $filter."and validasi_ik.no_divisi_prosedur = '".$_POST['d_prosedur']."'";
			$divisi_prosedur = $_POST['d_prosedur'];
		}
		if($_POST['t_det_prosedur'] != ''){
			$filter = $filter."and detail_prosedur = '".$_POST['t_det_prosedur']."'";
			$det_prosedur = $_POST['t_det_prosedur'];
		}
		if($_POST['nm_file'] != ''){
			$filter = $filter."and nama_folder = '".$_POST['nm_file']."'";
			$nm_file = $_POST['nm_file'];
		}
		if($_POST['tgl_berlaku'] != ''){
			$filter = $filter."and tgl_berlaku = '".$_POST['tgl_berlaku']."'";
			$tgl_berlaku = $_POST['tgl_berlaku'];
		}
		if($_POST['status_ik'] != ''){
			$filter = $filter."and vi_status_ik = '".$_POST['status_ik']."'";
			$status_ik = $_POST['status_ik'];
		}
		if($_POST['status_lj'] != ''){
			$filter = $filter."and vi_status_lj = '".$_POST['status_lj']."'";
			$status_lj = $_POST['status_lj'];
		}
		if($_POST['no_upp'] != ''){
			$filter = $filter."and validasi_ik.no_upp = '".$_POST['no_upp']."'";
			$no_upp = $_POST['no_upp'];
		}
		if ($_POST['tahun'] == "" AND $_POST['bulan'] == "" AND $_POST['pengaju'] == "" AND $_POST['d_prosedur'] == "" AND $_POST['t_det_prosedur'] == "" AND $_POST['nm_file'] == ""
			AND $_POST['tgl_berlaku'] == "" AND $_POST['status_ik'] == "" AND $_POST['status_lj'] == "" AND $_POST['no_upp'] == ""){
			header("location:main?index=validasi");
		}
	}

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {

			case 'edit':
				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik
					inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
					WHERE validasi_ik.no_upp ='$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$pengaju = test($_POST['pengaju']);
					$detail_kategori = test($_POST['detail_kategori']);
					$sebelumperubahan = test($_POST['sebelumperubahan']);
					$setelahperubahan = test($_POST['setelahperubahan']);
					$alasan = test($_POST['alasan']);
					$status_ik = test($_POST['status_ik']);

					$cx = mysqli_query($conn, "SELECT * FROM validasi_ik WHERE no_upp = '$id'");
					$cz = mysqli_fetch_array($cx);

					$fpp = pathinfo($cz['file_fmea']);
					$fol = $fpp['dirname'];
					
					if ($pengaju!='' AND $detail_kategori!='' AND $sebelumperubahan !='' AND $setelahperubahan!='' AND $alasan!='' AND $status_ik!='') {
						mysqli_query($conn, "UPDATE validasi_ik SET
							pengaju = '$pengaju',
							detail_prosedur = '$detail_kategori',
							sebelumperubahan = '$sebelumperubahan',
							setelahperubahan = '$setelahperubahan',
							alasan = '$alasan'
							WHERE no_upp = '$id'
							");

						mysqli_query($conn, "UPDATE validasi_ik_tmp SET
							vi_status_ik = '$status_ik'
							WHERE no_upp = '$id'
							");
					}

					$uploadOk = 1;
					$file_fmea = $_FILES['file_fmea']['name'];
					if ($file_fmea != '') {

						unlink($c['file_fmea']);

						$folder1 = $fol.'/';
						$file_user1 = $_FILES['file_fmea']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_fmea']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);
							mysqli_query($conn, "UPDATE validasi_ik SET
								file_fmea = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");

							mysqli_query($conn, "UPDATE upp SET
								file_fmea = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");							
						}
					}

					$uploadOk = 1;
					$file_rik = $_FILES['file_rik']['name'];
					if ($file_rik != '') {

						unlink($c['vi_file']);

						$folder1 = $fol.'/review/';
						$file_user1 = $_FILES['file_rik']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_rik']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);
							mysqli_query($conn, "UPDATE validasi_ik_tmp SET
								vi_file = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");
						}
					}

					header("location:main?index=validasi&id=$id");
				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:425px;'>
							Edit Validasi IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:450px;'>
							<form action='main?index=validasi&action=edit&id=$id' method='post' enctype='multipart/form-data'>
								<div class='alert_adm alert'><b>Warning !</b> - Jika file Upload tidak ada yang akan di edit, jangan diisi !</div><br>
								<a class='j_input_main'>No.UPP *</a><br>
									<input class='input_main readonly' type='text' name='no_upp' value='$c[no_upp]' required readonly><br>
								<a class='j_input_main'>Tanggal UPP *</a><br>
									<input class='input_main readonly' type='text' name='tgl_upp' value='$c[tgl_upp]' required readonly><br>
								<a class='j_input_main'>Pengaju *</a><br>
									<input class='input_main' type='text' name='pengaju' value='$c[pengaju]' required ><br>
								<a class='j_input_main'>Divisi Prosedur *</a><br>
									<input class='input_main readonly' type='text' name='divisi_prosedur' value='$c[divisi_prosedur]' required readonly><br>
								<a class='j_input_main'>Prosedur *</a><br>
									<input class='input_main readonly' type='text' name='prosedur' value='$c[master_prosedur]' required readonly><br>
								<a class='j_input_main'>Kategori Prosedur *</a><br>
									<input class='input_main readonly' type='text' name='jenis_prosedur' value='$c[jenis_prosedur]' required readonly><br>
								<a class='j_input_main'>Jenis Instruksi Kerja *</a><br>
									<input class='input_main readonly' type='text' name='jenis_ik' value='$c[jenis_ik]' required readonly><br>
								<a class='j_input_main'>Detail Kategori *</a><br>
									<input class='input_main' type='text' name='detail_kategori' value='$c[detail_prosedur]' required><br>
								<a class='j_input_main'>Nama File *</a><br>
									<input class='input_main readonly' type='text' name='nama_file' value='$c[nama_folder]' required readonly><br>
								<a class='j_input_main'>Sebelum Perubahan *</a><br>
									<textarea class='input_main' name='sebelumperubahan' required>$c[sebelumperubahan]</textarea><br>
								<a class='j_input_main'>Setelah Perubahan *</a><br>
									<textarea class='input_main' name='setelahperubahan' required>$c[setelahperubahan]</textarea><br>
								<a class='j_input_main'>Alasan *</a><br>
									<textarea class='input_main' name='alasan' required>$c[alasan]</textarea><br>"; ?>

								<a id='txt_sh_2' class='j_input_main'>Attachment FMEA *<font size='1' color='red'> ) Max File Size 1MB, Diisi jika file upload diubah</font><br></a>
									<input class='file_main' type='file' id='file_fmea' name='file_fmea' onchange="valid1(this)"><br>
								<div class='alert_adm alert' id="ugg" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr" style='width:70px;'>File is OK !</div>

								<?php echo "
								<a class='j_input_main'>Tanggal Berlaku *</a><br>
									<input class='input_main readonly' type='text' name='tgl_berlaku' value='$c[tgl_berlaku]' required readonly><br>";
								$tmp_tgl = $c['tgl_berlaku'];
								$tmp_tgl = date('Y-m-d', strtotime('+90 days', strtotime($tmp_tgl)));
								$tmp_status_ik = $c['vi_status_ik'];
								echo "
								<a class='j_input_main'>Tanggal Selesai Masa Percobaan *</a><br>
									<input class='input_main readonly' type='text' name='tgl_selesai' value='$tmp_tgl' required readonly><br>
								<a class='j_input_main'>Status IK *</a><br>
								<select class='input_main' name='status_ik' style='width:100%;' required>
									";
									if ($tmp_status_ik == 'Percobaan') {
										echo "<option value='Percobaan' selected>Percobaan</option>";}
									else{
										echo "<option value='Percobaan'>Percobaan</option>";}

									if ($tmp_status_ik == 'Expired') {
										echo "<option value='Expired' selected>Expired</option>";}
									else{
										echo "<option value='Expired'>Expired</option>";}
									echo "
								</select><br>"; ?>

								<a id='txt_sh_2' class='j_input_main'>Attachment Review IK *<font size='1' color='red'> ) Max File Size 1MB, Diisi jika file upload diubah</font><br></a>
									<input class='file_main' type='file' id='file_rik' name='file_rik' onchange="valid2(this)"><br>

								<div class='alert_adm alert' id="ugg1" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr1" style='width:70px;'>File is OK !</div>

								<?php echo "
								<input style='margin-left:145px;' id='submit' class='submit_main fl' type='submit' value='Update'>
							</form>
						</div>
					</div>";
			break;

			case 'tarik':

				$hariini=date("Y-m-d");

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_tarik = test($_POST['tgl_tarik']);
					$alasan_tarik = test($_POST['alasan_tarik']);

					if ($tgl_tarik != '' AND $alasan_tarik != '') {
						mysqli_query($conn, " UPDATE validasi_ik_tmp SET
								vi_status_ik = 'Expired',
								vi_status_lj = 'Tarik',
								vi_tgl_penarikan = '$tgl_tarik',
								vi_alasan_penarikan = '$alasan_tarik'
								WHERE no_upp = '$id'
							");
						
						mysqli_query($conn, "UPDATE upp SET
								status = 'Batal',
								tgl_batal = '$tgl_tarik',
								alasan_batal = 'Tarik Validasi Online'
								WHERE no_upp = '$id'
							");
					}
					header("location:main?index=validasi&id=$id");
				}
			
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Tarik Validasi IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=validasi&action=tarik&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Tanggal Penarikan *</a><br>
									<input class='input_main readonly' type='text' name='tgl_tarik' value='$hariini' required readonly><br>
								<a class='j_input_main'>Alasan Perubahan *</a><br>
									<textarea class='input_main' name='alasan_tarik' placeholder='Alasan Tarik' required></textarea><br>
								<input style='margin-left:145px;' class='submit_main fl' type='submit' value='Submit'>
							</form>
						</div>
					</div>";
			break;

			case 'mail':
				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik 
					inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
					WHERE validasi_ik.no_upp ='$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$email = test($_POST['email']);
					$tmp_tgl = $c['tgl_berlaku'];
					$tmp_tgl = date('Y-m-d', strtotime('+90 days', strtotime($tmp_tgl)));

							$to 	  =	"$email";
							$subject  =	"Validasi IK No. " . strip_tags($c['no_upp']);
							$headers  = array ('From' => $from,
							'To' => $to,
							'subject' => $subject,
							"MIME-Version"=>"1.0",
							"Content-type"=>"text/html"
							);
							$message  =	"<html><body>";
							$message .=	"<strong>Dear,</strong><br><br><br>";
							$message .=	"<strong>Dengan ini kami informasikan bahwa :</strong><br><br>";
							$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
							$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
							$message .=	"<tr><td><strong>Jenis IK : </strong> </td><td>" . strip_tags($c['jenis_ik']) . "</td></tr>";
							$message .=	"<tr><td><strong>Prosedur : </strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama File : </strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal Berlaku : </strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal Selesai Masa percobaan : </strong> </td><td>" . strip_tags($tmp_tgl) . "</td></tr>";
							$message .=	"<tr><td><strong>Pengaju : </strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
							$message .= "</table><br>";
							$message .=	"<strong>Sudah melewati 2.5 bulan untuk proses review IK, mohon untuk segera ditindaklanjuti.</strong><br><br>";
							$message .=	"<strong>Demikian kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.</strong><br><br>";
							$message .= "<strong>Salam,</strong><br>";
							$message .= "<strong>UPP Online</strong>";
							$message .= "</body></html>";
								$mail = $smtp->send($to, $headers, $message);
							if (Pear::isError($mail)) {
								echo "<p>" . $mail->getMessage() . "</p>";
								echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
							} else{
								echo "<p>Message successfully sent!</p>";
							}
							header("location:main?index=validasi&id=$id");
				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Email Validasi IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=validasi&action=tarik&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Email dituju : *</a><br>
									<textarea class='input_main' name='email' required autofocus>$c[vi_list_email]</textarea><br>
								<a style='font-size:12px;'>Pisahkan email dengan koma<br>(example@nutrifood.co.id, example2@nutrifood.co.id)</a><br><br>
								<input style='margin-left:145px;' class='submit_main fl' type='submit' value='Submit'>
							</form>
						</div>
					</div>";
			break;

			case 'terima':

				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$ttt_tgl = test($_POST['tgl_app']);

					mysqli_query($conn, "UPDATE validasi_ik_tmp SET vi_pic_app = '$ttt_tgl', vi_status_lj = 'Berlaku' WHERE no_upp = '$id'");

					$d=mysqli_query($conn, "SELECT * FROM prosedur 
						WHERE no_divisi_prosedur = '$c[no_divisi_prosedur]' 
						AND no_master_prosedur = '$c[no_master_prosedur]' 
						AND no_jenis_prosedur = '$c[no_jenis_prosedur]' 
						AND nama_folder = '$c[nama_folder]'");
					$e=mysqli_fetch_array($d);

					$jumlah_rev = $e['no_revisi']+1;

					mysqli_query($conn, "UPDATE upp SET
						pengaju = '$c[pengaju]',
						detail_prosedur = '$c[detail_prosedur]',
						sebelumperubahan = '$c[sebelumperubahan]',
						setelahperubahan = '$c[setelahperubahan]',
						file_fmea = '$c[file_fmea]',
						file_user = '$c[file_user]',
						status = 'need to check',
						no_revisi = '$jumlah_rev'
						WHERE no_upp = '$id'
						");

					//To Prosedur From Validasi IK

					$f=mysqli_num_rows($d);
					$tgl = date('Y-m-d');

					$ppart = pathinfo($c['file_prosedur']);
					$file_prosedur1 = $ppart['basename'];

					if ($f>0 AND $c['file_prosedur'] != '') {
						
						$folder1 = $ppart['dirname'];
						$folder2 = $folder1.'/revisi/';

						mysqli_query($conn, "INSERT INTO un_prosedur
							SELECT * FROM prosedur 
							WHERE
							no_divisi_prosedur = '$c[no_divisi_prosedur]' AND
							no_master_prosedur = '$c[no_master_prosedur]' AND
							no_jenis_prosedur = '$c[no_jenis_prosedur]' AND
							nama_folder = '$c[nama_folder]'
							");

						$query=mysqli_query($conn, "SELECT * FROM prosedur WHERE
							no_divisi_prosedur = '$c[no_divisi_prosedur]' AND
							no_master_prosedur = '$c[no_master_prosedur]' AND
							no_jenis_prosedur = '$c[no_jenis_prosedur]' AND
							nama_folder = '$c[nama_folder]'
							");

						$tmp_c=mysqli_fetch_array($query);
						
						$nm_file_tmp = $tmp_c['no_revisi'].'_'.$tmp_c['judul_file'];

						$nm_bksfile = $folder2.$nm_file_tmp;

						$a=mysqli_query($conn, "UPDATE un_prosedur SET
							nama_file = '$nm_bksfile',
							judul_file = '$nm_file_tmp'
							WHERE
							no_revisi = '$e[no_revisi]' AND
							no_divisi_prosedur = '$e[no_divisi_prosedur]' AND
							no_master_prosedur = '$e[no_master_prosedur]' AND
							no_jenis_prosedur = '$e[no_jenis_prosedur]' AND
							nama_folder = '$e[nama_folder]'
							");

						rename($nm1_file_tmp, $nm_bksfile);

						$a=mysqli_query($conn, "UPDATE prosedur SET no_revisi = '$jumlah_rev',
																	tgl_revisi = '$tgl',
																	judul_file = '$file_prosedur1',
																	nama_file = '$c[file_prosedur]'
																	WHERE
																	no_divisi_prosedur = '$c[no_divisi_prosedur]' AND
																	no_master_prosedur = '$c[no_master_prosedur]' AND
																	no_jenis_prosedur = '$c[no_jenis_prosedur]' AND
																	nama_folder = '$c[nama_folder]'
																	");
					}

					else if ($f == 0 AND $c['file_prosedur'] != '') {
						$a=mysqli_query($conn, "INSERT INTO prosedur (no_divisi_prosedur,no_master_prosedur,no_jenis_prosedur,detail_prosedur,nama_folder,no_revisi,tgl_revisi,judul_file,nama_file)
							VALUES	('$c[no_divisi_prosedur]','$c[no_master_prosedur]','$c[no_jenis_prosedur]','$c[detail_prosedur]','$c[nama_folder]','$jumlah_rev','$tgl','$file_prosedur1','$c[file_prosedur]')");

						$aa_a = mysqli_query($conn, "SELECT * FROM upp WHERE no_upp = '$id'");
						$bb_b = mysqli_fetch_array($aa_a);

						mysqli_query($conn, "UPDATE prosedur SET file_fmea = '$bb_b[file_fmea]' 
							WHERE nama_file = '$c[file_prosedur]'");
					}

					header("location:main?index=validasi&id=$id");

				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Pemberlakuan IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=validasi&action=terima&id=$id' method='post' enctype='multipart/form-data'>
								<center>
									<a style='font-size:14px;'>Permberlakuan IK Baru Dengan Nomor UPP : $id <br><br>
								</center>
								<a class='j_input_main'>Tanggal Approval *</a><br>
									<input class='input_main readonly' type='email' name='tgl_app' value='$hariini' readonly required ><br>
								<input style='margin-left:160px;' class='submit_main fl' id='subsub' type='submit' value='OK'>
							</form>
						</div>
					</div>";

			break;

			case 'berlaku':
				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik 
					WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$pic_app = test($_POST['pic_app']);

					$cx = mysqli_query($conn, "SELECT * FROM validasi_ik
						inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
						WHERE validasi_ik_tmp.no_upp = '$id'");
					$cz = mysqli_fetch_array($cx);

					$fpp = pathinfo($cz['file_fmea']);
					$fol = $fpp['dirname'];

					$uploadOk = 1;
					$file_rik = $_FILES['file_rik']['name'];
					if ($file_rik != '') {

						if($cz['vi_file'] != ''){
							unlink($cz['vi_file']);
						}

						if (!file_exists($fol.'/review')) {
							mkdir($fol.'/review');}

						$folder1 = $fol.'/review/';
						$file_user1 = $_FILES['file_rik']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_rik']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);
							mysqli_query($conn, "UPDATE validasi_ik_tmp SET
								vi_file = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");
						}	
					}

					$uploadOk = 1;
					$file_pro = $_FILES['file_pro']['name'];
					if ($file_pro != '') {

						$tep_a = mysqli_query($conn, "SELECT * FROM validasi_ik WHERE no_upp = '$id'");
						$tep_b = mysqli_fetch_array($tep_a);

						$path_parts = pathinfo($tep_b['file_prosedur']);
						$folder1 = $path_parts['dirname'].'/';

						unlink($tep_b['file_prosedur']);
						
						$file_user1 = $_FILES['file_pro']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_pro']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {

							rename($file_fmea_user, $file_fmea_rename);

							mysqli_query($conn, "UPDATE validasi_ik SET
								file_prosedur = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");

							mysqli_query($conn, "UPDATE upp SET
								file_prosedur = '$file_fmea_rename'
								WHERE no_upp = '$id'
								");
						}	
					}

					mysqli_query($conn, "UPDATE validasi_ik_tmp SET
						vi_status_lj = 'Berlakukan - Waiting Approval',
						vi_pic_email = '$pic_app'
						WHERE no_upp = '$id'
						");

					$tmp_tgl = $c['tgl_berlaku'];
					$tmp_tgl = date('Y-m-d', strtotime('+90 days', strtotime($tmp_tgl)));

					$to 	  =	"$pic_app";
					$subject  =	"Validasi IK No. " . strip_tags($c['no_upp']);
					$headers  = array ('From' => $from,
					'To' => $to,
					'subject' => $subject,
					"MIME-Version"=>"1.0",
					"Content-type"=>"text/html"
					);
					$message  =	"<html><body>";
					$message .=	"<strong>Dear,</strong><br><br><br>";
					$message .=	"<strong>Dengan ini kami informasikan bahwa :</strong><br><br>";
					$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
					$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
					$message .=	"<tr><td><strong>Jenis IK : </strong> </td><td>" . strip_tags($c['jenis_ik']) . "</td></tr>";
					$message .=	"<tr><td><strong>Prosedur : </strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
					$message .=	"<tr><td><strong>Nama File : </strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
					$message .=	"<tr><td><strong>Tanggal Berlaku : </strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
					$message .=	"<tr><td><strong>Tanggal Selesai Masa percobaan : </strong> </td><td>" . strip_tags($tmp_tgl) . "</td></tr>";
					$message .=	"<tr><td><strong>Pengaju : </strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
					$message .= "</table><br>";
					$message .=	"<strong>Approval Validasi IK dengan No UPP sesuai tertera pada judul.</strong><br><br>";
					$message .=	"<strong>Demikian kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.</strong><br><br>";
					$message .= "<strong>Salam,</strong><br>";
					$message .= "<strong>UPP Online</strong>";
					$message .= "</body></html>";
					$mail = $smtp->send($to, $headers, $message);
					if (Pear::isError($mail)) {
						echo "<p>" . $mail->getMessage() . "</p>";
						echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
					} else{
						echo "<p>Message successfully sent!</p>";
					}

				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Pemberlakuan IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=validasi&action=berlaku&id=$id' method='post' enctype='multipart/form-data'>
								<center>
									<a style='font-size:14px;'>Permberlakuan IK Baru Dengan Nomor UPP : $id <br>Jika iya isi riview ik dan klik button dibawah ini.</a><br><br>
								</center>";?>

								<script type="text/javascript">
									window.onload = function(){
										document.getElementById('ugg2').style.display = "none";
										document.getElementById('ubr2').style.display = "none";
									}
								</script>

								<a id='txt_sh_2' class='j_input_main'>Attachment Review IK <font size='1' color='red'> *) Max File = 1MB</font><br></a>
									<input class='file_main' type='file' id='file_rik' name='file_rik' onchange='valid(this)' required><br>

								<a id='txt_sh_2' class='j_input_main'>Attachment Prosedur <font size='1' color='red'> *) Max File = 1MB</font><br></a>
									<input class='file_main' type='file' id='file_pro' name='file_pro' onchange='valid(this)' required><br>
								<div class='alert_adm alert' id="ugg2" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr2" style='width:70px;'>File is OK !</div>

								<?php echo "
								<a class='j_input_main'>PIC Approval *</a><br>
									<input class='input_main' type='email' name='pic_app' placeholder='email@domain' required ><br>
								<input style='margi     n-left:160px;' class='submit_main fl' id='subsub' type='submit' value='OK'>
							</form>
						</div>
					</div>";
			break;

			case 'automail25':
				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik 
					inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
					WHERE validasi_ik.no_upp ='$id'");
				$c=mysqli_fetch_array($a);

				$lead = $_GET['lead'];

				if ($lead <= 0) {
					mysqli_query($conn, "UPDATE validasi_ik SET
					vi_status_ik = 'Expired'
					WHERE no_upp ='$id'");
				}

				$tmp_tgl = $c['tgl_berlaku'];
				$tmp_tgl = date('Y-m-d', strtotime('+90 days', strtotime($tmp_tgl)));

				$to 	  =	"$c[vi_list_email]";
				$subject  =	"Validasi IK No. " . strip_tags($c['no_upp']);
				$headers  = array ('From' => $from,
				'To' => $to,
				'subject' => $subject,
				"MIME-Version"=>"1.0",
				"Content-type"=>"text/html"
				);
				$message  =	"<html><body>";
				$message .=	"<strong>Dear,</strong><br><br><br>";
				$message .=	"<strong>Dengan ini kami informasikan bahwa :</strong><br><br>";
				$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
				$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
				$message .=	"<tr><td><strong>Jenis IK : </strong> </td><td>" . strip_tags($c['jenis_ik']) . "</td></tr>";
				$message .=	"<tr><td><strong>Prosedur : </strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Nama File : </strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal Berlaku : </strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal Selesai Masa percobaan : </strong> </td><td>" . strip_tags($tmp_tgl) . "</td></tr>";
				$message .=	"<tr><td><strong>Pengaju : </strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
				$message .= "</table><br>";
				$message .=	"<strong>Sudah melewati 2.5 bulan untuk proses review IK, mohon untuk segera ditindaklanjuti.</strong><br><br>";
				$message .=	"<strong>Demikian kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.</strong><br><br>";
				$message .= "<strong>Salam,</strong><br>";
				$message .= "<strong>UPP Online</strong>";
				$message .= "</body></html>";
				$mail = $smtp->send($to, $headers, $message);
				if (Pear::isError($mail)) {
					echo "<p>" . $mail->getMessage() . "</p>";
					echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
				} else{
					echo "<p>Message successfully sent!</p>";
				}
				header("location:main?index=validasi&id=$id");
			break;

			case 'l_email':
				$a=mysqli_query($conn, "SELECT * FROM validasi_ik
					inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik 
					inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
					WHERE validasi_ik.no_upp ='$id'");
				$c=mysqli_fetch_array($a);

				$get_mail = $c['vi_list_email'];

				if ($get_mail == ''){
					$tmp_mail = $c['email_pengaju'];
					mysqli_query($conn, "UPDATE validasi_ik_tmp SET
						vi_list_email = '$tmp_mail'
						WHERE no_upp = '$id'");
					header("location:main?index=validasi&action=l_email&id=$id#popup");
				}

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$l_mail = test($_POST['l_mail']);

					mysqli_query($conn, "UPDATE validasi_ik_tmp SET
						vi_list_email = '$l_mail'
						WHERE no_upp = '$id'");

					header("location:main?index=validasi&id=$id");
				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=validasi&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							List Email auto-mail IK
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=validasi&action=l_email&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>List E-Mail *</a><br>
									<textarea class='input_main' name='l_mail' value='' required>$c[vi_list_email]</textarea><br>
								<a style='font-size:12px;'>Pisahkan email dengan koma<br>(example@nutrifood.co.id, example2@nutrifood.co.id)</a><br><br>
								<input style='margin-left:160px;' class='submit_main fl' type='submit' value='Save'>
							</form>
						</div>
					</div>";
			break;

		}
	}

?>
<div class='judul_main' style='position:fixed;'>Validasi Instruksi Kerja</div>
<form style='margin-bottom:0px;' action='main?index=validasi' method='post' enctype='multipart/form-data'>
		<br><br><br>&emsp; 
		<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:80px;'>
			<option value=''>Tahun</option>
			<?php
				$year = date('Y')+1;
				for ($i=$year; $i > 1997; $i--) {
					if ($tahun==$i) {
						echo " <option value='$i' selected>$i</option> "; }
					else{
						echo " <option value='$i'>$i</option> "; }
				}
			?>
		</select>
		<select class='input_main' name='bulan' onchange='this.form.submit()' style='font-family:arial;width:105px;'>
			<option value=''>Bulan</option>
			<?php
				$month1=array('01','02','03','04','05','06','07','08','09','10','11','12');
				$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
				$monthlength=count($month1);
				for ($x=0; $x < $monthlength; $x++) {
					if ($month1[$x]==$bulan) {
						echo "<option value='$month1[$x]' selected>$month2[$x]</option>";}
					else{
						echo "<option value='$month1[$x]'>$month2[$x]</option>";}
				}
			?>
		</select>
		<select class='input_main' name='pengaju' onchange='this.form.submit()' style='font-family:arial;width:170px;'>
			<option value=''>Pengaju</option>
			<?php
				$a = mysqli_query($conn , "SELECT pengaju FROM validasi_ik GROUP BY pengaju ORDER BY pengaju ASC");
				while($c=mysqli_fetch_array($a)){
					if ($pengaju==$c['pengaju']) {
						echo "<option value='$c[pengaju]' selected>$c[pengaju]</option>";}
					else{
						echo "<option value='$c[pengaju]'>$c[pengaju]</option>";}
				}

			?>
		</select>
		<select class='input_main' name='d_prosedur' onchange='this.form.submit()' style='font-family:arial;width:305px;'>
			<option value=''>Divisi Prosedur</option>
			<?php
				$a = mysqli_query($conn , "SELECT * FROM divisi_prosedur");
				while($c=mysqli_fetch_array($a)){
					if ($divisi_prosedur==$c['no_divisi_prosedur']) {
						echo "<option value='$c[no_divisi_prosedur]' selected>$c[divisi_prosedur]</option>";}
					else{
						echo "<option value='$c[no_divisi_prosedur]'>$c[divisi_prosedur]</option>";}
				}

			?>
		</select>
		<select class='input_main' name='t_det_prosedur' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Detail Kategori</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM validasi_ik
						GROUP BY detail_prosedur");
					while ($c=mysqli_fetch_array($a)) {
						if ($det_prosedur==$c['detail_prosedur']) {
							echo "
								<option value='$c[detail_prosedur]' selected>$c[detail_prosedur]</option>
							";
						}
						else{
							echo "
								<option value='$c[detail_prosedur]'>$c[detail_prosedur]</option>
							";
						}
					}
				?>
		</select>
		<select class='input_main' name='nm_file' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Nama File</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM validasi_ik
						GROUP BY nama_folder");
					while ($c=mysqli_fetch_array($a)) {
						if ($nm_file==$c['nama_folder']) {
							echo "
								<option value='$c[nama_folder]' selected>$c[nama_folder]</option>
							";
						}
						else{
							echo "
								<option value='$c[nama_folder]'>$c[nama_folder]</option>
							";
						}
					}
				?>
		</select>
		<select class='input_main' name='tgl_berlaku' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Tanggal Berlaku</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM validasi_ik
						GROUP BY tgl_berlaku");
					while ($c=mysqli_fetch_array($a)) {
						if ($tgl_berlaku==$c['tgl_berlaku']) {
							echo "
								<option value='$c[tgl_berlaku]' selected>$c[tgl_berlaku]</option>
							";
						}
						else{
							echo "
								<option value='$c[tgl_berlaku]'>$c[tgl_berlaku]</option>
							";
						}
					}
				?>
		</select><br>&emsp;
		<select class='input_main' name='status_ik' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Status IK</option>
				<?php
					if ($status_ik == 'Percobaan') {
						echo "<option value='Percobaan' selected>Percobaan</option>";}
					else{
						echo "<option value='Percobaan'>Percobaan</option>";}

					if ($status_ik == 'Expired') {
						echo "<option value='Expired' selected>Expired</option>";}
					else{
						echo "<option value='Expired'>Expired</option>";}
				?>
		</select>
		<select class='input_main' name='status_lj' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Status Lanjutan</option>
				<?php
					if ($status_lj == 'Berlakukan') {
						echo "<option value='Berlakukan' selected>Berlakukan</option>";}
					else{
						echo "<option value='Berlakukan'>Berlakukan</option>";}

					if ($status_lj == 'Tarik') {
						echo "<option value='Tarik' selected>Tarik</option>";}
					else{
						echo "<option value='Tarik'>Tarik</option>";}
				?>
		</select>
		<select class='input_main' name='no_upp' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Nomor UPP</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM validasi_ik");
					while ($c=mysqli_fetch_array($a)) {
						if ($no_upp==$c['no_upp']) {
							echo "
								<option value='$c[no_upp]' selected>$c[no_upp]</option>
							";
						}
						else{
							echo "
								<option value='$c[no_upp]'>$c[no_upp]</option>
							";
						}
					}
				?>
		</select>
</form>
		
<div class='form_main' style='margin-top: 0px;'>
	<?php
			
			$sort="no DESC";
			if (isset($_GET['sort'])) {
				$sortby=$_GET['sort'];
				if (isset($_GET['order'])) {
					$orderby=$_GET['order'];
					$sort=$sortby." ".$orderby;
					$sorturl='&sort='.$sortby.'&order='.$orderby;
				}
				else{
					$orderby='';
					$sort=$sortby;
					$sorturl='&sort='.$sortby;
				}
			}
			else{
				$sortby='';
				$sorturl='';
			}
			if (isset($_GET['hal'])) {
				$hal=$_GET['hal'];
				$halurl='&hal='.$hal;
			}
			else{
				$hal = 1;
				$halurl='';
			}
			
			if (!empty($filter)) {
				$awal=0;
				$akhir=2147483647;
			}
			else{
				$awal=($hal-1)*10;
				$akhir=10;
			}
			
			if (isset($id)) {
				$a=mysqli_query($conn, "
					SELECT * FROM validasi_ik
						inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
						inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik
						inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
						WHERE no != '' AND validasi_ik.no_upp = '$id'
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM validasi_ik
						inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
						inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik
						inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
						WHERE no != '' AND validasi_ik.no_upp = '$id' ".$filter);
			}

			else {
				$a=mysqli_query($conn, "
					SELECT * FROM validasi_ik
						inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
						inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik
						inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
						WHERE no != ''
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM validasi_ik
						inner join divisi_prosedur on validasi_ik.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on validasi_ik.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on validasi_ik.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
						inner join jenis_ik	on validasi_ik.jenis_ik = jenis_ik.kode_ik
						inner join validasi_ik_tmp on validasi_ik.no_upp = validasi_ik_tmp.no_upp
						WHERE no != '' ".$filter);
			}

			$page2=mysqli_num_rows($page1);
			if (!empty($filter)) {
				$page3=$page2/2147483647;
			}
			else{
				$page3=$page2/10;
			}
			$page=floor($page3)+1;
			$alert2='Jumlah : '.$page2;
			echo "
				<table class='page_number'>
					<tr>
					";
					if ($hal<2) {
						echo "<td>First</a></td>";
						echo "<td>Previous</a></td>";
						$hal2=$hal;
					}
					elseif ($hal<=2) {
						$hal2=$hal-1;
						$hal3=$hal-1;
						echo "<td><a href='main?index=validasi&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=validasi&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=validasi&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=validasi&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=validasi&step=create&hal=$hal2$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=validasi&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=validasi&step=create&hal=$page$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					/**/
					echo "
					</tr>
				</table>
			";
		
		if (isset($alert)) {
			echo "<div class='alert_adm alert'>$alert</div>";
		}
		if (isset($alert2)) {
			echo "<div class='alert_adm alert2'>$alert2</div>";
		}
	?>
	<table class='table_admin'>
		<tr class='top_table'>
				<td>No</td>
				<td>No. UPP</td>
				<td>Tanggal UPP</td>
				<td>Pengaju</td>
				<td>Divisi Prosedur</td>
				<td>Prosedur</td>
				<td>Kategori Prosedur</td>
				<td>Jenis IK</td>
				<td>Detail Kategori</td>
				<td>Nama File</td>
				<td>Sebelum Perubahan</td>
				<td>Setelah Perubahan</td>
				<td>Alasan</td>
				<td>Attachment FMEA</td>
				<td>Attachment File Prosedur</td>
				<td>Tgl Berlaku</td>
				<td>Tgl Selesai Masa Percobaan</td>
				<td>Status IK</td>
				<td>Attachment report hasil review IK</td>
				<td>Tanggal Approve</td>
				<td>PIC Approve</td>
				<?php
					if (isset($_SESSION['username'])) {
						echo "<td colspan='6'>Action</td>";
					}
				?>
				<td>Status Lanjutan</td>
				<td>Tgl Penarikan</td>
				<td>Alasan Penarikan</td>
			</tr>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		$tmp_id = $c['no_upp'];
		$tmp_tgl = $c['tgl_berlaku'];
		$tmp_tgl = date('Y-m-d', strtotime('+90 days', strtotime($tmp_tgl)));
		if (isset($_SESSION['username'])) {
			$hariini = date('Y-m-d');
			$start = new DateTime($hariini);
			$finish = new DateTime($tmp_tgl);
			$leadtime=$start->diff($finish);
			$leadtime=$leadtime->days;
			if ($leadtime == 15 AND $c['vi_status_ik'] != 'Expired') {
				header('location:main?index=validasi&action=automail25&lead='.$leadtime.'&id='.$c['no_upp']);
			}
			else if ($leadtime < 15 AND $leadtime % 3 == 0 AND $leadtime >= 0 AND $c['vi_status_ik'] != 'Expired') {
				header('location:main?index=validasi&action=automail25&lead='.$leadtime.'&id='.$c['no_upp']);
			}
			else if($start > $finish){
				mysqli_query($conn, "UPDATE validasi_ik SET
					vi_status_ik = 'Expired'
					WHERE no_upp ='$tmp_id'");
			}
		}
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[pengaju]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>
					";
					if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>
					";
					if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[tgl_berlaku]</td>
					<td>$tmp_tgl</td>
					<td>$c[vi_status_ik]</td>
					<td>
					";
					if ($c['vi_file']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[vi_file]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[vi_pic_app]</td>
					<td>$c[vi_pic_email]</td>";

					if (isset($_SESSION['email'])) {
						if ($_SESSION['email'] == $c['vi_pic_email'] AND $c['vi_pic_app'] == '') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=terima&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
									</a>
								</td>
							";
						}
						else{
							echo "
								<td style='padding:10px;'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
								</td>
							";
						}
					}
					else{
						echo "
							<td style='padding:10px;'>
								<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
							</td>
						";
					}

					if (isset($_SESSION['username'])) {
						echo"
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=edit&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
								</a>
							</td>";
							if ($c['vi_status_ik'] == 'Expired' AND $c['vi_status_lj'] == '') {
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=tarik&id=$c[no_upp]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Tarik
										</a>
									</td>
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=berlaku&id=$c[no_upp]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/done.png'> Berlakukan
										</a>
									</td>
								";
							}
							else{
								echo "
									<td style='padding:10px;'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Tarik
									</td>
									<td style='padding:10px;'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/done.png'> Berlakukan
									</td>
								";
							}
							echo "
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=mail&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/mail.png'> Mail
								</a>
							</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=l_email&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> List Email
								</a>
							</td>
						";
					}
					echo"
					<td>$c[vi_status_lj]</td>
					<td>$c[vi_tgl_penarikan]</td>
					<td>$c[vi_alasan_penarikan]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>$rowscount</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[pengaju]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>
					";
					if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>
					";
					if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[tgl_berlaku]</td>
					<td>$tmp_tgl</td>
					<td>$c[vi_status_ik]</td>
					<td>
					";
					if ($c['vi_file']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[vi_file]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[vi_pic_app]</td>
					<td>$c[vi_pic_email]</td>";

					if (isset($_SESSION['email'])) {
						if ($_SESSION['email'] == $c['vi_pic_email'] AND $c['vi_pic_app'] == '') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=terima&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
									</a>
								</td>
							";
						}
						else{
							echo "
								<td style='padding:10px;'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
								</td>
							";
						}
					}
					else{
						echo "
							<td style='padding:10px;'>
								<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> Approve
							</td>
						";
					}

					if (isset($_SESSION['username'])) {
						echo "
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=edit&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
								</a>
							</td>";
							if ($c['vi_status_ik'] == 'Expired' AND $c['vi_status_lj'] == '') {
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=tarik&id=$c[no_upp]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Tarik
										</a>
									</td>
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=berlaku&id=$c[no_upp]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/done.png'> Berlakukan
										</a>
									</td>
								";
							}
							else{
								echo "
									<td style='padding:10px;'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Tarik
									</td>
									<td style='padding:10px;'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/done.png'> Berlakukan
									</td>
								";
							}
							echo "
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=mail&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/mail.png'> Mail
								</a>
							</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=validasi&action=l_email&id=$c[no_upp]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> List Email
								</a>
							</td>
						";
					}
					echo "
					<td>$c[vi_status_lj]</td>
					<td>$c[vi_tgl_penarikan]</td>
					<td>$c[vi_alasan_penarikan]</td>
				</tr>
			";
		}
		$rowscount++;
	}
	echo "
		</table>
	</div>
	";
?>
<script>
	function valid(file) {
		var FileSize = file.files[0].size / 1024 / 1024; // in MB
		if (FileSize > 2) {
			document.getElementById('ubr2').style.display = "none";
			document.getElementById('ugg2').style.display = "block";
			document.getElementById('subsub').style.display = "none";
		} else {
			document.getElementById('ugg2').style.display = "none";
			document.getElementById('ubr2').style.display = "block";
			document.getElementById('subsub').style.display = "block";
		}
	}

	function valid1(file) {
	    var FileSize = file.files[0].size / 1024 / 1024; // in MB
		if (FileSize > 2) {
			document.getElementById('ubr').style.display = "none";
			document.getElementById('ugg').style.display = "block";
			document.getElementById('submit').style.display = "none";
		} else {
			document.getElementById('ugg').style.display = "none";
			document.getElementById('ubr').style.display = "block";
			document.getElementById('submit').style.display = "block";
		}
	}

	function valid2(file) {
		var FileSize = file.files[0].size / 1024 / 1024; // in MB
		if (FileSize > 2) {
			document.getElementById('ubr1').style.display = "none";
			document.getElementById('ugg1').style.display = "block";
			document.getElementById('submit').style.display = "none";
		} else {
			document.getElementById('ugg1').style.display = "none";
			document.getElementById('ubr1').style.display = "block";
			document.getElementById('submit').style.display = "block";
		}
	}
</script>

<!-- Bima Putra S | SuBZero14 | 2017 | bimaputras.sz14@gmail.com | SMK Negeri 1 CIMAHI -->