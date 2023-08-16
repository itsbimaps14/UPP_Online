<?php
	if (!isset($_SESSION['username'])) {
		if (!isset($_GET['id'])) {
			header('location:home');
		}
	}
	else{
	}
	date_default_timezone_set('Asia/Jakarta');
	$hariinijam=date("Y-m-d")." ".date("H:i:s");
	$hariini=date("Y-m-d");
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'acc':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_pic1=test($_POST['tgl_pic1']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET 	tgl_pic1 = '$tgl_pic1'
												WHERE 	no_upp = '$id'
												")){
						$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp='$id' AND  status='approval'");
						$c=mysqli_fetch_array($a);
						if ($c['tgl_pic2']!='0000-00-00') {
							$a=mysqli_query($conn, "UPDATE upp SET status = 'approved', tgl_approved = '$tgl_pic1 ".date("H:i:s")."' WHERE no_upp = '$id'");
						}
						header('location:main?index=upp&step=approval1');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp='$id' AND  status='approval' AND tgl_pic1='0000/00/00'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approval1&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Approval
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=approval1&action=acc&id=$id' method='post'>
								<a class='j_input_main'>No. UPP</a><br>
								<input class='input_main' type='text' name='no_upp' value='$c[no_upp]' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Tanggal Approval</a><br>
								<input class='input_main' type='date' name='tgl_pic1' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<input style='margin-left:5px;' class='submit_main fr' type='submit' value='Approve'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'reject':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_reject=test($_POST['tgl_reject']);
					$alasan='Pic 1 : '.test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_pic1 = '0000-00-00',
												tgl_pic2 = '0000-00-00',
												tgl_reject = '$tgl_reject',
												alasan_reject = '$alasan',
												status = 'not approved'
												WHERE 	no_upp = '$id'
												")){
						$a=mysqli_query($conn, "SELECT * FROM upp 
							inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
							inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
							inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
							inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
							WHERE no_upp = '$id'");
						$c=mysqli_fetch_array($a);
						$email=$c['email_pengaju'];

						$to 	  =	"$email";
						$subject  =	"PROSEDUR ONLINE | APPROVAL REJECT";
						$headers  = array ('From' => $from,
						'To' => $to,
						'subject' => $subject,
						"MIME-Version"=>"1.0",
						"Content-type"=>"text/html"
						);
						$message  =	"<html><body>";
						$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
						$message .=	"<strong>Berikut kami sampaikan Usulan Perubahan Prosedur anda dengan detail sebagai berikut</strong><br><br>";
						$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
						$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
						$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
						$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
						$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
						$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Permohonan Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['permohonan_tgl_berlaku']) . "</td></tr>";
						$message .= "</table>";
						$message .= "<br>Permintaan Usulan Perubahan Prosedur yang ada minta telah <strong>direject pada tanggal " . strip_tags($c['tgl_reject']) . "</strong> dengan alasan <strong>" . strip_tags($c['alasan_reject']) . "</strong><br><br><br>";
						$message .= "<strong>Salam,</strong><br>";
						$message .= "<strong>UPP Online</strong>";
						$message .= "</body></html>";

						$mail = $smtp->send($to, $headers, $message);
						if (Pear::isError($mail)) {
							echo "<p>" . $mail->getMessage() . "</p>";
							echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
						} else{
							echo "<p>Message successfully sent!</p>";
							header('location:main?index=upp&step=approval1');
						}
						
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp='$id' AND status = 'approval' AND tgl_pic1='0000/00/00'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approval1&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Reject
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=approval1&action=reject&id=$id' method='post'>
								<a class='j_input_main'>No. UPP</a><br>
								<input class='input_main' type='text' name='no_upp' value='$c[no_upp]' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Tanggal Reject</a><br>
								<input class='input_main' type='date' name='tgl_reject' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Alasan Reject</a><br>
								<textarea class='input_main' type='text' name='alasan' value='' required style='width:100%;max-width:100%;'></textarea><br>
								<input style='margin-left:5px;' class='submit_main fr' type='submit' value='Reject'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'autosent':
				$a=mysqli_query($conn, "UPDATE upp SET tgl_kirim1 = '$hariini' WHERE no_upp ='$id'");
				$a=mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
					WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				$pic1=$c['pic1'];
				$to 	  =	"$pic1";
				$subject  =	"PROSEDUR ONLINE | APPROVAL";
				$headers  = array ('From' => $from,
				'To' => $to,
				'subject' => $subject,
				"MIME-Version"=>"1.0",
				"Content-type"=>"text/html"
				);
				$message  =	"<html><body>";
				$message .=	"<strong>Dear Manager,</strong><br><br><br>";
				$message .=	"<strong>Berikut kami sampaikan Usulan Perubahan Prosedur dengan detail sebagai berikut</strong><br><br>";
				$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
				$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
				$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
				$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
				$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
				$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Permohonan Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['permohonan_tgl_berlaku']) . "</td></tr>";
				$message .= "</table>";
				$message .= "<br><strong>Untuk melihat UPP diatas silahkan akses <a href='http://prosedur_online/main?index=upp&step=approval1&id=".strip_tags($id)."'>Go To UPP</a><br><br><br>";
				$message .= "<strong>Salam,</strong><br>";
				$message .= "<strong>UPP Online</strong>";
				$message .= "</body></html>";

				$mail = $smtp->send($to, $headers, $message);
				if (Pear::isError($mail)) {
					echo "<p>" . $mail->getMessage() . "</p>";
					echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
				} else{
					header('location:main?index=upp&step=approval1');
				}
				break;
			case 'sent':
				$a=mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
					WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				$pic1=$c['pic1'];
				$to 	  =	"$pic1";
				$subject  =	"PROSEDUR ONLINE | APPROVAL";
				$headers  = array ('From' => $from,
				'To' => $to,
				'subject' => $subject,
				"MIME-Version"=>"1.0",
				"Content-type"=>"text/html"
				);
				$message  =	"<html><body>";
				$message .=	"<strong>Dear Manager,</strong><br><br><br>";
				$message .=	"<strong>Berikut kami sampaikan Usulan Perubahan Prosedur dengan detail sebagai berikut</strong><br><br>";
				$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
				$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
				$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
				$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
				$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
				$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
				$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Permohonan Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['permohonan_tgl_berlaku']) . "</td></tr>";
				$message .= "</table>";
				$message .= "<br><strong>Untuk melihat UPP diatas silahkan akses <a href='http://prosedur_online/main?index=upp&step=approval1&id=".strip_tags($id)."'>Go To UPP</a><br><br><br>";
				$message .= "<strong>Salam,</strong><br>";
				$message .= "<strong>UPP Online</strong>";
				$message .= "</body></html>";
				$mail = $smtp->send($to, $headers, $message);
				if (Pear::isError($mail)) {
					echo "<p>" . $mail->getMessage() . "</p>";
					echo "<script type='text/javascript'>alert('email tidak terkirim $pic1');</script>";
				} else{
					$a=mysqli_query($conn, "UPDATE upp SET tgl_kirim1 = '$hariini' WHERE no_upp ='$id'");
					echo "
						<div id='popup' class='popup'>
							<a href='main?index=upp&step=approval1&id=$id'>
								<div class='popup_exit'></div>
							</a>
							<div class='popup_upp'>
								<a href='main?index=upp&step=approval1&id=$id' class='close-button' title='close'>X</a>
								UPP ONLINE<br>
								<span style='font-size:15px;'>Email Approval Telah Terkirim</span><br>
							</div>
						</div>
					";
				}
				break;
			case 'batal':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_batal=test($_POST['tgl_batal']);
					$alasan=test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_batal = '$tgl_batal',
												alasan_batal = '$alasan',
												status = 'batal'
												WHERE 	no_upp = '$id'
												")){
						$a=mysqli_query($conn, "SELECT * FROM upp 
							inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
							inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
							inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
							inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
							WHERE no_upp = '$id'");
						$c=mysqli_fetch_array($a);
						$email=$c['email_pengaju'];

						$to 	  =	"$email";
						$subject  =	"PROSEDUR ONLINE | BATAL";
						$headers  = array ('From' => $from,
						'To' => $to,
						'subject' => $subject,
						"MIME-Version"=>"1.0",
						"Content-type"=>"text/html"
						);
						$message  =	"<html><body>";
						$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
						$message .=	"<strong>Berikut kami sampaikan Usulan Perubahan Prosedur anda dengan detail sebagai berikut</strong><br><br>";
						$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
						$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
						$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
						$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
						$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
						$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
						$message .=	"<tr><td><strong>Permohonan Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['permohonan_tgl_berlaku']) . "</td></tr>";
						$message .= "</table>";
						$message .= "<br>Permintaan Usulan Perubahan Prosedur yang ada minta telah <strong>dibatalkan pada tanggal " . strip_tags($c['tgl_batal']) . "</strong> dengan alasan <strong>" . strip_tags($c['alasan_batal']) . "</strong><br><br><br>";
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
						header('location:main?index=upp&step=approval1');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approval1&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Batal
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=approval1&action=batal&id=$id' method='post'>
								<a class='j_input_main'>No. UPP</a><br>
								<input class='input_main' type='text' name='no_upp' value='$id' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Tanggal Batal</a><br>
								<input class='input_main' type='date' name='tgl_batal' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Alasan Batal</a><br>
								<textarea class='input_main' type='text' name='alasan' value='' required style='width:100%;max-width:100%;'></textarea><br>
								<input style='margin-left:5px;' class='submit_main fr' type='submit' value='batal'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_upp=test($_POST['no_upp']);
					$tgl_upp=test($_POST['tgl_upp']);
					$lokasi=test($_POST['lokasi']);
					$pengaju=test($_POST['pengaju']);
					$email_pengaju=test($_POST['email_pengaju']);
					$pic1=test($_POST['pic1']);
					$divisi_prosedur=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis_prosedur=test($_POST['jenis']);
					$detail_prosedur=test($_POST['detail']);
					$nama_folder=test($_POST['file']);
					$sebelumperubahan=test($_POST['sebelumperubahan']);
					$setelahperubahan=test($_POST['setelahperubahan']);
					$alasan=test($_POST['alasan']);
					$tahun=test($_POST['tahun']);
					$bulan=test($_POST['bulan']);
					$tanggal=test($_POST['tanggal']);
					$tanggal_berlaku=$tahun.'-'.$bulan.'-'.$tanggal;
					$kat_perubahan=test($_POST['kat_perubahan']);
					$kat_mesin=test($_POST['kat_mesin']);
					$pic=test($_POST['pic']);
					$cek_ddd=test($_POST['cek_ddd']);
					$jenis_ik=test($_POST['j_ik_user']);
					$d_date = date('Y-m-d');

					$uploadOk = 1;
					$nama_file = $_FILES['file_fmea']['name'];
					if ($nama_file!='') {
						$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
						$c=mysqli_fetch_array($a);

						$tmp_nmfl = $c['file_fmea'];
						$tmp_mvfl = pathinfo($tmp_nmfl);
						$tmp_name = $tmp_mvfl['filename'];
						$tmp_exte = $tmp_mvfl['extension'];
						$tmp_dirn = $tmp_mvfl['dirname'];

						if (!file_exists($tmp_dirn.'/')) {
							mkdir($tmp_dirn.'/');}

						$folder1 = $tmp_dirn.'/';
						$file_user1 = $_FILES['file_fmea']['name'];
						$file_user = $folder1.$file_user1;

						if (!file_exists('file_removal/'.$tmp_dirn.'/')) {
							mkdir('file_removal/'.$tmp_dirn.'/');}

						$rmv_file = 'file_removal/'.$tmp_dirn.'/';
						$fnl_name = $tmp_name.'_'.$d_date.'.'.$tmp_exte;
						$end_name = $rmv_file.$fnl_name;

						rename($c['file_fmea'], $end_name);

						if (move_uploaded_file($_FILES['file_fmea']['tmp_name'], $file_user)) {
							
							mysqli_query($conn, 
								"UPDATE upp SET
									file_fmea = '$file_user'
									WHERE no_upp = '$no_upp' ");
							$alert='Update File Berhasil !';

						}
						else {
							$alert='upload file gagal, silahkan ulangi pengajuan, atau hubungi QA team';
							$file_user='';
							$uploadOk = 0;
						}
					}
					else{
						$file_user='';
					}

					if ($a=mysqli_query($conn, "UPDATE upp SET lokasi = '$lokasi',
													pengaju = '$pengaju',
													email_pengaju = '$email_pengaju',
													pic1 = '$pic1',
													no_divisi_prosedur = '$divisi_prosedur',
													no_master_prosedur = '$prosedur',
													no_jenis_prosedur = '$jenis_prosedur',
													jenis_ik = '$jenis_ik',
													detail_prosedur = '$detail_prosedur',
													nama_folder = '$nama_folder',
													sebelumperubahan = '$sebelumperubahan',
													setelahperubahan = '$setelahperubahan',
													alasan = '$alasan',
													permohonan_tgl_berlaku = '$tanggal_berlaku',
													kat_perubahan = '$kat_perubahan',
													kat_mesin = '$kat_mesin',
													pic = '$pic',
													cek_ddd = '$cek_ddd'
													WHERE 	no_upp = '$no_upp'
													")) {
						header('location:main?index=upp&step=approval1');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approval1&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form Edit
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=approval1&action=edit&id=$id#popup' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>
									";
										if (isset($alert)) {
											echo "<div class='alert_adm alert'>$alert</div>";
										}
										if (isset($alert2)) {
											echo "<div class='alert_adm alert2'>$alert2</div>";
										}
									echo "
									<a class='j_input_main'>No. UPP *</a><br>
									<input class='input_main readonly' style='font-family:monospace;' type='text' name='no_upp' value='$c[no_upp]' required readonly><br>
									<a class='j_input_main'>Tanggal UPP *</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_upp' value='$c[tgl_upp]' required readonly><br>
									<a class='j_input_main'>Lokasi *</a><br>
									<select class='input_main' name='lokasi' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from plant");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['lokasi']==$f['plant']) {
													echo "
														<option value='$f[plant]' selected>$f[plant]</option>
													";
												}
												else{
													echo "
														<option value='$f[plant]'>$f[plant]</option>
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Pengaju *</a><br>
									<input class='input_main' type='text' name='pengaju' value='$c[pengaju]' required><br>
									<a class='j_input_main'>Email Pengaju *</a><br>
									<input class='input_main' type='email' name='email_pengaju' value='$c[email_pengaju]' required><br>
									<a class='j_input_main'>Manager Approver (PIC 1) *</a><br>
									<input class='input_main' type='email' name='pic1' value='$c[pic1]' required><br>
									<a class='j_input_main'>Divisi Prosedur *</a><br>
									<select class='input_main' name='divisi' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_divisi_prosedur']==$f['no_divisi_prosedur']) {
													echo "
														<option value='$f[no_divisi_prosedur]' selected>$f[divisi_prosedur]</option>
													";
												}
												else{
													echo "
														<option value='$f[no_divisi_prosedur]'>$f[divisi_prosedur]</option>
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Prosedur *</a><br>
									<select class='input_main' name='prosedur' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from master_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_master_prosedur']==$f['no_master_prosedur']) {
													echo "
														<option value='$f[no_master_prosedur]' selected>$f[master_prosedur]</option>
													";
												}
												else{
													echo "
														<option value='$f[no_master_prosedur]'>$f[master_prosedur]</option>
													";
												}
											}
										echo "
									</select><br>";
									?>
									<a class='j_input_main'>Kategori Prosedur *</a><br>
									<select class='input_main' name='jenis' id='jenis_ik' onload="check()" onchange="check()" required>
										<?php
											$d=mysqli_query($conn, "SELECT * from jenis_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_jenis_prosedur']==$f['no_jenis_prosedur']) {
													echo "
														<option value='$f[no_jenis_prosedur]' selected>$f[jenis_prosedur]</option>
													";
												}
												else{
													echo "
														<option value='$f[no_jenis_prosedur]'>$f[jenis_prosedur]</option>
													";
												}
											}
										?>
									</select><br>

									<a id='txt_sh_1' class='j_input_main'>Jenis Instruksi Kerja<br></a>
									<select class='input_main' name='j_ik_user' id='j_ik' required>
										<?php
										$d=mysqli_query($conn, "SELECT * from jenis_ik");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['jenis_ik']==$f['kode_ik']) {
													echo "
														<option value='$f[kode_ik]' selected>$f[jenis_ik]</option>
													";
												}
												else{
													echo "
														<option value='$f[kode_ik]'>$f[jenis_ik]</option>
													";
												}
											}
										?>
									</select>
					
									<a id='txt_sh_2' class='j_input_main'>Attachment FMEA <font size='1' color='red'> *) Max File 1MB, Diisi jika file upload akan diubah</font><br></a>
									<input class='file_main' type='file' id='file_fmea' name='file_fmea' onchange="valid(this)">

								<script>
									function valid(file) {
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

									function check(){
										var dropdown = document.getElementById("jenis_ik");
										var current_value = dropdown.options[dropdown.selectedIndex].value;

										if (current_value == "2") {
											document.getElementById("j_ik").style.display = "block";
								        	document.getElementById("file_fmea").style.display = "block";
											document.getElementById('txt_sh_1').style.display = "block";
											document.getElementById('txt_sh_2').style.display = "block";}
								        else {
								        	document.getElementById("j_ik").value = '1';
								        	document.getElementById("j_ik").style.display = "none";
									        document.getElementById("file_fmea").style.display = "none";
											document.getElementById('txt_sh_1').style.display = "none";
											document.getElementById('txt_sh_2').style.display = "none";}
									}
									
								</script>
								<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>

								<script>
									window.onload = function(){
										document.getElementById('ugg').style.display = "none";
										document.getElementById('ubr').style.display = "none";

										var dropdown = document.getElementById("jenis_ik");
										var current_value = dropdown.options[dropdown.selectedIndex].value;

										if (current_value == "2") {
											document.getElementById("j_ik").style.display = "block";
								        	document.getElementById("file_fmea").style.display = "block";
											document.getElementById('txt_sh_1').style.display = "block";
											document.getElementById('txt_sh_2').style.display = "block";}
								        else {
								        	document.getElementById("j_ik").value = '1';
								        	document.getElementById("j_ik").style.display = "none";
									        document.getElementById("file_fmea").style.display = "none";
											document.getElementById('txt_sh_1').style.display = "none";
											document.getElementById('txt_sh_2').style.display = "none";}
									}
								</script>

									<?php
									echo "
									<br>
									<a class='j_input_main'>Detail Kategori</a><br>
									<input class='input_main' type='input' name='detail' value='$c[detail_prosedur]' onload='load()'><br>
									<a class='j_input_main'>Nama File Prosedur *</a><br>
									<input class='input_main' type='text' name='file' value='$c[nama_folder]' required><br>
									<a class='j_input_main'>Sebelum Perubahan *</a><br>
									<textarea class='input_main' name='sebelumperubahan' required>$c[sebelumperubahan]</textarea><br>
									<a class='j_input_main'>Setelah Perubahan *</a><br>
									<textarea class='input_main' name='setelahperubahan' required>$c[setelahperubahan]</textarea><br>
									<a class='j_input_main'>Alasan *</a><br>
									<textarea class='input_main' name='alasan' required>$c[alasan]</textarea><br>
									<script>
										$(document).ready(function(){
											$('#thndibutuhkan').on('change', function(){
												var tanggal1 = $('#pengajuan').val();
												var tahun1 = tanggal1.substr(0, 4)
												var tahun = $('#thndibutuhkan').val();
												if(tahun < tahun1){
													$('#alert_tanggal').show();
													$('#button_submit').hide();
												}
												else{
													$('#alert_tanggal').hide();
													$('#button_submit').show();
												}
											});
											$('#blndibutuhkan').on('change', function(){
												var tanggal1 = $('#pengajuan').val();
												var tahun1 = tanggal1.substr(0, 4);
												var tahun = $('#thndibutuhkan').val();
												var bulan1 = tanggal1.substr(5, 2);
												var bulan = $('#blndibutuhkan').val();	
												if(tahun < tahun1){
													$('#alert_tanggal').show();
													$('#button_submit').hide();
												}
												else if(tahun == tahun1){
													if(bulan-bulan1<0){
														$('#alert_tanggal').show();
														$('#button_submit').hide();
													}
													else{
														$('#alert_tanggal').hide();
														$('#button_submit').show();
													}
												}
												else{
													$('#alert_tanggal').hide();
													$('#button_submit').show();
												}
											});
											$('#tgldibutuhkan').on('change', function(){
												var miliday = 24 * 60 * 60 * 1000;
												var tanggal1 = $('#pengajuan').val();
												var tahun = $('#thndibutuhkan').val();
												var bulan = $('#blndibutuhkan').val();
												var tanggal = $('#tgldibutuhkan').val();
												var tanggal2 = tahun+'-'+bulan+'-'+tanggal;
												var tglPertama = Date.parse(tanggal1);
												var tglKedua = Date.parse(tanggal2);
												var selisih = (tglKedua - tglPertama) / miliday;
												var d = new Date();
												var n = d.getDay();
												var h = n + selisih;
												if (h > 55) {
													hr = h - 56;
												}
												else if (h > 48) {
													hr = h - 49;
												}
												else if (h > 41) {
													hr = h - 42;
												}
												else if (h > 34) {
													hr = h - 35;
												}
												else if (h > 27) {
													hr = h - 28;
												}
												else if (h > 20) {
													hr = h - 21;
												}
												else if (h > 13) {
													hr = h - 14;
												}
												else if (h > 6) {
													hr = h - 7;
												}
												else if (h >= 0) {
													hr = h;
												}
												if (hr == 1) {
													selisih -= 2;
												}
												else if (hr == 2) {
													selisih -= 2;
												}	
												if(selisih < 3){
													$('#alert_tanggal').show();
													$('#button_submit').hide();
												}
												else{
													if (hr == 0) {
														$('#alert_tanggal').show();
														$('#button_submit').hide();
													}
													else if (hr == 6) {
														$('#alert_tanggal').show();
														$('#button_submit').hide();
													}
													else{
														$('#alert_tanggal').hide();
														$('#button_submit').show();
													}
												}
											});
										});
									</script>
									<div id='alert_tanggal' class='alert_adm alert' style='display:none;'>tanggal dibutuhkan minimal 3 hari kerja sesudah tanggal UPP</div>
									<a class='j_input_main'>Permohonan Tgl Berlaku *</a><br>
									<select id='thndibutuhkan' class='input_main' style='width:100px;' name='tahun' required>
										<option value=''></option>
										";
											$tahun=substr($c['permohonan_tgl_berlaku'],0,4);
											$tahunnow = date('Y')+1;
											for ($i=$tahunnow; $i >= 1980 ; $i--) {
												if ($i==$tahun) {
													echo "
														<option value='$i' selected>$i</option>
													";
												}
												else{
													echo "
														<option value='$i'>$i</option>
													";
												}
											}
										echo "
									</select>
									<select id='blndibutuhkan' class='input_main'  style='width:190px;' name='bulan' required>
										<option value=''></option>
										";
											$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['permohonan_tgl_berlaku'],5,2);
											for ($x=0; $x < 12; $x++) {
												$i=$x+1;
												if ($i==$bulan) {
													echo "
														<option value='$monthvalue[$x]' selected>$month2[$x]</option>
													";
												}
												else{
													echo "
														<option value='$monthvalue[$x]'>$month2[$x]</option>
													";
												}
											}
										echo "
									</select>
									<select id='tgldibutuhkan' class='input_main' style='width:100px;' name='tanggal' required>
										<option value=''></option>
										";
											$tgl=substr($c['permohonan_tgl_berlaku'],8,2);
											for ($i=1; $i <= 31 ; $i++) {
												if ($i<10) {
													$i='0'.$i;
												}
												if ($i==$tgl) {
													echo "
														<option value='$i' selected>$i</option>
													";
												}
												else{
													echo "
														<option value='$i'>$i</option>
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Kategori Perubahan *</a><br>
									<select class='input_main' name='kat_perubahan' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from kat_perubahan");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['kat_perubahan']==$f['kat_perubahan']) {
													echo "
														<option value='$f[kat_perubahan]' selected>$f[kat_perubahan]
													";
												}
												else{
													echo "
														<option value='$f[kat_perubahan]'>$f[kat_perubahan]
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Kategori Mesin</a><br>
									<select class='input_main' name='kat_mesin'>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from kat_mesin");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['kat_mesin']==$f['kat_mesin']) {
													echo "
														<option value='$f[kat_mesin]' selected>$f[kat_mesin]
													";
												}
												else{
													echo "
														<option value='$f[kat_mesin]'>$f[kat_mesin]
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>
									<input class='input_main' type='text' name='pic' value='$c[pic]' required><br>
									<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>
									<label>
									";
										if ($c['cek_ddd']=='ya') {
											echo "<input id='cek_ddd' class='radio_main' type='radio' name='cek_ddd' value='ya' checked required> Ya";
										}
										else{
											echo "<input id='cek_ddd' class='radio_main' type='radio' name='cek_ddd' value='ya' required> Ya";
										}
									echo "
									</label>
									<label>
									";
										if ($c['cek_ddd']=='tidak') {
											echo "<input id='cek_ddd2' class='radio_main' type='radio' name='cek_ddd' value='tidak' checked> Tidak";
										}
										else{
											echo "<input id='cek_ddd2' class='radio_main' type='radio' name='cek_ddd' value='tidak'> Tidak";
										}
									echo "
									</label>
									<br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:304px;' id='submit' class='submit_main' type='submit' value='Update'>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
?>
<div class='judul_main' style='position: fixed;'>Approval PIC 1 Usulan Perubahan Prosedur</div>

<div class='form_main' style='margin-top: 46px;'>
	<?php
	echo"<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=approval1' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE no_upp='$id' AND status='approval' AND tgl_pic1='0000/00/00'");
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=approval1' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else if (isset($_SESSION['username']) and $_SESSION['level'] == "approval1")
		{
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				WHERE status='approval' AND tgl_pic1='0000/00/00' and pic1 = '".$_SESSION['email']."' ORDER BY tgl_kirim desc");
		}
		else{
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				WHERE status='approval' AND tgl_pic1='0000/00/00' ORDER BY tgl_kirim desc");
			
		}
		if(isset($_POST['kw'])){
				$kw = $_POST['kw'];
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				WHERE status='approval' AND tgl_pic1='0000/00/00' 
				and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%') ORDER BY tgl_kirim desc
				");
				
		}
		if (isset($alert)) {
			echo "<div class='alert_adm alert'>$alert</div>";
		}
		if (isset($alert2)) {
			echo "<div class='alert_adm alert2'>$alert2</div>";
		}
	?>
	<table class='table_admin'>
		<tr class='top_table'>
			<?php
				if (isset($_SESSION['username'])) {
					echo "
						<td colspan='5'>Action</td>
					";
				}
				else{
					echo "
						<td colspan='2'>Action</td>
					";
				}
			?>
			<td>Tanggal Kirim Approval</td>
			<td>Attachment File Master</td>
			<td>No. UPP</td>
			<td>Tanggal UPP</td> 
			<td>Lokasi</td>
			<td>Pengaju</td>
			<td>Email Approver</td>
			<td>Divisi Prosedur</td>
			<td>Prosedur</td>
			<td>Jenis Prosedur</td>
			<td>Jenis IK</td>
			<td>File FMEA</td>
			<td>Detail Kategori</td>
			<td>Nama File</td>
			<td>Sebelum Perubahan</td>
			<td>Setelah Perubahan</td>
			<td>Alasan</td>
			<td>Permohonan Tgl Berlaku</td>
			<td>Kategori Perubahan</td>
			<td>Kategori Mesin</td>
			<td>PIC Sosialisasi Lapangan</td>
			<td>Cek DDD</td>
			<td>Keterangan Proses</td>
		</tr>
<?php
	$rowscount=1;
	while ($c=mysqli_fetch_array($a)) {
		if (isset($_SESSION['username'])) {
			$start = new DateTime($hariini);
			$finish = new DateTime($c['tgl_kirim1']);
			$leadtime=$start->diff($finish);
			$leadtime=$leadtime->days;
			if ($leadtime>0) {
				//header('location:main?index=upp&step=approval1&action=autosent&id='.$c['no_upp'].'#popup');
			}
		}
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=acc&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> approve
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=reject&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> reject
						</a>
					</td>
					";
						if (isset($_SESSION['username'])) {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=sent&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:15px; height:9px; margin: 2px 0px 0px 3px;' src='img/mail.png'> mail
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=batal&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=edit&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
									</a>
								</td>
							";
						}
					echo "
					<td>".substr($c['tgl_kirim'],0,10)."</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
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
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>$c[permohonan_tgl_berlaku]</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td>$c[pic]</td>";
					}
					else
					{
						echo"<td>Tidak ada</td>";
					}
					echo"
					<td>$c[cek_ddd]</td>
					<td>$c[ket_proses]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=acc&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> approve
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=reject&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> reject
						</a>
					</td>
					";
						if (isset($_SESSION['username'])) {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=sent&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:15px; height:9px; margin: 2px 0px 0px 3px;' src='img/mail.png'> mail
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=batal&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approval1&action=edit&id=$c[no_upp]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
									</a>
								</td>
							";
						}
					echo "
					<td>".substr($c['tgl_kirim'],0,10)."</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>Download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
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
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>$c[permohonan_tgl_berlaku]</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td>$c[pic]</td>";
					}
					else
					{
						echo"<td>Tidak ada</td>";
					}
					echo"
					<td>$c[cek_ddd]</td>
					<td>$c[ket_proses]</td>
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