<?php
	if (!isset($_SESSION['username'])) {
		header("location:home");
	}
	$hariini = date('Y-m-d');
	$filter = '';
	if (isset($_POST['no_running']) OR isset($_POST['tahun']) OR isset($_POST['lokasi_penyimpanan']) OR isset($_POST['nomor_copy']) 
		or isset($_POST['stat_ddd'])) {
		if($_POST['no_running'] != ''){
			$filter = "";
			$filter = $filter."and no_running = '".$_POST['no_running']."'";
			$no_running = $_POST['no_running'];
		}
		if($_POST['tahun'] != ''){
			$filter = $filter."and tahun = '".$_POST['tahun']."'";
			$tahun = $_POST['tahun'];
		}
		if($_POST['lokasi_penyimpanan'] != ''){
			$filter = $filter."and lokasi_penyimpanan = '".$_POST['lokasi_penyimpanan']."'";
			$lokasi_penyimpanan = $_POST['lokasi_penyimpanan'];
		}
		if($_POST['nomor_copy'] != ''){
			$filter = $filter."and nomor_copy = '".$_POST['nomor_copy']."'";
			$nomor_copy = $_POST['nomor_copy'];
		}
		if($_POST['stat_ddd'] != ''){
			$stat_ddd = $_POST['stat_ddd'];
			if ($stat_ddd == 'waiting') {
				$filter = $filter."and tgl_kembali = '0000-00-00'";
			}
			elseif ($stat_ddd == 'closed'){
				$filter = $filter."and tgl_kembali != '0000-00-00'";
			}
			else{
				$stat_ddd = '';
			}
		}
		if ($_POST['no_running'] == "" AND $_POST['tahun'] == "" AND $_POST['lokasi_penyimpanan'] == "" AND $_POST['nomor_copy'] == ""
			AND $_POST['stat_ddd'] == ""){
			header("location:main?index=ddd_pd");
		}
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'masuk' :
				$a = mysqli_query($conn, "SELECT * FROM ddd_s3 WHERE no_running = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$tgl_kembali = test($_POST['tgl_kembali']);
					$keterangan = test($_POST['keterangan']);
					$no = substr($id, 0,3);

					$uploadOk = 1;
					$file_spd = $_FILES['file_spd']['name'];
					if ($file_spd != '') {

						unlink($c['file_ds3']);

						if (!file_exists('file_upload/ddd/'.$no)) {
							mkdir('file_upload/ddd/'.$no);
						}

						$folder1 = 'file_upload/ddd/'.$no.'/';
						$file_user1 = $_FILES['file_spd']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['file_spd']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);
							mysqli_query($conn, "UPDATE ddd_s3 SET
								file_ds3 = '$file_fmea_rename',
								tgl_kembali = '$hariini',
								s3_keterangan = '$keterangan',
								ds3_status = 'closed'
								WHERE no_running = '$id'
								");
							mysqli_query($conn, "UPDATE ddd_tmp SET
								tgl_kembali = '$hariini'
								WHERE no_running = '$id'
								");
						}
					}

				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=ddd_pd&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Attachment SPD
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=ddd_pd&action=masuk&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Tanggal Kembali *</a><br>
									<input class='input_main readonly' type='text' name='tgl_kembali' value='$hariini' required readonly><br>
								<a class='j_input_main'>File Attachment SPD *<font size='1' color='red'> ) Max File Size = 1MB</font></a><br>
									<input class='file_main' type='file' name='file_spd' onchange='valid(this)' required><br>
								<div class='alert_adm alert' id='ugg1' style='width:94%;'>File Upload max Size is 1MB / 1024KB !</div>
								<div class='alert_adm alert2' id='ubr1' style='width:94%;'>File is OK !</div>";?>
								<script>
									window.onload = function(){
										document.getElementById('ugg1').style.display = "none";
										document.getElementById('ubr1').style.display = "none";}

									function valid(file) {
										var FileSize = file.files[0].size / 1024 / 1024; // in MB
										if (FileSize > 2) {
											document.getElementById('ubr1').style.display = "none";
											document.getElementById('ugg1').style.display = "block";
											document.getElementById('subsub').style.display = "none";
										} else {
											document.getElementById('ugg1').style.display = "none";
											document.getElementById('ubr1').style.display = "block";
											document.getElementById('subsub').style.display = "block";
										}
									}
								</script>
								<?php echo" 
								<a class='j_input_main'>Keterangan *</a><br>
									<textarea class='input_main' name='keterangan' placeholder='Keterangan' required></textarea><br>
								<input style='margin-left:145px;' class='submit_main fl' id='subsub' type='submit' value='Submit'>
							</form>
						</div>
					</div>";
			break;
		}
	}
