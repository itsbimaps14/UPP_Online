<?php
	$awal=0;
	$hariini=date("Y-m-d");
	if (!isset($_SESSION['username'])) {
		header('location:home');
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
	if (isset($_POST['search'])) {
		$search=$_POST['search'];
	}
	elseif (isset($_GET['search'])) {
		$search=$_GET['search'];
	}
	else{
		$search='';
	}
	$sort="no_file_prosedur DESC";
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
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis=test($_POST['jenis']);
					$detail=test($_POST['detail']);
					$folder=test($_POST['folder']);
					$tgl=test($_POST['tgl']);
					$no_revisi=test($_POST['no_revisi']);
					$file_master = $_FILES['file_master']['name'];

					if ($divisi!='' && $prosedur!='' && $jenis!='' && $folder!='' && $file_master!='') {
						$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
						$e=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);
						
						$no_file=$f+1;
						if ($file_master!='') {
							if (!file_exists('file_upload/master_prosedur/'.$divisi)) {
								mkdir('file_upload/master_prosedur/'.$divisi);
							}
							if (!file_exists('file_upload/master_prosedur/'.$divisi.'/'.$prosedur)) {
								mkdir('file_upload/master_prosedur/'.$divisi.'/'.$prosedur);
							}
							if (!file_exists('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis)) {
								mkdir('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis);
							}
							if (!file_exists('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis.'/'.$folder)) {
								mkdir('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis.'/'.$folder);
							}
							if (!file_exists('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis.'/'.$folder.'/'.$no_file)) {
								mkdir('file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis.'/'.$folder.'/'.$no_file);
							}
							
							$folder1 = 'file_upload/master_prosedur/'.$divisi.'/'.$prosedur.'/'.$jenis.'/'.$folder.'/'.$no_file.'/';
							$file_master1 = $_FILES['file_master']['name'];
							$file_master2 = test($file_master1);
							$tmp_file_master = $_FILES['file_master']['tmp_name'];
							$file_master = $folder1.$file_master1;
							$file_master_rename = $folder1.$file_master2;

							if (move_uploaded_file($tmp_file_master, $file_master)) {
								rename($file_master, $file_master_rename);
								$a=mysqli_query($conn, "INSERT INTO file_prosedur_master (no_divisi_prosedur,no_master_prosedur,no_jenis_prosedur,detail_prosedur,nama_folder,no_revisi,tgl_revisi,nama_file)
																				VALUES	('$divisi','$prosedur','$jenis','$detail','$folder','$no_revisi','$tgl','$file_master_rename')");
								header('location:main?index=upp&step=file');
							}
							else {
								$alert='upload file gagal, silahkan kirim lewat email';
								$file_master='';
								$uploadOk = 0;
							}
						}
					}
				}
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=upp&step=file'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:30px;'>
							Form File Master Prosedur
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=file&action=tambah#popup' method='post' enctype='multipart/form-data'>
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
									$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
									$e=mysqli_fetch_array($d);
									$f=mysqli_num_rows($d);
									if ($f=='0') {
										$no_revisi='';
										echo "<div class='alert_adm alert' style='width:94%;'>Nama File Prosedur Belum Ada</div>";
									}
								echo "
								<input class='input_main' type='input' name='folder' placeholder='Nama File Prosedur' value='$folder' style='width:100%;'  onchange='this.form.submit()' required><br>
								<a class='j_input_main'>File Prosedur</a><br>
								<input class='file_main' type='file' name='file_master' required>
								<br>
								<a class='j_input_main'>No. Revisi</a><br>
								<input class='input_main' type='input' name='no_revisi' placeholder='No. Revisi' value='$no_revisi' style='width:100%;' required><br>
								<a class='j_input_main'>Tanggal</a>
								<input class='input_main' type='input' name='tgl'  value='$hariini' style='width:100%; margin-bottom:0' maxlength='10' required>
								<font style='margin-left:10px; margin-top:-20px; font-size:11px;'>note : tahun-bulan-tanggal</font><br><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'edit':
				$id=$_GET['id'];
				$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_file_prosedur = '$id'");
				$e=mysqli_fetch_array($d);
				$f=mysqli_num_rows($d);
				$divisi=$e['no_divisi_prosedur'];
					$prosedur=$e['no_master_prosedur'];
					$jenis=$e['no_jenis_prosedur'];
					$detail=$e['detail_prosedur'];
					$folder=$e['nama_folder'];
					$no_revisi=$e['no_revisi'];
					$tgl=$e['tgl_revisi'];
				
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis=test($_POST['jenis']);
					$detail=test($_POST['detail']);
					$folder=test($_POST['folder']);
					$tgl=test($_POST['tgl']);
					$no_revisi=test($_POST['no_revisi']);
					$file_master = $_FILES['file_master']['name'];

					if ($divisi!='' && $prosedur!='' && $jenis!='' && $folder!='') {
						$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
						$e=mysqli_fetch_array($d);
						$f=mysqli_num_rows($d);
						
						$no_file=$f+1;
						if ($file_master!='') {
							
							$ab = mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_file_prosedur = '$id'");
							$cd = mysqli_fetch_array($ab);

							unlink($cd['nama_file']);

							$ppath = pathinfo($e['nama_file']);
							$folder1 = $ppath['dirname'];
							$folder1 = $folder1.'/';
							$file_master1 = $_FILES['file_master']['name'];
							$file_master2 = test($file_master1);
							$tmp_file_master = $_FILES['file_master']['tmp_name'];
							$file_master1 = $no_revisi.'_'.$file_master1;
							$file_master = $folder1.$file_master1;
							$file_master_rename = $folder1.$file_master2;

							if (move_uploaded_file($tmp_file_master, $file_master)) {
								$a=mysqli_query($conn, "update file_prosedur_master set no_divisi_prosedur='$divisi', no_master_prosedur='$prosedur', no_jenis_prosedur='$jenis', detail_prosedur='$detail', nama_folder='$folder', no_revisi='$no_revisi', tgl_revisi='$tgl', nama_file='$file_master' where no_file_prosedur='$id'");
								header('location:main?index=upp&step=file');
							}
							
							else {
								$alert='upload file gagal, silahkan kirim lewat email';
								$file_master='';
								$uploadOk = 0;
							}
						}
						else
						{
							if($a=mysqli_query($conn, "update file_prosedur_master set no_divisi_prosedur='$divisi', no_master_prosedur='$prosedur', no_jenis_prosedur='$jenis', detail_prosedur='$detail', nama_folder='$folder', no_revisi='$no_revisi', tgl_revisi='$tgl' where no_file_prosedur='$id'"))
							{
								header('location:main?index=upp&step=file');
							}
							else {
								$alert='gagal';
								$file_master='';
								$uploadOk = 0;
							}
						}

					}
				}
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=upp&step=file'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:30px;'>
							Form File Master Prosedur
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=file&action=edit&id=$id#popup' method='post' enctype='multipart/form-data'>
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
									$d=mysqli_query($conn, "SELECT * FROM file_prosedur_master WHERE no_divisi_prosedur = '$divisi' AND no_master_prosedur = '$prosedur' AND no_jenis_prosedur = '$jenis' AND nama_folder = '$folder'");
									$e=mysqli_fetch_array($d);
									$f=mysqli_num_rows($d);
									if ($f=='0') {
										$no_revisi='';
										echo "<div class='alert_adm alert' style='width:94%;'>Nama File Prosedur Belum Ada</div>";
									}
								echo "
								<input class='input_main' type='input' name='folder' placeholder='Nama File Prosedur' value='$folder' style='width:100%;'  onchange='this.form.submit()' required><br>";?>

								<a class='j_input_main'>File Prosedur<font size='1' color='red'> *) Max file = 2MB, Diisi jika file upload akan diubah</font></a><br>
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

								<div class='alert_adm alert' id="ugg" style='width:94%;'>File Upload max Size is 2MB / 2048B !</div>
								<div class='alert_adm alert2' id="ubr" style='width:94%;'>File is OK !</div>
								<br>

								<?php echo "
								<a class='j_input_main'>No. Revisi</a><br>
								<input class='input_main' type='input' name='no_revisi' placeholder='No. Revisi' value='$no_revisi' style='width:100%;' required><br>
								<a class='j_input_main'>Tanggal</a>
								<input class='input_main' type='input' name='tgl'  value='$tgl' style='width:100%; margin-bottom:0' maxlength='10' required>
								<font style='margin-left:10px; margin-top:-20px; font-size:11px;'>note : tahun-bulan-tanggal</font><br><br>
								<input style='margin-left:5px;' id='submit' class='submit_main fl' type='submit' value='Update'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
				case 'hapus':
				$a=mysqli_query($conn, "delete from file_prosedur_master where no_file_prosedur = '$_GET[id]'");
								
				if($a)
				{
					header('location:main?index=upp&step=file');
				}
				break;
		}
	}
?>
<div class='judul_main' style='position: fixed;'>File Master Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<div style='margin-right:10px;'>
		<a href='main?index=upp&step=file&action=tambah#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>
	</div>
	<br>
	<form action='main?index=upp&step=file' method='post' enctype='multipart/form-data'>
		<select class='input_main' name='divisi' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Divisi Prosedur</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from file_prosedur_master inner join divisi_prosedur on file_prosedur_master.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur group by divisi_prosedur.divisi_prosedur order by divisi_prosedur.divisi_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from file_prosedur_master inner join master_prosedur on file_prosedur_master.no_master_prosedur = master_prosedur.no_master_prosedur where file_prosedur_master.no_divisi_prosedur='$divisi' group by master_prosedur.master_prosedur order by master_prosedur.master_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from file_prosedur_master inner join jenis_prosedur on file_prosedur_master.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur where file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' group by jenis_prosedur.jenis_prosedur order by jenis_prosedur.jenis_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from file_prosedur_master where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' group by detail_prosedur order by detail_prosedur");
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
			<br>
			<br>
			<select class='input_main' name='folder' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Nama File</option>
					<?php
						$a=mysqli_query($conn, "SELECT * from file_prosedur_master where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' group by nama_folder order by nama_folder");
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
			$limit="";
			if ($prosedur != '') {
				if ($jenis != '') {
					if ($detail != '') {
						if ($folder != '') {
							if ($search != '') {
								$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur'AND file_prosedur_master.no_jenis_prosedur='$jenis' AND  AND detail_prosedur='$detail' nama_folder='$folder' AND nama_folder like'%$search%'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder.'&search='.$search;
							}
							else{
								$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' AND file_prosedur_master.no_jenis_prosedur='$jenis'  AND detail_prosedur='$detail' AND nama_folder='$folder'";
								$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&folder='.$folder;
								$limit=" LIMIT 0,6";
							}
						}
						elseif ($search != '') {
							$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' AND file_prosedur_master.no_jenis_prosedur='$jenis' AND detail_prosedur='$detail' AND nama_folder like'%$search%'";
							$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&detail='.$detail.'&search='.$search;
						}
						else{
							$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' AND file_prosedur_master.no_jenis_prosedur='$jenis' AND detail_prosedur='$detail'";
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
						$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur'AND file_prosedur_master.no_jenis_prosedur='$jenis' AND nama_folder like'%$search%'";
						$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis.'&search='.$search;
					}
					else{
						$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' AND file_prosedur_master.no_jenis_prosedur='$jenis'";
						$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&jenis='.$jenis;
					}
				}
				elseif ($search != '') {
					$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur' AND nama_folder like'%$search%'";
					$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur.'&search='.$search;
				}
				else{
					$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi' AND file_prosedur_master.no_master_prosedur='$prosedur'";
					$filterurl='&divisi='.$divisi.'&prosedur='.$prosedur;
				}
			}
			else{
				$filter="AND file_prosedur_master.no_divisi_prosedur='$divisi'";
				$filterurl='&divisi='.$divisi;
			}
			$a=mysqli_query($conn, "SELECT * FROM file_prosedur_master inner join divisi_prosedur on file_prosedur_master.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on file_prosedur_master.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on file_prosedur_master.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_file_prosedur != '' ".$filter." ORDER BY ".$sort.$limit);
		}
		elseif ($search != '') {
			$a=mysqli_query($conn, "SELECT * FROM file_prosedur_master inner join divisi_prosedur on file_prosedur_master.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on file_prosedur_master.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on file_prosedur_master.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE nama_folder like'%$search%' ORDER BY ".$sort);
			$filterurl='';
		}
		else{
			$awal=($hal-1)*30;
			$akhir=30;
			$a=mysqli_query($conn, "SELECT * FROM file_prosedur_master inner join divisi_prosedur on file_prosedur_master.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on file_prosedur_master.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on file_prosedur_master.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT * FROM file_prosedur_master inner join divisi_prosedur on file_prosedur_master.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on file_prosedur_master.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on file_prosedur_master.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur");
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
						echo "<td><a href='main?index=upp&step=file&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=file&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=file&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=file&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=file&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=file&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=file&hal=$page$sorturl'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					echo "
					</tr>
				</table>
			";
			$filterurl='';
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
			<td>No</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='divisi_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=file&sort=divisi_prosedur&order=DESC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=divisi_prosedur&order=ASC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=file&sort=divisi_prosedur&order=ASC$halurl$filterurl'>";
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
								echo "<a href='main?index=upp&step=file&sort=master_prosedur&order=DESC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=master_prosedur&order=ASC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=file&sort=master_prosedur&order=ASC$halurl$filterurl'>";
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
								echo "<a href='main?index=upp&step=file&sort=jenis_prosedur&order=DESC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=jenis_prosedur&order=ASC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=file&sort=jenis_prosedur&order=ASC$halurl$filterurl'>";
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
								echo "<a href='main?index=upp&step=file&sort=detail_prosedur&order=DESC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=detail_prosedur&order=ASC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=file&sort=detail_prosedur&order=ASC$halurl$filterurl'>";
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
								echo "<a href='main?index=upp&step=file&sort=nama_folder&order=DESC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=nama_folder&order=ASC$halurl$filterurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=file&sort=nama_folder&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=upp&step=file&sort=no_revisi&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=upp&step=file&sort=no_revisi&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=no_revisi&order=ASC$halurl$filterurl'>";
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
									echo "<a href='main?index=upp&step=file&sort=tgl_revisi&order=DESC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_top.png'><br>";
								}
								else{
									echo "<a href='main?index=upp&step=file&sort=tgl_revisi&order=ASC$halurl$filterurl'>";
									echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
								}
							}
							else{
								echo "<a href='main?index=upp&step=file&sort=tgl_revisi&order=ASC$halurl$filterurl'>";
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
            <td>Action</td>
            <td>Hapus</td>
            
		</tr>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
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
					<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a></td>
					<td>
											<a style='padding-right:5px;color: blue;' href='main?index=upp&step=file&action=edit&id=$c[no_file_prosedur]#popup'> 
												<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
											</a>
										</td>
					<td>
											<a style='padding-right:5px;color: blue;' onclick=\"return confirm('Hapus Data?')\" href='main?index=upp&step=file&action=hapus&id=$c[no_file_prosedur]#popup'> 
												<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> hapus
											</a>
										</td>
				</tr>
			";
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
					<td><a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a></td>
					<td>
											<a style='padding-right:5px;color: blue;' href='main?index=upp&step=file&action=edit&id=$c[no_file_prosedur]#popup'> 
												<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
											</a>
										</td>
					<td>
											<a style='padding-right:5px;color: blue;' onclick=\"return confirm('Hapus Data?')\" href='main?index=upp&step=file&action=hapus&id=$c[no_file_prosedur]#popup'> 
												<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> hapus
											</a>
										</td>
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