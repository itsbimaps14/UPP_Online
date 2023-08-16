<script>
	window.onload = function(){
		document.getElementById('ugg1').style.display = "none";
		document.getElementById('ubr1').style.display = "none";
		document.getElementById('ugg2').style.display = "none";
		document.getElementById('ubr2').style.display = "none";
	}
	
	function valid1(file) {
	    var FileSize = file.files[0].size / 1024 / 1024; // in MB
	    if (FileSize > 2) {
			document.getElementById('ubr1').style.display = "none";
			document.getElementById('ugg1').style.display = "block";
			document.getElementById('tod').style.display = "none";
		} else {
			document.getElementById('ugg1').style.display = "none";
			document.getElementById('ubr1').style.display = "block";
			document.getElementById('tod').style.display = "block";
		}
	}

	function valid2(file) {
		var FileSize = file.files[0].size / 1024 / 1024; // in MB
		if (FileSize > 2) {
			document.getElementById('ubr2').style.display = "none";
			document.getElementById('ugg2').style.display = "block";
			document.getElementById('dot').style.display = "none";
		} else {
			document.getElementById('ugg2').style.display = "none";
			document.getElementById('ubr2').style.display = "block";
			document.getElementById('dot').style.display = "block";
		}
	}
</script>
<?php
	$awal=0;
	$hariini=date("Y-m-d");
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
	if (isset($_POST['search'])) {
		$search=$_POST['search'];
	}
	elseif (isset($_GET['search'])) {
		$search=$_GET['search'];
	}
	else{
		$search='';
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi_prosedur=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis_prosedur=test($_POST['jenis']);
					$detail_prosedur=test($_POST['detail']);
					$nama_folder=test($_POST['folder']);
					$no_revisi=test($_POST['no_revisi']);
					$tgl=test($_POST['tgl']);
					$file_prosedur = $_FILES['file_prosedur']['name'];

					if ($divisi_prosedur!='' && $prosedur!='' && $jenis_prosedur!='' && $nama_folder!='' && $file_prosedur!='' && $no_revisi!='') {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi_prosedur' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis_prosedur' AND nama_folder = '$nama_folder'");
						$e=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);
						
						if ($file_prosedur!='') {

							// File Divisi Prosedur
							$y = mysqli_query($conn, "SELECT * FROM divisi_prosedur WHERE no_divisi_prosedur = '$divisi_prosedur'");
							$x = mysqli_fetch_array($y);
							$tmp_div_pro = $x['nf_prosedur'];
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro);
							}

							// File Master Prosedur
							$y = mysqli_query($conn, "SELECT * FROM master_prosedur WHERE no_master_prosedur = '$prosedur'");
							$x = mysqli_fetch_array($y);
							$tmp_mas_pro = $x['nm_prosedur'];
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro);
							}

							// File Jenis Prosedur
							$y = mysqli_query($conn, "SELECT * FROM jenis_prosedur WHERE no_jenis_prosedur = '$jenis_prosedur'");
							$x = mysqli_fetch_array($y);
							$tmp_jen_pro = $x['nf_jprosedur'];
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro);
							}

							// Nama Folder
							if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder)) {
								mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder);
							}
							
							$folder1 = 'file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder.'/';
							$file_prosedur1 = $_FILES['file_prosedur']['name'];
							$file_prosedur2 = test($file_prosedur1);
							$tmp_file_prosedur = $_FILES['file_prosedur']['tmp_name'];
							$file_prosedur = $folder1.$file_prosedur1;
							$file_prosedur_rename = $folder1.$file_prosedur2;

							if ($f>0) {
								// File Divisi Prosedur
								if (!file_exists('file_upload/prosedur/'.$tmp_div_pro)) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro);
								}

								// File Master Prosedur
								if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro)) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro);
								}

								// File Jenis Prosedur
								if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro)) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro);
								}

								// Nama Folder
								if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder)) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder);
								}

								// Nama Revisi Folder
								if (!file_exists('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder.'/revisi')) {
									mkdir('file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder.'/revisi');
								}

								$folder2 = 'file_upload/prosedur/'.$tmp_div_pro.'/'.$tmp_mas_pro.'/'.$tmp_jen_pro.'/'.$nama_folder.'/revisi/';

								mysqli_query($conn, "INSERT INTO un_prosedur
									SELECT * FROM prosedur 
									WHERE
									no_divisi_prosedur = '$divisi_prosedur' AND
									no_master_prosedur = '$prosedur' AND
									no_jenis_prosedur = '$jenis_prosedur' AND
									nama_folder = '$nama_folder'
									");

								$query=mysqli_query($conn, "SELECT * FROM prosedur WHERE
									no_divisi_prosedur = '$divisi_prosedur' AND
									no_master_prosedur = '$prosedur' AND
									no_jenis_prosedur = '$jenis_prosedur' AND
									nama_folder = '$nama_folder'
									");

								while ($tmp_c=mysqli_fetch_array($query)) {
									$nm_file_tmp = $tmp_c['no_revisi'].'_'.$tmp_c['judul_file'];
									$nm1_file_tmp = $tmp_c['nama_file'];
								}

								$nm_bksfile = $folder2.$nm_file_tmp;

								$a=mysqli_query($conn, "UPDATE un_prosedur SET
									nama_file = '$nm_bksfile',
									judul_file = '$nm_file_tmp'
									WHERE
									no_revisi = $no_revisi - 1 AND
									no_divisi_prosedur = '$divisi_prosedur' AND
									no_master_prosedur = '$prosedur' AND
									no_jenis_prosedur = '$jenis_prosedur' AND
									nama_folder = '$nama_folder'
									");
								rename($nm1_file_tmp, $nm_bksfile);

								//unlink($e['nama_file']);
							}

							if (move_uploaded_file($tmp_file_prosedur, $file_prosedur)) {
								rename($file_prosedur, $file_prosedur_rename);
								if ($f>0) {

									$a=mysqli_query($conn, "UPDATE prosedur SET no_revisi = '$no_revisi',
																				tgl_revisi = '$tgl',
																				judul_file = '$file_prosedur1',
																				nama_file = '$file_prosedur_rename'
																				WHERE
																				no_divisi_prosedur = '$divisi_prosedur' AND
																				no_master_prosedur = '$prosedur' AND
																				no_jenis_prosedur = '$jenis_prosedur' AND
																				nama_folder = '$nama_folder'
																				");
								}
								else{
									$a=mysqli_query($conn, "INSERT INTO prosedur (no_divisi_prosedur,no_master_prosedur,no_jenis_prosedur,detail_prosedur,nama_folder,no_revisi,tgl_revisi,judul_file,nama_file)
																		VALUES	('$divisi_prosedur','$prosedur','$jenis_prosedur','$detail_prosedur','$nama_folder','$no_revisi','$tgl','$file_prosedur1','$file_prosedur_rename')");
								}
								header('location:main?index=prosedur');
							}
							else {
								$alert='upload file gagal';
							}
						}
					}
				}
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
					
						<a href='main?index=prosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px;' >
							Tambah Prosedur
						</div>
						<div class='form_process' >
							<form action='main?index=prosedur&action=tambah#popup' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Divisi Prosedur</a><br>
								<select class='input_main' name='divisi' style='width:100%;' onchange='this.form.submit()' required autofocus>
										<option value=''>Pilih Divisi Prosedur</option>
										";
											$a=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
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
								</select><br>
								<a class='j_input_main'>Prosedur</a><br>
								<select class='input_main' name='prosedur' style='width:100%;' onchange='this.form.submit()' required>
										<option value=''>Pilih Master Prosedur</option>
										";
											$a=mysqli_query($conn, "SELECT * from master_prosedur order by master_prosedur");
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
								<a class='j_input_main'>Kategori Prosedur</a><br>
								<select class='input_main' name='jenis' style='width:100%;' onchange='this.form.submit()' required>
										<option value=''>Pilih Kategori Prosedur</option>
										";
											$a=mysqli_query($conn, "SELECT * from jenis_prosedur order by jenis_prosedur");
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
								<input class='input_main' type='input' name='detail' placeholder='Detail Kategori' value='$detail' style='width:100%;'  onchange='this.form.submit()'><br>
								<a class='j_input_main'>Nama File Prosedur</a><br>
								";
									$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
									$e=mysqli_fetch_array($d);
									$f=mysqli_num_rows($d);
									if ($f=='0') {
										$no_revisi='1';
										echo "<div class='alert_adm alert' style='width:94%;'>Nama File Prosedur Belum Ada</div>";
									}
									else{
										$no_revisi=$e['no_revisi']+1;
									}
								echo "
								<input class='input_main' type='input' name='folder' placeholder='Nama File Prosedur' value='$folder' style='width:100%;'  onchange='this.form.submit()' required><br>
								<a class='j_input_main'>File Prosedur <font size='1' color='red'> ) Max File Size = 1MB</font></a><br>
								<input class='file_main' type='file' name='file_prosedur' onchange='valid1(this)' required><br>
								<div class='alert_adm alert' id='ugg1' style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id='ubr1' style='width:94%;'>File is OK !</div>";?>
								<script>
									window.onload = function(){
										document.getElementById('ugg1').style.display = "none";
										document.getElementById('ubr1').style.display = "none";}
								</script>
								<?php echo "
								<a class='j_input_main'>No. Revisi</a><br>
								<input class='input_main' type='input' name='no_revisi' placeholder='No. Revisi' value='$no_revisi' style='width:100%;' required><br>
								<a class='j_input_main'>Tanggal</a><br>
								<input class='input_main' type='input' name='tgl'  value='$hariini' style='width:100%;' maxlength='10' required>
								<font style='margin-left:10px; margin-top:-20px; font-size:11px;'>note : tahun-bulan-tanggal</font><br>";
								echo"<br>
								<input style='margin-left:5px;' class='submit_main fl' id='tod' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'ubahaktif':
				$status = $_GET['status'];
				$id=$_GET['id'];
				if ($status=='aktif') {
					$a=mysqli_query($conn, "UPDATE prosedur SET status='tidak aktif' WHERE no_prosedur=$id  ");
					header('location:main?index=prosedur');
				}
				elseif ($status=='tidak aktif') {
					$a=mysqli_query($conn, "UPDATE prosedur SET status='aktif' WHERE no_prosedur=$id  ");
					header('location:main?index=prosedur');
				}
				break;
			case 'hapus':
				$id=$_GET['id'];
				$unlink=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_prosedur=$id");
				$unlink2=mysqli_fetch_array($unlink);
				if(unlink($unlink2['nama_file'])){
					$a=mysqli_query($conn, "DELETE FROM prosedur WHERE no_prosedur=$id");
					header('location:main?index=prosedur');
				}
				break;
			case 'edit':
				$id=$_GET['id'];
				$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_prosedur = '$id'");
				$e=mysqli_fetch_array($d);
				$f=mysqli_num_rows($d);
				$divisi_prosedur=$e['no_divisi_prosedur'];
				$prosedur=$e['no_master_prosedur'];
				$jenis_prosedur=$e['no_jenis_prosedur'];
				$detail_prosedur=$e['detail_prosedur'];
				$nama_folder=$e['nama_folder'];
				$no_revisi=$e['no_revisi'];
				$tgl=$e['tgl_revisi'];
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi_prosedur=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis_prosedur=test($_POST['jenis']);
					$detail_prosedur=test($_POST['detail']);
					$nama_folder=test($_POST['folder']);
					$no_revisi=test($_POST['no_revisi']);
					$tgl=test($_POST['tgl']);
					$file_prosedur = $_FILES['file_prosedur']['name'];
					$file_fmea = $_FILES['file_fmea']['name'];

					if ($divisi_prosedur!='' && $prosedur!='' && $jenis_prosedur!='' && $nama_folder!='' && $no_revisi!='') {
						$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$divisi_prosedur' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis_prosedur' AND nama_folder = '$nama_folder'");
						$ez=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);

						if ($file_fmea!='') {
							$path = pathinfo($e['file_fmea']);
							$fol = $path['dirname'];	
							$fol = $fol.'/';
							$file_user1 = $_FILES['file_fmea']['name'];
							$file_user2 = test($file_user1);
							$tmp_file_user = $_FILES['file_fmea']['tmp_name'];
							$file_fmea_user = $fol.$file_user1;
							$file_fmea_rename = $fol.$file_user2;

							if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
								rename($file_fmea_user, $file_fmea_rename);
								mysqli_query($conn, "UPDATE prosedur SET
									file_fmea = '$file_fmea_rename'
									WHERE no_prosedur = '$id'
									");
							}
						}
						
						if ($file_prosedur!='') {
							$path = pathinfo($e['nama_file']);
							$fol = $path['dirname'];	
							$fol = $fol.'/';
							$file_user1 = $_FILES['file_prosedur']['name'];
							$file_user2 = test($file_user1);
							$tmp_file_user = $_FILES['file_prosedur']['tmp_name'];
							$file_fmea_user = $fol.$file_user1;
							$file_fmea_rename = $fol.$file_user2;

							if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
								rename($file_fmea_user, $file_fmea_rename);
								mysqli_query($conn, "UPDATE prosedur SET
									nama_file = '$file_fmea_rename'
									WHERE no_prosedur = '$id'
									");
							}
						}

						if ($a=mysqli_query($conn, "UPDATE prosedur SET detail_prosedur = '$detail_prosedur',
																	tgl_revisi = '$tgl'
																	WHERE no_prosedur = '$id'
																	")
						) {
							header('location:main?index=prosedur');
						}
					}
				}
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=prosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:30px;'>
							Edit Prosedur
						</div>
						<div class='form_process'>
							<form action='main?index=prosedur&action=edit&id=$id#popup' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Divisi Prosedur</a><br>
								<select class='input_main' name='divisi' style='width:100%;' onchange='this.form.submit()' required readonly autofocus>
										";
											$a=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
											while ($c=mysqli_fetch_array($a)) {
												if ($divisi_prosedur==$c['no_divisi_prosedur']) {
													echo "
														<option value='$c[no_divisi_prosedur]' selected>$c[divisi_prosedur]</option>
													";
												}
											}
										echo "
								</select><br>
								<a class='j_input_main'>Prosedur</a><br>
								<select class='input_main' name='prosedur' style='width:100%;' onchange='this.form.submit()' required readonly>
										";
											$a=mysqli_query($conn, "SELECT * from master_prosedur order by master_prosedur");
											while ($c=mysqli_fetch_array($a)) {
												if ($prosedur==$c['no_master_prosedur']) {
													echo "
														<option value='$c[no_master_prosedur]' selected>$c[master_prosedur]</option>
													";
												}
											}
										echo "
								</select><br>
								<a class='j_input_main'>Kategori Prosedur</a><br>
								<select class='input_main' name='jenis' style='width:100%;' onchange='this.form.submit()' required readonly>
										";
											$a=mysqli_query($conn, "SELECT * from jenis_prosedur order by jenis_prosedur");
											while ($c=mysqli_fetch_array($a)) {
												if ($jenis_prosedur==$c['no_jenis_prosedur']) {
													echo "
														<option value='$c[no_jenis_prosedur]' selected>$c[jenis_prosedur]</option>
													";
												}
											}
										echo "
								</select><br>
								<a class='j_input_main'>Detail Kategori</a><br>
								<input class='input_main' type='input' name='detail' placeholder='Detail Kategori' value='$detail_prosedur' style='width:100%;'><br>
								<a class='j_input_main'>Nama File Prosedur</a><br>
								<input class='input_main readonly' type='input' name='folder' placeholder='Nama File Prosedur' value='$nama_folder' style='width:100%;' readonly required><br>
								";?>

								<a class='j_input_main'>File Prosedur</a><font size='1' color='red'> ) Max File Size = 1MB</font><br>
									<input class='file_main' type='file' name='file_prosedur' onchange="valid2(this)"><br>

								<a class='j_input_main'>File FMEA</a><font size='1' color='red'> ) Max File Size = 1MB</font><br>
									<input class='file_main' type='file' name='file_fmea' onchange="valid2(this)"><br>

								<div class='alert_adm alert' id="ugg2" style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr2" style='width:94%;'>File is OK !</div>

								<script>
									window.onload = function(){
										document.getElementById('ugg2').style.display = "none";
										document.getElementById('ubr2').style.display = "none";}
								</script>
								<?php
								echo "
								<a class='j_input_main'>No. Revisi</a><br>
								<input class='input_main readonly' type='input' name='no_revisi' placeholder='No. Revisi' value='$no_revisi' style='width:100%;' required><br>
								<a class='j_input_main'>Tanggal</a><br>
								<input class='input_main' type='input' name='tgl'  value='$tgl' style='width:100%;' maxlength='10' required>
								<font style='margin-left:10px; margin-top:-20px; font-size:11px;'>note : tahun-bulan-tanggal</font><br><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' id='dot' value='Update'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'view':
				$id = $_GET['id'];
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
					
						<a href='main?index=prosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px;' >
							File Revisi Sebelumnya
						</div>
						<div class='form_process' >
							<table class='table_admin'>
							<tr class='top_table'>
								<td>No</td>
								<td>Nama File</td>
								<td>Attachment</td>
							</tr>";

							$tmp_baris = 1;
							$query = mysqli_query($conn, "SELECT * FROM un_prosedur
								WHERE no_prosedur = '$id'
								");

							while ($tmp_c=mysqli_fetch_array($query)){
								if ($tmp_baris % 2 == 1) {
									echo "
									<tr class='main_table odd'>
										<td>$tmp_baris</td>
										<td>$tmp_c[judul_file]</td>
										<td><a style='padding-right:5px;color: blue;' href='download.php?index=$tmp_c[nama_file]'>Download</a></td>
									</tr>
									";
								}
								elseif ($tmp_baris % 2 == 0) {
									echo "
									<tr class='main_table even'>
										<td>$tmp_baris</td>
										<td>$tmp_c[judul_file]</td>
										<td><a style='padding-right:5px;color: blue;' href='download.php?index=$tmp_c[nama_file]'>Download</a></td>
									</tr>
									";
								}
								$tmp_baris++;
							}
				echo "
							</table>
						</div>
					</div>
				";
				break;
		}
	}
