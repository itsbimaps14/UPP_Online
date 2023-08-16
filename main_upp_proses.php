<?php
	$awal=0;
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	else{
		date_default_timezone_set('Asia/Jakarta');
		$hariinijam=date("Y-m-d")." ".date("H:i:s");
		$hariini=date("Y-m-d");
		
	}
	if (isset($_POST['thnpermohonan'])) {
		$thnpermohonan=$_POST['thnpermohonan'];
		if ($thnpermohonan!='') {
			if (isset($_POST['blnpermohonan'])) {
				$blnpermohonan=$_POST['blnpermohonan'];
				if ($blnpermohonan!='') {
					if (isset($_POST['tglpermohonan'])) {
						$tglpermohonan=$_POST['tglpermohonan'];
						if ($tglpermohonan!='') {
							if ($tglpermohonan<10) {
								$tglpermohonan='0'.$tglpermohonan;
							}
							$filter.=" AND DATE_FORMAT(permohonan_tgl_berlaku,'%Y-%m-%d') = '".$thnpermohonan."-".$blnpermohonan."-".$tglpermohonan."'";
						}
						else{
							$filter.=" AND DATE_FORMAT(permohonan_tgl_berlaku,'%Y-%m') = '".$thnpermohonan."-".$blnpermohonan."'";
						}
					}
					else{
						$tglpermohonan = '';
						$filter.=" AND DATE_FORMAT(permohonan_tgl_berlaku,'%Y-%m') = '".$thnpermohonan."-".$blnpermohonan."'";
					}
				}
				else{
					$filter.=" AND DATE_FORMAT(permohonan_tgl_berlaku,'%Y') = ".$thnpermohonan;
				}
			}
			else{
				$blnpermohonan = '';
				$filter.=" AND DATE_FORMAT(permohonan_tgl_berlaku,'%Y') = ".$thnpermohonan;
			}
		}
	}
	else{
		$thnpermohonan = '';
	}
	if (isset($_POST['lokasi'])) {
		$lokasi=$_POST['lokasi'];
		if ($lokasi!='') {
			$filter.=" AND lokasi = '".$lokasi."'";
		}
	}
	else{
		$lokasi = '';
	}
	if (isset($_POST['divisi'])) {
		$divisi=$_POST['divisi'];
		if ($divisi!='') {
			$filter.=" AND upp.no_divisi_prosedur = '".$divisi."'";
		}
	}
	else{
		$divisi = '';
	}
	if (isset($_POST['prosedur'])) {
		$prosedur=$_POST['prosedur'];
		if ($prosedur!='') {
			$filter.=" AND upp.no_master_prosedur = '".$prosedur."'";
		}
	}
	else{
		$prosedur = '';
	}
	if (isset($_POST['jenis'])) {
		$jenis=$_POST['jenis'];
		if ($jenis!='') {
			$filter.=" AND upp.no_jenis_prosedur = '".$jenis."'";
		}
	}
	else{
		$jenis = '';
	}
	if (isset($_POST['detail'])) {
		$detail=$_POST['detail'];
		if ($detail!='') {
			$filter.=" AND upp.detail_prosedur = '".$detail."'";
		}
	}
	else{
		$detail = '';
	}
	if (isset($_POST['folder'])) {
		$folder=$_POST['folder'];
		if ($folder!='') {
			$filter.=" AND upp.nama_folder = '".$folder."'";
		}
	}
	else{
		$folder = '';
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'batal':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_batal=test($_POST['tgl_batal']);
					$alasan=test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_batal = '$tgl_batal',
												alasan_batal = '$alasan',
												status = 'batal'
												WHERE 	no_upp = '$id'
												")){
						$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp = '$id'");
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
						header('location:main?index=upp&step=proses');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=proses&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Pembatalan UPP Proses
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=proses&action=batal&id=$id' method='post'>
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
					$ket_proses=test($_POST['ket_proses']);

					if ($pic == 'Tidak' or $pic == 'tidak') {
						$pic = '484ea5618aaf3e9c851c28c6dbca6a1f';
					}

					$no = substr($no_upp,0,-5);
					$year = $c['tahun'];

					$uploadOk = 1;
					$nama_file = $_FILES['file_user']['name'];
					if ($nama_file!='') {
						if (!file_exists('file_upload/upp_user/'.$year)) {
							mkdir('file_upload/upp_user/'.$year);
						}
						if (!file_exists('file_upload/upp_user/'.$year.'/'.$no)) {
							mkdir('file_upload/upp_user/'.$year.'/'.$no);
						}
						
						$folder1 = 'file_upload/upp_user/'.$year.'/'.$no.'/';
						$file_user1 = $_FILES['file_user']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_user']['tmp_name'];
						$file_user = $folder1.$file_user1;
						$file_user_rename = $folder1.$file_user2;

						unlink($c['file_user']);

						if (move_uploaded_file($tmp_file_user, $file_user)) {
							rename($file_user, $file_user_rename);
							$a=mysqli_query($conn, "UPDATE upp SET file_user = '$file_user_rename'	WHERE 	no_upp = '$no_upp'");
						}
						else {
							$alert='upload file gagal, silahkan kirim lewat email';
							$file_user='';
							$uploadOk = 0;
						}
					}

					if ($a=mysqli_query($conn, "UPDATE upp SET lokasi = '$lokasi',
													pengaju = '$pengaju',
													email_pengaju = '$email_pengaju',
													pic1 = '$pic1',
													no_divisi_prosedur = '$divisi_prosedur',
													no_master_prosedur = '$prosedur',
													no_jenis_prosedur = '$jenis_prosedur',
													detail_prosedur = '$detail_prosedur',
													nama_folder = '$nama_folder',
													sebelumperubahan = '$sebelumperubahan',
													setelahperubahan = '$setelahperubahan',
													alasan = '$alasan',
													permohonan_tgl_berlaku = '$tanggal_berlaku',
													kat_perubahan = '$kat_perubahan',
													kat_mesin = '$kat_mesin',
													pic = '$pic',
													cek_ddd = '$cek_ddd',
													ket_proses ='$ket_proses'
													WHERE 	no_upp = '$no_upp'
													")) {
						header('location:main?index=upp&step=proses');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=proses'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Edit UPP Proses
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=proses&action=edit&id=$id#popup' method='post'  enctype='multipart/form-data'>
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
									<input class='input_main' type='text' name='pic1' value='$c[pic1]' required><br>
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
									</select><br>
									<a class='j_input_main'>Kategori Prosedur *</a><br>
									<select class='input_main' name='jenis' required>
										<option value=''></option>
										";
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
										echo "
									</select><br>
									<a class='j_input_main'>Detail Kategori</a><br>
									<input class='input_main' type='input' name='detail' value='$c[detail_prosedur]'><br>
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
									</select><br>";
									?>

									<a class='j_input_main'>Attachment File User</a><font size="1" color="red"> *) Max File = 1MB, Diisi jika file upload akan diubah</font><br>
									<input class='file_main' type='file' name='file_user' onchange="valid(this)"><br>

									<script>
										window.onload = function(){
											document.getElementById('ugg').style.display = "none";
											document.getElementById('ubr').style.display = "none";
										}
										
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
									</script>

									<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
									<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>

									<?php
									echo "
									<a class='j_input_main'>Kategori Perubahan *</a><br>
									<select class='input_main' name='kat_perubahan' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from kat_perubahan");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['kat_perubahan']==$f['kat_perubahan']) {
													echo "
														<option value='$f[kat_perubahan]' selected>$f[kat_perubahan]</option>
													";
												}
												else{
													echo "
														<option value='$f[kat_perubahan]'>$f[kat_perubahan]</option>
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
									<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>";

									if ($c['pic'] == '484ea5618aaf3e9c851c28c6dbca6a1f') {
										$tmp_pic = 'Tidak ada';
									}
									else{
										$tmp_pic = $c['pic'];
									}

									echo"
									<input class='input_main' type='text' name='pic' value='$c[pic]' required><br>
									<a class='j_input_main'>Perlu Distribusi Hardcopy ? *</a><br>
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
									<a class='j_input_main'>Keterangan Process</a><br>
									<textarea class='input_main' name='ket_proses' >$c[ket_proses]</textarea><br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:304px;' id='submit' class='submit_main' type='submit' value='Update'>
							</form>
						</div>
					</div>
				";
				break;
			case 'process':
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nama_folder=test($_POST['nama_folder']);
					$pic1=test($_POST['pic1']);
					$pic2=test($_POST['pic2']);
					$ket_proses=test($_POST['ket_proses']);

					$divisi=$c['no_divisi_prosedur'];
					$prosedur=$c['no_master_prosedur'];
					$jenis=$c['no_jenis_prosedur'];
					$detail=$c['detail_prosedur'];

					if ($c['nama_folder']!=$nama_folder) {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$nama_folder'");
						$e=mysqli_num_rows($d);
						if ($e==0) {
							$update=mysqli_query($conn, "UPDATE upp SET nama_folder='$nama_folder' WHERE no_upp ='$id'");
							header('location:main?index=upp&step=proses&action=process&id='.$id.'#popup');
							exit();
						}
						else{
							$update=mysqli_query($conn, "UPDATE upp SET nama_folder='$nama_folder' WHERE no_upp ='$id'");
						}
					}

					if ($ket_proses != $c['ket_proses']) {
						mysqli_query($conn, "UPDATE upp SET ket_proses = '$ket_proses' WHERE no_upp ='$id'");
					}

					$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$nama_folder'");
					$e=mysqli_num_rows($d);

					$no_file=$e+1;
					$uploadOk = 1;
					$file_master = $_FILES['file_master']['name'];
					if ($file_master!='') {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$nama_folder'");
						$e=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);

						// File Divisi Prosedur
						$y = mysqli_query($conn, "SELECT * FROM divisi_prosedur WHERE no_divisi_prosedur = '$divisi'");
						$x = mysqli_fetch_array($y);
						$tmp_div_pro = $x['nf_prosedur'];
						if (!file_exists('file_upload/master_prosedur/'.$tmp_div_pro)) {
							mkdir('file_upload/master_prosedur/'.$tmp_div_pro);}

						// File Master Prosedur
						$y = mysqli_query($conn, "SELECT * FROM master_prosedur WHERE no_master_prosedur = '$prosedur'");
						$x = mysqli_fetch_array($y);
						$tmp_mas_pro = $x['nm_prosedur'];
						if (!file_exists('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro)) {
							mkdir('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro);}

						// File Jenis Prosedur
						$y = mysqli_query($conn, "SELECT * FROM jenis_prosedur WHERE no_jenis_prosedur = '$jenis'");
						$x = mysqli_fetch_array($y);
						$tmp_jen_pro = $x['nf_jprosedur'];
						if (!file_exists('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro)) {
							mkdir('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro);}

						// Nama Folder
						if (!file_exists('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder)) {
							mkdir('file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder);}
						
						$folder1 = 'file_upload/master_prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder.'/';
						$file_master1 = $_FILES['file_master']['name'];
						$file_master2 = test($file_master1);
						$tmp_file_master = $_FILES['file_master']['tmp_name'];
						$file_master1 = $no_file.'_'.$file_master1;
						$file_master = $folder1.$file_master1;
						$file_master_rename = $folder1.$file_master1;

						if (move_uploaded_file($tmp_file_master, $file_master)) {
							$a=mysqli_query($conn, "INSERT INTO file_prosedur_master (no_divisi_prosedur,no_master_prosedur,no_jenis_prosedur,detail_prosedur,nama_folder,no_revisi,tgl_revisi,nama_file)
																			VALUES	('$divisi','$prosedur','$jenis','$detail','$nama_folder','$no_file','$hariini','$file_master')");
						}
						else {
							$alert='upload file gagal, silahkan kirim lewat email';
							$file_master='';
							$uploadOk = 0;
						}
					}
					else{
						$file_master_rename='';
					}

					if ($uploadOk==0) {
					}
					elseif ($a=mysqli_query($conn, "UPDATE upp SET pic1 = '$pic1',
												pic2 = '$pic2',
												status = 'approval',
												tgl_kirim = '$hariinijam',
												tgl_kirim1 = '$hariinijam',
												tgl_kirim2 = '$hariinijam',
												file_master = '$file_master_rename',
												tgl_pic1 = '0000-00-00',
												tgl_pic2 = '0000-00-00'
												WHERE 	no_upp = '$id'")){
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
							echo "<p>Message successfully sent!</p>";
						}

						$to 	  =	"$pic2";
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
						$message .= "<br><strong>Untuk melihat UPP diatas silahkan akses <a href='http://prosedur_online/main?index=upp&step=approval2&id=".strip_tags($id)."'>Go To UPP</a><br><br><br>";
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
						header('location:main?index=upp&step=proses');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				$divisi=$c['no_divisi_prosedur'];
				$prosedur=$c['no_master_prosedur'];
				$jenis=$c['no_jenis_prosedur'];
				$file=test($c['nama_folder']);
				$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$file'");
				$e=mysqli_num_rows($d);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=proses'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:80px;width:455px;'>
							Process UPP Online
						</div>
						<div class='form_process' style='overflow:auto;width:445px;height:400px;'>
							<form action='main?index=upp&step=proses&action=process&id=$id#popup' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>
									";
										if (isset($alert)) {
											echo "<div class='alert_adm alert'>$alert</div>";
										}
										if (isset($alert2)) {
											echo "<div class='alert_adm alert2'>$alert2</div>";
										}
									echo "
									<a class='j_input_main'>Email Manager Approver (PIC 1) *</a><br>
									<input class='input_main' type='email' name='pic1' value='$c[pic1]' required><br>
									<a class='j_input_main'>Email Approver 2 *</a><br>
									<input class='input_main' type='email' name='pic2' value='$c[pic2]' required><br>
									";
										if ($e==0) {
											echo "<div class='alert_adm alert'>nama file belum ada, silahkan edit jika bukan prosedur baru, lanjutkan jika prosedur baru</div>";
										}
									echo "
									<a class='j_input_main'>Nama File *</a><br>
									<input class='input_main' type='text' name='nama_folder' value='$c[nama_folder]' required><br>";?>
									
									<a class='j_input_main'>Attachment File Master Revisi</a><font size="1" color="red"> *) Max File = 1MB</font><br>
									<input class='file_main' type='file' name='file_master' onchange="valid(this)"><br>

									<script>
										window.onload = function(){
											document.getElementById('ugg').style.display = "none";
											document.getElementById('ubr').style.display = "none";
										}
										
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
									</script>

									<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
									<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>
									<?php echo "
									<a class='j_input_main'>Keterangan Process</a><br>
									<textarea class='input_main' name='ket_proses'>$c[ket_proses]</textarea><br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:104px;' id='submit' class='submit_main' type='submit' value='Sent Approval Request'>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
?>
<div class='judul_main' style='position: fixed;'>Process Usulan Perubahan Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
		echo "
			<form style='margin-bottom:0px;' action='main?index=upp&step=proses' method='post' enctype='multipart/form-data'>
				<select class='input_main' name='thnpermohonan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
					<option value=''>Tahun Permohonan</option>
					";
					$year=date('Y')+1;
					for ($i=$year; $i > 1997; $i--) {
						if ($thnpermohonan==$i) {
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
				<select class='input_main' name='blnpermohonan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
					<option value=''>Bulan Permohonan</option>
					";
					$month=array('01','02','03','04','05','06','07','08','09','10','11','12');
					$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					$monthlength=count($month);
					for ($x=0; $x < $monthlength; $x++) {
						if ($month[$x]==$blnpermohonan) {
							$bulantampil=$month2[$x];
							echo "
							<option value='$month[$x]' selected>$month2[$x]</option>
							";
						}
						else{
							echo "
							<option value='$month[$x]'>$month2[$x]</option>
							";
						}
					}
					echo "
				</select>
				<select class='input_main' name='tglpermohonan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
					<option value=''>Tanggal Permohonan</option>
					";
					for ($i=1; $i < 31; $i++) {
						if ($tglpermohonan==$i) {
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
				<select class='input_main' name='lokasi' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
					<option value=''>Pilih Lokasi</option>
					";
						$d=mysqli_query($conn, "SELECT * from plant order by plant");
							while ($f=mysqli_fetch_array($d)) {
								if ($lokasi == $f['plant']) {
									echo "
										<option value='$f[plant]' selected>$f[plant]</option>
									";
								}
								else {
									echo "
										<option value='$f[plant]'>$f[plant]</option>
									";
								}
						}
					echo "
				</select>
				<select class='input_main' name='divisi' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Divisi Prosedur</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp 
							inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
							group by divisi_prosedur.divisi_prosedur 
							order by divisi_prosedur.divisi_prosedur");

						while ($c=mysqli_fetch_array($a)) {
							if ($divisi==$c['no_divisi_prosedur']) {
								echo "
									<option value='$c[no_divisi_prosedur]' selected>$c[divisi_prosedur]</option>
								";
							}
							else{
								echo "
									<option value='$c[no_divisi_prosedur]'>$c[divisi_prosedur]</option>
								";
							}
						}
					echo "
				</select>
				<select class='input_main' name='prosedur' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Master Prosedur</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp 
							inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
							where upp.no_divisi_prosedur='$divisi' 
							group by master_prosedur.master_prosedur 
							order by master_prosedur.master_prosedur");

						while ($c=mysqli_fetch_array($a)) {
							if ($prosedur==$c['no_master_prosedur']) {
								echo "
									<option value='$c[no_master_prosedur]' selected>$c[master_prosedur]</option>
								";
							}
							else{
								echo "
									<option value='$c[no_master_prosedur]'>$c[master_prosedur]</option>
								";
							}
						}
					echo "
				</select>
				<select class='input_main' name='jenis' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Kategori Prosedur</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp 
							inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
							where upp.no_divisi_prosedur='$divisi' AND upp.no_master_prosedur='$prosedur' 
							group by jenis_prosedur.jenis_prosedur 
							order by jenis_prosedur.jenis_prosedur");

						while ($c=mysqli_fetch_array($a)) {
							if ($jenis==$c['no_jenis_prosedur']) {
								echo "
									<option value='$c[no_jenis_prosedur]' selected>$c[jenis_prosedur]</option>
								";
							}
							else{
								echo "
									<option value='$c[no_jenis_prosedur]'>$c[jenis_prosedur]</option>
								";
							}
						}
					echo "
				</select>
				<select class='input_main' name='detail' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Detail Kategori</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp 
							where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' 
							group by detail_prosedur 
							order by detail_prosedur");

						while ($c=mysqli_fetch_array($a)) {
							if ($detail==$c['detail_prosedur']) {
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
					echo "
				</select>
				<select class='input_main' name='folder' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Nama File</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp 
							where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' 
							and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' 
							group by nama_folder order by nama_folder");

						while ($c=mysqli_fetch_array($a)) {
							if ($folder==$c['nama_folder']) {
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
					echo "
				</select>
			</form>
			<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=proses' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
			if(isset($_POST['kw'])){
			}
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE no_upp='$id' AND status='progress' OR status='not approved'");

			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=proses' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else{
			$sort="tgl_upp DESC, no DESC";
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
			$awal=($hal-1)*30;
			$akhir=30;
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE status = 'progress' ".$filter." OR status = 'not approved' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			
			$page1=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'progress' ".$filter." OR status = 'not approved' ".$filter);
			if(isset($_POST['kw']))
			{
				$kw = $_POST['kw'];
				$a=mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
					WHERE (status = 'progress' OR status = 'not approved')
					and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%')");
				$page1 = $a;
			}
			$page2=mysqli_num_rows($page1);
			$page3=$page2/30;
			$page=floor($page3)+1;
			
			$alert2='Jumlah : '.$page2;
			if(!isset($_POST['kw']))
			{
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
						echo "<td><a href='main?index=upp&step=proses&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=proses&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=proses&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=proses&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=proses&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=proses&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=proses&hal=$page$sorturl'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					echo "
					</tr>
				</table>
			";
			}
			else
			{
			}
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
			<td colspan='3'>Action</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='status') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=status&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=status&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=status&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Status
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=no&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=no&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=no&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. UPP
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_upp') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=tgl_upp&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal UPP
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='lokasi') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=lokasi&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Lokasi
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='pengaju') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=pengaju&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Pengaju
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='email_pengaju') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=email_pengaju&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Email Pengaju
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='pic1') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=pic1&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Manager Approver (PIC 1)
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='divisi_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=divisi_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=divisi_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=divisi_prosedur&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Divisi Prosedur
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='master_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=master_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=master_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=master_prosedur&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Prosedur
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='jenis_ik.jenis_ik') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=jenis_ik.jenis_ik&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=jenis_ik.jenis_ik&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=jenis_ik.jenis_ik&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Jenis IK
					</a>
					";
				?>
			</td>
			<td>
				File FMEA
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='jenis_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=jenis_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=jenis_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=jenis_prosedur&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Kategori Prosedur
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='detail_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=detail_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=detail_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=detail_prosedur&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Detail Kategori
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='nama_folder') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=nama_folder&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Nama File
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='sebelumperubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=sebelumperubahan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Sebelum Perubahan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='setelahperubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=setelahperubahan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Setelah Perubahan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='alasan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=alasan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Alasan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='permohonan_tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Permohonan Tanggal Berlaku
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='upp.permohonan_tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=upp.permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=upp.permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=upp.permohonan_tgl_berlaku&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Harus Proses
					</a>
					";
				?>
			</td>
			<td>Attachment File User</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='kat_perubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=kat_perubahan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Kategori Perubahan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='kat_mesin') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=kat_mesin&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Kategori Mesin
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='pic') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=pic&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						PIC Sosialisasi Lapangan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='cek_ddd') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=cek_ddd&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Cek DDD
					</a>
					";
				?>
			</td>
			
			<td>
				<?php 
					if (isset($sort)) {
						if ($sortby=='tgl_reject') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=tgl_reject&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=tgl_reject&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=tgl_reject&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Reject
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='alasan_reject') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=proses&sort=alasan_reject&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=proses&sort=alasan_reject&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=proses&sort=alasan_reject&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Alasan Reject
					</a>
					";
				?>
			</td>
			<td> Keterangan Proses </td>
		</tr>
		
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		$tmp_tgl = $c['permohonan_tgl_berlaku'];
		$tmp_tgl = date('Y-m-d', strtotime('-3 days', strtotime($tmp_tgl)));
		$tgl_now = date('Y-m-d');
		if ($tgl_now > $tmp_tgl) {
			$warna = 'red';}
		else{
			$warna = 'black';}
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		$alasan_reject=nl2br($c['alasan_reject']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					
					<td>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=process&id=$c[no_upp]#popup'>
							<img style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reply.png'> process
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=batal&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					";
						if ($c['status']=='not approved') {
							echo "<td style='background-color:#c00000;color:white;'><font color='$warna'>$c[status]</td>";
						}
						else{
							echo "<td><font color='$warna'>$c[status]</td>";
						}
					echo "
					<td><font color='$warna'>$c[no_upp]</td>
					<td><font color='$warna'>$c[tgl_upp]</td>
					<td><font color='$warna'>$c[lokasi]</td>
					<td><font color='$warna'>$c[pengaju]</td>
					<td><font color='$warna'>$c[email_pengaju]</td>
					<td><font color='$warna'>$c[pic1]</td>
					<td><font color='$warna'>$c[divisi_prosedur]</td>
					<td><font color='$warna'>$c[master_prosedur]</td>

					<td><font color='$warna'>$c[jenis_ik]</td>
					<td>
					";

					//Bima

					if ($c['file_fmea']!='') {
							echo "<font color='$warna'><a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "

					</td>

					<td><font color='$warna'>$c[jenis_prosedur]</td>
					<td><font color='$warna'>$c[detail_prosedur]</td>
					<td><font color='$warna'>$c[nama_folder]</td>
					<td><font color='$warna'>$sebelumperubahan</td>
					<td><font color='$warna'>$setelahperubahan</td>
					<td><font color='$warna'>$alasan</td>
					<td><font color='$warna'>$c[permohonan_tgl_berlaku]</td>
					<td><font color='$warna'>$tmp_tgl</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[kat_perubahan]</td>
					<td><font color='$warna'>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td><font color='$warna'>$c[pic]</td>";
					}
					else
					{
						echo"<td><font color='$warna'>Tidak ada</td>";
					}
					echo"
					<td><font color='$warna'>$c[cek_ddd]</td>
					<td><font color='$warna'>$c[tgl_batal]</td>
					<td><font color='$warna'>$c[alasan_batal]</td>
					<td><font color='$warna'>$c[ket_proses]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=process&id=$c[no_upp]#popup'>
							<img style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reply.png'> process
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=batal&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=proses&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					";
						if ($c['status']=='not approved') {
							echo "<td style='background-color:#c00000;color:white;'><font color='$warna'>$c[status]</td>";
						}
						else{
							echo "<td><font color='$warna'>$c[status]</td>";
						}
					echo "
					<td><font color='$warna'>$c[no_upp]</td>
					<td><font color='$warna'>$c[tgl_upp]</td>
					<td><font color='$warna'>$c[lokasi]</td>
					<td><font color='$warna'>$c[pengaju]</td>
					<td><font color='$warna'>$c[email_pengaju]</td>
					<td><font color='$warna'>$c[pic1]</td>
					<td><font color='$warna'>$c[divisi_prosedur]</td>
					<td><font color='$warna'>$c[master_prosedur]</td>

					<td><font color='$warna'>$c[jenis_ik]</td>
					<td>
					";

					//Bima

					if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "

					</td>

					<td><font color='$warna'>$c[jenis_prosedur]</td>
					<td><font color='$warna'>$c[detail_prosedur]</td>
					<td><font color='$warna'>$c[nama_folder]</td>
					<td><font color='$warna'>$sebelumperubahan</td>
					<td><font color='$warna'>$setelahperubahan</td>
					<td><font color='$warna'>$alasan</td>
					<td><font color='$warna'>$c[permohonan_tgl_berlaku]</td>
					<td><font color='$warna'>$tmp_tgl</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[kat_perubahan]</td>
					<td><font color='$warna'>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td><font color='$warna'>$c[pic]</td>";
					}
					else
					{
						echo"<td><font color='$warna'>Tidak ada</td>";
					}
					echo"<td><font color='$warna'>$c[cek_ddd]</td>
					<td><font color='$warna'>$c[tgl_batal]</td>
					<td><font color='$warna'>$c[alasan_batal]</td>
					<td><font color='$warna'>$c[ket_proses]</td>
					</font>
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