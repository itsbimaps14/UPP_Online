<?php
	if (!isset($_SESSION['username'])) {
		header("location:home");
	}
	$filter="";
	if (isset($_POST['status']) OR isset($_POST['prosedur']) OR isset($_POST['jenis_prosedur']) OR isset($_POST['detail_prosedur']) OR isset($_POST['nama_folder']) OR isset($_POST['lokasi_penyimpanan']) OR isset($_POST['jenis_penyimpanan']) OR isset($_POST['pic_penyimpanan']) OR isset($_POST['searchcari'])) {
		if($_POST['status'] != ''){
			$filter = "";
			$filter = $filter."and ddds2status = '".$_POST['status']."'";
			$status = $_POST['status'];
		}
		if($_POST['prosedur'] != ''){
			$filter = $filter."and master_prosedur = '".$_POST['prosedur']."'";
			$prosedur = $_POST['prosedur'];
		}
		if($_POST['jenis_prosedur'] != ''){
			$filter = $filter."and jenis_prosedur = '".$_POST['jenis_prosedur']."'";
			$jenis_prosedur = $_POST['jenis_prosedur'];
		}
		if($_POST['detail_prosedur'] != ''){
			$filter = $filter."and detail_prosedur = '".$_POST['detail_prosedur']."'";
			$detail_prosedur = $_POST['detail_prosedur'];
		}
		if($_POST['nama_folder'] != ''){
			$filter = $filter."and nama_folder = '".$_POST['nama_folder']."'";
			$nama_folder = $_POST['nama_folder'];
		}
		if($_POST['lokasi_penyimpanan'] != ''){
			$filter = $filter."and lokasi_penyimpanan = '".$_POST['lokasi_penyimpanan']."'";
			$lokasi_penyimpanan = $_POST['lokasi_penyimpanan'];
		}
		if($_POST['jenis_penyimpanan'] != ''){
			$filter = $filter."and jenis_penyimpanan = '".$_POST['jenis_penyimpanan']."'";
			$jenis_penyimpanan = $_POST['jenis_penyimpanan'];
		}
		if($_POST['pic_penyimpanan'] != ''){
			$filter = $filter."and pic_penyimpanan = '".$_POST['pic_penyimpanan']."'";
			$pic_penyimpanan = $_POST['pic_penyimpanan'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
		}
		if ($_POST['status'] == "" AND $_POST['prosedur'] == "" AND $_POST['jenis_prosedur'] == "" AND $_POST['detail_prosedur'] == "" AND $_POST['nama_folder'] == "" AND $_POST['lokasi_penyimpanan'] == "" AND $_POST['jenis_penyimpanan'] == "" AND $_POST['pic_penyimpanan'] == "" AND $_POST['searchcari'] == ""){
			header("location:main?index=ddd_db");
		}
	}

	$st1=array('done','ok','validasi');
	$st2=array('Sudah Kirim','Belum Kirim','Validasi Copy');
	$tahun = date('Y');
	$hariini = date('Y-m-d');
	$harisls = date('Y-m-d', strtotime('+3 days', strtotime($hariini)));
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {


			case 'hapus':
				$a = mysqli_query($conn, "SELECT * FROM ddd_s2 WHERE no = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					mysqli_query($conn, "DELETE FROM ddd_s2 WHERE no = '$id'");
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd_db'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form DDD | Database
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:auto;'>
							<form action='main?index=ddd_db&action=hapus&id=$id' method='post'  enctype='multipart/form-data'>
								<center>
									<a style='font-size:14px;'>Penghapusan data DB DDD dengan No : $id <br>Klik button dibawah ini.</a><br><br>
								</center>
								<input style='margin-left:180px;' class='submit_main fl' type='submit' value='OK'>
							</form>
						</div>
					</div>
				";
			break;

			case 'tambah':
				$a = mysqli_query($conn, "SELECT * FROM ddd_s2 WHERE no = '$id'");
				$c = mysqli_fetch_array($a);

				$x = mysqli_query($conn, "SELECT * FROM ddd_s2 
					WHERE no_ddd = '$c[no_ddd]'
					AND no_prosedur = '$c[no_prosedur]'
					AND lokasi_penyimpanan = '$c[lokasi_penyimpanan]'
					AND pic_penyimpanan = '$c[pic_penyimpanan]'
					AND jenis_penyimpanan = '$c[jenis_penyimpanan]'
					");
				$z = mysqli_num_rows($x);
				$z = $z + 1;
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
							'$c[no_ddd]',
							'$c[no_prosedur]',
							'$z',
							'$c[lokasi_penyimpanan]',
							'$c[jenis_penyimpanan]',
							'$c[pic_penyimpanan]',
							'$c[keterangan]',
							'$c[ddd2_no_revisi]')");

				mysqli_query($conn, "UPDATE ddd SET jumlah_copy = '$z'
					WHERE no_ddd = '$c[no_ddd]'
					AND no_prosedur = '$c[no_prosedur]'
					AND lokasi_penyimpanan = '$c[lokasi_penyimpanan]'
					AND pic_penyimpanan = '$c[pic_penyimpanan]'
					AND jenis_penyimpanan = '$c[jenis_penyimpanan]'
					");


				header("location:main?index=ddd_db");
			break;

			case 'kirim':

				$a = mysqli_query($conn, "SELECT * FROM ddd_s2 WHERE no = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_kirim = test($_POST['tgl_kirim']);

					mysqli_query($conn, "UPDATE ddd_s2 SET ddds2status = 'done' WHERE no = '$id'");

					$tmp1a = mysqli_query ($conn, "SELECT * FROM ddd_tmp
						WHERE tahun = '$tahun'
						AND nomor_copy = '$c[nomor_copy]'
						AND lokasi_penyimpanan = '$c[lokasi_penyimpanan]'
						AND jenis_penyimpanan = '$c[jenis_penyimpanan]'
						AND pic_penyimpanan = '$c[pic_penyimpanan]'
						AND tgl_kirim = '$tgl_kirim'
						");
					$tmp1c = mysqli_fetch_array($tmp1a);
					$tmp1b = mysqli_num_rows($tmp1a);

					if ($tmp1b == 0) {
						$tmp2a = mysqli_query($conn, "SELECT * FROM ddd_tmp");
						$tmp2b = mysqli_num_rows($tmp2a);
						$tmp2b = $tmp2b + 1 ;
						if ($tmp2b < 10) {
							$tmp2b = '00'.$tmp2b;
						}
						elseif ($tmp2b < 100) {
							$tmp2b = '0'.$tmp2b;
						}
						$tmp2b = $tmp2b.'/DDD/'.$tahun;
						mysqli_query($conn, "INSERT INTO ddd_tmp (
							no_running,
							tahun,
							nomor_copy,
							lokasi_penyimpanan,
							jenis_penyimpanan,
							pic_penyimpanan,
							tgl_kirim)
							VALUES(
							'$tmp2b',
							'$tahun',
							'$c[nomor_copy]',
							'$c[lokasi_penyimpanan]',
							'$c[jenis_penyimpanan]',
							'$c[pic_penyimpanan]',
							'$tgl_kirim')");

						$tmp1aa = mysqli_query ($conn, "SELECT * FROM ddd_tmp
							WHERE tahun = '$tahun'
							AND nomor_copy = '$c[nomor_copy]'
							AND lokasi_penyimpanan = '$c[lokasi_penyimpanan]'
							AND jenis_penyimpanan = '$c[jenis_penyimpanan]'
							AND pic_penyimpanan = '$c[pic_penyimpanan]'
							AND tgl_kirim = '$tgl_kirim'
							");
						$tmp1cc = mysqli_fetch_array($tmp1aa);
						$tmp1bb = mysqli_num_rows($tmp1aa);

						mysqli_query($conn, "INSERT INTO ddd_s3 (
							no_running,
							no_prosedur,
							nomor_copy,
							lokasi_penyimpanan,
							jenis_penyimpanan,
							pic_penyimpanan,
							tgl_kirim,
							s3_keterangan,
							ddd3_no_revisi)
							VALUES(
							'$tmp1cc[no_running]',
							'$c[no_prosedur]',
							'$tmp1cc[nomor_copy]',
							'$tmp1cc[lokasi_penyimpanan]',
							'$tmp1cc[jenis_penyimpanan]',
							'$tmp1cc[pic_penyimpanan]',
							'$tgl_kirim',
							'$tmp1cc[keterangan]',
							'$c[ddd2_no_revisi]'
							)");
					}
					else{
						mysqli_query($conn, "INSERT INTO ddd_s3 (
							no_running,
							no_prosedur,
							nomor_copy,
							lokasi_penyimpanan,
							jenis_penyimpanan,
							pic_penyimpanan,
							tgl_kirim,
							s3_keterangan,
							ddd3_no_revisi)
							VALUES(
							'$tmp1c[no_running]',
							'$c[no_prosedur]',
							'$tmp1c[nomor_copy]',
							'$tmp1c[lokasi_penyimpanan]',
							'$tmp1c[jenis_penyimpanan]',
							'$tmp1c[pic_penyimpanan]',
							'$tgl_kirim',
							'$tmp1c[keterangan]',
							'$c[ddd2_no_revisi]'
							)");
					}
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd_db&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Form DDD | Database
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:auto;'>
							<form action='main?index=ddd_db&action=kirim&id=$id' method='post'  enctype='multipart/form-data'>
								<div class='form_main'>
									<a class='j_input_main'>Tanggal Kirim</a><br>
									<input class='input_main' type='text' name='tgl_kirim' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
									<input style='margin-left:5px;' class='submit_main fr' type='submit' value='Submit'>
								</div>
							</form>
						</div>
					</div>
				";
			break;

			case 'edit' :

				$a = mysqli_query($conn, "SELECT * FROM ddd_s2 WHERE no = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_cop = test($_POST['no_copy']);
					$ket_db_ddd = test($_POST['ket_db_ddd']);
					mysqli_query($conn, "UPDATE ddd_s2 SET 
						nomor_copy = '$no_cop',
						keterangan = '$ket_db_ddd',
						ddds2status = 'ok'
						WHERE no = '$id'");
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd_db'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;width:420px;'>
							Form Batal
						</div>
						<div class='form_process' style='width:410px;height:190px;'>
							<form action='main?index=ddd_db&action=edit&id=$id' method='post'>
								<a class='j_input_main'>No. Copy</a><br>
								<input class='input_main' type='text' name='no_copy' value='$c[nomor_copy]' required><br>
								<a class='j_input_main'>Keterangan</a><br>
									<textarea class='input_main' type='text' name='ket_db_ddd' value='' required style='width:100%;max-width:100%;'>$c[keterangan]</textarea><br>
								<input style='margin-left:0px;' class='submit_main fl' type='submit' value='Submit'>
							</form>
						</div>
					</div>
				";
			break;
		}
	}
?>
<div class='judul_main' style='position:fixed;'>Distribusi Dokumen Hardcopy | Database</div>
<a href='main?index=ddd'><button class='submit_main fl' style='margin-top: 60px;margin-left:120px;'>TAMBAH DDD</button></a>
<a href='main?index=ddd_db'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px; color:black; background:#fff6bc;'>DATABASE DDD</button></a>
<a href='main?index=ddd_pd'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>PENGIRIMAN DOKUMEN</button>
<a href='main?index=ddd_mm'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>MASTER DB DDD</button></a><br><br><br>
<br><br><br>&emsp; 
<div class='form_main' style='margin-top: 0px;'>
	<form style='margin-bottom:0px;' action='main?index=ddd_db' method='post' enctype='multipart/form-data'>
			<select class='input_main' name='status' onchange='this.form.submit()' style='font-family:arial;width:130px;'>
				<option value=''>No Running</option>
				<?php
					for ($a=0; $a < 3; $a++) {
						if ($status == $st1[$a]) {
							echo "<option value='$st1[$a]' selected>$st2[$a]</option>";}
						else{
							echo "<option value='$st1[$a]'>$st2[$a]</option>";}
					}
				?>
			</select>
			<select class='input_main' name='prosedur' onchange='this.form.submit()' style='font-family:arial;width:100px;'>
				<option value=''>Prosedur</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM master_prosedur");
					while($c=mysqli_fetch_array($a)){
						if ($prosedur==$c['master_prosedur']) {
							echo "<option value='$c[master_prosedur]' selected>$c[nm_prosedur]</option>";}
						else{
							echo "<option value='$c[master_prosedur]'>$c[nm_prosedur]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='jenis_prosedur' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
				<option value=''>Kategori Prosedur</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM jenis_prosedur");
					while($c=mysqli_fetch_array($a)){
						if ($jenis_prosedur==$c['jenis_prosedur']) {
							echo "<option value='$c[jenis_prosedur]' selected>$c[jenis_prosedur]</option>";}
						else{
							echo "<option value='$c[jenis_prosedur]'>$c[jenis_prosedur]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='detail_prosedur' onchange='this.form.submit()' style='font-family:arial;width:145px;'>
				<option value=''>Detail Prosedur</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM ddd_s2 INNER JOIN prosedur ON ddd_s2.no_prosedur = prosedur.no_prosedur GROUP BY detail_prosedur ");
					while($c=mysqli_fetch_array($a)){
						if ($detail_prosedur==$c['detail_prosedur']) {
							echo "<option value='$c[detail_prosedur]' selected>$c[detail_prosedur]</option>";}
						else{
							echo "<option value='$c[detail_prosedur]'>$c[detail_prosedur]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='nama_folder' onchange='this.form.submit()' style='font-family:arial;width:110px;'>
				<option value=''>Nama File</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM ddd_s2 INNER JOIN prosedur ON ddd_s2.no_prosedur = prosedur.no_prosedur GROUP BY nama_folder ");
					while($c=mysqli_fetch_array($a)){
						if ($nama_folder==$c['nama_folder']) {
							echo "<option value='$c[nama_folder]' selected>$c[nama_folder]</option>";}
						else{
							echo "<option value='$c[nama_folder]'>$c[nama_folder]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='lokasi_penyimpanan' onchange='this.form.submit()' style='font-family:arial;width:160px;'>
				<option value=''>Nama Departemen</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM ddd_s2 GROUP BY lokasi_penyimpanan ");
					while($c=mysqli_fetch_array($a)){
						if ($lokasi_penyimpanan==$c['lokasi_penyimpanan']) {
							echo "<option value='$c[lokasi_penyimpanan]' selected>$c[lokasi_penyimpanan]</option>";}
						else{
							echo "<option value='$c[lokasi_penyimpanan]'>$c[lokasi_penyimpanan]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='jenis_penyimpanan' onchange='this.form.submit()' style='font-family:arial;width:100px;'>
				<option value=''>Kategori</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM ddd_s2 GROUP BY jenis_penyimpanan ");
					while($c=mysqli_fetch_array($a)){
						if ($jenis_penyimpanan==$c['jenis_penyimpanan']) {
							echo "<option value='$c[jenis_penyimpanan]' selected>$c[jenis_penyimpanan]</option>";}
						else{
							echo "<option value='$c[jenis_penyimpanan]'>$c[jenis_penyimpanan]</option>";}
					}

				?>
			</select>
			<select class='input_main' name='pic_penyimpanan' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
				<option value=''>PJ</option>
				<?php
					$a = mysqli_query($conn , "SELECT * FROM ddd_s2 INNER JOIN master_ddd ON ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd GROUP BY pic_penyimpanan");
					while($c=mysqli_fetch_array($a)){
						if ($pic_penyimpanan==$c['pic_penyimpanan']) {
							echo "<option value='$c[pic_penyimpanan]' selected>$c[no_copy_master] - $c[penerima]</option>";}
						else{
							echo "<option value='$c[pic_penyimpanan]'>$c[no_copy_master] - $c[penerima]</option>";}
					}

				?>
			</select>
			<br>
			<?php
				if (isset($searchcari)) {
					echo "<input class='input_main' name='searchcari' value='$searchcari' placeholder='Search by Keyword' style='width:200px;margin:0px;' onchange='this.form.submit()'>";
				}
				else{
					echo "<input class='input_main' name='searchcari' placeholder='Search by Keyword' style='width:200px;margin:0px;' onchange='this.form.submit()'>";
				}
			?>
	</form>
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
				$a=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no='$id' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no != '' AND no_ddd = '$id' ".$filter);
			}

			elseif (isset($searchcari)) {
				$a=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE 
						lokasi_penyimpanan LIKE '%$searchcari%' 
						OR ddd_s2.keterangan LIKE '%$searchcari%'
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR nomor_copy LIKE '%$searchcari%'
						ORDER BY ".$sort." LIMIT $awal,$akhir
					");
				$page1=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE 
						lokasi_penyimpanan LIKE '%$searchcari%' 
						OR ddd_s2.keterangan LIKE '%$searchcari%'
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR nomor_copy LIKE '%$searchcari%'
					");
			}

			else {
				$a=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no != '' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "SELECT * FROM ddd_s2
					inner join master_ddd on ddd_s2.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on ddd_s2.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
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
				<br>
				<table class='page_number'>
					<tr>
					";
					if ($hal<2) {
						echo "<td>First</a></td>";
						echo "<td>Previous</a></td>";
						$hal2=$hal;}

					elseif ($hal<=2) {

						$hal2=$hal-1;
						$hal3=$hal-1;
						echo "<td><a href='main?index=ddd_db&hal=1$sorturl";

						if(isset($_POST['st'])){
							echo"&st=".$_POST['st']."";}

						else if(isset ($_GET['st'])){
							echo"&st=".$_GET['st']."";}
						
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_db&hal=$hal3$sorturl";
								
						if(isset($_POST['st'])){
							echo"&st=".$_POST['st']."";}

						else if(isset ($_GET['st'])){
							echo"&st=".$_GET['st']."";}

						echo"'>Previous</a></td>";
					}

					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=ddd_db&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_db&hal=$hal3$sorturl";
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
							echo"<td><a href='main?index=ddd_db&hal=$hal2$sorturl";
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
						echo "<td><a href='main?index=ddd_db&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=ddd_db&hal=$page$sorturl";
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
	<table id='tableID' class='table_admin'>
		<tr class='top_table'>
			<td>Status</td>
			<td>Prosedur</td>
			<td>Kategori Prosedur</td>
			<td>Detail Kategori</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='nama_folder') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=ddd_db&step=create&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=ddd_db&step=create&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=ddd_db&step=create&sort=nama_folder&order=ASC$halurl'>";
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
			<td>No Revisi</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='nomor_copy') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=ddd_db&step=create&sort=nomor_copy&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=ddd_db&step=create&sort=nomor_copy&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=ddd_db&step=create&sort=nomor_copy&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. Copy
					</a>
					";
				?>
			</td>
			<td>Nama Dept</td>
			<td>Kategori</td>
			<td>PJ</td>
			<td>Keterangan</td>
			<?php
				if (isset($_SESSION['username'])) {
					echo "<td colspan='4'>Action</td>";}
			?>
		</tr>
		<?php
			$rowscount=$awal+1;
			while ($c=mysqli_fetch_array($a)) {
				if ($rowscount % 2 == 1) {
					echo "
						<tr class='main_table odd'>
							";
							if ($c['ddds2status'] == 'done') {
								echo "<td style='background:#92d050;'>Sudah Kirim</td>";
							}
							elseif ($c['ddds2status'] == 'ok') {
								echo "<td style='background:#fcff00;'>Belum Kirim</td>";
							}
							elseif ($c['ddds2status'] == 'validasi') {
								echo "<td style='background:#fff6bc;'>Validasi Copy</td>";
							}

							echo "
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[ddd2_no_revisi]</td>
							<td>$c[nomor_copy]</td>
							<td>$c[lokasi_penyimpanan]</td>
							<td>$c[jenis_penyimpanan]</td>
							<td>$c[no_copy_master] - $c[penerima]</td>
							<td>$c[keterangan]</td>";
							if (isset($_SESSION['username'])) {
								if ($c['ddds2status'] == 'ok') {
									echo "
										<td><a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=kirim&id=$c[no]#popup'>Kirim Dokumen</a></td>
									";
								}
								else{
									echo "
										<td>Kirim Dokumen</td>
									";
								}
								echo "
								<td>
									<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=tambah&id=$c[no]#popup'>
										Tambah Copy
									</a>
								</td>
								";
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=edit&id=$c[no]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
										</a>
									</td>
								";
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=hapus&id=$c[no]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
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
							if ($c['ddds2status']=='done') {
								echo "<td style='background:#92d050;'>Sudah Kirim</td>";
							}
							elseif ($c['ddds2status']=='ok') {
								echo "<td style='background:#fcff00;'>Belum Kirim</td>";
							}
							elseif ($c['ddds2status'] == 'validasi') {
								echo "<td style='background:#fff6bc;'>Validasi Copy</td>";
							}
							echo "
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[ddd2_no_revisi]</td>
							<td>$c[nomor_copy]</td>
							<td>$c[lokasi_penyimpanan]</td>
							<td>$c[jenis_penyimpanan]</td>
							<td>$c[no_copy_master] - $c[penerima]</td>
							<td>$c[keterangan]</td>";
							if (isset($_SESSION['username'])) {
								if ($c['ddds2status'] == 'ok') {
									echo "
										<td><a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=kirim&id=$c[no]#popup'>Kirim Dokumen</a></td>
									";
								}
								else{
									echo "
										<td>Kirim Dokumen</td>
									";
								}
								echo "
								<td>
									<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=tambah&id=$c[no]#popup'>
										Tambah Copy
									</a>
								</td>
								";
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=edit&id=$c[no]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
										</a>
									</td>
								";
								echo "
									<td style='padding:10px;'>
										<a style='padding-right:5px;color: blue;' href='main?index=ddd_db&action=hapus&id=$c[no]#popup'>
											<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
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
			echo "
				</table>
			</div>
			";
		?>