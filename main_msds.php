<?php
	$tahun = date('Y');
	$today = date('Y-m-d');

	$filter = "";
	if (isset($_POST['tahun']) OR isset($_POST['k_msds']) OR isset($_POST['nama_bahan']) OR isset($_POST['nama_sederhana_bahan']) OR isset($_POST['tanggal_berlaku'])
		OR isset($_POST['tanggal_expired']) OR isset($_POST['pic']) OR isset($_POST['searchcari'])) {
		if($_POST['tahun'] != ''){
			$filter = "";
			$filter = $filter."and tahun = '".$_POST['tahun']."'";
			$taun = $_POST['tahun'];
		}
		if($_POST['k_msds'] != ''){
			$filter = $filter."and kategori_msds = '".$_POST['k_msds']."'";
			$k_msds = $_POST['k_msds'];
		}
		if($_POST['nama_bahan'] != ''){
			$filter = $filter."and nama_bahan = '".$_POST['nama_bahan']."'";
			$nama_bahan = $_POST['nama_bahan'];
		}
		if($_POST['nama_sederhana_bahan'] != ''){
			$filter = $filter."and nama_sederhana_bahan = '".$_POST['nama_sederhana_bahan']."'";
			$nama_sederhana_bahan = $_POST['nama_sederhana_bahan'];
		}
		if($_POST['tanggal_berlaku'] != ''){
			$filter = $filter."and tanggal_berlaku = '".$_POST['tanggal_berlaku']."'";
			$tanggal_berlaku = $_POST['tanggal_berlaku'];
		}
		if($_POST['tanggal_expired'] != ''){
			$filter = $filter."and tanggal_expired = '".$_POST['tanggal_expired']."'";
			$tanggal_expired = $_POST['tanggal_expired'];
		}
		if($_POST['pic'] != ''){
			$filter = $filter."and pic = '".$_POST['pic']."'";
			$pic = $_POST['pic'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
		}
		if ($_POST['tahun'] == "" AND $_POST['k_msds'] == "" AND $_POST['nama_bahan'] == "" AND $_POST['nama_sederhana_bahan'] == "" AND $_POST['tanggal_berlaku'] == ""
			AND $_POST['tanggal_expired'] == "" AND $_POST['pic'] == "" AND $_POST['searchcari'] == ""){
			header("location:main?index=msds");
		}
	}

	$a=mysqli_query($conn, "SELECT * FROM msds WHERE tahun = '$tahun'");
	$c=mysqli_fetch_array($a);
	$d=mysqli_num_rows($a);
	$d+=1;

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'tambah' :

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no = test($_POST['no_msds']);
					$kat_msds = test($_POST['kat_msds']);
					$nama_bahan = test($_POST['nama_bahan']);
					$nama_sederhana_bahan = test($_POST['nama_sederhana_bahan']);
					$vendor = test($_POST['vendor']);
					$year = test($_POST['tahun']);
					$bulan = test($_POST['bulan']);
					$tanggal = test($_POST['tanggal']);
					$tgl_berlaku = $year.'-'.$bulan.'-'.$tanggal;
					$exp = date('Y-m-d', strtotime('+5 year', strtotime($tgl_berlaku)));
					$pic = test($_POST['pic']);
					$email_pic = test($_POST['email_pic']);

					$uploadOk = 1;
					$nama_file = $_FILES['file_msds']['name'];
					if ($nama_file!='') {
						if (!file_exists('file_upload/msds/'.$tahun)) {
							mkdir('file_upload/msds/'.$tahun);}
						if (!file_exists('file_upload/msds/'.$tahun.'/'.$d)) {
							mkdir('file_upload/msds/'.$tahun.'/'.$d);}
			
						$folder1 = 'file_upload/msds/'.$tahun.'/'.$d.'/';
						$file_user1 = $_FILES['file_msds']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_msds']['tmp_name'];
						$file_user = $folder1.$file_user1;
						$file_user_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_user)) {
							rename($file_user, $file_user_rename);
							mysqli_query($conn, "INSERT INTO msds (
								no,
								kategori_msds,
								tahun,
								nama_bahan,
								nama_sederhana_bahan,
								vendor,
								tanggal_berlaku,
								tanggal_expired,
								status,
								attachement_msds,
								pic,
								email_pic)
								VALUES (
								'$no',
								'$kat_msds',
								'$tahun',
								'$nama_bahan',
								'$nama_sederhana_bahan',
								'$vendor',
								'$tgl_berlaku',
								'$exp',
								'OK',
								'$file_user_rename',
								'$pic',
								'$email_pic'
								)
								");
						}
					}
					header("location:main?index=msds");
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=msds'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:440px;'>
							Tambah MSDS
						</div>
						<div class='form_process' style='overflow:auto;width:430px;height:470px;'>
							<form action='main?index=msds&action=tambah' method='post'  enctype='multipart/form-data'>
								";
								if ($d < 10) {
									$d = '000'.$d;
								}
								if ($d > 9 AND $d < 100) {
									$d = '00'.$d;
								}
								if ($d > 99 AND $d < 1000) {
									$d = '0'.$d;
								}
								$no_msds = $d.'/MSDS/'.$tahun;
								$exp = date('Y-m-d', strtotime('+5 year', strtotime($today)));
								echo "
								<a class='j_input_main'>No MSDS *</a><br>
									<input class='input_main readonly' type='text' name='no_msds' value='$no_msds' required readonly><br>
								<a class='j_input_main'>Kategori MSDS *</a><br>
									<select class='input_main' name='kat_msds' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from kat_msds");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['kat_msds']==$f['kat_msds']) {
													echo "
														<option value='$f[kat_msds]' selected>$f[nama_msds]</option>
													";
												}
												else{
													echo "
														<option value='$f[kat_msds]'>$f[nama_msds]</option>
													";
												}
											}
										echo "
									</select><br>
								<a class='j_input_main'>Item Description *</a><br>
									<input class='input_main' type='text' name='nama_bahan' required><br>
								<a class='j_input_main'>Nama Sederhana Bahan *</a><br>
									<input class='input_main' type='text' name='nama_sederhana_bahan' required><br>
								<a class='j_input_main'>Nama Vendor / Principal *</a><br>
									<input class='input_main' type='text' name='vendor' required><br>
								<a class='j_input_main'>Tanggal Berlaku *</a><br>
									";?>
									<select id='thndibutuhkan' class='input_main' style='width:100px;' name='tahun' required>
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

									<select id='blndibutuhkan' class='input_main' style='width:190px;' name='bulan' required>
										<option value=''></option>
									
									<?php

									$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
									$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
									$daymonth=array('31','28','31','30','31','30','31','31','30','31','30','31');
									$monthlength=count($month2);

									for ($x=0; $x < 12; $x++) {
										echo "<option value='$monthvalue[$x]'>$month2[$x]</option>";
									}

									echo "
									</select>
									<select id='tgldibutuhkan' class='input_main' style='width:100px;' name='tanggal' required>
										<option value=''></option>
									";
									echo "
									</select><br>";?>

								<a id='txt_sh_2' class='j_input_main'>Attachment MSDS *<font size='1' color='red'> ) Max File Size = 1MB</font><br></a>
									<input class='file_main' type='file' name='file_msds' onchange="valid(this)" required><br>

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

								<div class='alert_adm alert' id="ugg" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr" style='width:70px;'>File is OK !</div>

								<?php echo "
								<a class='j_input_main'>PIC *</a><br>
									<input class='input_main' type='text' name='pic' required><br>
								<a class='j_input_main'>Alamat email PIC *</a><br>
									<input class='input_main' type='email' name='email_pic' required><br>
								<input style='margin-left:282px;' id='submit' class='submit_main' type='submit' value='Simpan'>
							</form>
						</div>
					</div>
				";
			break;

			case 'edit' :
				$a=mysqli_query($conn, "SELECT * FROM msds WHERE no = '$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kat_msds = test($_POST['kat_msds']);
					$nama_bahan = test($_POST['nama_bahan']);
					$nama_sederhana_bahan = test($_POST['nama_sederhana_bahan']);
					$vendor = test($_POST['vendor']);
					$pic = test($_POST['pic']);
					$email_pic = test($_POST['email_pic']);

					mysqli_query($conn, " UPDATE msds SET 
						kategori_msds = '$kat_msds',
						nama_bahan = '$nama_bahan',
						nama_sederhana_bahan = '$nama_sederhana_bahan',
						vendor = '$vendor',
						pic = '$pic',
						email_pic = '$email_pic'
						WHERE
						no = '$id'
						");

					$uploadOk = 1;
					$nama_file = $_FILES['file_msds']['name'];
					if ($nama_file!='') {

						$ppath = pathinfo($c['attachement_msds']);
						$dirdir = $ppath['dirname'];
			
						$folder1 = $dirdir.'/';
						$file_user1 = $_FILES['file_msds']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_msds']['tmp_name'];
						$file_user = $folder1.$file_user1;
						$file_user_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_user)) {
							rename($file_user, $file_user_rename);
							unlink($c['attachement_msds']);
							mysqli_query($conn, "UPDATE msds SET 
								attachement_msds = '$file_user_rename'
								WHERE
								no = '$id'");
						}
					}
					header("location:main?index=msds");
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=msds'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:440px;'>
							Edit MSDS
						</div>
						<div class='form_process' style='overflow:auto;width:430px;height:470px;'>
							<form action='main?index=msds&action=edit&id=$id' method='post'  enctype='multipart/form-data'>
								<div class='alert_adm alert'><b>Warning !</b> - Jika file Upload tidak ada yang akan di edit, jangan diisi !</div><br>
								<a class='j_input_main'>No MSDS *</a><br>
									<input class='input_main readonly' type='text' name='no_msds' value='$c[no]' required readonly><br>
								<a class='j_input_main'>Kategori MSDS *</a><br>
									<select class='input_main' name='kat_msds' required>
										<option value=''></option>
										";
											$d=mysqli_query($conn, "SELECT * from kat_msds");
											while ($f=mysqli_fetch_array($d)) {
												if ($c['kategori_msds']==$f['kat_msds']) {
													echo "
														<option value='$f[kat_msds]' selected>$f[nama_msds]</option>
													";
												}
												else{
													echo "
														<option value='$f[kat_msds]'>$f[nama_msds]</option>
													";
												}
											}
										echo "
									</select><br>
								<a class='j_input_main'>Nama Bahan *</a><br>
									<input class='input_main' type='text' name='nama_bahan' value='$c[nama_bahan]' required><br>
								<a class='j_input_main'>Nama Sederhana Bahan *</a><br>
									<input class='input_main' type='text' name='nama_sederhana_bahan' value='$c[nama_sederhana_bahan]' required><br>
								<a class='j_input_main'>Nama Vendor / Principal *</a><br>
									<input class='input_main' type='text' name='vendor' value='$c[vendor]' required><br>
								<a class='j_input_main'>Tanggal Berlaku *</a><br>
									<input class='input_main readonly' type='text' name='tgl_berlaku' value='$c[tanggal_berlaku]' required readonly><br>
								<a class='j_input_main'>Tanggal Expired *</a><br>
									<input class='input_main readonly' type='text' name='tgl_expired' value='$c[tanggal_expired]' required readonly><br>";?>

								<a id='txt_sh_2' class='j_input_main'>Attachment MSDS <font size='1' color='red'> ) Max File Size 1MB, Diisi jika file upload akan diubah</font><br></a>
									<input class='file_main' type='file' name='file_msds' onchange="valid(this)"><br>

								<script type="text/javascript">
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
								        }
								        else {
								            document.getElementById('ugg').style.display = "none";
								        	document.getElementById('ubr').style.display = "block";
								            document.getElementById('submit').style.display = "block";
								        }
								    }
								</script>

								<div class='alert_adm alert' id="ugg" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id="ubr" style='width:70px;'>File is OK !</div>

								<?php echo "
								<a class='j_input_main'>PIC *</a><br>
									<input class='input_main' type='text' name='pic' value=$c[pic] required><br>
								<a class='j_input_main'>Alamat email PIC *</a><br>
									<input class='input_main' type='email' name='email_pic' value=$c[email_pic] required><br>
								<input style='margin-left:282px;' id='submit' class='submit_main' type='submit' value='Edit'>
							</form>
						</div>
					</div>
				";
			break;

			case 'hapus' :
				$a=mysqli_query($conn, "SELECT * FROM msds WHERE no = '$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					unlink($c['attachement_msds']);
					mysqli_query($conn, "DELETE from msds WHERE no = '$id'");
					header("location:main?index=msds");
				}
				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=msds'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Penghapusan MSDS
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=msds&action=hapus&id=$id' method='post' enctype='multipart/form-data'>
								<center>
									<a style='font-size:14px;'>Penghapusan data MSDS dengan No : $id <br>Klik button dibawah ini.</a><br><br>
								</center>
								<input style='margin-left:160px;' class='submit_main fl' type='submit' value='OK'>
							</form>
						</div>
					</div>";
			break;

			case 'autostatus' :
				mysqli_query($conn, "UPDATE msds SET status = 'Inprogress' WHERE no = '$id'");
				header("location:main?index=msds");
			break;

			case 'automail':

				$a=mysqli_query($conn, "
					SELECT * FROM msds
						INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
						WHERE no = '$id'
						".$filter);

				$c=mysqli_fetch_array($a);
				$email = $c['email_pic'];

				mysqli_query($conn, "UPDATE msds SET status = 'Expired' WHERE no = '$id'");

				$to 	  =	"$email";
				$subject  =	"MSDS No. " . strip_tags($c['no']);
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
				$message .=	"<tr style='background: #eee;'><td><strong>No UPP:</strong> </td><td>" . strip_tags($c['no']) . "</td></tr>";
				$message .=	"<tr><td><strong>Kategori MSDS : </strong> </td><td>" . strip_tags($c['nama_msds']) . "</td></tr>";
				$message .=	"<tr><td><strong>Nama Bahan : </strong> </td><td>" . strip_tags($c['nama_bahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Nama Sederhana Bahan : </strong> </td><td>" . strip_tags($c['nama_sederhana_bahan']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal Berlaku : </strong> </td><td>" . strip_tags($c['tanggal_berlaku']) . "</td></tr>";
				$message .=	"<tr><td><strong>Tanggal Expired : </strong> </td><td>" . strip_tags($c['tanggal_expired']) . "</td></tr>";
				$message .=	"<tr><td><strong>Pengaju : </strong> </td><td>" . strip_tags($c['pic']) . "</td></tr>";
				$message .= "</table><br>";
				$message .=	"<strong>Sudah melewati 3 tahun dan expired.</strong><br><br>";
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

				header("location:main?index=msds");
			break;

		}
	}
?>
<div class='judul_main' style='position:fixed;'>MSDS</div>
	<form style='margin-bottom:0px;' action='main?index=msds' method='post' enctype='multipart/form-data'><br><br><br>&emsp;
		<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:80px;'>
			<option value=''>Tahun</option>
				<?php
					$a=mysqli_query($conn, "SELECT tahun from msds GROUP BY tahun ORDER BY tahun DESC");
					while ($c=mysqli_fetch_array($a)) {
						if ($taun==$c['tahun']) {
							echo "<option value='$c[tahun]' selected>$c[tahun]</option>";
						}
						else{
							echo "<option value='$c[tahun]'>$c[tahun]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='k_msds' onchange='this.form.submit()' style='font-family:arial;width:165px;'>
			<option value=''>Kategori MSDS</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM kat_msds");
					while ($c=mysqli_fetch_array($a)) {
						if ($k_msds==$c['kat_msds']) {
							echo "<option value='$c[kat_msds]' selected>$c[nama_msds]</option>";
						}
						else{
							echo "<option value='$c[kat_msds]'>$c[nama_msds]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='nama_bahan' onchange='this.form.submit()' style='font-family:arial;width:165px;'>
			<option value=''>Nama Bahan</option>
				<?php
					$a=mysqli_query($conn, "SELECT nama_bahan FROM msds GROUP BY nama_bahan ORDER BY nama_bahan ASC");
					while ($c=mysqli_fetch_array($a)) {
						if ($nama_bahan==$c['nama_bahan']) {
							echo "<option value='$c[nama_bahan]' selected>$c[nama_bahan]</option>";
						}
						else{
							echo "<option value='$c[nama_bahan]'>$c[nama_bahan]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='nama_sederhana_bahan' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
			<option value=''>Nama Sederhana Bahan</option>
				<?php
					$a=mysqli_query($conn, "SELECT nama_sederhana_bahan FROM msds GROUP BY nama_sederhana_bahan ORDER BY nama_sederhana_bahan ASC");
					while ($c=mysqli_fetch_array($a)) {
						if ($nama_sederhana_bahan==$c['nama_sederhana_bahan']) {
							echo "<option value='$c[nama_sederhana_bahan]' selected>$c[nama_sederhana_bahan]</option>";
						}
						else{
							echo "<option value='$c[nama_sederhana_bahan]'>$c[nama_sederhana_bahan]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='tanggal_berlaku' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
			<option value=''>Tanggal Berlaku</option>
				<?php
					$a=mysqli_query($conn, "SELECT tanggal_berlaku FROM msds GROUP BY tanggal_berlaku ORDER BY tanggal_berlaku ASC");
					while ($c=mysqli_fetch_array($a)) {
						if ($tanggal_berlaku==$c['tanggal_berlaku']) {
							echo "<option value='$c[tanggal_berlaku]' selected>$c[tanggal_berlaku]</option>";
						}
						else{
							echo "<option value='$c[tanggal_berlaku]'>$c[tanggal_berlaku]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='tanggal_expired' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
			<option value=''>Tanggal Expired</option>
				<?php
					$a=mysqli_query($conn, "SELECT tanggal_expired FROM msds GROUP BY tanggal_expired ORDER BY tanggal_expired ASC");
					while ($c=mysqli_fetch_array($a)) {
						if ($tanggal_expired==$c['tanggal_expired']) {
							echo "<option value='$c[tanggal_expired]' selected>$c[tanggal_expired]</option>";
						}
						else{
							echo "<option value='$c[tanggal_expired]'>$c[tanggal_expired]</option>";
						}
					}
				?>
		</select>
		<select class='input_main' name='pic' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
			<option value=''>PIC</option>
				<?php
					$a=mysqli_query($conn, "SELECT pic FROM msds GROUP BY pic ORDER BY pic ASC");
					while ($c=mysqli_fetch_array($a)) {
						if ($pic==$c['pic']) {
							echo "<option value='$c[pic]' selected>$c[pic]</option>";
						}
						else{
							echo "<option value='$c[pic]'>$c[pic]</option>";
						}
					}
				?>
		</select>
		<br>&emsp;
			<?php
				if (isset($searchcari)) {
					echo "<input class='input_main' name='searchcari' value='$searchcari' placeholder='Search by Keyword' style='width:200px;margin:0px;' onchange='this.form.submit()'>";
				}
				else{
					echo "<input class='input_main' name='searchcari' placeholder='Search by Keyword' style='width:200px;margin:0px;' onchange='this.form.submit()'>";
				}
			?>
		<br><br>
	</form>
<div style='margin-left: 20px;'>
	<a href='main?index=msds&action=tambah#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>
</div>
<div class='form_main' style='margin-top: 0px;'>
	<?php
			$sort="nomor DESC";
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
					SELECT * FROM msds
						INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
						WHERE no = '$id'
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM msds
						INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
						WHERE no = '$id' ".$filter);
			}
			elseif (isset($searchcari)) {
				$a=mysqli_query($conn, "SELECT * FROM msds
					INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
					WHERE
						nama_bahan LIKE '%$searchcari%' 
						OR nama_sederhana_bahan LIKE '%$searchcari%'
						OR pic LIKE '%$searchcari%'
						OR email_pic LIKE '%$searchcari%'
						ORDER BY ".$sort." LIMIT $awal,$akhir
					");
				$page1=mysqli_query($conn, "SELECT * FROM msds
					INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
					WHERE
						nama_bahan LIKE '%$searchcari%' 
						OR nama_sederhana_bahan LIKE '%$searchcari%'
						OR pic LIKE '%$searchcari%'
						OR email_pic LIKE '%$searchcari%'
					");
			}
			else {
				$a=mysqli_query($conn, "
					SELECT * FROM msds
						INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
						WHERE no != ''
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM msds
						INNER JOIN kat_msds ON msds.kategori_msds = kat_msds.kat_msds
						WHERE no!= '' ".$filter);
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
						echo "<td><a href='main?index=msds&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=msds&step=create&hal=$hal3$sorturl";
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
						echo "<td><a href='main?index=msds&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=msds&step=create&hal=$hal3$sorturl";
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
							echo"<td><a href='main?index=msds&step=create&hal=$hal2$sorturl";
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
						echo "<td><a href='main?index=msds&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=msds&step=create&hal=$page$sorturl";
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
			<td>Kategori MSDS</td>
			<td>Item Description</td>
			<td>Nama Sederhana Bahan</td>
			<td>Nama Vendor / Principal</td>
			<td>Tanggal Berlaku</td>
			<td>Tanggal Expired</td>
			<td>Status</td>
			<td>Attachment MSDS</td>
			<td>PIC</td>
			<td>Alamat Email PIC</td>
			<?php
				if (isset($_SESSION['username'])) {
					if ($_SESSION['level'] == 'admin') {
						echo "<td colspan='2'>Action</td>";
					}
				}
			?>
		</tr>
</div>
<?php	
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		if (isset($_SESSION['username'])) {
			$hariini = date('Y-m-d');
			$start = new DateTime($hariini);
			$finish = new DateTime($c['tanggal_expired']);
			$leadtime=$start->diff($finish);
			$leadtime=$leadtime->days;
			if ($leadtime <= 90 AND $c['status'] == 'OK') {
				header('location:main?index=msds&action=autostatus&id='.$c['no']);
			}
			else if ($start >= $finish AND $c['status'] == 'Inprogress' ) {
				header('location:main?index=msds&action=automail&lead='.$leadtime.'&id='.$c['no']);
			}
		}
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$c[no]</td>
					<td>$c[nama_msds]</td>
					<td>$c[nama_bahan]</td>
					<td>$c[nama_sederhana_bahan]</td>
					<td>$c[vendor]</td>
					<td>$c[tanggal_berlaku]</td>
					<td>$c[tanggal_expired]</td>
					<td>$c[status]</td>
					<td>
					";
						if ($c['attachement_msds']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[attachement_msds]'>Download</a>";
						}
						else{
							echo "no file";
						}
		
					echo "
					</td>
					<td>$c[pic]</td>
					<td>$c[email_pic]</td>";
					if (isset($_SESSION['username'])) {
						if ($_SESSION['level'] == 'admin' OR $_SESSION['level'] == 'msds') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=msds&action=edit&id=$c[no]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=msds&action=hapus&id=$c[no]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
									</a>
								</td>
							";
						}
					}
					echo"
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>$c[no]</td>
					<td>$c[nama_msds]</td>
					<td>$c[nama_bahan]</td>
					<td>$c[nama_sederhana_bahan]</td>
					<td>$c[vendor]</td>
					<td>$c[tanggal_berlaku]</td>
					<td>$c[tanggal_expired]</td>
					<td>$c[status]</td>
					<td>
					";
						if ($c['attachement_msds']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[attachement_msds]'>Download</a>";
						}
						else{
							echo "no file";
						}
		
					echo "
					</td>
					<td>$c[pic]</td>
					<td>$c[email_pic]</td>";
					if (isset($_SESSION['username'])) {
						if ($_SESSION['level'] == 'admin') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=msds&action=edit&id=$c[no]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=msds&action=hapus&id=$c[no]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
									</a>
								</td>
							";
						}
					}
					echo "
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

<!-- Bootstrap Datetimepicker-->
<script type="text/javascript">
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

	$(document).ready(function() {
		$('#thndibutuhkan').change(function() {
			ubahtgl();
		});
		$('#blndibutuhkan').change(function() {
			ubahtgl();
		});
	});
</script>
<!-- /Bootstrap Datetimepicker-->