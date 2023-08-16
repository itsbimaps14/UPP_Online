<?php
	$awal=0;
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	else{
		$hariini=date("Y-m-d");
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];

		switch ($action) {
			case 'done':
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				$g_rev=mysqli_query($conn, "SELECT * FROM prosedur 
					WHERE no_divisi_prosedur = '$c[no_divisi_prosedur]' 
					AND no_master_prosedur = '$c[no_master_prosedur]' 
					AND no_jenis_prosedur = '$c[no_jenis_prosedur]' 
					AND nama_folder = '$c[nama_folder]'");
				$h_rev=mysqli_fetch_array($g_rev);
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_revisi=$_POST['no_revisi'];
					$no_revisi_cover=$_POST['no_revisi_cover'];
					$divisi=$c['no_divisi_prosedur'];
					$prosedur=$c['no_master_prosedur'];
					$jenis=$c['no_jenis_prosedur'];
					$detail=$c['detail_prosedur'];
					$folder=$c['nama_folder'];
					$tgl=date('Y-m-d');

					$uploadOk = 1;
					$file_prosedur = $_FILES['file_prosedur']['name'];
					if ($file_prosedur!='') {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
						$e=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);

						// File Divisi Prosedur
						$y = mysqli_query($conn, "SELECT * FROM divisi_prosedur WHERE no_divisi_prosedur = '$divisi'");
						$x = mysqli_fetch_array($y);
						$tmp_div_pro = $x['nf_prosedur'];
						if (!file_exists('file_upload/prosedur/'.$tmp_div_pro)) {
							mkdir('file_upload/prosedur/'.$tmp_div_pro);}

						// File Master Prosedur
						$y = mysqli_query($conn, "SELECT * FROM master_prosedur WHERE no_master_prosedur = '$prosedur'");
						$x = mysqli_fetch_array($y);
						$tmp_mas_pro = $x['nm_prosedur'];
						if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro)) {
							mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro);}

						// File Jenis Prosedur
						$y = mysqli_query($conn, "SELECT * FROM jenis_prosedur WHERE no_jenis_prosedur = '$jenis'");
						$x = mysqli_fetch_array($y);
						$tmp_jen_pro = $x['nf_jprosedur'];
						if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro)) {
							mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro);}

						// Nama Folder
						if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder)) {
							mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder);}

						// Nama Revisi Folder
						if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/revisi')) {
							mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/revisi');}

						if ($f>0 AND $c['jenis_ik'] != '2') {
							// File Divisi Prosedur
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro);}

							// File Master Prosedur
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro);}

							// File Jenis Prosedur
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro)) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro);}

							// Nama Folder
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder);}

							// Nama Revisi Folder
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/revisi')) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/revisi');}

							$folder2 = 'file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/revisi/';

							mysqli_query($conn, "INSERT INTO un_prosedur
								SELECT * FROM prosedur 
								WHERE
								no_divisi_prosedur = '$divisi' AND
								no_master_prosedur = '$prosedur' AND
								no_jenis_prosedur = '$jenis' AND
								nama_folder = '$folder'
								");

							$query=mysqli_query($conn, "SELECT * FROM prosedur WHERE
								no_divisi_prosedur = '$divisi' AND
								no_master_prosedur = '$prosedur' AND
								no_jenis_prosedur = '$jenis' AND
								nama_folder = '$folder'
								");

							$tmp_c=mysqli_fetch_array($query);
							$nm_file_tmp = $tmp_c['no_revisi'].'_'.$tmp_c['judul_file'];
							$nm1_file_tmp = $tmp_c['nama_file'];

							$nm_bksfile = $folder2.$nm_file_tmp;

							$a=mysqli_query($conn, "UPDATE un_prosedur SET
								nama_file = '$nm_bksfile',
								judul_file = '$nm_file_tmp'
								WHERE
								no_revisi = $no_revisi - 1 AND
								no_divisi_prosedur = '$divisi' AND
								no_master_prosedur = '$prosedur' AND
								no_jenis_prosedur = '$jenis' AND
								nama_folder = '$folder'
								");

							mysqli_query($conn, "UPDATE upp SET
								file_prosedur = '$nm_bksfile'
								WHERE
								no_revisi = $no_revisi - 1 AND
								no_divisi_prosedur = '$divisi' AND
								no_master_prosedur = '$prosedur' AND
								no_jenis_prosedur = '$jenis' AND
								nama_folder = '$folder'
								");

							rename($nm1_file_tmp, $nm_bksfile);
						}

						$folder1 = 'file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$folder.'/';
						$file_prosedur1 = $_FILES['file_prosedur']['name'];
						$file_prosedur2 = test($file_prosedur1);
						$tmp_file_prosedur = $_FILES['file_prosedur']['tmp_name'];
						$file_prosedur = $folder1.$file_prosedur1;
						$file_prosedur_rename = $folder1.$file_prosedur2;

						move_uploaded_file($tmp_file_prosedur, $file_prosedur);
						
						rename($file_prosedur, $file_prosedur_rename);

						if ($c['jenis_ik'] != '2') {
							if ($f>0) {
								//$no_revisi=$e['no_revisi']+1;
								$a=mysqli_query($conn, "UPDATE prosedur SET no_revisi = '$no_revisi',
																				tgl_revisi = '$tgl',
																				judul_file = '$file_prosedur1',
																				nama_file = '$file_prosedur_rename',
																				file_fmea = '$c[file_fmea]'
																				WHERE
																				no_divisi_prosedur = '$divisi' AND
																				no_master_prosedur = '$prosedur' AND
																				no_jenis_prosedur = '$jenis' AND
																				nama_folder = '$folder'
																				");
							}
							else{
								//$no_revisi=1;
								$a=mysqli_query($conn, "INSERT INTO prosedur (no_divisi_prosedur,no_master_prosedur,no_jenis_prosedur,detail_prosedur,nama_folder,no_revisi,tgl_revisi,judul_file,nama_file,file_fmea)
																	VALUES	('$divisi','$prosedur','$jenis','$detail','$folder','$no_revisi','$hariini','$file_prosedur1','$file_prosedur_rename','$c[file_fmea]')");
							}
							$g=mysqli_query($conn, "SELECT * FROM upp WHERE no_master_prosedur = '$prosedur' AND status = 'need to check'");
							$h=mysqli_num_rows($g);
							$i=mysqli_query($conn, "SELECT * FROM upp WHERE no_master_prosedur = '$prosedur' AND status = 'closed'");
							$j=mysqli_num_rows($i);
							//$no_revisi_cover = $h+$j+1;
						}
						$link_prosedur='';
						if ($f>0) {
							//$no_revisi=$e['no_revisi']+1;
						}
						else{
							//$no_revisi=1;
						}
						$g=mysqli_query($conn, "SELECT * FROM upp WHERE no_master_prosedur = '$prosedur' AND status = 'need to check'");
						$h=mysqli_num_rows($g);
						$i=mysqli_query($conn, "SELECT * FROM upp WHERE no_master_prosedur = '$prosedur' AND status = 'closed'");
						$j=mysqli_num_rows($i);
						//$no_revisi_cover = $h+$j+1;
					}
					else{
						$file_prosedur_rename='';
						if ($_POST['link_prosedur']!='') {
							$link_prosedur=$_POST['link_prosedur'];
						}
						else{
							$link_prosedur='';
						}
						if ($_POST['no_revisi']!='') {
							//$no_revisi=$_POST['no_revisi'];
						}
						else{
							//$no_revisi='';
						}
						if ($_POST['no_revisi_cover']!='') {
							//$no_revisi_cover=$_POST['no_revisi_cover'];
						}
						else{
							//$no_revisi_cover='';
						}
					}

					$tgl_sosialisasi=test($_POST['tgl_sosialisasi']);
					$email_sosialisasi=test($_POST['email_sosialisasi']);

					if ($uploadOk==0) {
					}
					elseif ($c['status'] == 'approved' AND $c['jenis_ik'] == '2') {
						mysqli_query($conn, "UPDATE upp SET status = 'validasi ik',
												file_prosedur = '$file_prosedur_rename',
												link_prosedur = '$link_prosedur',
												tgl_berlaku = '$hariini',
												no_revisi = '$no_revisi',
												no_revisi_cover = '$no_revisi_cover',
												tgl_sosialisasi = '$tgl_sosialisasi',
												email_sosialisasi = '$email_sosialisasi',
												kesesuaian_dokumen = ''
												WHERE no_upp = '$id'");

						mysqli_query($conn, "INSERT INTO validasi_ik
												SELECT * FROM upp
												WHERE no_upp = '$id'");

						mysqli_query($conn, "INSERT INTO validasi_ik_tmp (no_upp) VALUES ('$id')");

						$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp = '$id'");
						$c=mysqli_fetch_array($a);
						$email=$c['email_sosialisasi'];

							$to 	  =	"$email";
							$subject  =	"Sosialisasi UPP No. " . strip_tags($c['no_upp']);
							$headers  = array ('From' => $from,
							'To' => $to,
							'subject' => $subject,
							"MIME-Version"=>"1.0",
							"Content-type"=>"text/html"
							);
							$message  =	"<html><body>";
							$message .=	"<strong>Dear All,</strong><br><br><br>";
							$message .=	"<strong>Berikut kami menginformasikan per hari ini sudah terbit UPP sebagai berikut :</strong><br><br>";
							$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
							$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
							$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
							$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
							$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama Bahan Baku:</strong> </td><td>" . strip_tags($c['nama_bb']) . "</td></tr>";
							$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
							$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
							$message .=	"<tr><td><strong>Status:</strong> </td><td> OK dan Validasi IK</td></tr>";
							$message .= "</table>";
							if ($link_prosedur=='') {
								$message .= "<br><strong>Silahkan akses <a href='http://prosedur_online/main?index=upp&step=create&id=".strip_tags($id)."'>Go To UPP</a><br><br>";
							}
							else{
								$message .= "<br><strong>Silahkan akses <a href='".strip_tags($link_prosedur)."'>Go To Link</a><br><br>";
							}
							if ( strip_tags($c['pic'])!= '484ea5618aaf3e9c851c28c6dbca6a1f') {
								$message .= "<br><strong>UPP ini memerlukan Sosialisasi Lapangan dengan PIC Sosialisasi Lapangan : ".strip_tags($c['pic'])." dan silahkan download daftar hadir pada link diatas<br><br>";
							}
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

							header('location:main?index=upp&step=approved');
							
					}
					elseif ($c['jenis_ik'] != '2'){
						mysqli_query($conn, "UPDATE upp SET status = 'need to check',
												file_prosedur = '$file_prosedur_rename',
												link_prosedur = '$link_prosedur',
												tgl_berlaku = '$hariini',
												no_revisi = '$no_revisi',
												no_revisi_cover = '$no_revisi_cover',
												kesesuaian_dokumen = ''
												WHERE no_upp = '$id'");

						if ($a=mysqli_query($conn, "UPDATE upp SET tgl_sosialisasi = '$tgl_sosialisasi',
													email_sosialisasi = '$email_sosialisasi'
													WHERE no_upp = '$id'
													")){
							$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp = '$id'");
							$c=mysqli_fetch_array($a);
							$email=$c['email_sosialisasi'];

							$to 	  =	"$email";
							$subject  =	"Sosialisasi UPP No. " . strip_tags($c['no_upp']);
							$headers  = array ('From' => $from,
							'To' => $to,
							'subject' => $subject,
							"MIME-Version"=>"1.0",
							"Content-type"=>"text/html"
							);
							$message  =	"<html><body>";
							$message .=	"<strong>Dear All,</strong><br><br><br>";
							$message .=	"<strong>Berikut kami menginformasikan per hari ini sudah terbit UPP sebagai berikut :</strong><br><br>";
							$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
							$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no_upp']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($c['tgl_upp']) . "</td></tr>";
							$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($c['lokasi']) . "</td></tr>";
							$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($c['pengaju']) . "</td></tr>";
							$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama Bahan Baku:</strong> </td><td>" . strip_tags($c['nama_bb']) . "</td></tr>";
							$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
							$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
							$message .= "</table>";
							if ($link_prosedur=='') {
								$message .= "<br><strong>Silahkan akses <a href='http://prosedur_online/main?index=upp&step=create&id=".strip_tags($id)."'>Go To UPP</a><br><br>";
							}
							else{
								$message .= "<br><strong>Silahkan akses <a href='".strip_tags($link_prosedur)."'>Go To Link</a><br><br>";
							}
							if ( strip_tags($c['pic'])!= '484ea5618aaf3e9c851c28c6dbca6a1f') {
								$message .= "<br><strong>UPP ini memerlukan Sosialisasi Lapangan dengan PIC Sosialisasi Lapangan : ".strip_tags($c['pic'])." dan silahkan download daftar hadir pada link diatas<br><br>";
							}
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
							header('location:main?index=upp&step=approved');
						}
						else{
							$alert='update gagal '.$id;
						}
					}
					else{
						$alert='update gagal 1 '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				$jumlah=$h_rev['no_revisi']+1;
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approved&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:455px;'>
							Form Done UPP Online
						</div>
						<div class='form_process' style='overflow:auto;width:445px;height:450px;'>
							<form action='main?index=upp&step=approved&action=done&id=$id#popup' method='post' enctype='multipart/form-data'>
								<div class='form_main'>
									";
										if (isset($alert)) {
											echo "<div class='alert_adm alert'>$alert</div>";
										}
										if (isset($alert2)) {
											echo "<div class='alert_adm alert2'>$alert2</div>";
										}
									echo "
									<a class='j_input_main'>Tanggal Berlaku *</a><br>
									<input class='input_main readonly' type='date' name='tgl_berlaku' value='$hariini' required readonly><br>";?>
									
									<a class='j_input_main'>Attachment File Prosedur Revisi</a><font size='1' color='red'> *) Max File = 2MB</font><br>
									<input class='file_main' type='file' name='file_prosedur' onchange="valid(this)"><br>
									
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

								<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 2MB / 2048B !</div>
								<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>

									<?php echo "
									<a class='j_input_main'>Link Prosedur Di Click Data</a><br>
									<input class='input_main' type='text' name='link_prosedur' value='' placeholder='http://clickdata/'><br>
									<a class='j_input_main'>No. Revisi</a><br>
									<input class='input_main' type='text' name='no_revisi' value='$jumlah'>
									<!-- <a class='j_input_main'>No. Revisi Cover</a><br> -->
									<input class='input_main' type='hidden' name='no_revisi_cover' value='-'><br>
									<a class='j_input_main'>Tanggal Sosialisasi</a><br>
									<input class='input_main' type='date' name='tgl_sosialisasi' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
									<a class='j_input_main'>Email *</a><br>
									<textarea class='input_main' type='text' name='email_sosialisasi' value='' required style='width:100%;max-width:100%;'>$c[email_sosialisasi]</textarea><br>
									<a style='font-size:12px;'>Pisahkan email dengan koma<br>(example@nutrifood.co.id, example2@nutrifood.co.id)</a><br><br>
									<a style='font-size:12px;'>Jika UPP memerlukan Sosialisasi Lapangan, maka daftar hadir sosialisasi terkirim secara otomatis di email sosialisasi</a><br><br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:170px;' id='submit' class='submit_main' type='submit' value='Done'>
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
					$pic2=test($_POST['pic2']);
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

					if ($a=mysqli_query($conn, "UPDATE upp SET lokasi = '$lokasi',
													pengaju = '$pengaju',
													email_pengaju = '$email_pengaju',
													pic1 = '$pic1',
													pic2 = '$pic2',
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
													cek_ddd = '$cek_ddd'
													WHERE 	no_upp = '$no_upp'
													")) {
						header('location:main?index=upp&step=approved');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approved&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form Edit Approved
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=approved&action=edit&id=$id#popup' method='post'  enctype='multipart/form-data'>
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
									<a class='j_input_main'>Approver PIC 1 *</a><br>
									<input class='input_main' type='email' name='pic1' value='$c[pic1]' required><br>
									<a class='j_input_main'>Approver PIC 2 *</a><br>
									<input class='input_main' type='email' name='pic2' value='$c[pic2]' required><br>
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
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:304px;' class='submit_main' type='submit' value='Update'>
							</form>
						</div>
					</div>
				";
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
						header('location:main?index=upp&step=approved');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=approved&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Batal
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=approved&action=batal&id=$id' method='post'>
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
		}
	}
?>
<div class='judul_main' style='position: fixed;'>List Usulan Perubahan Prosedur Approved</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
	echo"<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=approved' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE no_upp='$id' AND status='approved'");
			
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=approved' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else{
			$filter="";
			$sort="tgl_approved DESC";
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
				WHERE status = 'approved' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE status = 'approved' ".$filter);
			if(isset($_POST['kw']))
			{
				$kw = $_POST['kw'];
			$a=mysqli_query($conn, "SELECT * FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
				WHERE status = 'approved' 				and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%') ORDER BY tgl_kirim desc
				");
				$page1 = $a;
				
			}
			$page2=mysqli_num_rows($page1);
			$page3=$page2/30;
			$page=floor($page3)+1;
			$alert2='Jumlah : '.$page2;
			if(!isset($_POST['kw'])){
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
						echo "<td><a href='main?index=upp&step=approved&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=approved&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=approved&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=approved&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=approved&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=approved&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=approved&hal=$page$sorturl'>Last</a></td>";
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
			<td>Attachment File Master</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=no&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=no&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=no&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=tgl_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=lokasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=email_pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=pic1&order=ASC$halurl'>";
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
						if ($sortby=='pic2') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=pic2&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Approver 2
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='divisi_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=divisi_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=divisi_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=divisi_prosedur&order=ASC$halurl'>";
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
						if ($sortby=='prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=prosedur&order=ASC$halurl'>";
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
						if ($sortby=='jenis_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=jenis_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=jenis_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=jenis_prosedur&order=ASC$halurl'>";
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
				Jenis IK
			</td>
			<td>
				File FMEA
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='detail_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=detail_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=detail_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=detail_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=nama_folder&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=sebelumperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=setelahperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=alasan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
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
						if ($sortby=='kat_perubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=kat_perubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=kat_mesin&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=pic&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=approved&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=cek_ddd&order=ASC$halurl'>";
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
						if ($sortby=='tgl_kirim') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=tgl_kirim&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=tgl_kirim&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=tgl_kirim&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Kirim
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_pic1') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=tgl_pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=tgl_pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=tgl_pic1&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Approval (PIC 1)
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_pic2') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=approved&sort=tgl_pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=approved&sort=tgl_pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=approved&sort=tgl_pic2&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Approval (PIC 2)
					</a>
					";
				?>
			</td>
			<td>Keterangan Proses</td>
		</tr>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=done&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> done
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=batal&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
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
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>

					<td>$c[jenis_ik]</td>
					<td>
					";

					//Bima

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
					<td>".substr($c['tgl_kirim'],0,10)."</td>
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
					<td>$c[ket_proses]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=done&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> done
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=batal&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> batal
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=approved&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
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
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[jenis_prosedur]</td>

					<td>$c[jenis_ik]</td>
					<td>
					";

					//Bima

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
					<td>$c[tgl_kirim]</td>
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
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