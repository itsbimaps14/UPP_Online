<?php
	if (!isset($_SESSION['username'])) {
		header("location:home");
	}
	$filter="";
	if (isset($_POST['prosedur']) OR isset($_POST['jenis_prosedur']) OR isset($_POST['detail_prosedur']) OR isset($_POST['nama_folder']) OR isset($_POST['lokasi_penyimpanan']) OR isset($_POST['jenis_penyimpanan']) OR isset($_POST['pic_penyimpanan']) OR isset($_POST['searchcari'])) {
		if($_POST['prosedur'] != ''){
			$filter = "";
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
		if ($_POST['prosedur'] == "" AND $_POST['jenis_prosedur'] == "" AND $_POST['detail_prosedur'] == "" AND $_POST['nama_folder'] == "" AND $_POST['lokasi_penyimpanan'] == "" AND $_POST['jenis_penyimpanan'] == "" AND $_POST['pic_penyimpanan'] == "" AND $_POST['searchcari'] == ""){
			header("location:main?index=ddd_mm");
		}
	}

	$tahun = date('Y');
	$hariini = date('Y-m-d');
	$xpengaju=$xemail_pengaju=$xjumlah_copy=$xlokasi_penyimpanan=$xjenis_ddd=$xpic_penyimpanan='';
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {

			case 'edit' :
				$a = mysqli_query($conn, "SELECT * FROM filemaster_ddd WHERE no='$id'");
				$c = mysqli_fetch_array($a);
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nocop = test($_POST['no_copy']);
					$keter = test($_POST['keterangan']);
					mysqli_query($conn,"UPDATE filemaster_ddd SET nomor_copy = '$nocop', keterangan = '$keter' WHERE no = '$id'");
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=ddd_mm'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;width:420px;'>
							Edit Filemaster DDD
						</div>
						<div class='form_process' style='width:410px;height:173px;'>
							<form action='main?index=ddd_mm&action=edit&id=$id' method='post'>
								<a class='j_input_main'>No. Copy</a><br>
								<input class='input_main' type='text' name='no_copy' value='$c[nomor_copy]' required><br>
								<a class='j_input_main'>Keterangan</a><br>
								<input class='input_main' type='text' name='keterangan' value='$c[keterangan]' required><br>
								<input style='margin-left:0px;' class='submit_main fl' type='submit' value='Submit'>
							</form>
						</div>
					</div>
				";
			break;

			case 'hapus' :
				mysqli_query($conn, "DELETE FROM filemaster_ddd WHERE no = '$id'");
				header('location:main?index=ddd_mm');
			break;
		}
	}
?>
<div class='judul_main' style='position:fixed;'>Distribusi Dokumen Hardcopy | Database</div>
<a href='main?index=ddd'><button class='submit_main fl' style='margin-top: 60px;margin-left:120px;'>TAMBAH DDD</button></a>
<a href='main?index=ddd_db'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>DATABASE DDD</button></a>
<a href='main?index=ddd_pd'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>PENGIRIMAN DOKUMEN</button>
<a href='main?index=ddd_mm'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px; color:black; background:#fff6bc;'>MASTER DB DDD</button></a><br><br><br>
<br><br>