?>
<div id='main' class='main fl m-left-0px width100pc'>
	<div class='judul_main' style='position: fixed;'>File Prosedur</div>
	<div class='form_main' style='margin-top: 46px;'>
		<?php
			if (isset($_SESSION['username'])) {
				if ($_SESSION['level'] == 'admin') {
					echo "
						<div style='margin-right:10px;'>
							<a href='main?index=prosedur&action=tambah#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>
						</div>
					";
				}
			}
			if (isset($_SESSION['username'])) {
				if ($_SESSION['level'] == 'admin') {
					$status = "status != ''";
				}
			}
			else {
				$status = "status = 'aktif'";
			}
		?>
		<br>
		<form action='main?index=prosedur' method='post' class='fl' enctype='multipart/form-data'>
			<select class='input_main' name='divisi' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Divisi Prosedur</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from prosedur inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur group by divisi_prosedur.divisi_prosedur order by divisi_prosedur.divisi_prosedur");
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
					?>
			</select>
			<select class='input_main' name='prosedur' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Master Prosedur</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from prosedur inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur where prosedur.no_divisi_prosedur='$divisi' AND $status group by master_prosedur.master_prosedur order by master_prosedur.master_prosedur");
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
					?>
			</select>
			<select class='input_main' name='jenis' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Kategori Prosedur</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from prosedur inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur where prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND $status group by jenis_prosedur.jenis_prosedur order by jenis_prosedur.jenis_prosedur");
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
					?>
			</select>
			<select class='input_main' name='detail' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Detail Kategori</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' AND $status group by detail_prosedur order by detail_prosedur");
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
					?>
			</select>
			<select class='input_main' name='folder' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Nama File</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' AND $status group by nama_folder order by nama_folder");
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
					?>
			</select>
			<?php
				echo "
					<input class='input_main' name='search' value='$search' placeholder='Search Nama File' style='width:200px;margin:0px;' onchange='this.form.submit()'>
				";
			?>
		</form>
		<div class='cb'></div>
		<?php
			if ($divisi != '') {
				if ($prosedur != '') {
					if ($jenis != '') {
						if ($detail != '') {
							if ($folder != '') {
								if ($search != '') {
									$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur'AND prosedur.no_jenis_prosedur='$jenis' AND  AND detail_prosedur='$detail' nama_folder='$folder' AND nama_folder like'%$search%'";
									$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder.'&search='.$search;
								}
								else{
									$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis'  AND detail_prosedur='$detail' AND nama_folder='$folder'";
									$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder;
								}
							}
							elseif ($search != '') {
								$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis' AND detail_prosedur='$detail' AND nama_folder like'%$search%'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&search='.$search;
							}
							else{
								$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis' AND detail_prosedur='$detail'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail;
							}
						}
						elseif ($folder != '') {
							if ($search != '') {
								$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur'AND prosedur.no_jenis_prosedur='$jenis' AND nama_folder='$folder' AND nama_folder like'%$search%'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder.'&search='.$search;
							}
							else{
								$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis' AND nama_folder='$folder'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder;
							}
						}
						elseif ($search != '') {
							$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur'AND prosedur.no_jenis_prosedur='$jenis' AND nama_folder like'%$search%'";
							$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&search='.$search;
						}
						else{
							$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND prosedur.no_jenis_prosedur='$jenis'";
							$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis;
						}
					}
					elseif ($search != '') {
						$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur' AND nama_folder like'%$search%'";
						$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&search='.$search;
					}
					else{
						$filter="AND prosedur.no_divisi_prosedur='$divisi' AND prosedur.no_master_prosedur='$prosedur'";
						$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur;
					}
				}
				else{
					$filter="AND prosedur.no_divisi_prosedur='$divisi'";
					$filterurl='&divisi='.$divisi;
				}
			}
			elseif ($search != '') {
				$filter="AND nama_folder like'%$search%'";
				$filterurl='&search='.$search;
			}
			else{
				$filter="";
				$filterurl='';
			}
			$sort="tgl_revisi DESC";
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
			if (isset($_SESSION['username'])) {
				$a = mysqli_query($conn, "SELECT * FROM prosedur 
						inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
						WHERE status != '' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
				$page1=mysqli_query($conn, "SELECT * FROM prosedur WHERE status != '' ".$filter);
			}
			else{
				$a = mysqli_query($conn, "SELECT * FROM prosedur 
						inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
						inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
						WHERE status = 'aktif' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
				$page1=mysqli_query($conn, "SELECT * FROM prosedur WHERE status = 'aktif' ".$filter);
			}
			$page2=mysqli_num_rows($page1);
			$page3=$page2/30;
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
						echo "<td><a href='main?index=prosedur&hal=1$sorturl$filterurl'>First</a></td>";
						echo "<td><a href='main?index=prosedur&hal=$hal3$sorturl$filterurl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=prosedur&hal=1$sorturl$filterurl'>First</a></td>";
						echo "<td><a href='main?index=prosedur&hal=$hal3$sorturl$filterurl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=prosedur&hal=$hal2$sorturl$filterurl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=prosedur&hal=$hal3$sorturl$filterurl'>Next</a></td>";
						echo "<td><a href='main?index=prosedur&hal=$page$sorturl$filterurl'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
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
				<td>
					<?php
						if (isset($sort)) {
							if ($sortby=='divisi_prosedur') {
								if ($orderby=='ASC') {
									echo "<a href='main?index=prosedur&sort=divisi_prosedur&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=divisi_prosedur&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=divisi_prosedur&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=prosedur&sort=master_prosedur&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=master_prosedur&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=master_prosedur&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=prosedur&sort=jenis_prosedur&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=jenis_prosedur&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=jenis_prosedur&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=prosedur&sort=detail_prosedur&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=detail_prosedur&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=detail_prosedur&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=prosedur&sort=nama_folder&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=nama_folder&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=nama_folder&order=ASC$halurl$filterurl'>";
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
							if ($sortby=='no_revisi') {
								if ($orderby=='ASC') {
									echo "<a href='main?index=prosedur&sort=no_revisi&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=no_revisi&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=no_revisi&order=ASC$halurl$filterurl'>";
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
				<td>
					<?php
						if (isset($sort)) {
							if ($sortby=='tgl_revisi') {
								if ($orderby=='ASC') {
									echo "<a href='main?index=prosedur&sort=tgl_revisi&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=prosedur&sort=tgl_revisi&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=prosedur&sort=tgl_revisi&order=ASC$halurl$filterurl'>";
							}
						}
						else{
							echo "<a>";
						}
						echo "
							Tanggal Revisi
						</a>
						";
					?>
				</td>
				<td>File Attachment</td>
				<?php
					if (isset($_SESSION['username'])) {
						if ($_SESSION['level'] == 'admin') {
							echo "
								<td colspan='3'>Action</td>
							";
						}
					}
				?>
				<td>File FMEA</td>
				<td>Jumlah File Revisi Sebelumnya</td>
				<td>File Sebelumnya</td>
			</tr>
		<?php
			$rowscount=$awal+1;
			while ($c=mysqli_fetch_array($a)) {
				$tmp_no_rev = $c['no_revisi']-1;
				if ($tmp_no_rev == 0) {
					$tmp_no_rev = '-';}
				

				if ($rowscount % 2 == 1) {
					echo "
						<tr class='main_table odd'>
							<td>$rowscount</td>
							<td>$c[divisi_prosedur]</td>
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[no_revisi]</td>
							<td>$c[tgl_revisi]</td>
							<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>Download</a></td>
							";
								if (isset($_SESSION['username'])) {
									if ($_SESSION['level'] == 'admin') {
										echo "
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=edit&id=$c[no_prosedur]#popup'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=ubahaktif&id=$c[no_prosedur]&status=$c[status]'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=hapus&id=$c[no_prosedur]'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> hapus
												</a>
											</td>
										";
									}
								}
							if ($c['file_fmea'] != '') {
								echo "<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>Download</a></td>";}
							else{
								echo "<td>No File</td>";}
						echo "
							<td>$tmp_no_rev</td>
							<td><a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=view&id=$c[no_prosedur]#popup'>View</a></td>
							</tr>";
				}
				elseif ($rowscount % 2 == 0) {
					echo "
						<tr class='main_table even'>
							<td>$rowscount</td>
							<td>$c[divisi_prosedur]</td>
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[no_revisi]</td>
							<td>$c[tgl_revisi]</td>
							<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>Download</a></td>
							";
								if (isset($_SESSION['username'])) {
									if ($_SESSION['level'] == 'admin') {
										echo "
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=edit&id=$c[no_prosedur]#popup'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=ubahaktif&id=$c[no_prosedur]&status=$c[status]'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
												</a>
											</td>
											<td>
												<a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=hapus&id=$c[no_prosedur]'> 
													<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> hapus
												</a>
											</td>
										";
									}
								}
							if ($c['file_fmea'] != '') {
								echo "<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'>Download</a></td>";}
							else{
								echo "<td>No File</td>";}
						echo "
						<td>$tmp_no_rev</td>
						<td><a style='padding-right:5px;color: blue;' href='main?index=prosedur&action=view&id=$c[no_prosedur]#popup'>View</a></td>
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