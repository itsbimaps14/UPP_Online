<?php
	$hariini=date("Y-m-d");
	$thn=date("Y");
	$bln=date("m");
	$filter = "";
	if(isset($_POST['tahun1']) or isset($_POST['bulan1']) or isset($_POST['status']) or isset($_POST['deprt']))
	{
		if($_POST['tahun1'] != ''){
		$filter = "";
		$filter = $filter."and tahun = '".$_POST['tahun1']."'";
		$tahun1 = $_POST['tahun1'];
		}
		if($_POST['bulan1'] != '')
		{
		$filter = $filter."and bulan = '".$_POST['bulan1']."'";
		$bulan1 = $_POST['bulan1'];
		}
		if($_POST['status'] != '')
		{
		$filter = $filter."and status = '".$_POST['status']."'";
		$status = $_POST['status'];
		}
		if($_POST['deprt'] != '')
		{
		$filter = $filter."and no_department = '".$_POST['deprt']."'";
		$deprt = $_POST['deprt'];
		}
		if ($_POST['tahun1'] == "" and $_POST['bulan1'] == "" and $_POST['status'] == "" and $_POST['deprt'] == "" and $_POST['sort'] == "" and $_POST['sortby'] == "")
		{
			header("location:main?index=dde");
		}
	}
	if (isset($_POST['sort'])) {
		$sortby=$_POST['sort'];
		if ($sortby!='') {
			if (isset($_POST['order'])) {
				$orderby=$_POST['order'];
				if ($sortby!='') {
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
				$orderby='';
				$sort=$sortby;
				$sorturl='&sort='.$sortby;
			}
		}
		else{
			$sort="no_dde DESC";
			$sortby='';
			$sorturl='';
		}
	}
	else{
		$sort="no_dde DESC";
		$sortby='';
		$sorturl='';
	}//sort
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'tambah':
				$tgl_dde=test($_POST['tgl_dde']);
				$no_department=test($_POST['no_department']);
				$nama_dokumen=test($_POST['nama_dokumen']);
				$sumber_edisi_tahun=test($_POST['sumber_edisi_tahun']);
				$pengaju=test($_POST['pengaju']);
				$email_pengaju=test($_POST['email_pengaju']);
				$tahun=test($_POST['tahun']);
				$bulan=test($_POST['bulan']);
				$tanggal=test($_POST['tanggal']);
				$tgl_kirim=$tahun.'-'.$bulan.'-'.$tanggal;

				if ($a=mysqli_query($conn, "INSERT INTO dde (tgl_dde,tahun,bulan,no_department,nama_dokumen,sumber_edisi_tahun,pengaju,email_pengaju,tgl_kirim)
					VALUES ('$tgl_dde','$thn','$bln','$no_department','$nama_dokumen','$sumber_edisi_tahun','$pengaju','$email_pengaju','$tgl_kirim')
					")) {
					$alert2='pengajuan berhasil';
					echo "
						<div id='popup_done' class='popup'>
							<a href='main?index=dde'>
								<div class='popup_exit'></div>
							</a>
							<div class='popup_upp'>
								<a href='main?index=dde' class='close-button' title='close'>X</a>
								UPP ONLINE<br>
								";
									if (isset($alert)) {
										echo "<span style='font-size:15px;'>$alert</span>";
									}
									else{
										echo "<span style='font-size:15px;'>Permintaan Distribusi Dokumen Eksternal Anda Telah Terkirim</span><br>";
									}
								echo "
							</div>
						</div>
					";
				}
				else{
					$alert='pengajuan gagal ada yang error: '.mysqli_errno($conn).' - '.mysqli_error($conn);
				}
				break;
			case 'process':
				if ($id=='') {
					header('location:main?index=dde');
				}
				$a=mysqli_query($conn, "SELECT * FROM dde WHERE no_dde ='$id'");
				$c=mysqli_fetch_array($a);
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_dde=test($_POST['tgl_dde']);
					$no_department=test($_POST['no_department']);
					$nama_dokumen=test($_POST['nama_dokumen']);
					$sumber_edisi_tahun=test($_POST['sumber_edisi_tahun']);
					$pengaju=test($_POST['pengaju']);
					$email_pengaju=test($_POST['email_pengaju']);
					$tahun=test($_POST['thn_kirim']);
					$bulan=test($_POST['bln_kirim']);
					$tanggal=test($_POST['tgl_kirim']);
					$tgl_kirim=$tahun.'-'.$bulan.'-'.$tanggal;
					$tahun=test($_POST['thn_terima']);
					$bulan=test($_POST['bln_terima']);
					$tanggal=test($_POST['tgl_terima']);
					$tgl_terima=$tahun.'-'.$bulan.'-'.$tanggal;
					$no_copy=test($_POST['no_copy']);
					$bentuk_penyimpanan=test($_POST['bentuk_penyimpanan']);
					$tahun=test($_POST['thn_kembali']);
					$bulan=test($_POST['bln_kembali']);
					$tanggal=test($_POST['tgl_kembali']);
					$tgl_kembali=$tahun.'-'.$bulan.'-'.$tanggal;
					$kode=test($_POST['kode']);

					$uploadOk = 1;
					$nama_file = $_FILES['nama_file']['name'];
					if ($nama_file!='') {
						if (!file_exists('file_upload/dde/'.$id)) {
							mkdir('file_upload/dde/'.$id);
						}
						
						$folder1 = 'file_upload/dde/'.$id.'/';
						$nama_file1 = $_FILES['nama_file']['name'];
						$nama_file2 = test($nama_file1);
						$tmp_nama_file = $_FILES['nama_file']['tmp_name'];
						$nama_file = $folder1.$nama_file1;
						$nama_file_rename = $folder1.$nama_file2;

						unlink($c['nama_file']);

						if (move_uploaded_file($tmp_nama_file, $nama_file)) {
							rename($nama_file, $nama_file_rename);
							$a=mysqli_query($conn, "UPDATE dde SET nama_file = '$nama_file_rename'	WHERE 	no_dde = '$id'");
						}
						else {
							$alert='upload file gagal, silahkan kirim lewat email';
							$nama_file='';
							$uploadOk = 0;
						}
					}

					if ($a=mysqli_query($conn, "UPDATE dde SET tgl_dde = '$tgl_dde',
													no_department = '$no_department',
													nama_dokumen = '$nama_dokumen',
													sumber_edisi_tahun = '$sumber_edisi_tahun',
													pengaju = '$pengaju',
													email_pengaju = '$email_pengaju',
													tgl_kirim = '$tgl_kirim',
													tgl_terima = '$tgl_terima',
													no_copy = '$no_copy',
													bentuk_penyimpanan = '$bentuk_penyimpanan',
													tgl_kembali = '$tgl_kembali',
													kode = '$kode',
													alasan_batal = '',
													tgl_batal = '0000-00-00'
													WHERE 	no_dde = '$id'
													")) {
						$a=mysqli_query($conn, "SELECT * FROM dde INNER JOIN department WHERE dde.no_department = department.no AND no_dde ='$id'");
						$c=mysqli_fetch_array($a);
						if ($c['status']!='closed') {
							if ($c['tgl_kembali']!='0000-00-00') {
								$a=mysqli_query($conn, "UPDATE dde SET status = 'closed' WHERE 	no_dde = '$id'");

								$email=$c['email_pengaju'];
								$to 	  =	"$email";
								$subject  =	"PROSEDUR ONLINE | DISTRIBUDI DOKUMEN EKSTERNAL";
								$headers  = array ('From' => $from,
								'To' => $to,
								'subject' => $subject,
								"MIME-Version"=>"1.0",
								"Content-type"=>"text/html"
								);
								$message  =	"<html><body>";
								$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
								$message .=	"<strong>Berikut kami sampaikan Permintaan Distribusi Dokumen Eksternal anda telah selesai di proses dengan detail sebagai berikut</strong><br><br>";
								$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
								$message .=	"<tr style='background: #eee;'><td><strong>No. DDE:</strong> </td><td>" . strip_tags($c['no_dde']) . "</td></tr>";
								$message .=	"<tr><td><strong>Tanggal DDE:</strong> </td><td>" . strip_tags($c['tgl_dde']) . "</td></tr>";
								$message .=	"<tr><td><strong>Department:</strong> </td><td>" . strip_tags($c['kode_department']) . "</td></tr>";
								$message .=	"<tr><td><strong>Nama Dokumen:</strong> </td><td>" . strip_tags($c['nama_dokumen']) . "</td></tr>";
								$message .=	"<tr><td><strong>Sumber/Edisi/Tahun:</strong> </td><td>" . strip_tags($c['sumber_edisi_tahun']) . "</td></tr>";
								$message .=	"<tr><td><strong>Tanggal Kirim:</strong> </td><td>" . strip_tags($c['tgl_kirim']) . "</td></tr>";
								$message .=	"<tr><td><strong>Tanggal Terima:</strong> </td><td>" . strip_tags($c['tgl_terima']) . "</td></tr>";
								$message .=	"<tr><td><strong>No. Copy:</strong> </td><td>" . strip_tags($c['no_copy']) . "</td></tr>";
								$message .=	"<tr><td><strong>Bentuk Penyimpanan:</strong> </td><td>" . strip_tags($c['bentuk_penyimpanan']) . "</td></tr>";
								$message .=	"<tr><td><strong>Tanggal Kembali:</strong> </td><td>" . strip_tags($c['tgl_kembali']) . "</td></tr>";
								$message .= "</table>";
								$message .= "<br><strong>Untuk melihat permintaan DDE diatas silahkan akses <a href='http://prosedur_online/main?index=dde&id=".strip_tags($id)."'>Go To DDE</a><br><br><br>";
								$message .= "<strong>Salam,</strong><br>";
								$message .= "<strong>UPP Online</strong>";
								$message .= "</body></html>";

								$mail = $smtp->send($to, $headers, $message);
								if (Pear::isError($mail)) {
									echo "<p>" . $mail->getMessage() . "</p>";
									echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
								} else{
									echo "<p>Message 1 successfully sent!</p>";
								}
							}
							else if ($c['status'] == 'closed') {
								$email=$c['email_pengaju'];
								$to 	  =	"$email";
								$subject  =	'Portal Pengendalian Dokumen "DDE Closed" | PROSEDUR ONLINE';
								$headers  = array ('From' => $from,
								'To' => $to,
								'subject' => $subject,
								"MIME-Version"=>"1.0",
								"Content-type"=>"text/html"
								);
								$message  =	"<html><body>";
								$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
								$message .=	"<strong>Berikut kami sampaikan DDE anda dengan detail sbb :</strong><br><br>";
								$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
								$message .=	"<tr style='background: #eee;'><td><strong>No. DDE:</strong> </td><td>" . strip_tags($c['no_dde']) . "</td></tr>";
								$message .=	"<tr><td><strong>Tanggal DDE:</strong> </td><td>" . strip_tags($c['tgl_dde']) . "</td></tr>";
								$message .=	"<tr><td><strong>Department:</strong> </td><td>" . strip_tags($c['kode_department']) . "</td></tr>";
								$message .=	"<tr><td><strong>Nama Dokumen:</strong> </td><td>" . strip_tags($c['nama_dokumen']) . "</td></tr>";
								$message .=	"<tr><td><strong>Sumber/Edisi/Tahun:</strong> </td><td>" . strip_tags($c['sumber_edisi_tahun']) . "</td></tr>";
								$message .= "</table><br>";
								$message .= "<strong>Telah Selesai diproses.</strong><br>";
								$message .= "<strong>Salam,</strong><br>";
								$message .= "<strong>UPP Online</strong>";
								$message .= "</body></html>";

								$mail = $smtp->send($to, $headers, $message);
								if (Pear::isError($mail)) {
									echo "<p>" . $mail->getMessage() . "</p>";
									echo "<script type='text/javascript'>alert('email tidak terkirim');</script>";
								} else{
									echo "<p>Message 2 successfully sent!</p>";
								}
								header('location:main?index=keluhan');
							}
							else{
								$a=mysqli_query($conn, "UPDATE dde SET status = 'process' WHERE no_dde = '$id'");
								header('location:main?index=dde&action=process&id='.$id.'#popup');
							}
						}
						else{
							header('location:main?index=dde');
						}
					}
					else{
						$alert='pengajuan gagal ada yang error: '.mysqli_errno($conn).' - '.mysqli_error($conn);
					}
					header('location:main?index=dde');
				}
				$a=mysqli_query($conn, "SELECT * FROM dde WHERE no_dde ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=dde&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form Distribusi Dokumen Eksternal
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=dde&action=process&id=$id#popup' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>
									";
										if (isset($alert)) {
											echo "<div class='alert_adm alert'>$alert</div>";
										}
										if (isset($alert2)) {
											echo "<div class='alert_adm alert2'>$alert2</div>";
										}
									echo "
									<a class='j_input_main'>Tanggal DDE *</a><br>
									<input class='input_main readonly' type='text' name='tgl_dde' value='$c[tgl_dde]' required readonly><br>
									<a class='j_input_main'>Department *</a><br>
									<select class='input_main' name='no_department' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from department order by department");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['no_department']==$f['no']) {
													echo "
														<option value='$f[no]' selected>$f[kode_department] - $f[department] - $f[lokasi]</option>
													";
												}
												else{
													echo "
														<option value='$f[no]'>$f[kode_department] - $f[department] - $f[lokasi]</option>
													";
												}
											}
										echo "
									</select><br>
									<a class='j_input_main'>Nama Dokumen *</a><br>
									<input class='input_main' type='text' name='nama_dokumen' value='$c[nama_dokumen]' required><br>
									<a class='j_input_main'>Sumber/Edisi/Tahun *</a><br>
									<input class='input_main' type='text' name='sumber_edisi_tahun' value='$c[sumber_edisi_tahun]' required><br>
									<a class='j_input_main'>Pengaju *</a><br>
									<input class='input_main' type='text' name='pengaju' value='$c[pengaju]' required><br>
									<a class='j_input_main'>Email Pengaju *</a><br>
									<input class='input_main' type='email' name='email_pengaju' value='$c[email_pengaju]' required><br>
									<a class='j_input_main'>Tanggal Kirim *</a><br>
									<select class='input_main' style='width:100px;' name='thn_kirim' required>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_kirim'],0,4);
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
									<select class='input_main'  style='width:190px;' name='bln_kirim' required>
										<option value=''></option>
										";
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_kirim'],5,2);
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
									<select class='input_main' style='width:100px;' name='tgl_kirim' required>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_kirim'],8,2);
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
									<a class='j_input_main'>Tanggal Terima</a><br>
									<select class='input_main' style='width:100px;' name='thn_terima'>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_terima'],0,4);
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
									<select class='input_main'  style='width:190px;' name='bln_terima'>
										<option value=''></option>
										";
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_terima'],5,2);
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
									<select class='input_main' style='width:100px;' name='tgl_terima'>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_terima'],8,2);
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
									<a class='j_input_main'>No. Copy</a><br>
									<input class='input_main' type='text' name='no_copy' value='$c[no_copy]'><br>
									<a class='j_input_main'>Bentuk Penyimpanan</a><br>
									<label>
									";
										if ($c['bentuk_penyimpanan']=='softcopy') {
											echo "<input class='radio_main' type='radio' name='bentuk_penyimpanan' value='softcopy' checked> Softcopy";
										}
										else{
											echo "<input class='radio_main' type='radio' name='bentuk_penyimpanan' value='softcopy'> Softcopy";
										}
									echo "
									</label>
									<label>
									";
										if ($c['bentuk_penyimpanan']=='hardcopy') {
											echo "<input class='radio_main' type='radio' name='bentuk_penyimpanan' value='hardcopy' checked> Hardcopy";
										}
										else{
											echo "<input class='radio_main' type='radio' name='bentuk_penyimpanan' value='hardcopy'> Hardcopy";
										}
									echo "
									</label>
									<br>
									<a class='j_input_main'>Tanggal Kembali</a><br>
									<select class='input_main' style='width:100px;' name='thn_kembali'>
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
									<select class='input_main'  style='width:190px;' name='bln_kembali'>
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
									<select class='input_main' style='width:100px;' name='tgl_kembali'>
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
									<a class='j_input_main'>Kode *</a><br>
									<input class='input_main' type='text' name='kode' value='$c[kode]' required><br>
									<a class='j_input_main'>Attachment File <font size='1' color='red'> ) Max File Size = 2MB</font></a><br>
									<input class='file_main' type='file' name='nama_file' onchange='valid(this)'><br>
									<div class='alert_adm alert' id='ugg' style='width:230px;'>File Upload max Size is 2MB / 2048B !</div>
									<div class='alert_adm alert2' id='ubr' style='width:70px;'>File is OK !</div>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:304px;' class='submit_main' type='submit' id='submit' value='Process'>
							</form>
						</div>
					</div>
				";
				break;
			case 'batal':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_batal=test($_POST['tgl_batal']);
					$alasan=test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE dde 	SET tgl_batal = '$tgl_batal',
												alasan_batal = '$alasan',
												status = 'batal'
												WHERE 	no_dde = '$id'
												")){
						$a=mysqli_query($conn, "SELECT * FROM dde INNER JOIN department WHERE dde.no_department = department.no AND no_dde ='$id'");
						$c=mysqli_fetch_array($a);

						$email=$c['email_pengaju'];
						$to 	  =	"$email";
						$subject  =	"PROSEDUR ONLINE | DISTRIBUDI DOKUMEN EKSTERNAL";
						$headers  = array ('From' => $from,
						'To' => $to,
						'subject' => $subject,
						"MIME-Version"=>"1.0",
						"Content-type"=>"text/html"
						);
						$message  =	"<html><body>";
						$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
						$message .=	"<strong>Berikut kami sampaikan Permintaan Distribusi Dokumen Eksternal dengan detail sebagai berikut</strong><br><br>";
						$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
						$message .=	"<tr style='background: #eee;'><td><strong>No. DDE:</strong> </td><td>" . strip_tags($c['no_dde']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal DDE:</strong> </td><td>" . strip_tags($c['tgl_dde']) . "</td></tr>";
						$message .=	"<tr><td><strong>Department:</strong> </td><td>" . strip_tags($c['kode_department']) . "</td></tr>";
						$message .=	"<tr><td><strong>Nama Dokumen:</strong> </td><td>" . strip_tags($c['nama_dokumen']) . "</td></tr>";
						$message .=	"<tr><td><strong>Sumber/Edisi/Tahun:</strong> </td><td>" . strip_tags($c['sumber_edisi_tahun']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal Kirim:</strong> </td><td>" . strip_tags($c['tgl_kirim']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal Batal:</strong> </td><td>" . strip_tags($c['tgl_batal']) . "</td></tr>";
						$message .=	"<tr><td><strong>Alasan Batal:</strong> </td><td>" . strip_tags($c['alasan_batal']) . "</td></tr>";
						$message .= "</table>";
						$message .= "<br><strong>Permintaan Distribusi Dokumen Eksternal anda telah di batalkan, untuk melihat permintaan silahkan akses <a href='http://prosedur_online/main?index=dde&id=".strip_tags($id)."'>Go To DDE</a><br><br><br>";
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
						header('location:main?index=dde');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=dde&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Batal
						</div>
						<div class='form_process'>
							<form action='main?index=dde&action=batal&id=$id' method='post'>
								<a class='j_input_main'>No. DDE</a><br>
								<input class='input_main' type='text' name='no_dde' value='$id' required style='background-color:#e7e7e7;width:100%;' readonly><br>
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
<div id='main' class='main fl m-left-0px width100pc' style='min-height:800px;'>
	<div class='judul_main' style='position: fixed;'>Distribusi Dokumen Eksternal</div>
	<?php
		if(isset($_GET['action'])){
			if($_GET['action']=='create'){
	?>
				<form action='main?index=dde&action=tambah#popup_done' method='post'  enctype='multipart/form-data'>
					<div class='form_main' style='margin-top: 46px;'>
						<?php
							if (isset($alert)) {
								echo "<div class='alert_adm alert'>$alert</div>";
							}
							if (isset($alert2)) {
								echo "<div class='alert_adm alert2'>$alert2</div>";
							}
						?>
						<a class='j_input_main'>Tanggal DDE *</a><br>
						<?php
							echo "
								<input class='input_main readonly' type='text' name='tgl_dde' value='$hariini' readonly required><br>
							";
						?>
						<a class='j_input_main'>Department *</a><br>
						<select class='input_main' name='no_department' required>
							<option value=''></option>
							<?php
								$a=mysqli_query($conn, "SELECT * from department order by department");
								while ($c=mysqli_fetch_array($a)) {
									echo "
										<option value='$c[no]'>$c[kode_department] - $c[department] - $c[lokasi]</option>
									";
								}
							?>
						</select><br>
						<a class='j_input_main'>Nama Dokumen *</a><br>
						<input class='input_main' type='text' name='nama_dokumen' value='' required><br>
						<a class='j_input_main'>Sumber/Edisi/Tahun *</a><br>
						<input class='input_main' type='text' name='sumber_edisi_tahun' value='' required><br>
						<a class='j_input_main'>Pengaju *</a><br>
						<input class='input_main' type='text' name='pengaju' value='' required><br>
						<a class='j_input_main'>Email Pengaju *</a><br>
						<input class='input_main' type='email' name='email_pengaju' value='' required><br>
						<a class='j_input_main'>Tanggal Kirim *</a><br>
						<?php
							echo "
								<select class='input_main' style='width:100px;' name='tahun' required>
									<option value=''></option>
									";
										$tahunnow = date('Y')+1;
										for ($i=$tahunnow; $i >= 1980 ; $i--) {
											echo "
												<option value='$i'>$i</option>
											";
										}
									echo "
								</select>
								<select class='input_main'  style='width:190px;' name='bulan' required>
									<option value=''></option>
									";
										$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
										$monthlength=count($month2);

										for ($x=0; $x < 12; $x++) {
											$i=$x+1;
											echo "
												<option value='$i'>$month2[$x]</option>
											";
										}
									echo "
								</select>
								<select class='input_main' style='width:100px;' name='tanggal' required>
									<option value=''></option>
									";
										for ($i=1; $i <= 31 ; $i++) {
											if ($i<10) {
												$i='0'.$i;
											}
											echo "
											<option value='$i'>$i</option>
											";
										}
									echo "
								</select><br>
							";
						?>
						<a style='font-size:12px;'><i>*) wajib diisi</i></a>
					</div>
					<input style='margin-left:308px;' id='button_submit' class='submit_main' type='submit' value='Ajukan'>
				</form>
	<?php
			}
			else{
				echo"
					<a href='main?index=dde&action=create'><button class='submit_main fl' style='margin-top: 60px;margin-left:20px;'>TAMBAH DDE</button></a><br><br><br>
				";
			}
		}
		else{
			echo"
				<a href='main?index=dde&action=create'><button class='submit_main fl' style='margin-top: 60px;margin-left:20px;'>TAMBAH DDE</button></a><br><br><br>
			";
		}
	?>
	<div class='form_main' style='margin-top: 46px;'>
		<?php
			echo "
				<form name='fill' style='margin-bottom:0px;' action='main?index=dde' method='post' enctype='multipart/form-data'>
				<select class='input_main' name='tahun1' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
						<option value=''>Pilih Tahun</option>
						";
						$year=date('Y');
						for ($i=$year; $i > 1997; $i--) {
							if ($tahun1==$i) {
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
					<select class='input_main' name='bulan1' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
						<option value=''>Pilih Bulan</option>
						";
						$month=array('01','02','03','04','05','06','07','08','09','10','11','12');
						$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						$monthlength=count($month);
						for ($x=0; $x < $monthlength; $x++) {
							if ($month[$x]==$bulan1) {
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
					<select class='input_main' name='status' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
						<option value=''>Status</option>
						";
						$statusarray=array('process','closed','batal');
						$statuslength=count($statusarray);
						for ($x=0; $x < $statuslength; $x++) {
							if ($statusarray[$x]==$status) {
								echo "
								<option value='$statusarray[$x]' selected>$statusarray[$x]</option>
								";
							}
							else{
								echo "
								<option value='$statusarray[$x]'>$statusarray[$x]</option>
								";
							}
						}
						echo "
					</select>
					<select class='input_main' name='deprt' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
						<option value=''>Department</option>
						";
						$qq=mysqli_query($conn,"SELECT department.no, kode_department from department INNER JOIN dde ON (department.no = dde.no_department) GROUP BY department.no");
						while ($d = mysqli_fetch_array($qq)) {
							if ($deprt == $d['no']) {
								echo "
								<option value='$d[no]' selected>$d[kode_department]</option>
								";
							}
							else{
								echo "
								<option value='$d[no]'>$d[kode_department]</option>
								";
							}
						}
						echo "
					</select>
					<br>
					<select class='input_main' name='sort' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
						<option value=''>Sort By</option>
						";
						$sorttampil=array('No. DDE','Tanggal DDE','Department','Nama Dokumen','Sumber/Edisi/Tahun','Pengaju','Email Pengaju','Tanggal Kirim','Tanggal Terima','No. Copy','Bentuk Penyimpanan','Tanggal Kembali','Kode','Status','Keterangan','Tanggal Batal','Alasan Batal');
						$sortarray=array('no_dde','tgl_dde','department','nama_dokumen','sumber_edisi_tahun','pengaju','email_pengaju','tgl_kirim','tgl_terima','no_copy','bentuk_penyimpanan','tgl_kembali','kode','status','keterangan','tgl_batal','alasan_batal');
						$sortlength=count($sortarray);
						for ($x=0; $x < $sortlength; $x++) {
							if ($sortarray[$x]==$sortby) {
								echo "
								<option value='$sortarray[$x]' selected>$sorttampil[$x]</option>
								";
							}
							else{
								echo "
								<option value='$sortarray[$x]'>$sorttampil[$x]</option>
								";
							}
						}
						echo "
					</select>
					<select class='input_main' name='order' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
						<option value=''>Order By</option>
						";
						$orderarray=array('ASC','DESC');
						$orderlength=count($orderarray);
						for ($x=0; $x < $orderlength; $x++) {
							if ($orderarray[$x]==$orderby) {
								echo "
								<option value='$orderarray[$x]' selected>$orderarray[$x]</option>
								";
							}
							else{
								echo "
								<option value='$orderarray[$x]'>$orderarray[$x]</option>
								";
							}
						}
						echo "
					</select>
				</form>
			";
			
			if (isset($_GET['id'])) {
				$a=mysqli_query($conn, "SELECT * FROM dde INNER JOIN department WHERE dde.no_department = department.no AND no_dde='$id'");
				echo "
					<div class='alert_adm alert2'>id : $id<a href='main?index=dde' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
				";
			}
			else{
				if (isset($_GET['hal'])) {
					$hal=$_GET['hal'];
					$halurl='&hal='.$hal;
				}
				else{
					$hal = 1;
					$halurl='';
				}
				$awal=($hal-1)*10;
				$akhir=10;
				if(!isset($_POST['tahun']) or !isset($_POST['bulan']) or !isset($_POST['status']) or !isset($_POST['deprt'])) {
					$limit = "LIMIT $awal,$akhir";
				}
				else
				{$limit="";
				}
				$a=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter." ORDER BY ".$sort."  ".$limit."");
				$page1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no  ".$filter."");
				$page2=mysqli_num_rows($page1);
				$jumlah1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter."");
				$jumlah2=mysqli_num_rows($jumlah1);
				$process1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter." and status = 'process' ");
				$process2=mysqli_num_rows($process1);
				$closed1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter." and status = 'closed' ");
				$closed2=mysqli_num_rows($closed1);
				$batal1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter." and status = 'batal' ");
				$batal2=mysqli_num_rows($batal1);
				$page3=$page2/10;
				$page=floor($page3)+1;
				
				if(isset($_POST['sort'])){
					
				if ($_POST['sort'] != "" and $_POST['tahun'] == "" and $_POST['bulan'] == "" and $_POST['status'] == "" and $_POST['deprt'] == "") {
					$limit = "LIMIT $awal,$akhir";
					$a=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no ".$filter." ORDER BY ".$sort."  ".$limit."");
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
							echo "<td><a href='main?index=dde&hal=1$sorturl'>First</a></td>";
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Previous</a></td>";
						}
						else{
							$hal2=$hal-2;
							$hal3=$hal-1;
							echo "<td><a href='main?index=dde&hal=1$sorturl'>First</a></td>";
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($hal2>$page) {
							}
							elseif ($hal2==$hal) {
								echo"<td style='font-family:arial;color: black;'>$hal2</td>";
							}
							else {
								echo"<td><a href='main?index=dde&hal=$hal2$sorturl'>$hal2</a></td>";
							}
							$hal2++;
						}
						if ($hal<$page) {
							$hal3=$hal+1;
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Next</a></td>";
							echo "<td><a href='main?index=dde&hal=$page$sorturl'>Last</a></td>";
						}
						else{
							echo "<td>Next</a></td>";
							echo "<td>Last</a></td>";
						}
						echo "
						</tr>
					</table>";}
					
			}
			else
			{
				echo"<table class='page_number'>
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
							echo "<td><a href='main?index=dde&hal=1$sorturl'>First</a></td>";
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Previous</a></td>";
						}
						else{
							$hal2=$hal-2;
							$hal3=$hal-1;
							echo "<td><a href='main?index=dde&hal=1$sorturl'>First</a></td>";
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($hal2>$page) {
							}
							elseif ($hal2==$hal) {
								echo"<td style='font-family:arial;color: black;'>$hal2</td>";
							}
							else {
								echo"<td><a href='main?index=dde&hal=$hal2$sorturl'>$hal2</a></td>";
							}
							$hal2++;
						}
						if ($hal<$page) {
							$hal3=$hal+1;
							echo "<td><a href='main?index=dde&hal=$hal3$sorturl'>Next</a></td>";
							echo "<td><a href='main?index=dde&hal=$page$sorturl'>Last</a></td>";
						}
						else{
							echo "<td>Next</a></td>";
							echo "<td>Last</a></td>";
						}
						echo "
						</tr>
					</table>";
			}
					echo"
					<div class='alert_adm alert2'>Jumlah : $jumlah2 | Process : $process2 | Closed : $closed2 | Batal : $batal2</div>
				";
			}
			if (isset($alert)) {
				echo "<div class='alert_adm alert'>$alert</div>";
			}
			if (isset($alert2)) {
				echo "<div class='alert_adm alert2'>$alert2</div>";
			}
		?>
		<a href="excel/export.php?file=dde"><button id='download' class='button_download fl'>Export To Excel</button></a>
		<div class='cb'></div>
		<table id='tableID' class='table_admin'>
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal DDE</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Department</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama Dokumen</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Sumber/Edisi/Tahun</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kirim</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Terima</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Copy</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Bentuk Penyimpanan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kembali</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kode</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>File Attachment</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Batal</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Batal</td>
				<?php
					if (isset($_SESSION['username'])) {
						echo "
							<td colspan='2'>Action</td>
						";
					}
				?>
			</tr>
			<?php
				$rowscount=1;
				while ($c=mysqli_fetch_array($a)) {
					if ($rowscount % 2 == 1) {
						echo "
							<tr class='main_table odd'>
								";
									if ($c['status']=='closed') {
										echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									elseif ($c['status']=='batal') {
										echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									else {
										echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
								echo "
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_dde]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_dde]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode_department]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_dokumen]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[sumber_edisi_tahun]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_terima]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[bentuk_penyimpanan]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>
								";
									if ($c['nama_file']!='') {
										echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a>";
									}
									else{
										echo "no file";
									}
								echo "
								</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
								";
									if (isset($_SESSION['username'])) {
										echo "
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=dde&action=process&id=$c[no_dde]#popup'>
													process
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=dde&action=batal&id=$c[no_dde]#popup'>
													batal
												</a>
											</td>
										";
									}
								echo "
							</tr>
						";
					}
					elseif ($rowscount % 2 == 0) {
						echo "
							<tr class='main_table even'>
								";
									if ($c['status']=='closed') {
										echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									elseif ($c['status']=='batal') {
										echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									else {
										echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
								echo "
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_dde]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_dde]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode_department]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_dokumen]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[sumber_edisi_tahun]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_terima]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[bentuk_penyimpanan]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>
								";
									if ($c['nama_file']!='') {
										echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a>";
									}
									else{
										echo "no file";
									}
								echo "
								</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
								";
									if (isset($_SESSION['username'])) {
										echo "
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=dde&action=process&id=$c[no_dde]#popup'>
													process
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=dde&action=batal&id=$c[no_dde]#popup'>
													batal
												</a>
											</td>
										";
									}
								echo "
							</tr>
						";
					}
					$rowscount++;
				}
			?>
		</table>
	</div>
</div>
<div class='cb'></div>

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