<?php
	if(isset($_GET['step'])){
		if($_GET['step']=='create'){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$xdivisi_prosedur=test($_POST['xdivisi']);
				$xprosedur=test($_POST['xprosedur']);
				$xjenis_prosedur=test($_POST['xjenis']);
				$xdetail_prosedur=test($_POST['xdetail']);
				$xnama_folder=test($_POST['xfolder']);
				$xtgl_ddd=test($_POST['xtgl_ddd']);
				$xpengaju=test($_POST['xpengaju']);
				$xemail_pengaju=test($_POST['xemail_pengaju']);
				$xjumlah_copy=test($_POST['xjumlah_copy']);
				$xlokasi_penyimpanan=test($_POST['xlokasi_penyimpanan']);
				$xjenis_ddd = test($_POST['xjenis_ddd']);
				$xpic_penyimpanan=test($_POST['xpic_penyimpanan']);
				if ($xdivisi_prosedur!='' && $xprosedur!='' && $xjenis_prosedur!='' && $xnama_folder!='' && $xpengaju!='' && $xjumlah_copy!='' && $xlokasi_penyimpanan!='' && $xpic_penyimpanan!='') {
					$d=mysqli_query($conn, "SELECT * FROM prosedur WHERE no_divisi_prosedur = '$xdivisi_prosedur' AND no_master_prosedur = '$xprosedur' AND no_jenis_prosedur = '$xjenis_prosedur'AND nama_folder = '$xnama_folder'");
					$e=mysqli_fetch_array($d);
					$no_prosedur=$e['no_prosedur'];
					if ($no_prosedur!=0) {
						for ($i=1; $i <= $xjumlah_copy ; $i++) { 
							mysqli_query($conn, "INSERT INTO filemaster_ddd (no_prosedur,nomor_copy,lokasi_penyimpanan,jenis_penyimpanan,pic_penyimpanan,fmd_norev)
								VALUES ('$no_prosedur','$i','$xlokasi_penyimpanan','$xjenis_ddd','$xpic_penyimpanan','$e[no_revisi]')");
						}
						echo "
							<div id='popup_done' class='popup'>
								<a href='main?index=ddd_mm'>
									<div class='popup_exit'></div>
								</a>
								<div class='popup_upp'>
									<a href='main?index=ddd_mm' class='close-button' title='close'>X</a>
									UPP ONLINE<br>";
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
				}
			}
?>
				<form action='main?index=ddd_mm&step=create#popup_done' method='post' enctype='multipart/form-data'>
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
								<input class='input_main readonly' type='text' name='xtgl_ddd' value='$hariini' readonly required><br>
								<a class='j_input_main'>Pengaju *</a><br>
								<input class='input_main' type='text' name='xpengaju' value='$xpengaju' required><br>
								<a class='j_input_main'>Email Pengaju *</a><br>
								<input class='input_main' type='email' name='xemail_pengaju' value='$xemail_pengaju' required><br>
								<a class='j_input_main'>Divisi Prosedur *</a><br>
								<select class='input_main' name='xdivisi' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur group by divisi_prosedur.divisi_prosedur order by divisi_prosedur.divisi_prosedur");
										while ($c=mysqli_fetch_array($a)) {
											if ($xdivisi_prosedur==$c['no_divisi_prosedur']) {
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
								<select class='input_main' name='xprosedur' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur where prosedur.no_divisi_prosedur='$xdivisi_prosedur' group by master_prosedur.master_prosedur order by master_prosedur.master_prosedur");
										while ($c=mysqli_fetch_array($a)) {
											if ($xprosedur==$c['no_master_prosedur']) {
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
								<select class='input_main' name='xjenis' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur where prosedur.no_divisi_prosedur='$xdivisi_prosedur' AND prosedur.no_master_prosedur='$xprosedur' group by jenis_prosedur.jenis_prosedur order by jenis_prosedur.jenis_prosedur");
										while ($c=mysqli_fetch_array($a)) {
											if ($xjenis_prosedur==$c['no_jenis_prosedur']) {
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
								<select class='input_main' name='xdetail' onchange='this.form.submit()'>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$xdivisi_prosedur' AND no_master_prosedur='$xprosedur' and no_jenis_prosedur='$xjenis_prosedur' group by detail_prosedur order by detail_prosedur");
										while ($c=mysqli_fetch_array($a)) {
											if ($xdetail_prosedur==$c['detail_prosedur']) {
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
								<select class='input_main' name='xfolder' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from prosedur where no_divisi_prosedur='$xdivisi_prosedur' AND no_master_prosedur='$xprosedur' and no_jenis_prosedur='$xjenis_prosedur' and detail_prosedur='$xdetail_prosedur' group by nama_folder order by nama_folder");
										while ($c=mysqli_fetch_array($a)) {
											if ($xnama_folder==$c['nama_folder']) {
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
								<input class='input_main' type='text' name='xjumlah_copy' value='$xjumlah_copy' required><br>
								<a class='j_input_main'>Lokasi Penyimpanan *</a><br>
								<input class='input_main' type='text' name='xlokasi_penyimpanan' value='$xlokasi_penyimpanan' required><br>
								<a class='j_input_main'>Kategori *</a><br>
								<select class='input_main' name='xjenis_ddd' onchange='this.form.submit()' required>
									<option value=''></option>
									";
										if ($xjenis_ddd=='internal') {
											echo "
												<option value='internal' selected>Internal</option>
												<option value='eksternal'>Eksternal</option>
											";
										}
										elseif ($xjenis_ddd=='eksternal'){
											echo "
												<option value='internal'>Internal</option>
												<option value='eksternal' selected>Eksternal</option>
											";
										}
										else{
											echo "
												<option value='internal'>Internal</option>
												<option value='eksternal'>Eksternal</option>
											";
										}
									echo "
								</select><br>
								<a class='j_input_main'>PIC Penyimpanan *</a><br>
								<select class='input_main' name='xpic_penyimpanan' required>
									<option value=''></option>
									";
										$a=mysqli_query($conn, "SELECT * from master_ddd where jenis_ddd='$xjenis_ddd' order by no_copy_master");
										while ($c=mysqli_fetch_array($a)) {
											if ($xpic_penyimpanan==$c['no_master_ddd']) {
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
	?>
<br>&emsp;
<div class='form_main' style='margin-top: 0px;'>
	<form style='margin-bottom:0px;' action='main?index=ddd_mm' method='post' enctype='multipart/form-data'>
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
					$a = mysqli_query($conn , "SELECT * FROM filemaster_ddd INNER JOIN prosedur ON filemaster_ddd.no_prosedur = prosedur.no_prosedur GROUP BY detail_prosedur ");
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
					$a = mysqli_query($conn , "SELECT * FROM filemaster_ddd INNER JOIN prosedur ON filemaster_ddd.no_prosedur = prosedur.no_prosedur GROUP BY nama_folder ");
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
					$a = mysqli_query($conn , "SELECT * FROM filemaster_ddd GROUP BY lokasi_penyimpanan ");
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
					$a = mysqli_query($conn , "SELECT * FROM filemaster_ddd GROUP BY jenis_penyimpanan ");
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
					$a = mysqli_query($conn , "SELECT * FROM filemaster_ddd INNER JOIN master_ddd ON filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd GROUP BY pic_penyimpanan");
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
	<div style='margin-top:13px;'>
		<a href="main?index=ddd_mm&step=create">
			<button class='button_admin'>
				Tambah
			</button>
		</a>
	</div>
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
				$a=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no='$id' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no != '' ".$filter);
			}

			elseif (isset($searchcari)) {
				$a=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE 
						lokasi_penyimpanan LIKE '%$searchcari%' 
						OR filemaster_ddd.keterangan LIKE '%$searchcari%'
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR nomor_copy LIKE '%$searchcari%'
						ORDER BY ".$sort." LIMIT $awal,$akhir
					");
				$page1=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE 
						lokasi_penyimpanan LIKE '%$searchcari%' 
						OR filemaster_ddd.keterangan LIKE '%$searchcari%'
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR nomor_copy LIKE '%$searchcari%'
					");
			}

			else {
				$a=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
					inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE no != '' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "SELECT * FROM filemaster_ddd
					inner join master_ddd on filemaster_ddd.pic_penyimpanan = master_ddd.no_master_ddd 
					inner join prosedur on filemaster_ddd.no_prosedur = prosedur.no_prosedur 
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
						$hal2=$hal;
					}
					elseif ($hal<=2) {
						$hal2=$hal-1;
						$hal3=$hal-1;
						echo "<td><a href='main?index=ddd_mm&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_mm&hal=$hal3$sorturl";
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
						echo "<td><a href='main?index=ddd_mm&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_mm&hal=$hal3$sorturl";
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
							echo"<td><a href='main?index=ddd_mm&hal=$hal2$sorturl";
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
						echo "<td><a href='main?index=ddd_mm&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=ddd_mm&hal=$page$sorturl";
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
			<td>Prosedur</td>
			<td>Kategori Prosedur</td>
			<td>Detail Kategori</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='nama_folder') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=ddd_mm&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=ddd_mm&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=ddd_mm&sort=nama_folder&order=ASC$halurl'>";
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
								echo "<a href='main?index=ddd_mm&sort=nomor_copy&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=ddd_mm&sort=nomor_copy&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=ddd_mm&sort=nomor_copy&order=ASC$halurl'>";
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
			<td colspan="2">Action</td>
		</tr>
		<?php
			$rowscount=$awal+1;
			while ($c=mysqli_fetch_array($a)) {
				if ($rowscount % 2 == 1) {
					echo "
						<tr class='main_table odd'>
							";
							echo "
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[fmd_norev]</td>
							<td>$c[nomor_copy]</td>
							<td>$c[lokasi_penyimpanan]</td>
							<td>$c[jenis_penyimpanan]</td>
							<td>$c[no_copy_master] - $c[penerima]</td>
							<td>$c[keterangan]</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd_mm&action=edit&id=$c[no]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
								</a>
							</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd_mm&action=hapus&id=$c[no]'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
								</a>
							</td>";
						echo "
						</tr>
					";
				}
				elseif ($rowscount % 2 == 0) {
					echo "
						<tr class='main_table even'>
						";
							echo "
							<td>$c[master_prosedur]</td>
							<td>$c[jenis_prosedur]</td>
							<td>$c[detail_prosedur]</td>
							<td>$c[nama_folder]</td>
							<td>$c[fmd_norev]</td>
							<td>$c[nomor_copy]</td>
							<td>$c[lokasi_penyimpanan]</td>
							<td>$c[jenis_penyimpanan]</td>
							<td>$c[no_copy_master] - $c[penerima]</td>
							<td>$c[keterangan]</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd_mm&action=edit&id=$c[no]#popup'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
								</a>
							</td>
							<td style='padding:10px;'>
								<a style='padding-right:5px;color: blue;' href='main?index=ddd_mm&action=hapus&id=$c[no]'>
									<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
								</a>
							</td>";
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