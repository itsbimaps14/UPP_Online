<?php
	$hariini=date("Y-m-d");
	$thn=date("Y");
	$bln=date("m");
	if (isset($_POST['status'])) {
		$status=$_POST['status'];
	}
	elseif (isset($_GET['filter'])) {
		$status=$_GET['filter'];
	}
	else{
		$status='';
	}
	if ($status!='') {
		$filter="ddd.status = '".$status."'";
		$filterurl='&filter='.$status;
	}
	else{
		$filter="ddd.status != ''";
		$filterurl='';
	}
	if (isset($_POST['tahun'])) {
		$tahun=$_POST['tahun'];
		if ($tahun!='') {
			$filter.=" AND tahun = '".$tahun."'";
			if (isset($_POST['bulan'])) {
				$bulan=$_POST['bulan'];
				if ($bulan!='') {
					$filter.=" AND bulan = '".$bulan."'";
				}
			}
			else{
				$bulan = '';
			}
		}
	}
	else{
		$tahun = '';
		$bulan = '';
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
			$sort="no_ddd DESC";
			$sortby='';
			$sorturl='';
		}
	}
	else{
		$sort="no_ddd DESC";
		$sortby='';
		$sorturl='';
	}
	if (isset($_POST['divisi'])) {
		$divisi=$_POST['divisi'];
	}
	elseif (isset($_GET['divisi'])) {
		$divisi=$_GET['divisi'];
	}
	else{
		$divisi='';
	}
	if (isset($_POST['prosedur'])) {
		$prosedur=$_POST['prosedur'];
	}
	elseif (isset($_GET['prosedur'])) {
		$prosedur=$_GET['prosedur'];
	}
	else{
		$prosedur='';
	}
	if (isset($_POST['jenis'])) {
		$jenis=$_POST['jenis'];
	}
	elseif (isset($_GET['jenis'])) {
		$jenis=$_GET['jenis'];
	}
	else{
		$jenis='';
	}
	if (isset($_POST['detail'])) {
		$detail=$_POST['detail'];
	}
	elseif (isset($_GET['detail'])) {
		$detail=$_GET['detail'];
	}
	else{
		$detail='';
	}
	if (isset($_POST['folder'])) {
		$folder=$_POST['folder'];
	}
	elseif (isset($_GET['folder'])) {
		$folder=$_GET['folder'];
	}
	else{
		$folder='';
	}
	$pengaju=$email_pengaju=$jumlah_copy=$lokasi_penyimpanan=$jenis_ddd=$pic_penyimpanan='';
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'process':

				$a = mysqli_query($conn, "SELECT * FROM ddd WHERE no_ddd = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					mysqli_query($conn, "UPDATE ddd SET 
						status = 'waiting'
						WHERE 
						no_ddd = '$id'
					");
					for ($i=0; $i < $c['jumlah_copy']; $i++) {
						$nomor = $i + 1;
						if ($nomor < 10) {
							$nomor = '0'.$nomor;
						}
						mysqli_query($conn, "INSERT INTO ddd_s2 (
							no_ddd,
							no_prosedur,
							nomor_copy,
							lokasi_penyimpanan,
							jenis_penyimpanan,
							pic_penyimpanan,
							keterangan,
							ddd2_no_revisi)
							VALUES(
							'$id',
							'$c[no_prosedur]',
							'$nomor',
							'$c[lokasi_penyimpanan]',
							'$c[jenis_penyimpanan]',
							'$c[pic_penyimpanan]',
							'$c[keterangan]',
							'$c[ddd_no_revisi]')");
					}

					header("location:main?index=ddd_db");
				}
					
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form DDD User
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:auto;'>
							<form action='main?index=ddd&action=process&id=$id' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>
									<center>
										<a style='font-size:14px;'>Lanjutkan Proses DDD dengan No : $id <br>Jika iya klik button dibawah ini.</a><br><br>
										<input style='margin-left:0px;' class='submit_main' type='submit' value='Process'>
									</center>
								</div>
							</form>
						</div>
					</div>
				";
			break;

			case 'batal':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_batal=test($_POST['tgl_batal']);
					$alasan=test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE ddd 	SET tgl_batal = '$tgl_batal',
												alasan_batal = '$alasan',
												status = 'batal'
												WHERE 	no_ddd = '$id'
												")){

						$a=mysqli_query($conn, "SELECT * FROM ddd 
							inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
							inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
							inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
							inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
							inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
							WHERE no_ddd ='$id'");

						$c=mysqli_fetch_array($a);

						$email=$c['email_pengaju'];
						$to 	  =	"$email";
						$subject  =	"PROSEDUR ONLINE | DISTRIBUDI DOKUMEN HARDCOPY";
						$headers  = array ('From' => $from,
						'To' => $to,
						'subject' => $subject,
						"MIME-Version"=>"1.0",
						"Content-type"=>"text/html"
						);
						$message  =	"<html><body>";
						$message .=	"<strong>Dear " . strip_tags($c['pengaju']) . ",</strong><br><br><br>";
						$message .=	"<strong>Berikut kami sampaikan Permintaan Distribusi Dokumen Hardcopy dengan detail sebagai berikut</strong><br><br>";
						$message .=	"<table rules='all' style='border: 1px solid #666;' cellpadding='10'>";
						$message .=	"<tr style='background: #eee;'><td><strong>No. DDD:</strong> </td><td>" . strip_tags($c['no_ddd']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal DDD:</strong> </td><td>" . strip_tags($c['tgl_ddd']) . "</td></tr>";
						$message .=	"<tr><td><strong>Divisi:</strong> </td><td>" . strip_tags($c['divisi_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Prosedur:</strong> </td><td>" . strip_tags($c['master_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Kategori:</strong> </td><td>" . strip_tags($c['jenis_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Detail:</strong> </td><td>" . strip_tags($c['detail_prosedur']) . "</td></tr>";
						$message .=	"<tr><td><strong>Nama File:</strong> </td><td>" . strip_tags($c['nama_folder']) . "</td></tr>";
						$message .=	"<tr><td><strong>Jumlah Copy:</strong> </td><td>" . strip_tags($c['jumlah_copy']) . "</td></tr>";
						$message .=	"<tr><td><strong>Lokasi Penyimpanan:</strong> </td><td>" . strip_tags($c['lokasi_penyimpanan']) . "</td></tr>";
						$message .=	"<tr><td><strong>PIC Penyimpanan:</strong> </td><td>" . strip_tags($c['no_copy_master']) . " - " . strip_tags($c['penerima']) . "</td></tr>";
						$message .=	"<tr><td><strong>Tanggal Batal:</strong> </td><td>" . strip_tags($c['tgl_batal']) . "</td></tr>";
						$message .=	"<tr><td><strong>Alasan Batal:</strong> </td><td>" . strip_tags($c['alasan_batal']) . "</td></tr>";
						$message .= "</table>";
						$message .= "<br><strong>Permintaan Distribusi Dokumen Hardcopy anda telah di batalkan, untuk melihat permintaan silahkan akses <a href='http://prosedur_online/main?index=ddd&id=".strip_tags($id)."'>Go To DDD</a><br><br><br>";
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
						header('location:main?index=ddd');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Batal
						</div>
						<div class='form_process'>
							<form action='main?index=ddd&action=batal&id=$id' method='post'>
								<a class='j_input_main'>No. DDD</a><br>
								<input class='input_main' type='text' name='no_ddd' value='$id' required style='background-color:#e7e7e7;width:100%;' readonly><br>
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

			case 'closed':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					mysqli_query($conn, "UPDATE ddd SET status = 'closed' WHERE no_ddd = '$id'");
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Closed
						</div>
						<div class='form_process'>
							<form action='main?index=ddd&action=closed&id=$id' method='post'>
								<center>
									<a class='j_input_main'>Close DDD No : $id</a><br>
									<br><input style='margin-left:0px;' class='submit_main' type='submit' value='Yes'>
								</center>
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
	<div class='judul_main' style='position: fixed;'>Distribusi Dokumen Hardcopy | Index</div>
	<?php
		if(isset($_GET['step'])){
			if($_GET['step']=='create'){
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi_prosedur=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis_prosedur=test($_POST['jenis']);
					$detail_prosedur=test($_POST['detail']);
					$nama_folder=test($_POST['folder']);
					$tgl_ddd=test($_POST['tgl_ddd']);
					$pengaju=test($_POST['pengaju']);
					$email_pengaju=test($_POST['email_pengaju']);
					$jumlah_copy=test($_POST['jumlah_copy']);
					$lokasi_penyimpanan=test($_POST['lokasi_penyimpanan']);
					$jenis_ddd=test($_POST['jenis_ddd']);
					$pic_penyimpanan=test($_POST['pic_penyimpanan']);
					if ($divisi_prosedur!='' && $prosedur!='' && $jenis_prosedur!='' && $nama_folder!='' && $pengaju!='' && $jumlah_copy!='' && $lokasi_penyimpanan!='' && $pic_penyimpanan!='') {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi_prosedur' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis_prosedur' AND nama_folder = '$nama_folder'");
						$e=mysqli_fetch_array($d);

						$no_prosedur=$e['no_prosedur'];
						if ($no_prosedur!=0) {
							if ($a=mysqli_query($conn, "INSERT INTO ddd (tgl_ddd,tahun,bulan,pengaju,email_pengaju,no_prosedur,jumlah_copy,lokasi_penyimpanan,jenis_penyimpanan,pic_penyimpanan,ddd_no_revisi)
								VALUES ('$tgl_ddd','$thn','$bln','$pengaju','$email_pengaju','$no_prosedur','$jumlah_copy','$lokasi_penyimpanan','$jenis_ddd','$pic_penyimpanan','$e[no_revisi]')
								")) {
								$alert2='pengajuan berhasil';
								echo "
									<div id='popup_done' class='popup'>
										<a href='main?index=ddd'>
											<div class='popup_exit'></div>
										</a>
										<div class='popup_upp'>
											<a href='main?index=ddd' class='close-button' title='close'>X</a>
											UPP ONLINE<br>
											";
												if (isset($alert)) {
													echo "<span style='font-size:15px;'>$alert</span>";
												}
												else{
													echo "<span style='font-size:15px;'>Permintaan Distribusi Dokumen Hardcopy Anda Telah Terkirim</span><br>";
												}
											echo "
										</div>
									</div>
								";
							}
							else{
								$alert='pengajuan gagal ada yang error: '.mysqli_errno($conn).' - '.mysqli_error($conn);
							}
						}
					}
				}
	?>
				<form action='main?index=ddd&step=create#popup_done' method='post'  enctype='multipart/form-data'>
					<div class='form_main' style='margin-top: 46px;'>
						<?php
							if (isset($alert)) {
								echo "<div class='alert_adm alert'>$alert</div>";
							}
							if (isset($alert2)) {
								echo "<div class='alert_adm alert2'>$alert2</div>";
							}
							echo "
								<a class='j_input_main'>Tanggal DDD *</a><br>
								<input class='input_main readonly' type='text' name='tgl_ddd' value='$hariini' readonly required><br>
								<a class='j_input_main'>Pengaju *</a><br>
								<input class='input_main' type='text' name='pengaju' value='$pengaju' required><br>
								<a class='j_input_main'>Email Pengaju *</a><br>
								<input class='input_main' type='email' name='email_pengaju' value='$email_pengaju' required><br>
								<a class='j_input_main'>Divisi Prosedur *</a><br>
								<select class='input_main' name='divisi' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur group by divisi_prosedur.divisi_prosedur order by divisi_prosedur.divisi_prosedur");
										while ($c=mysqli_fetch_array($a)) {
											if ($divisi_prosedur==$c['no_divisi_prosedur']) {
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
								</select><br>
								<a class='j_input_main'>Prosedur *</a><br>
								<select class='input_main' name='prosedur' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur where prosedur.no_divisi_prosedur='$divisi' group by master_prosedur.master_prosedur order by master_prosedur.master_prosedur");
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
								</select><br>
								<a class='j_input_main'>Kategori Prosedur *</a><br>
								<select class='input_main' name='jenis' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur where prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' group by jenis_prosedur.jenis_prosedur order by jenis_prosedur.jenis_prosedur");
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
								</select><br>
								<a class='j_input_main'>Detail Kategori</a><br>
								<select class='input_main' name='detail' onchange='this.form.submit()'>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' group by detail_prosedur order by detail_prosedur");
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
								</select><br>
								<a class='j_input_main'>Nama File *</a><br>
								<select class='input_main' name='folder' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' group by nama_folder order by nama_folder");
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
								</select><br>
								<a class='j_input_main'>Jumlah Copy *</a><br>
								<input class='input_main' type='text' name='jumlah_copy' value='$jumlah_copy' required><br>
								<a class='j_input_main'>Lokasi Penyimpanan *</a><br>
								<input class='input_main' type='text' name='lokasi_penyimpanan' value='$lokasi_penyimpanan' required><br>
								<a class='j_input_main'>Kategori *</a><br>
								<label>
									";
										if ($jenis_ddd=='internal') {
											echo "
												<input class='radio_main' type='radio' name='jenis_ddd' value='internal' onchange='this.form.submit()' checked required> Internal
											";
										}
										else {
											echo "
												<input class='radio_main' type='radio' name='jenis_ddd' value='internal' onchange='this.form.submit()' required> Internal
											";
										}
									echo "
								</label>
								<label>
									";
										if ($jenis_ddd=='eksternal') {
											echo "	
												<input class='radio_main' type='radio' name='jenis_ddd' value='eksternal' onchange='this.form.submit()' checked> Eksternal
											";
										}
										else {
											echo "	
												<input class='radio_main' type='radio' name='jenis_ddd' value='eksternal' onchange='this.form.submit()'> Eksternal
											";
										}
									echo "
								</label>
								<br>
								<a class='j_input_main'>PIC Penyimpanan *</a><br>
								<select class='input_main' name='pic_penyimpanan' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from master_ddd where jenis_ddd='$jenis_ddd' order by no_copy_master");
										while ($c=mysqli_fetch_array($a)) {
											if ($pic_penyimpanan==$c['no_master_ddd']) {
												echo "
													<option value='$c[no_master_ddd]' selected>$c[no_copy_master] - $c[penerima]</option>
												";
											}
											else{
												echo "
													<option value='$c[no_master_ddd]'>$c[no_copy_master] - $c[penerima]</option>
												";
											}
										}
									echo "
								</select><br>
								<a style='font-size:12px;'><i>*) wajib diisi</i></a>
							";
						?>
					</div>
					<input style='margin-left:308px;' id='button_submit' class='submit_main' type='submit' value='Input'>
				</form>
	<?php
			}
			else{
				echo"
					<a href='main?index=ddd&step=create'><button class='submit_main fl' style='margin-top: 60px;margin-left:20px;'>TAMBAH DDD</button></a><br><br><br>
				";
			}
		}
		else{
			if (isset($_SESSION['username']) AND $_SESSION['level'] == 'admin') {
				echo "
					<a href='main?index=ddd&step=create'><button class='submit_main fl' style='margin-top: 60px;margin-left:120px; color:black; background:#fff6bc;'>TAMBAH DDD</button></a>
					<a href='main?index=ddd_db'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>DATABASE DDD</button></a>
					<a href='main?index=ddd_pd'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>PENGIRIMAN DOKUMEN</button></a>
					<a href='main?index=ddd_mm'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>MASTER DB DDD</button></a><br><br><br>
				";
			}
			else{
				echo"
					<a href='main?index=ddd&step=create'><button class='submit_main fl' style='margin-top: 60px;margin-left:120px; color:black; background:#fff6bc;'>TAMBAH DDD</button></a>
					<button class='submit_main fl' style='margin-top: 60px;margin-left:80px;cursor:default;'>DATABASE DDD</button>
					<button class='submit_main fl' style='margin-top: 60px;margin-left:80px;cursor:default;'>PENGIRIMAN DOKUMEN</button>
					<button class='submit_main fl' style='margin-top: 60px;margin-left:80px;cursor:default;'>MASTER DB DDD</button><br><br><br>
				";
			}
		}
	?>
	<div class='form_main' style='margin-top: 46px;'>
		<?php
			echo "
				<form style='margin-bottom:0px;' action='main?index=ddd' method='post' enctype='multipart/form-data'>
					<select class='input_main' name='divisi' style='width:200px;margin:0px;' onchange='this.form.submit()'>
						<option value=''>Pilih Divisi Prosedur</option>
						";
							$a=mysqli_query($conn, "SELECT * from ddd 
								inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
								inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
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
							$a=mysqli_query($conn, "SELECT * from ddd 
								inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
								inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
								where prosedur.no_divisi_prosedur='$divisi' 
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
							$a=mysqli_query($conn, "SELECT * from ddd 
								inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
								inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
								where prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' 
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
							$a=mysqli_query($conn, "SELECT * from ddd 
								inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
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
							$a=mysqli_query($conn, "SELECT * from ddd 
								inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
								where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' 
								group by nama_folder 
								order by nama_folder");
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
					<br>
					<br>
					<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
						<option value=''>Pilih Tahun</option>
						";
						$year=date('Y');
						for ($i=$year; $i > 1997; $i--) {
							if ($tahun==$i) {
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
					<select class='input_main' name='bulan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
						<option value=''>Pilih Bulan</option>
						";
						$month=array('01','02','03','04','05','06','07','08','09','10','11','12');
						$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						$monthlength=count($month);
						for ($x=0; $x < $monthlength; $x++) {
							if ($month[$x]==$bulan) {
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
					<br>
					<select class='input_main' name='sort' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
						<option value=''>Sort By</option>
						";
						$sorttampil=array('No. DDD','Tanggal DDD','Pengaju','Email Pengaju','Prosedur','Jenis Prosedur','Nama File Prosedur','Jumlah Copy','Lokasi Penyimpanan','PIC Penyimpanan','Tanggal Kirim','Tanggal Terima','Tanggal Kembali','No. SPD','No. Copy Awal','No. Copy Akhir','Keterangan','Status','Tanggal Batal','Alasan Batal');
						$sortarray=array('no_ddd','tgl_ddd','pengaju','email_pengaju','prosedur','prosedur2','prosedur3','jumlah_copy','lokasi_penyimpanan','pic_penyimpanan','tgl_kirim','tgl_terima','tgl_kembali','no_spd','no_copy_awal','no_copy_akhir','keterangan','status','tgl_batal','alasan_batal');
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
			if ($divisi != '') {
				if ($prosedur != '') {
					if ($jenis != '') {
						if ($detail != '') {
							if ($folder != '') {
								$filter.="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis'  AND detail_prosedur='$detail' AND nama_folder='$folder'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder;
							}
							else{
								$filter.="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis' AND detail_prosedur='$detail'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail;
							}
						}
						elseif ($folder != '') {
							$filter.="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis' AND nama_folder='$folder'";
							$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder;
						}
						else{
							$filter.="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis'";
							$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis;
						}
					}
					else{
						$filter.="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur'";
						$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur;
					}
				}
				else{
					$filter.="AND prosedur.no_divisi_prosedur='$divisi'";
					$filterurl='&divisi='.$divisi;
				}
			}

			if (isset($_GET['id'])) {
				$a=mysqli_query($conn, "SELECT * FROM ddd 
					inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no_ddd='$id'");
				echo "
					<div class='alert_adm alert2'>id : $id<a href='main?index=ddd' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
				";
			}

			elseif ($tahun!='') {

				$a=mysqli_query($conn, "SELECT * FROM ddd 
					inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE ".$filter." ORDER BY ".$sort);

				$page1=mysqli_query($conn, "SELECT * FROM ddd 
					inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE ".$filter);

				$page2=mysqli_num_rows($page1);

				echo "
					<div class='alert_adm alert2'>Jumlah : $page2</div>
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

				$a=mysqli_query($conn, "SELECT * FROM ddd 
					inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");

				$page1=mysqli_query($conn, "SELECT * FROM ddd 
					inner join master_ddd on ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE ".$filter);

				$page2=mysqli_num_rows($page1);
				$jumlah1=mysqli_query($conn, "SELECT * FROM ddd");
				$jumlah2=mysqli_num_rows($jumlah1);
				$process1=mysqli_query($conn, "SELECT * FROM ddd WHERE status = 'process' ");
				$process2=mysqli_num_rows($process1);
				$closed1=mysqli_query($conn, "SELECT * FROM ddd WHERE status = 'closed' ");
				$closed2=mysqli_num_rows($closed1);
				$batal1=mysqli_query($conn, "SELECT * FROM ddd WHERE status = 'batal' ");
				$batal2=mysqli_num_rows($batal1);
				$page3=$page2/10;
				$page=floor($page3)+1;
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
							echo "<td><a href='main?index=ddd&hal=1$sorturl$filterurl'>First</a></td>";
							echo "<td><a href='main?index=ddd&hal=$hal3$sorturl$filterurl'>Previous</a></td>";
						}
						else{
							$hal2=$hal-2;
							$hal3=$hal-1;
							echo "<td><a href='main?index=ddd&hal=1$sorturl$filterurl'>First</a></td>";
							echo "<td><a href='main?index=ddd&hal=$hal3$sorturl$filterurl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($hal2>$page) {
							}
							elseif ($hal2==$hal) {
								echo"<td style='font-family:arial;color: black;'>$hal2</td>";
							}
							else {
								echo"<td><a href='main?index=ddd&hal=$hal2$sorturl$filterurl'>$hal2</a></td>";
							}
							$hal2++;
						}
						if ($hal<$page) {
							$hal3=$hal+1;
							echo "<td><a href='main?index=ddd&hal=$hal3$sorturl$filterurl'>Next</a></td>";
							echo "<td><a href='main?index=ddd&hal=$page$sorturl$filterurl'>Last</a></td>";
						}
						else{
							echo "<td>Next</a></td>";
							echo "<td>Last</a></td>";
						}
						echo "
						</tr>
					</table>
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
		
		<a href="excel/export.php?file=ddd"><button id='download' class='button_download fl'>Export To Excel</button></a>
		<div class='cb'></div>
		<table id='tableID' class='table_admin'>
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal DDD</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Divisi Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Jenis Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Detail Kategori</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama File</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No Revisi</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Jumlah Copy</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Lokasi Penyimpanan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>PIC Penyimpanan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Keterangan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Batal</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Batal</td>
				<?php
					if (isset($_SESSION['username'])) {
						echo "
							<td colspan='3'>Action</td>
						";
					}
				?>
			</tr>
		<?php
			$rowscount=1;
			while ($c=mysqli_fetch_array($a)) {
				$d=mysqli_query($conn, "SELECT * FROM ddd where no_ddd = '$c[no_ddd]'");
				$f=mysqli_fetch_array($d);
				if ($rowscount % 2 == 1) {
					echo "
						<tr class='main_table odd'>
							";
								if ($f['status']=='closed') {
									echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='batal') {
									echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='waiting') {
									echo "<td style='background:green;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								else {
									echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
							echo "
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_ddd]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_ddd]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[ddd_no_revisi]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jumlah_copy]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[lokasi_penyimpanan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_penyimpanan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy_master] - $c[penerima]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keterangan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
							";
								if (isset($_SESSION['username']) AND $f['status'] == 'process') {
									echo "
										<td>
											<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=process&id=$c[no_ddd]#popup'>
												process
											</a>
										</td>
										<td>
											<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=batal&id=$c[no_ddd]#popup'>
												batal
											</a>
										</td>
									";
								}
								elseif (isset($_SESSION['username']) AND $f['status'] != 'process') {
									echo "
										<td>
											process
										</td>
										<td>
											batal
										</td>
									";
								}
							echo "
							<td>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=closed&id=$c[no_ddd]#popup'>
									closed
								</a>
							</td>
						</tr>
					";
				}
				elseif ($rowscount % 2 == 0) {
					echo "
						<tr class='main_table even'>
							";
								if ($f['status']=='closed') {
									echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='batal') {
									echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='waiting') {
									echo "<td style='background:green;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								else {
									echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
							echo "
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_ddd]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_ddd]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[ddd_no_revisi]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jumlah_copy]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[lokasi_penyimpanan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_penyimpanan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy_master] - $c[penerima]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keterangan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
							";
								if (isset($_SESSION['username']) AND $f['status'] == 'process') {
									echo "
										<td>
											<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=process&id=$c[no_ddd]#popup'>
												process
											</a>
										</td>
										<td>
											<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=batal&id=$c[no_ddd]#popup'>
												batal
											</a>
										</td>
									";
								}
								elseif (isset($_SESSION['username']) AND $f['status'] != 'process') {
									echo "
										<td>
											process
										</td>
										<td>
											batal
										</td>
									";
								}
							echo "
							<td>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd&action=closed&id=$c[no_ddd]#popup'>
									closed
								</a>
							</td>
						</tr>
					";
				}
				$rowscount++;
			}
			echo "
				</table>
			";
		?>
	</div>
</div>
<div class='cb'></div>