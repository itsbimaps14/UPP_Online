<?php
	$awal=0;
	$year = date('Y');
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	else{
		$hariini=date("Y-m-d");
		$year = date('Y');
		$month = date('m');
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {

			// _bimaps

			case 'mail':

				$que = mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no_upp = '$id'");
				$far = mysqli_fetch_array($que);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$tmp_mail = test($_POST['email_sosialisasi']);
					mysqli_query($conn, "UPDATE upp SET email_sosialisasi = '$tmp_mail' WHERE no_upp = '$id'");
					$tmp_thn = test($_POST['tahun']);
					$tmp_bln = test($_POST['bulan']);
					$tmp_tgl = test($_POST['tanggal']);
					$tmp_tdy = $tmp_thn.'-'.$tmp_bln.'-'.$tmp_tgl;
					
					$to 	  =	"$tmp_mail";
					$subject  =	"Sosialisasi UPP No. " . strip_tags($far['no_upp']);
					$headers  = array ('From' => $from,
					'To' => $to,
					'subject' => $subject,
					"MIME-Version"=>"1.0",
					"Content-type"=>"text/html"
					);
					$message  =	"<html><body>";
					$message .=	"<strong>Dear All,</strong><br><br><br>";
					$message .=	"<strong>Berikut kami menginformasikan per tanggal " . strip_tags($tmp_tdy) . " sudah terbit UPP sebagai berikut :</strong><br><br>";
					$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
					$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($far['no_upp']) . "</td></tr>";
					$message .=	"<tr><td><strong>Tanggal UPP:</strong> </td><td>" . strip_tags($far['tgl_upp']) . "</td></tr>";
					$message .=	"<tr><td><strong>Lokasi:</strong> </td><td>" . strip_tags($far['lokasi']) . "</td></tr>";
					$message .=	"<tr><td><strong>Pengaju:</strong> </td><td>" . strip_tags($far['pengaju']) . "</td></tr>";
					$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($far['divisi_prosedur']) . "</td></tr>";
					$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($far['master_prosedur']) . "</td></tr>";
					$message .=	"<tr><td><strong>Nama Bahan Baku:</strong> </td><td>" . strip_tags($far['nama_bb']) . "</td></tr>";
					$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($far['jenis_prosedur']) . "</td></tr>";
					$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($far['detail_prosedur']) . "</td></tr>";
					$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($far['nama_folder']) . "</td></tr>";
					$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($far['sebelumperubahan']) . "</td></tr>";
					$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($far['setelahperubahan']) . "</td></tr>";
					$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($far['alasan']) . "</td></tr>";
					$message .=	"<tr><td><strong>Tanggal Berlaku:</strong> </td><td>" . strip_tags($far['tgl_berlaku']) . "</td></tr>";
					$message .= "</table>";
					
					if ($far['link_prosedur']=='') {
						$message .= "<br><strong>Silahkan akses <a href='http://prosedur_online/main?index=upp&step=create&id=".strip_tags($id)."'>Go To UPP</a><br><br>";}
					else{
						$message .= "<br><strong>Silahkan akses <a href='".strip_tags($far['link_prosedur'])."'>Go To Link</a><br><br>";}
					
					if ( strip_tags($far['pic'])!= '484ea5618aaf3e9c851c28c6dbca6a1f') {
						$message .= "<br><strong>UPP ini memerlukan Sosialisasi Lapangan dengan PIC Sosialisasi Lapangan : ".strip_tags($far['pic'])." dan silahkan download daftar hadir pada link diatas<br><br>";}
						
					$message .=	"<strong>Demikian kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.</strong><br><br>";
					$message .= "<strong>Salam,</strong><br>";
					$message .= "<strong>UPP Online</strong>";
					$message .= "</body></html>";
					$mail = $smtp->send($to, $headers, $message);
					
					if (Pear::isError($mail)) {
						echo "<p>" . $mail->getMessage() . "</p>";
						echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";}
					else{
						echo "<p>Message successfully sent!</p>";}
				}

				echo "
						<div id='popup' class='popup'>
							<a href='main?index=upp&step=done&id=$id'>
								<div class='popup_exit'></div>
							</a>
							<div class='process_top' style='margin-top:50px;width:480px;'>
								Manual Mail Sosialisasi Lapangan
							</div>
							<div class='form_process' style='overflow:auto;width:470px;height:330px;'>
								<form action='main?index=upp&step=done&action=mail&id=$id' method='post'  enctype='multipart/form-data'>
									<div class='form_main'>";
										?>
											<select id='thnmdone' class='input_main' style='width:100px;' onchange="ubahtglan()" name='tahun' required>
												<option value=''>Tahun</option>
												<?php
													$tahunnow = date('Y')+1;
													for ($i=$tahunnow; $i >= 1980 ; $i--) {
														echo " <option value='$i'>$i</option> ";
													}

													echo "</select>";
												?>

											<select id='blnmdone' class='input_main' style='width:190px;' onchange="ubahtglan()" name='bulan' required>
												<option value=''>Bulan</option>
													<?php
														$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
														$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
														$monthlength=count($month2);
														
														for ($x=0; $x < 12; $x++) {
															echo "<option value='$monthvalue[$x]'>$month2[$x]</option>";}
													?>
											</select>

											<select id='tglmdone' class='input_main' style='width:100px;' name='tanggal' required>
												<option value=''>Tanggal</option>";
											</select><br>

											<script type='text/javascript'>
												function ubahtglan(){

													// Remove and Clear select Option
													selectbox = document.getElementById('tglmdone');
													var i;
													for (var i = selectbox.options.length - 1; i >= 0; i--) {
														selectbox.remove(i);
													}

													// Set default option
													var opt = document.createElement('option');
													opt.value = '';
													opt.text = 'Tanggal';
													selectbox.appendChild(opt);

													// Declare and initiate variable
													var js_tmp_tahun = document.getElementById('thnmdone').value;
													var js_tmp_bulan = document.getElementById('blnmdone').value;

													if (js_tmp_tahun % 4 == 0) {
														var daymonth = ['31','29','31','30','31','30','31','31','30','31','30','31'];}
													else{
														var daymonth = ['31','28','31','30','31','30','31','31','30','31','30','31'];}

													if (js_tmp_tahun != '' && js_tmp_bulan != '') {
														var tmp_daylength = daymonth[js_tmp_bulan-1];

														// Adding option in select using for
														for (var i = 0; i < tmp_daylength; i++) {

															select = document.getElementById('tglmdone');
															var opt = document.createElement('option');

															var tmp_i = i + 1;
															if (i < 9) {
																tmp_i = "0" + tmp_i;}
															opt.value = tmp_i;
															opt.text = tmp_i;
															select.appendChild(opt);

														}
													}

												}
											</script>
										<?php
										echo "
										<textarea class='input_main' type='text' name='email_sosialisasi' value='' required style='width:100%;max-width:100%;'>$far[email_sosialisasi]</textarea><br>
										<a style='font-size:12px;'>Pisahkan email dengan koma<br>(example@nutrifood.co.id, example2@nutrifood.co.id)</a><br><br>
										<a style='font-size:12px;'>Jika UPP memerlukan Sosialisasi Lapangan, maka daftar hadir sosialisasi terkirim secara otomatis di email sosialisasi</a><br><br>
										<a style='font-size:12px;'><i>*) wajib diisi</i></a>
										<input style='margin-left:308px;' id='button_submit' class='submit_main' type='submit' value='Kirim'>
									</div>
								</form>
							</div>
						</div>
				";

			break;

			case 'edit':
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$d_lokasi = test($_POST['lokasi']);
					$d_pengaju = test($_POST['pengaju']);
					$d_email = test($_POST['email_pengaju']);
					$d_divisi = test($_POST['divisi']);
					$d_prosedur = test($_POST['d_prosedur']);
					$d_bb = test($_POST['nama_bb']);
					$d_jenis = test($_POST['jenis']);
					$d_j_ik = test($_POST['j_ik_user']);
					$d_det_kat = test($_POST['det_kat']);
					$d_nm_folder = test($_POST['nm_folder']);
					$d_sblm_perubahan = test($_POST['sblm_perubahan']);
					$d_stlh_perubahan = test($_POST['stlh_perubahan']);
					$d_alasan = test($_POST['alasan']);
					$d_t = test($_POST['tahun']);
					$d_b = test($_POST['bulan']);
					$d_h = test($_POST['tanggal']);
					$d_date = date($d_t.'-'.$d_b.'-'.$d_h);
					$d_kat_per = test($_POST['kat_per']);
					$d_kat_mesin = test($_POST['kat_mesin']);
					$d_pic = test($_POST['pic_lap']);
					$d_cek_ddd = test($_POST['cek_ddd']);
					$d_status_sementara = test($_POST['status_sementara']);
					$d_ket_proses = test($_POST['ket_proses']);

					$a=mysqli_query($conn, "SELECT * FROM upp WHERE tahun='$year'");
					$c=mysqli_fetch_array($a);
					$b=mysqli_num_rows($a);
					$no = $b;	

					mysqli_query($conn, 
						"UPDATE upp SET
							lokasi = '$d_lokasi',
							pengaju = '$d_pengaju',
							email_pengaju = '$d_email',
							no_divisi_prosedur = '$d_divisi',
							no_master_prosedur = '$d_prosedur',
							nama_bb = '$d_bb',
							no_jenis_prosedur ='$d_jenis',
							jenis_ik = '$d_j_ik',
							detail_prosedur = '$d_det_kat',
							nama_folder = '$d_nm_folder',
							sebelumperubahan = '$d_sblm_perubahan',
							setelahperubahan = '$d_stlh_perubahan',
							alasan = '$d_alasan',
							permohonan_tgl_berlaku = '$d_date',
							kat_perubahan = '$d_kat_per',
							kat_mesin = '$d_kat_mesin',
							pic = '$d_pic',
							cek_ddd = '$d_cek_ddd',
							status_sementara = '$d_status_sementara',
							ket_proses = '$d_ket_proses'
							WHERE no_upp = '$id' ");

					//echo "<script> alert('$d_date'); </script>";

					// Upload File FMEA

					$uploadOk = 1;
					$nama_file = $_FILES['file_fmea']['name'];
					if ($nama_file!='') {

						$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
						$c=mysqli_fetch_array($a);

						if (!file_exists('file_upload/upp_ik_fmea/'.$year)) {
							mkdir('file_upload/upp_ik_fmea/'.$year);}
						if (!file_exists('file_upload/upp_ik_fmea/'.$year.'/'.$no)) {
							mkdir('file_upload/upp_ik_fmea/'.$year.'/'.$no);}

						$folder1 = 'file_upload/upp_ik_fmea/'.$year.'/'.$no.'/';
						$file_user1 = $_FILES['file_fmea']['name'];
						$file_user = $folder1.$file_user1;

						if (!file_exists('file_removal/file_upload/upp_ik_fmea/'.$year)) {
							mkdir('file_removal/file_upload/upp_ik_fmea/'.$year);}
						if (!file_exists('file_removal/file_upload/upp_ik_fmea/'.$year.'/'.$no)) {
							mkdir('file_removal/file_upload/upp_ik_fmea/'.$year.'/'.$no);}

						$rmv_file = 'file_removal/file_upload/upp_ik_fmea/'.$year.'/'.$no.'/';
						$tmp_nmfl = $c['file_fmea'];
						$tmp_mvfl = pathinfo($tmp_nmfl);
						$tmp_name = $tmp_mvfl['filename'];
						$tmp_exte = $tmp_mvfl['extension'];
						$fnl_name = $tmp_name.'_'.$d_date.'.'.$tmp_exte;
						$end_name = $rmv_file.$fnl_name;

						rename($c['file_fmea'], $end_name);

						if (move_uploaded_file($_FILES['file_fmea']['tmp_name'], $file_user)) {
							
							mysqli_query($conn, 
								"UPDATE upp SET
									file_fmea = '$file_user'
									WHERE no_upp = '$id' ");
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

					// Upload File User

					$nama_file = $_FILES['file_user']['name'];
					if ($nama_file!='') {

						$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
						$c=mysqli_fetch_array($a);

						if (!file_exists('file_upload/upp_user/'.$year)) {
							mkdir('file_upload/upp_user/'.$year);}
						if (!file_exists('file_upload/upp_user/'.$year.'/'.$no)) {
							mkdir('file_upload/upp_user/'.$year.'/'.$no);}
			
						$folder1 = 'file_upload/upp_user/'.$year.'/'.$no.'/';
						$file_user = $_FILES['file_user']['name'];
						$file_user = $folder1.$file_user;

						if (!file_exists('file_removal/file_upload/upp_user/'.$year)) {
							mkdir('file_removal/file_upload/upp_user/'.$year);}
						if (!file_exists('file_removal/file_upload/upp_user/'.$year.'/'.$no)) {
							mkdir('file_removal/file_upload/upp_user/'.$year.'/'.$no);}

						$rmv_file = 'file_removal/file_upload/upp_user/'.$year.'/'.$no.'/';
						$tmp_nmfl = $c['file_user'];
						$tmp_mvfl = pathinfo($tmp_nmfl);
						$tmp_name = $tmp_mvfl['filename'];
						$tmp_exte = $tmp_mvfl['extension'];
						$fnl_name = $tmp_name.'_'.$d_date.'.'.$tmp_exte;
						$end_name = $rmv_file.$fnl_name;

						rename($c['file_user'], $end_name);

						if (move_uploaded_file($_FILES['file_user']['tmp_name'], $file_user)) {

							mysqli_query($conn, 
								"UPDATE upp SET
									file_user = '$file_user'
									WHERE no_upp = '$id' ");

							$alert='Update File Berhasil !';}

						else {
							$alert='upload file gagal, silahkan ulangi pengajuan, atau hubungi QA team';
							$file_user='';
							$uploadOk = 0;}
					}

					else{
						$file_user='';}

					header("location:main?index=upp&step=done&id=$id");
				}
	
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=done&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Edit UPP Need to Check
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=done&action=edit&id=$id#popup' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>

									<div class='alert_adm alert'><b>Warning !</b> - Jika file Upload tidak ada yang akan di edit, jangan diisi !</div><br>

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

									<a class='j_input_main'>Divisi Prosedur *</a><br>
									<select class='input_main' name='divisi' required>
										";
											$d=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_divisi_prosedur']==$f['no_divisi_prosedur']) {
													echo "
														<option value='$f[no_divisi_prosedur]' selected>$f[divisi_prosedur]</option>
													";
												}
											}
										echo "
									</select><br>

									<a class='j_input_main'>Prosedur *</a><br>
									<select class='input_main' name='d_prosedur' required>
										";
											$d=mysqli_query($conn, "SELECT * from master_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_master_prosedur']==$f['no_master_prosedur']) {
													echo "
														<option value='$f[no_master_prosedur]' selected>$f[master_prosedur]</option>
													";
												}
											}
										echo "
									</select><br>
									$d_prosedur

									<a class='j_input_main'>Nama Bahan Baku / Produk *</a><br>
									<input class='input_main' type='text' name='nama_bb' value='$c[nama_bb]' required><br>
									";
									?>

									<a class='j_input_main'>Kategori Prosedur *</a><br>
									<select class='input_main' name='jenis' id='ik' onload='check()' onchange='check()' required>
											<?php
											$d=mysqli_query($conn, "SELECT * from jenis_prosedur");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_jenis_prosedur']==$f['no_jenis_prosedur']) {
													echo "
														<option value='$f[no_jenis_prosedur]' selected>$f[jenis_prosedur]</option>
													";
												}
											}
											?>
									</select>

									<a id='txt_sh_1' class='j_input_main'>Jenis Instruksi Kerja</a>
									<select class='input_main' name='j_ik_user' id='j_ik' required>
									";
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
					
									<a id='txt_sh_2' class='j_input_main'>Attachment FMEA <font size='1' color='red'> *)File Max 2MB, Diisi jika file upload akan diubah</font><br></a>
									<input class='file_main' type='file' id='file_fmea' name='file_fmea' onchange="valid(this)">

								<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 2MB / 2048B !</div>
								<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>

								<?php
									echo "

									<br><a class='j_input_main'>Detail Kategori *</a><br>
									<input class='input_main readonly' type='text' name='det_kat' value='$c[detail_prosedur]' readonly required><br>

									<a class='j_input_main'>Nama File *</a><br>
									<input class='input_main readonly' type='text' name='nm_folder' value='$c[nama_folder]' readonly required><br>

									<a class='j_input_main'>Sebelum Perubahan *</a><br>
									<textarea class='input_main' name='sblm_perubahan' required>$c[sebelumperubahan]</textarea><br>

									<a class='j_input_main'>Setelah Perubahan *</a><br>
									<textarea class='input_main' name='stlh_perubahan' required>$c[setelahperubahan]</textarea><br>
									
									<a class='j_input_main'>Alasan *</a><br>
									<textarea class='input_main' name='alasan' required>$c[alasan]</textarea><br>
									";
									?>

									<a class='j_input_main'>Permohonan Tgl Berlaku *</a><br>
									<select id='thndibutuhkan' class='input_main' style='width:100px;' onchange="ubahtgl()" name='tahun' required>
										<option value=''></option>
									
									<?php

										$tmp_tahun = substr($c['permohonan_tgl_berlaku'], 0,4);
										$tahunnow = date('Y')+1;
										for ($i=$tahunnow; $i >= 1980 ; $i--) {
											if ($tmp_tahun == $i) {
												echo " <option value='$i' selected>$i</option> ";}
											else{
												echo " <option value='$i'>$i</option> ";}
										}
									echo "
									</select>";

									?>

									<select id='blndibutuhkan' class='input_main' style='width:190px;' onchange="ubahtgl()" name='bulan' required>
										<option value=''></option>
									
									<?php

									$tmp_bulan = substr($c['permohonan_tgl_berlaku'], 5,2);
									$tmp_bulan = $tmp_bulan - 1;
									$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
									$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
									$daymonth=array('31','28','31','30','31','30','31','31','30','31','30','31');
									$monthlength=count($month2);

									for ($x=0; $x < 12; $x++) {
										if ($tmp_bulan == $x) {
											echo "<option value='$monthvalue[$x]' selected>$month2[$x]</option>";}
										else{
											echo "<option value='$monthvalue[$x]'>$month2[$x]</option>";}
									}
									echo "
									</select>
									<select id='tgldibutuhkan' class='input_main' style='width:100px;' name='tanggal' id='tgl' required>
										<option value=''></option>
									";

									$tmp_tgl = substr($c['permohonan_tgl_berlaku'], 8,2);
									
									if ($tmp_tahun % 4 == 0) {
										$daymonth=array('31','29','31','30','31','30','31','31','30','31','30','31');}

									else{
										$daymonth=array('31','28','31','30','31','30','31','31','30','31','30','31');}

									$daylength = $daymonth[$tmp_bulan];
									for ($i=1; $i <= $daylength ; $i++) {
										if ($i<10) {
											$iday='0'.$i;
										}
										else{
											$iday=$i;
										}

										if ($tmp_tgl == $iday) {
											echo "<option value='$iday' selected>$iday</option>";}
										else{
											echo "<option value='$iday'>$iday</option>";}

									}
									echo "
									</select><br>";?>

									<a id='txt_sh_2' class='j_input_main'>Attachment File User *<font size='1' color='red'> *)File Max 2MB, Diisi jika file upload akan diubah</font><br></a>
									<input class='file_main' type='file' id='file_user' name='file_user'onchange="valid1(this)">

									<div class='alert_adm alert' id="ugg1" style='width:94%;'>File Upload max Size is 2MB / 2048B !</div>
									<div class='alert_adm alert2' id="ubr1" style='width:94%;'>File is OK !</div>

									<br>

									<?php echo "
									<a class='j_input_main'>Kategori Perubahan *</a><br>
									<select class='input_main' name='kat_per' required>
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
														<option value='$f[kat_mesin]' selected>$f[kat_mesin]</option>
													";
												}
												else{
													echo "
														<option value='$f[kat_mesin]'>$f[kat_mesin]</option>
													";
												}
											}
										echo "
									</select><br>";
									?>

									<a class='j_input_main'>Perlu Sosialisasi Lapangan ? *</a><br>

									<?php
									echo "
									<label>";
										if ($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f') {
											?>
											<input id='cek_pic' class='radio_main' type='radio' name='cek_pic' value='ya'
											onclick="ch_pic()" checked required> Ya
											<?php
										}
										else{
											?>
											<input id='cek_pic' class='radio_main' type='radio' name='cek_pic' value='ya'
											onclick="ch_pic()" required> Ya
											<?php
										}
									echo "
									</label>
									<label>";
										if ($c['pic'] == '484ea5618aaf3e9c851c28c6dbca6a1f') {
											?>
											<input id='cek_pic2' class='radio_main' type='radio' name='cek_pic' value='tidak'
											onclick="
												document.getElementById('pic_lap').value = '484ea5618aaf3e9c851c28c6dbca6a1f';
												document.getElementById('pic_t').style.display = 'none';
												document.getElementById('pic_lap').style.display = 'none';"
											checked> Tidak
											<?php
										}
										else{
											?>
											<input id='cek_pic2' class='radio_main' type='radio' name='cek_pic' value='tidak'
											onclick="
												document.getElementById('pic_lap').value = '484ea5618aaf3e9c851c28c6dbca6a1f'
												document.getElementById('pic_t').style.display = 'none';
												document.getElementById('pic_lap').style.display = 'none';"
											> Tidak
											<?php
										}
									echo "
									</label><br>";

									

									echo "
									<a id='pic_t' class='j_input_main'>PIC Sosialisasi Lapangan ? *</a>
									<input class='input_main' type='text' name='pic_lap' id='pic_lap' value='$c[pic]' required>

									<a class='j_input_main'>Cek DDD / Perlu Disrtibusi Hardcopy ? *</a><br>
									<label>";
										if ($c['cek_ddd'] == 'ya') {
											?>
											<input id='cek_ddd' class='radio_main' type='radio' name='cek_ddd' value='ya' checked required> Ya
											<?php
										}
										else{
											?>
											<input id='cek_ddd' class='radio_main' type='radio' name='cek_ddd' value='ya' required> Ya
											<?php
										}
									echo "
									</label>
									<label>";
										if ($c['cek_ddd'] == 'tidak') {
											?>
											<input id='cek_ddd2' class='radio_main' type='radio' name='cek_ddd' value='tidak' checked> Tidak
											<?php
										}
										else{
											?>
											<input id='cek_dd2' class='radio_main' type='radio' name='cek_ddd' value='tidak' > Tidak
											<?php
										}
									echo "
									</label><br>

									<a class='j_input_main'>Prosedur *</a><br>
									<select class='input_main' name='d_prosedur' required>
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

									";

								?>
								<script type="text/javascript">
								function valid(file) {
								        var FileSize = file.files[0].size / 1024 / 1024; // in MB
								        if (FileSize > 2) {
								        	document.getElementById('ubr').style.display = "none";
								            document.getElementById('ugg').style.display = "block";
								            document.getElementById('button_submit').style.display = "none";
								        } else {
								            document.getElementById('ugg').style.display = "none";
								        	document.getElementById('ubr').style.display = "block";
								            document.getElementById('button_submit').style.display = "block";
								        }
								    }
								    function valid1(file) {
								        var FileSize = file.files[0].size / 1024 / 1024; // in MB
								        if (FileSize > 2) {
								        	document.getElementById('ubr1').style.display = "none";
								            document.getElementById('ugg1').style.display = "block";
								            document.getElementById('button_submit').style.display = "none";
								        } else {
								            document.getElementById('ugg1').style.display = "none";
								        	document.getElementById('ubr1').style.display = "block";
								            document.getElementById('button_submit').style.display = "block";
								        }
								    }

									function check(){
										var dropdown = document.getElementById("ik");
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

									window.onload = function(){
										document.getElementById('ugg').style.display = "none";
										document.getElementById('ubr').style.display = "none";
										document.getElementById('ugg1').style.display = "none";
										document.getElementById('ubr1').style.display = "none";
										var dropdown = document.getElementById("ik");
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

										if (document.getElementById('pic_lap').value == '484ea5618aaf3e9c851c28c6dbca6a1f') {
											document.getElementById('pic_t').style.display = 'none';
											document.getElementById('pic_lap').style.display = 'none';
										}
										else{
											document.getElementById('pic_t').style.display = 'block';
											document.getElementById('pic_lap').style.display = 'block';
										}
									}

									function ch_pic(){
										var take_pic = "<?php echo $c['pic'] ?>";
										document.getElementById('pic_t').style.display = 'block';
										document.getElementById('pic_lap').style.display = 'block';
										document.getElementById('pic_lap').value = take_pic;
									}

									function ubahtgl(){

										$('#tgldibutuhkan')
											.find('option')
											.remove()
											.end()

										var js_tmp_tahun = document.getElementById('thndibutuhkan').value;
										var js_tmp_bulan = document.getElementById('blndibutuhkan').value;
										
										if (js_tmp_tahun % 4 == 0) {
											var daymonth = ['31','29','31','30','31','30','31','31','30','31','30','31'];}
										else{
											var daymonth = ['31','28','31','30','31','30','31','31','30','31','30','31'];}

										var tmp_daylength = daymonth[js_tmp_bulan-1];

										for (var i = 0; i < tmp_daylength; i++) {
											select = document.getElementById('tgldibutuhkan');
											var opt = document.createElement('option');
											var tmp_i = i + 1;
											if (i < 9) {
												tmp_i = "0" + tmp_i;
											}
											opt.value = tmp_i;
											opt.text = tmp_i;
											select.appendChild(opt);
										}

									}
								</script>
								<?php
								echo "
								<a class='j_input_main'>Status Sementara *</a><br>
									<select class='input_main' name='status_sementara' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from tbl_status");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['status_sementara']==$f['id_status']) {
													echo "
														<option value='$f[id_status]' selected>$f[nm_status]</option>
													";
												}
												else{
													echo "
														<option value='$f[id_status]'>$f[nm_status]</option>
													";
												}
											}
										echo "
									</select><br>
								<a class='j_input_main'>Keterangan Proses</a><br>
									<textarea class='input_main' name='ket_proses'>$c[ket_proses]</textarea><br>
								<input style='margin-left:308px;' id='button_submit' class='submit_main' type='submit' value='Edit'>
								";?>
								</div>
							</form>
						</div>
					</div>
			<?php
			break;


			case 'closed':
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
					$nama_bb=test($_POST['nama_bb']);
					$jenis_prosedur=test($_POST['jenis']);
					$detail_prosedur=test($_POST['detail']);
					$nama_folder=test($_POST['file']);
					$sebelumperubahan=test($_POST['sebelumperubahan']);
					$setelahperubahan=test($_POST['setelahperubahan']);
					$alasan=test($_POST['alasan']);
					$tahun=test($_POST['thndibutuhkan']);
					$bulan=test($_POST['blndibutuhkan']);
					$tanggal=test($_POST['tgldibutuhkan']);
					$permohonan_tgl_berlaku=$tahun.'-'.$bulan.'-'.$tanggal;
					$kat_perubahan=test($_POST['kat_perubahan']);
					$kat_mesin=test($_POST['kat_mesin']);
					$pic=test($_POST['pic']);
					$cek_ddd=test($_POST['cek_ddd']);
					$kat_delay=test($_POST['kat_delay']);
					$tahun=test($_POST['thnberlaku']);
					$bulan=test($_POST['blnberlaku']);
					$tanggal=test($_POST['tglberlaku']);
					$tgl_berlaku=$tahun.'-'.$bulan.'-'.$tanggal;
					$tahun=test($_POST['thndistribusi']);
					$bulan=test($_POST['blndistribusi']);
					$tanggal=test($_POST['tgldistribusi']);
					$tgl_distribusi=$tahun.'-'.$bulan.'-'.$tanggal;
					$tahun=test($_POST['thnkembali']);
					$bulan=test($_POST['blnkembali']);
					$tanggal=test($_POST['tglkembali']);
					$tgl_kembali=$tahun.'-'.$bulan.'-'.$tanggal;
					$no_spd=test($_POST['no_spd']);
					$tgl_pengecekan=test($_POST['tgl_pengecekan']);
					$kesesuaian_dokumen=test($_POST['kesesuaian_dokumen']);
					$keterangan=test($_POST['keterangan']);
					$status_sementara=test($_POST['status_sementara']);
					$d_ket_proses=test($_POST['ket_proses']);

					if ($tgl_berlaku <= $c['permohonan_tgl_berlaku']) {
						$report1='ok';
					}
					else{
						$report1='tidak ok';
					}
					$t1 = substr($c['tgl_kirim'], 0,10);
					$t2 = date('Y-m-d', strtotime('+3 days', strtotime($t1)));
					if ($tgl_berlaku >= $t2) {
						$report2='tidak ok';
					}
					else{
						$report2='ok';
					}
					$t1 = $tgl_berlaku;
					$t2 = date('Y-m-d', strtotime('+1 days', strtotime($t1)));
					if ($c['tgl_sosialisasi'] <= $t2) {
						$report3='ok';
					}
					else{
						$report3='tidak ok';
					}

		$fname = $_FILES['draf_hdr']['name'];
		$info = pathinfo($fname);
		if($_FILES['draf_hdr']['name'] != '')
		{
		$fsize = $_FILES['draf_hdr']['size'];
		$ftipe = $_FILES['draf_hdr']['type'];
		$ferror = $_FILES['draf_hdr']['error'];
		$ff = str_replace("/","_",$no_upp)." ".$_FILES['draf_hdr']['name'];
 		$uploaddir = 'file_upload/daftar_hadir/';
		$lokasifile = $uploaddir.$ff;
		$move = move_uploaded_file($_FILES['draf_hdr']['tmp_name'],$lokasifile);
		}
		else
		{
			$ff = '';
		}
					if ($a=mysqli_query($conn, "UPDATE upp SET tahun = '$year',
													bulan = '$month',
													lokasi = '$lokasi',
													pengaju = '$pengaju',
													email_pengaju = '$email_pengaju',
													pic1 = '$pic1',
													pic2 = '$pic2',
													no_divisi_prosedur = '$divisi_prosedur',
													no_master_prosedur = '$prosedur',
													nama_bb = '$nama_bb',
													no_jenis_prosedur = '$jenis_prosedur',
													detail_prosedur = '$detail_prosedur',
													nama_folder = '$nama_folder',
													sebelumperubahan = '$sebelumperubahan',
													setelahperubahan = '$setelahperubahan',
													alasan = '$alasan',
													permohonan_tgl_berlaku = '$permohonan_tgl_berlaku',
													kat_perubahan = '$kat_perubahan',
													kat_mesin = '$kat_mesin',
													pic = '$pic',
													cek_ddd = '$cek_ddd',
													kat_delay = '$kat_delay',
													tgl_berlaku = '$tgl_berlaku',
													tgl_distribusi = '$tgl_distribusi',
													tgl_kembali = '$tgl_kembali',
													no_spd = '$no_spd',
													tgl_pengecekan = '$tgl_pengecekan',
													kesesuaian_dokumen = '$kesesuaian_dokumen',
													keterangan = '$keterangan',
													report1 = '$report1',
													report2 = '$report2',
													report3 = '$report3',
													status = 'closed',
													file_daftar_hadir = '$ff',
													ket_proses = '$d_ket_proses'
													WHERE 	no_upp = '$no_upp'
													")) {
														
		
		
		
						if ($kesesuaian_dokumen=='ok') {
							$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp = '$id'");
							$c=mysqli_fetch_array($a);
							$email=$c['email_pengaju'];

							$to 	  =	"$email";
							$subject  =	"PROSEDUR ONLINE | DONE";
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
							$message .=	"<tr><td><strong>Nama Bahan Baku:</strong> </td><td>" . strip_tags($c['nama_bb']) . "</td></tr>";
							$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
							$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
							$message .=	"<tr><td><strong>Sebelum Perubahan:</strong> </td><td>" . strip_tags($c['sebelumperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Setelah Perubahan:</strong> </td><td>" . strip_tags($c['setelahperubahan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Alasan:</strong> </td><td>" . strip_tags($c['alasan']) . "</td></tr>";
							$message .=	"<tr><td><strong>Tanggal Berlaku:</strong> </td><td>" . strip_tags($c['tgl_berlaku']) . "</td></tr>";
							$message .= "</table>";
							$message .= "<br><strong>Permintaan UPP anda telah selesai di proses, silahkan akses link berikut untuk mengisi kepuasan <a href='http://prosedur_online/main?index=upp&step=kepuasan&id=".strip_tags($id)."'>Go To UPP</a><br>";
							$message .=	"<strong>Jika dalam waktu 3 hari permintaan kepuasan tidak di proses, maka akan dianggap puas oleh sistem.</strong><br>";
							if ($c['cek_ddd']=='ya') {
								$message .= "<br><strong>Untuk permintaan distribusi dokumen hardcopy silahkan akses link berikut <a href='http://prosedur_online/main?index=ddd&action=upp&step=create&id=".strip_tags($id)."'>Go To DDD</a><br>";
							}
							$message .= "<br><br><strong>Salam,</strong><br>";
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
						else{
							$a=mysqli_query($conn, "UPDATE upp SET tgl_pengecekan = '0000-00-00', status = 'approved' WHERE no_upp = '$no_upp'");
						}
						header('location:main?index=upp&step=done');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=done&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Usulan Perubahan Prosedur
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=done&action=closed&id=$id#popup' method='post'  enctype='multipart/form-data'>
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
									<a class='j_input_main'>Nama Bahan Baku/Produk</a><br>
									<input class='input_main' type='text' name='nama_bb' value='$c[nama_bb]'><br>
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
									<select id='thndibutuhkan' class='input_main' style='width:100px;' name='thndibutuhkan' required>
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
									<select id='blndibutuhkan' class='input_main'  style='width:190px;' name='blndibutuhkan' required>
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
									<select id='tgldibutuhkan' class='input_main' style='width:100px;' name='tgldibutuhkan' required>
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
									<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>";
									
									
									if($c['pic'] == '484ea5618aaf3e9c851c28c6dbca6a1f')
									{
									echo"
									<input class='input_main' type='hidden' name='pic' value='$c[pic]' required>
									<input class='input_main readonly' type='text' name='picc' value='Tidak ada' readonly><br>";
									
									}
									else
									{
										echo"
									<input class='input_main' type='text' name='pic' value='$c[pic]' required><br>";
									}
									
									
								if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
								{
									echo "<input type='file' name='draf_hdr' onchange=\"document.getElementById('bb').style.display = 'block';
									document.getElementById('bbb').style.display = 'none';\"><br><br>";
								}
								
									
									
									echo"
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
									<a class='j_input_main'>Kategori Delay</a><br>
									<select class='input_main' name='kat_delay'>
										<option value=''></option>
										";
											$kat_delay2=array('UPP mendadak','Delay Approval','UPP belum fix');
											foreach ($kat_delay2 as $value) {
												$x=1;
												if ($c['kat_delay']==$value) {
													echo "
														<option value='$value' selected>$value</option>
													";
												}
												else{
													echo "
														<option value='$value'>$value</option>
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Tanggal Kirim *</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_kirim' value='$c[tgl_kirim]' required readonly><br>
									<a class='j_input_main'>Tanggal Approval (PIC 1) *</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_pic1' value='$c[tgl_pic1]' required readonly><br>
									<a class='j_input_main'>Tanggal Approval (PIC 2) *</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_pic2' value='$c[tgl_pic2]' required readonly><br>
									<a class='j_input_main'>Tanggal Berlaku *</a><br>
									<select class='input_main' style='width:100px;' name='thnberlaku' required>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_berlaku'],0,4);
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
									<select class='input_main'  style='width:190px;' name='blnberlaku' required>
										<option value=''></option>
										";
											$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_berlaku'],5,2);
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
									<select class='input_main' style='width:100px;' name='tglberlaku' required>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_berlaku'],8,2);
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
									<a class='j_input_main'>Tanggal Sosialisasi *</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_sosialisasi' value='$c[tgl_sosialisasi]' required readonly><br>

									<a class='j_input_main'>Status Sementara *</a><br>
									<select class='input_main' name='status_sementara' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from tbl_status");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['status_sementara']==$f['id_status']) {
													echo "
														<option value='$f[id_status]' selected>$f[nm_status]</option>
													";
												}
												else{
													echo "
														<option value='$f[id_status]'>$f[nm_status]</option>
													";
												}
											}
										echo "
									</select><br>

									<a class='j_input_main'>Tanggal Distribusi</a><br>
									<select class='input_main' style='width:100px;' name='thndistribusi'>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_distribusi'],0,4);
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
									<select class='input_main'  style='width:190px;' name='blndistribusi'>
										<option value=''></option>
										";
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_distribusi'],5,2);
											for ($x=0; $x < 12; $x++) {
												$i=$x+1;
												if ($i==$bulan) {
													echo "
														<option value='$i' selected>$month2[$x]</option>
													";
												}
												else{
													echo "
														<option value='$i'>$month2[$x]</option>
													";
												}
											}
										echo "
									</select>
									<select class='input_main' style='width:100px;' name='tgldistribusi'>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_distribusi'],8,2);
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
									<a class='j_input_main'>Tanggal Kembali Dokumen lama + SPD</a><br>
									<select class='input_main' style='width:100px;' name='thnkembali'>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_kembali'],0,4);
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
									<select class='input_main'  style='width:190px;' name='blnkembali'>
										<option value=''></option>
										";
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_kembali'],5,2);
											for ($x=0; $x < 12; $x++) {
												$i=$x+1;
												if ($i==$bulan) {
													echo "
														<option value='$i' selected>$month2[$x]</option>
													";
												}
												else{
													echo "
														<option value='$i'>$month2[$x]</option>
													";
												}
											}
										echo "
									</select>
									<select class='input_main' style='width:100px;' name='tglkembali'>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_kembali'],8,2);
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
									<a class='j_input_main'>No. SPD</a><br>
									<input class='input_main' type='text' name='no_spd' value='$c[no_spd]'><br>
									<a class='j_input_main'>Tanggal Pengecekan</a><br>
									<input class='input_main readonly' type='date' name='tgl_pengecekan' value='$hariini' required readonly><br>
									<a class='j_input_main'>Kesesuaian Dokumen</a><br>
									<script>
										$(document).ready(function(){
											$('#cek_dok').on('change', function(){
													$('#ket').removeAttr('required', 'required');
											});
											$('#cek_dok2').on('change', function(){
													$('#ket').attr('required', 'required');
											});
										});
									</script>
									<label>
									";
										if ($c['kesesuaian_dokumen']=='ok') {
											echo "<input id='cek_dok' class='radio_main' type='radio' name='kesesuaian_dokumen' value='ok' checked required> Ok";
										}
										else{
											echo "<input id='cek_dok' class='radio_main' type='radio' name='kesesuaian_dokumen' value='ok' required> Ok";
										}
									echo "
									</label>
									<label>
									";
										if ($c['kesesuaian_dokumen']=='tidak ok') {
											echo "<input id='cek_dok2' class='radio_main' type='radio' name='kesesuaian_dokumen' value='tidak ok' checked> Tidak Ok";
										}
										else{
											echo "<input id='cek_dok2' class='radio_main' type='radio' name='kesesuaian_dokumen' value='tidak ok'> Tidak Ok";
										}
									echo "
									</label>
									<br>
									<a class='j_input_main'>Keteangan Proses</a><br>
									<textarea class='input_main' name='ket_proses' required>$c[ket_proses]</textarea><br>
									<a class='j_input_main'>Keterangan</a><br>
									";
										if ($c['kesesuaian_dokumen']=='ok') {
											echo "
												<textarea id='ket' class='input_main' name='keterangan'>$c[keterangan]</textarea>
											";
										}
										else{
											echo "
												<textarea id='ket' class='input_main' name='keterangan' required>$c[keterangan]</textarea>
											";
										}
									echo "
									<br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input id='bb' style='margin-left:304px; ";
								if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
								{
									echo "display:none;";
								}
								
								echo"' class='submit_main' type='submit' value='Closed'>
								";
								if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
								{
									echo "<a style=\"font-size:11px; text-align:right;\"  id='bbb'>Button akan muncul setelah upload file daftar hadir</a>";
								}
								
								echo"
								<br><br><br><br><br><br><br>
								
							</form>
						</div>
					</div>
				";
				break;
		}
	} 		
?>
<div class='judul_main' style='position: fixed;'>Usulan Perubahan Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
	echo"<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=done' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				LEFT join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				LEFT join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				LEFT join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				LEFT join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				LEFT join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE no_upp='$id' AND status='need to check'");
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=done' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else{
			$filter="";
			$sort="tgl_berlaku desc";
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
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				LEFT join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				LEFT join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				LEFT join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				LEFT join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				LEFT join tbl_status on upp.status_sementara = tbl_status.id_status				
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'need to check' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				LEFT join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				LEFT join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				LEFT join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				LEFT join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				LEFT join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'need to check' ".$filter);
			if(isset($_POST['kw']))
			{
				$kw = $_POST['kw'];
				$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				LEFT join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				LEFT join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				LEFT join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				LEFT join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik
				LEFT join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'need to check' and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or upp.no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%') ORDER BY tgl_kirim desc
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
						echo "<td><a href='main?index=upp&step=done&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=done&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=done&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=done&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=done&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=done&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=done&hal=$page$sorturl'>Last</a></td>";
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
			<td colspan="3">Action</td>
			<td>Status Sementara</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=no&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=no&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=no&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=lokasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=email_pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=pic2&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=divisi_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=divisi_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=divisi_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=prosedur&order=ASC$halurl'>";
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
						if ($sortby=='nama_bb') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=nama_bb&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=nama_bb&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=nama_bb&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Nama Bahan Baku/Produk
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='jenis_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=jenis_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=jenis_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=jenis_prosedur&order=ASC$halurl'>";
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
			<td>Jenis IK</td>
			<td>File FMEA</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='detail_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=detail_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=detail_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=detail_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=nama_folder&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=sebelumperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=setelahperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=alasan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
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
			<td>Attachment File User</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='kat_perubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=kat_perubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=kat_mesin&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=pic&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=cek_ddd&order=ASC$halurl'>";
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
						if ($sortby=='status') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=status&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=status&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=status&order=ASC$halurl'>";
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
						if ($sortby=='kat_delay') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=kat_delay&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=kat_delay&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=kat_delay&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Kategori Delay
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_kirim') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_kirim&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_kirim&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_kirim&order=ASC$halurl'>";
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
			<td>Attachment File Master</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_pic1') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=done&sort=tgl_pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_pic2&order=ASC$halurl'>";
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
			<td>Tanggal Approval Validasi</td>
			<td>Attachment File Prosedur</td>
			<td>Link Prosedur</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_berlaku&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Berlaku
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_sosialisasi') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_sosialisasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_sosialisasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_sosialisasi&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Sosialisasi
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_filling') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_filling&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_filling&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_filling&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Filling
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_distribusi') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_distribusi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_distribusi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_distribusi&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Distribusi
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_kembali') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_kembali&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_kembali&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_kembali&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Kembali Dokumen lama + SPD
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no_spd') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=no_spd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=no_spd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=no_spd&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. SPD
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_pengecekan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=tgl_pengecekan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=tgl_pengecekan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=tgl_pengecekan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Pengecekan
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='kesesuaian_dokumen') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=kesesuaian_dokumen&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=kesesuaian_dokumen&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=kesesuaian_dokumen&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Kesesuaian Dokumen
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='keterangan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=keterangan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=keterangan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=keterangan&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Keterangan
					</a>
					";
				?>
			</td>
			<td>Keterangan Proses</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no_revisi') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=no_revisi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=no_revisi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=no_revisi&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. Revisi
					</a>
					";
				?>
			</td>			
				<?php
				/*echo"<td>";
					if (isset($sort)) {
						if ($sortby=='no_revisi_cover') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=done&sort=no_revisi_cover&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=done&sort=no_revisi_cover&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=done&sort=no_revisi_cover&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. Revisi Cover
					</a>
					</td>
					";*/
				?>
			
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
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=closed&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reply.png'> close
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=mail&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/mail.png'> mail
						</a>
					</td>
					<td>$c[nm_status]</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[nama_bb]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
					<td>
					";
						if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>download</a>";
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
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td>$c[pic]</td>";
					}
					else
					{
						echo"<td>Tidak</td>";
					}
					echo"
					<td>$c[cek_ddd]</td>
					<td>$c[status]</td>
					<td>$c[kat_delay]</td>
					<td>$c[tgl_kirim]</td>
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
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
					<td>$c[vi_pic_app]</td>
					<td>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>
					";
						if ($c['link_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
						}
						else{
							echo "no link";
						}
					echo "
					</td>
					<td>$c[tgl_berlaku]</td>
					<td>$c[tgl_sosialisasi]</td>
					<td>$c[tgl_filling]</td>
					<td>$c[tgl_distribusi]</td>
					<td>$c[tgl_kembali]</td>
					<td>$c[no_spd]</td>
					<td>$c[tgl_pengecekan]</td>
					<td>$c[kesesuaian_dokumen]</td>
					<td>$c[keterangan]</td>
					<td>$c[ket_proses]</td>
					<td>$c[no_revisi]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=closed&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reply.png'> close
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=edit&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>

					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=done&action=mail&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/mail.png'> mail
						</a>
					</td>
					<td>$c[nm_status]</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[nama_bb]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[jenis_ik]</td>
					<td>
					";
						if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>download</a>";
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
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td>$c[pic]</td>";
					}
					else
					{
						echo"<td>Tidak</td>";
					}
					echo"
					<td>$c[cek_ddd]</td>
					<td>$c[status]</td>
					<td>$c[kat_delay]</td>
					<td>$c[tgl_kirim]</td>
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
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
					<td>$c[vi_pic_app]</td>
					<td>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>
					";
						if ($c['link_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
						}
						else{
							echo "no link";
						}
					echo "
					</td>
					<td>$c[tgl_berlaku]</td>
					<td>$c[tgl_sosialisasi]</td>
					<td>$c[tgl_filling]</td>
					<td>$c[tgl_distribusi]</td>
					<td>$c[tgl_kembali]</td>
					<td>$c[no_spd]</td>
					<td>$c[tgl_pengecekan]</td>
					<td>$c[kesesuaian_dokumen]</td>
					<td>$c[keterangan]</td>
					<td>$c[ket_proses]</td>
					<td>$c[no_revisi]</td>
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