?>
<div class='judul_main' style='position:fixed;'>Distribusi Dokumen Hardcopy | Pengiriman Document</div>
<a href='main?index=ddd'><button class='submit_main fl' style='margin-top: 60px;margin-left:120px;'>TAMBAH DDD</button></a>
<a href='main?index=ddd_db'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>DATABASE DDD</button></a>
<a href='main?index=ddd_pd'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;color:black; background:#fff6bc;'>PENGIRIMAN DOKUMEN</button>
<a href='main?index=ddd_mm'><button class='submit_main fl' style='margin-top: 60px;margin-left:80px;'>MASTER DB DDD</button></a><br><br><br>
<br><br>&emsp; 
<div class='form_main' style='margin-top: 0px;'>
	<form style='margin-bottom:0px;' action='main?index=ddd_pd' method='post' enctype='multipart/form-data'>
		<select class='input_main' name='no_running' onchange='this.form.submit()' style='font-family:arial;width:135px;'>
			<option value=''>No Running</option>
			<?php
				$a = mysqli_query($conn , "SELECT * FROM ddd_tmp");
				while($c=mysqli_fetch_array($a)){
					if ($no_running==$c['no_running']) {
						echo "<option value='$c[no_running]' selected>$c[no_running]</option>";}
					else{
						echo "<option value='$c[no_running]'>$c[no_running]</option>";}
				}

			?>
		</select>
		<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:80px;'>
			<option value=''>Tahun</option>
			<?php
				$year = date('Y')+1;
				for ($i=$year; $i > 1997; $i--) {
					if ($tahun==$i) {
						echo " <option value='$i' selected>$i</option> "; }
					else{
						echo " <option value='$i'>$i</option> "; }
				}
			?>
		</select>
		<select class='input_main' name='lokasi_penyimpanan' onchange='this.form.submit()' style='font-family:arial;width:180px;'>
			<option value=''>Lokasi Penyimpanan</option>
			<?php
				$a = mysqli_query($conn , "SELECT * FROM ddd_tmp GROUP BY lokasi_penyimpanan");
				while($c=mysqli_fetch_array($a)){
					if ($lokasi_penyimpanan==$c['lokasi_penyimpanan']) {
						echo "<option value='$c[lokasi_penyimpanan]' selected>$c[lokasi_penyimpanan]</option>";}
					else{
						echo "<option value='$c[lokasi_penyimpanan]'>$c[lokasi_penyimpanan]</option>";}
				}
			?>
		</select>
		<select class='input_main' name='nomor_copy' onchange='this.form.submit()' style='font-family:arial;width:80px;'>
			<option value=''>Copy</option>
			<?php
				$a = mysqli_query($conn , "SELECT * FROM ddd_tmp GROUP BY nomor_copy");
				while($c=mysqli_fetch_array($a)){
					if ($nomor_copy==$c['nomor_copy']) {
						echo "<option value='$c[nomor_copy]' selected>$c[nomor_copy]</option>";}
					else{
						echo "<option value='$c[nomor_copy]'>$c[nomor_copy]</option>";}
				}
			?>
		</select>
		<select class='input_main' name='stat_ddd' onchange='this.form.submit()' style='font-family:arial;width:90px;'>
			<option value=''>Status</option>
			<?php
					if ($stat_ddd == 'waiting') {
						echo "<option value='waiting' selected>Waiting</option>";
						echo "<option value='closed'>Closed</option>";}
					elseif ($stat_ddd == 'closed') {
						echo "<option value='waiting'>Waiting</option>";
						echo "<option value='closed' selected>Closed</option>";}
					else{
						echo "<option value='waiting'>Waiting</option>";
						echo "<option value='closed'>Closed</option>";}
			?>
		</select>
	</form>
	<?php
			$sort="no_running DESC";
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
			if(!empty($filter)) {
				$awal=0;
				$akhir=2147483647;
			}
			else{
				$awal=($hal-1)*10;
				$akhir=10;
			}
			
			if (isset($id)) {
				$a=mysqli_query($conn, "
					SELECT * FROM ddd_tmp
						inner join master_ddd on ddd_tmp.pic_penyimpanan = master_ddd.no_master_ddd 
						WHERE no_running != '' AND no_running = '$id'
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
				$page1=mysqli_query($conn, "
					SELECT * FROM ddd_tmp
						inner join master_ddd on ddd_tmp.pic_penyimpanan = master_ddd.no_master_ddd 
						WHERE no_running != '' AND no_running = '$id' ".$filter);
			}

			else {
				$a=mysqli_query($conn, "
					SELECT * FROM ddd_tmp
						inner join master_ddd on ddd_tmp.pic_penyimpanan = master_ddd.no_master_ddd 
						WHERE no_running != ''
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
				$page1=mysqli_query($conn, "
					SELECT * FROM ddd_tmp
						inner join master_ddd on ddd_tmp.pic_penyimpanan = master_ddd.no_master_ddd 
						WHERE no_running != '' ".$filter);
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
						echo "<td><a href='main?index=ddd_pd&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_pd&step=create&hal=$hal3$sorturl";
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
						echo "<td><a href='main?index=ddd_pd&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=ddd_pd&step=create&hal=$hal3$sorturl";
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
							echo"<td><a href='main?index=ddd_pd&step=create&hal=$hal2$sorturl";
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
						echo "<td><a href='main?index=ddd_pd&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=ddd_pd&step=create&hal=$page$sorturl";
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
			<td>No SPD.</td>
			<td>Kategori Pengiriman</td>
			<td>Nama Dept</td>
			<td>PJ</td>
			<td>No. Copy</td>
			<td>Prosedur</td>
			<td>No. UPP</td>
			<td>Deskripsi dokumen</td>
			<td>Revisi</td>
			<td>Tgl Berlaku</td>
			<td>Tgl Kirim</td>
			<td>Tgl Kembali</td>
			<td>Dokumen yang Kembali</td>
			<td>Revisi tidak berlaku</td>
			<td style='width: 70px;'>Create SPD</td>
			<td colspan="2" style="width: auto;">Attachment SPD</td>
			<td>Status DDD</td>
			<td>Keterangan</td>
			<td>Leadtime (hr)</td>
			<td>Status Leadtime</td>
		</tr>
	<?php
		$rowscount = 1;
		while ($c1 = mysqli_fetch_array($a)){

			if ($c1['tgl_kembali'] != '0000-00-00' ) {
				$selisih = strtotime($c1['tgl_kembali']) - strtotime($c1['tgl_kirim']);
				$selisih = $selisih/(60*60*24);
				if ($selisih > 7) {
					$st_ok = 'Tidak OK';
				}
				else{
					$st_ok = 'OK';
				}
			}
			else{
				$st_ok = '';
				$selisih = '';
			}
			
			$aa = mysqli_query($conn, "SELECT * FROM
											ddd_s3,
											master_ddd,
											prosedur,
											divisi_prosedur,
											master_prosedur,
											jenis_prosedur,
											upp
										WHERE
											no_running = '$c1[no_running]'
										AND ddd_s3.pic_penyimpanan = master_ddd.no_master_ddd
										AND ddd_s3.no_prosedur = prosedur.no_prosedur
										AND prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur
										AND prosedur.no_master_prosedur = master_prosedur.no_master_prosedur
										AND prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
										AND prosedur.no_divisi_prosedur = upp.no_divisi_prosedur
										AND prosedur.no_master_prosedur = upp.no_master_prosedur
										AND prosedur.no_jenis_prosedur = upp.no_jenis_prosedur
										AND prosedur.nama_folder = upp.nama_folder
										AND ddd_s3.ddd3_no_revisi = upp.no_revisi
							");
			$b1 = mysqli_num_rows($aa);
			$t_b1 = $b1;

			if ($rowscount % 2 == 1) {
				echo "
					<tr class='main_table odd' style='background:#fff6bc;'>
						<td rowspan='$b1'>$c1[no_running]</td>
						<td rowspan='$b1'>$c1[jenis_penyimpanan]</td>
						<td rowspan='$b1'>$c1[lokasi_penyimpanan]</td>
						<td rowspan='$b1'>$c1[no_copy_master] - $c1[penerima]</td>
						<td rowspan='$b1'>$c1[nomor_copy]</td>
				";
						while ($cx = mysqli_fetch_array($aa)) {
							if ($t_b1 == $b1){
								$nrev = $cx['ddd3_no_revisi'] - 1;
								echo "
									<td>$cx[master_prosedur]</td>
									<td>$cx[no_upp]</td>
									<td>$cx[nama_folder]</td>
									<td>$cx[ddd3_no_revisi]</td>
									<td>$cx[tgl_revisi]</td>
									<td rowspan='$b1'>$c1[tgl_kirim]</td>
									<td rowspan='$b1'>$c1[tgl_kembali]</td>
									<td>$cx[nama_folder]</td>
									<td>$nrev</td>
									<td rowspan='$b1'>
										<form action='excel/spd.php' method='post'>
											<input type='hidden' name=untuk_spd value=$c1[no_running]>
											<button type='submit' value='H' style='width: 50px; height: 30px; margin-top:15%;'>
											SPD
										</form>
									</td>
									<td rowspan='$b1'>
										<a href='main?index=ddd_pd&action=masuk&id=$c1[no_running]#popup'>
											<u>Attach</u>
										</a>
									</td>
									<td rowspan='$b1'>";
										if ($cx['file_ds3']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$cx[file_ds3]'>Download</a>";
										}
										else{
											echo "no file";
										}
									echo " </td>
									<td rowspan='$b1'>$cx[ds3_status]</td>
									<td>$cx[s3_keterangan]</td>
									<td rowspan='$b1'>$selisih</td>
									<td rowspan='$b1'>$st_ok</td>
					</tr>
								";}
							else {
								$nrev = $cx['no_revisi'] - 1;
								echo "
									<tr class='main_table odd' style='background:#f0ca77;'>
										<td>$cx[master_prosedur]</td>
										<td>$cx[no_upp]</td>
										<td>$cx[nama_folder]</td>
										<td>$cx[no_revisi]</td>
										<td>$cx[tgl_revisi]</td>
										<td>$cx[nama_folder]</td>
										<td>$nrev</td>
										<td>$cx[s3_keterangan]</td>
									</tr>
								";}
							$t_b1--;
						}
					echo "
						
					";
			}
			if ($rowscount % 2 == 0) {
				echo "
					<tr class='main_table even'>
						<td rowspan='$b1'>$c1[no_running]</td>
						<td rowspan='$b1'>$c1[jenis_penyimpanan]</td>
						<td rowspan='$b1'>$c1[lokasi_penyimpanan]</td>
						<td rowspan='$b1'>$c1[no_copy_master] - $c1[penerima]</td>
						<td rowspan='$b1'>$c1[nomor_copy]</td>
				";
						while ($cx = mysqli_fetch_array($aa)) {
							if ($t_b1 == $b1){
								$nrev = $cx['no_revisi'] - 1;
								echo "
									<td>$cx[master_prosedur]</td>
									<td>$cx[no_upp]</td>
									<td>$cx[nama_folder]</td>
									<td>$cx[ddd3_no_revisi]</td>
									<td>$cx[tgl_revisi]</td>
									<td rowspan='$b1'>$c1[tgl_kirim]</td>
									<td rowspan='$b1'>$c1[tgl_kembali]</td>
									<td>$cx[nama_folder]</td>
									<td>$nrev</td>
									<td rowspan='$b1' style='width: auto;'>
										<form action='excel/spd.php' method='post'>
											<input type='hidden' name=untuk_spd value='$c1[no_running]'>
											<button type='submit' value='H' style='width: 50px; height: 30px; margin-top:15%;'>
											SPD
										</form>
									</td>
									<td rowspan='$b1'>
										<a href='main?index=ddd_pd&action=masuk&id=$c1[no_running]#popup'>
											<u>Attach</u>
										</a>
									</td>
									<td rowspan='$b1'>";
										if ($cx['file_ds3']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$cx[file_ds3]'>Download</a>";
										}
										else{
											echo "no file";
										}
									echo " </td>
									<td rowspan='$b1'>$cx[ds3_status]</td>
									<td>$cx[s3_keterangan]</td>
									<td rowspan='$b1'>$selisih</td>
									<td rowspan='$b1'>$st_ok</td>
					</tr>
								";}
							else {
								$nrev = $cx['no_revisi'] - 1;
								echo "
									<tr class='main_table even' style='background:#a1a6aa;'>
										<td>$cx[master_prosedur]</td>
										<td>$cx[no_upp]</td>
										<td>$cx[nama_folder]</td>
										<td>$cx[no_revisi]</td>
										<td>$cx[tgl_revisi]</td>
										<td>$cx[nama_folder]</td>
										<td>$nrev</td>
										<td>$cx[s3_keterangan]</td>
									</tr>
								";}
							$t_b1--;
						}
					echo "
						
					";
			}
			$rowscount++;
		}
	?>
	</table>
</div>