<?php
	$awal=0;
	$year = date('Y');
	$month = date('m');
	$bantuan = 0;
	if (isset($_GET['bantuan'])) {
		$bantuan = $_GET['bantuan'];
	}
	if ($bantuan == 1 AND isset($_SESSION['temp_namaik']) AND isset($_SESSION['temp_cre_dpr']) AND isset($_SESSION['temp_cre_pro']) AND isset($_SESSION['temp_cre_jpr'])) {
		unset($_SESSION['gn_pros']);
		unset($_SESSION['temp_cre_lok']);
		unset($_SESSION['temp_cre_pen']);
		unset($_SESSION['temp_cre_epe']);
		unset($_SESSION['temp_cre_ep1']);
		unset($_SESSION['temp_cre_dpr']);
		unset($_SESSION['temp_cre_pro']);
		unset($_SESSION['temp_cre_jpr']);
		unset($_SESSION['temp_cre_jik']);
		unset($_SESSION['temp_namaik']);
	}

	// Filter

	if (isset($_POST['status']) or isset($_POST['t_lokasi']) or isset($_POST['t_prosedur']) or isset($_POST['t_nama_bb']) or isset($_POST['searchcari'])) {
		if($_POST['status'] != ''){
			$filter = "";
			$filter = $filter."and status = '".$_POST['status']."'";
			$status = $_POST['status'];
		}
		if($_POST['t_lokasi'] != ''){
			$filter = $filter."and lokasi = '".$_POST['t_lokasi']."'";
			$lokasi = $_POST['t_lokasi'];
		}
		if($_POST['t_prosedur'] != ''){
			$filter = $filter."and upp.no_master_prosedur = '".$_POST['t_prosedur']."'";
			$prosedur = $_POST['t_prosedur'];
		}
		if($_POST['t_nama_bb'] != ''){
			$filter = $filter."and nama_bb = '".$_POST['t_nama_bb']."'";
			$nama_bb = $_POST['t_nama_bb'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
		}
		if ($_POST['status'] == "" and $_POST['t_lokasi'] =="" and $_POST['t_prosedur'] == "" and $_POST['t_nama_bb'] == "" AND $_POST['searchcari'] == ""){
			header("location:main?index=upp");
		}
	}

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {

			case 'gnnff':

				$gn_nafa = '';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$gn_nafa = test($_POST['gn_nafa']);
					$gn_cffo = test($_POST['gn_cffo']);
					if ($gn_nafa != '' AND $gn_cffo == 'FileOK' ) {
						$_SESSION['temp_namaik'] = $gn_nafa;
						header("location:main?index=upp&action=buat#popup");
					}
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=create&bantuan=1'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:15px;width:460px;'>
							Create UPP
						</div>
						<div class='form_process' style='overflow:auto;width:450px;height:550px;'>
							<form action='main?index=upp&step=create&action=gnnff#popup' method='post' enctype='multipart/form-data'>
								<div class='form_main'>
									<a class='j_input_main'> Existing File Name IK *</a><br>
										<select class='input_main' name='gn_nafa' onchange='this.form.submit()' required autofocus>
											<option value=''></option>";
													$aaa = mysqli_query($conn, "SELECT no_master_prosedur FROM master_prosedur WHERE nm_prosedur = '$gn_pros'");
													$bbb = mysqli_fetch_array($aaa);

													$a=mysqli_query($conn, "SELECT * from prosedur WHERE
														no_divisi_prosedur = '$_SESSION[temp_cre_dpr]' AND
														no_master_prosedur = '$_SESSION[temp_cre_pro]' AND
														no_jenis_prosedur = '$_SESSION[temp_cre_jpr]'
														");
													
													while ($c=mysqli_fetch_array($a)) {
														if ($gn_nafa == $c['nama_folder']) {
															echo "<option value='$c[nama_folder]' selected>$c[nama_folder]</option>";}
														else {
															echo "<option value='$c[nama_folder]'>$c[nama_folder]</option>";}
													}
											echo "
										</select><br>
									<a class='j_input_main'>Generated Nama File IK Baru</a><br>
										<input class='input_main readonly' type='text' name='file' value='$gn_nafa' readonly required><br>
									<a class='j_input_main'>Konfirmasi Nama File IK - Ketik 'FileOK'</a><br>
										<input class='input_main' type='text' name='gn_cffo' placeholder='FileOK' required><br>
									<input style='margin-left:290px;' id='button_submit' class='submit_main' type='submit' value='Simpan'>
								</div>
							</form>
						</div>
					</div>
				";

			break;

			case 'gnnf':

				$gn_pros = $_SESSION['gn_pros'];
				$nmfl_ik = 'IK '.$gn_pros;

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$gn_flok=$gn_nmfl=$gn_nmpr=$gn_nrrn=$gn_kopl=$gn_pros=$gn_nowo='';
					$gn_pros = test($_POST['gn_pros']);
					$gn_nowo = test($_POST['gn_nowo']);
					$gn_kopl = test($_POST['gn_kopl']);
					$gn_nrrn = test($_POST['gn_nrrn']);
					$gn_nmpr = test($_POST['gn_nmpr']);
					$gn_nmfl = test($_POST['gn_nmfl']);
					$gn_cffo = test($_POST['gn_cffo']);
					$nmfl_ik = 'IK '.$gn_pros.$gn_nowo.$gn_kopl.$gn_nrrn.'-'.$gn_nmpr.'-'.$gn_nmfl;

					if ($gn_nmfl != '' AND $gn_cffo == 'FileOK') {
						$_SESSION['temp_namaik'] = $nmfl_ik;
						header("location:main?index=upp&action=buat#popup");
					}
					
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=create&bantuan=1'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:15px;width:460px;'>
							Create UPP
						</div>
						<div class='form_process' style='overflow:auto;width:450px;height:550px;'>
							<form action='main?index=upp&step=create&action=gnnf#popup' method='post' enctype='multipart/form-data'>
								<div class='form_main'>
									<a class='j_input_main'> Kode Prosedur *</a><br>
										<select class='input_main' name='gn_pros' onchange='this.form.submit()' required autofocus>
											<option value=''></option>";
													$a=mysqli_query($conn, "SELECT * from master_prosedur order by master_prosedur");
													while ($c=mysqli_fetch_array($a)) {
														if ($gn_pros == $c['nm_prosedur']) {
															echo "<option value='$c[nm_prosedur]' selected>$c[nm_prosedur] - $c[master_prosedur]</option>";}
														else {
															echo "<option value='$c[nm_prosedur]'>$c[nm_prosedur] - $c[master_prosedur]</option>";}
													}
											echo "
										</select><br>
									<a class='j_input_main'> Kode Workcenter *</a><br>
										<select class='input_main' name='gn_nowo' onchange='this.form.submit()' required autofocus>
											<option value=''></option>";
													$a=mysqli_query($conn, "SELECT * from tbl_listworkcenter WHERE no_pros = '$gn_pros' order by kode_workcenter");
													while ($c=mysqli_fetch_array($a)) {
														if ($gn_nowo == $c['kode_workcenter']) {
															echo "<option value='$c[kode_workcenter]' selected>$c[kode_workcenter] - $c[ket_workcenter]</option>";}
														else {
															echo "<option value='$c[kode_workcenter]'>$c[kode_workcenter] - $c[ket_workcenter]</option>";}
													}
											echo "
										</select><br>
									<a class='j_input_main'> Kode Plant *</a><br>
										<select class='input_main' name='gn_kopl' onchange='this.form.submit()' required autofocus>
											<option value=''></option>";
													$a=mysqli_query($conn, "SELECT * from tbl_listkdplant order by kd_plant");
													while ($c=mysqli_fetch_array($a)) {
														if ($gn_kopl == $c['kd_plant']) {
															echo "<option value='$c[kd_plant]' selected>$c[kd_plant] - $c[nm_plant]</option>";}
														else {
															echo "<option value='$c[kd_plant]'>$c[kd_plant] - $c[nm_plant]</option>";}
													}
											echo "
										</select><br>
									<a class='j_input_main'> Nomor Running *</a><br>
										<input class='input_main' type='text' name='gn_nrrn' value='$gn_nrrn' onchange='this.form.submit()' required><br>
									<a class='j_input_main'> Nama Proses *</a><br>
										<select class='input_main' name='gn_nmpr' onchange='this.form.submit()' required autofocus>
											<option value=''></option>";
													$a=mysqli_query($conn, "SELECT * from tbl_listnamapros WHERE no_pros = '$gn_pros' order by nm_pros");
													while ($c=mysqli_fetch_array($a)) {
														if ($gn_nmpr == $c['nm_pros']) {
															echo "<option value='$c[nm_pros]' selected>$c[nm_pros]</option>";}
														else {
															echo "<option value='$c[nm_pros]'>$c[nm_pros]</option>";}
													}
											echo "
										</select><br>
									<a class='j_input_main'>Nama IK *</a><br>
										<input class='input_main' type='text' name='gn_nmfl' value='$gn_nmfl' onchange='this.form.submit()' required><br>
									<a class='j_input_main'>Generated Nama File IK Baru</a><br>
										<input class='input_main readonly' type='text' name='file' value='$nmfl_ik' readonly required><br>
									<a class='j_input_main'>Konfirmasi Nama File IK - Ketik 'FileOK'</a><br>
										<input class='input_main' type='text' name='gn_cffo' placeholder='FileOK' required><br>
									<input style='margin-left:290px;' id='button_submit' class='submit_main' type='submit' value='Simpan'>
								</div>
							</form>
						</div>
					</div>
				";
			break;

			case 'buat':

				if (isset($_SESSION['temp_namaik'])) {
					$temp_namaik = $_SESSION['temp_namaik'];
				}
				else{
					$temp_namaik = '';
				}

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_upp=test($_POST['no_upp']);
					$tgl_upp=test($_POST['tgl_upp']);
					$lokasi=test($_POST['lokasi']);
					$pengaju=test($_POST['pengaju']);
					$email_pengaju=test($_POST['email_pengaju']);
					$pic1=test($_POST['pic1']);
					$divisi_prosedur=test($_POST['divisi']);
					$prosedur=test($_POST['prosedur']);
					$jenis_prosedur=test($_POST['jenis']);

					if($_POST['j_ik_user'] != ''){
						$jenis_ik = test($_POST['j_ik_user']);}

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

					if ($nama_folder == '') {
						$temp_a = mysqli_query($conn, "SELECT nm_prosedur FROM master_prosedur WHERE no_master_prosedur ='$prosedur'");
						$temp_b = mysqli_fetch_array($temp_a);
						$_SESSION['gn_pros'] = $temp_b['nm_prosedur'];
						$_SESSION['temp_cre_lok'] = $lokasi;
						$_SESSION['temp_cre_pen'] = $pengaju;
						$_SESSION['temp_cre_epe'] = $email_pengaju;
						$_SESSION['temp_cre_ep1'] = $pic1;
						$_SESSION['temp_cre_dpr'] = $divisi_prosedur;
						$_SESSION['temp_cre_pro'] = $prosedur;
						$_SESSION['temp_cre_jpr'] = $jenis_prosedur;
						$_SESSION['temp_cre_jik'] = $jenis_ik;
						if ($jenis_ik == '2') {
							header("location:main?index=upp&action=gnnf#popup");
						}
						elseif ($jenis_ik == '3') {
							header("location:main?index=upp&action=gnnff#popup");
						}
						else{
							echo "<script>alert('Isi data lokasi, pengaju, email pengaju, pic 1, divisi prosedur, prosedur, jenis prosedur, dan jenis ik')</script>";
						}
						
					}

					else {
						$a=mysqli_query($conn, "SELECT * FROM upp WHERE tahun='$year'");
						$c=mysqli_fetch_array($a);
						$b=mysqli_num_rows($a);
						$no = $b+1;	

						$uploadOk = 1;
						$nama_file = $_FILES['file_user']['name'];
						if ($nama_file!='') {
							if (!file_exists('file_upload/upp_user/'.$year)) {
								mkdir('file_upload/upp_user/'.$year);}
							if (!file_exists('file_upload/upp_user/'.$year.'/'.$no)) {
								mkdir('file_upload/upp_user/'.$year.'/'.$no);}
						
							$folder1 = 'file_upload/upp_user/'.$year.'/'.$no.'/';
							$file_user1 = $_FILES['file_user']['name'];
							$file_user2 = test($file_user1);
							$tmp_file_user = $_FILES['file_user']['tmp_name'];
							$file_user = $folder1.$file_user1;
							$file_user_rename = $folder1.$file_user2;

							if (move_uploaded_file($tmp_file_user, $file_user)) {
								rename($file_user, $file_user_rename);}
							else {
								$alert='upload file gagal, silahkan ulangi pengajuan, atau hubungi QA team';
								$file_user='';
								$uploadOk = 0;}
						}

						else{
							$file_user='';}

						$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE tahun='$year'");
						$jumlah=mysqli_num_rows($jumlah1)+1;
						$no_upp= $jumlah.'/UPP/'.$year;
					
						//Bima FMEA Upload
						$nama_file = $_FILES['file_fmea_user']['name'];

						if ($nama_file!='') {
							if (!file_exists('file_upload/upp_ik_fmea/'.$year)) {
								mkdir('file_upload/upp_ik_fmea/'.$year);}
							if (!file_exists('file_upload/upp_ik_fmea/'.$year.'/'.$no)) {
								mkdir('file_upload/upp_ik_fmea/'.$year.'/'.$no);}
					
							$folder1 = 'file_upload/upp_ik_fmea/'.$year.'/'.$no.'/';
							$file_user1 = $_FILES['file_fmea_user']['name'];
							$file_user2 = test($file_user1);
							$tmp_file_user = $_FILES['file_fmea_user']['tmp_name'];
							$file_fmea_user = $folder1.$file_user1;
							$file_fmea_rename = $folder1.$file_user2;

							if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
								rename($file_fmea_user, $file_fmea_rename);}
							else{
								$alert='upload file gagal, silahkan ulangi pengajuan, atau hubungi QA team';
								$file_fmea_user='';
								$uploadOk = 0;}
						}

						else{
							$file_fmea_user='1';}	

						if ($file_fmea_user == '1') {
							$query_simpandata_upp = "INSERT INTO upp (tahun,bulan,no_upp,tgl_upp,lokasi,pengaju,email_pengaju,pic1,pic2,no_divisi_prosedur,no_master_prosedur,nama_bb,no_jenis_prosedur,jenis_ik,file_fmea,detail_prosedur,nama_folder,sebelumperubahan,setelahperubahan,alasan,permohonan_tgl_berlaku,file_user,kat_perubahan,kat_mesin,pic,cek_ddd,status,status_sementara)
							VALUES ('$year','$month','$no_upp','$tgl_upp','$lokasi','$pengaju','$email_pengaju','$pic1','-','$divisi_prosedur','$prosedur','-','$jenis_prosedur','1','','$detail_prosedur','$nama_folder','$sebelumperubahan','$setelahperubahan','$alasan','$tanggal_berlaku','$file_user_rename','$kat_perubahan','$kat_mesin','$pic','$cek_ddd','progress','1')
							";
						}

						else {
							$query_simpandata_upp = "INSERT INTO upp (tahun,bulan,no_upp,tgl_upp,lokasi,pengaju,email_pengaju,pic1,pic2,no_divisi_prosedur,no_master_prosedur,nama_bb,no_jenis_prosedur,jenis_ik,file_fmea,detail_prosedur,nama_folder,sebelumperubahan,setelahperubahan,alasan,permohonan_tgl_berlaku,file_user,kat_perubahan,kat_mesin,pic,cek_ddd,status,status_sementara)
							VALUES ('$year','$month','$no_upp','$tgl_upp','$lokasi','$pengaju','$email_pengaju','$pic1','-','$divisi_prosedur','$prosedur','-','$jenis_prosedur','$jenis_ik','$file_fmea_rename','$detail_prosedur','$nama_folder','$sebelumperubahan','$setelahperubahan','$alasan','$tanggal_berlaku','$file_user_rename','$kat_perubahan','$kat_mesin','$pic','$cek_ddd','progress','1')
							";
						}

						if ($uploadOk == 0) {
						}
						// Edit 7/13/2017

						elseif ($a=mysqli_query($conn, $query_simpandata_upp)) {
							$alert2='pengajuan berhasil';
							unset($_SESSION['gn_pros']);
							unset($_SESSION['temp_cre_lok']);
							unset($_SESSION['temp_cre_pen']);
							unset($_SESSION['temp_cre_epe']);
							unset($_SESSION['temp_cre_ep1']);
							unset($_SESSION['temp_cre_dpr']);
							unset($_SESSION['temp_cre_pro']);
							unset($_SESSION['temp_cre_jpr']);
							unset($_SESSION['temp_cre_jik']);
							unset($_SESSION['temp_namaik']);
							$bantuan = 1;
						}
						else{
							$bantuan = 1;
							$alert='pengajuan gagal ada yang error: '.mysqli_errno($conn).' - '.mysqli_error($conn);
						}
					}

					
				}

				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=create&bantuan=1'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:15px;width:510px;'>
							Create UPP
						</div>
						<div class='form_process' style='overflow:auto;width:500px;height:500px;'>
							<form action='main?index=upp&step=create&action=buat' method='post' enctype='multipart/form-data'>
								<div class='form_main'>";?>
										<?php
											if (isset($alert)) {
												echo "<div class='alert_adm alert'>$alert</div>";}
											if (isset($alert2)) {
												echo "<div class='alert_adm alert2'>$alert2</div>";}
										?>
										<a class='j_input_main'>No. UPP *</a><br>
										<?php
											$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE tahun='$year'");
											$jumlah=mysqli_num_rows($jumlah1)+1;
											$no_upp= $jumlah.'/UPP/'.$year;
											echo "<input class='input_main readonly' style='font-family:monospace;' type='text' name='no_upp' value='$no_upp' required readonly><br>";
										?>
										<a class='j_input_main'>Tanggal UPP *</a><br>
										<?php
											$now=date('Y-m-d');
											echo "<input id='pengajuan' class='input_main readonly' type='date' name='tgl_upp' value='$now' required readonly><br>";
										?>
										<a class='j_input_main'>Lokasi *</a><br>
										<select class='input_main' name='lokasi' required autofocus>
											<option value=''></option>
											<?php
												$a=mysqli_query($conn, "SELECT * from plant");
												while ($c=mysqli_fetch_array($a)) {
													if (isset($_SESSION['temp_cre_lok'])) {
														if ($_SESSION['temp_cre_lok'] == $c['plant']) {
															echo "<option value='$c[plant]' selected>$c[plant]</option>";}
														else{
															echo "<option value='$c[plant]'>$c[plant]</option>";}
													}
													else{
														echo "<option value='$c[plant]'>$c[plant]</option>";}
												}
											?>
										</select><br>
										<a class='j_input_main'>Pengaju *</a><br>
											<input class='input_main' type='text' name='pengaju' 
												value='<?php 
													if (isset($_SESSION['temp_cre_pen'])) {
														echo $_SESSION['temp_cre_pen'];
													}
													else{
														echo "";
													}
												?>' 
												required><br>
										<a class='j_input_main'>Email Pengaju *</a><br>
											<input class='input_main' type='email' name='email_pengaju' 
											value='<?php 
													if (isset($_SESSION['temp_cre_epe'])) {
														echo $_SESSION['temp_cre_epe'];
													}
													else{
														echo "";
													}
												?>' 
											required><br>
										<a class='j_input_main'>Manager Approver (PIC 1) *</a><br>
											<input class='input_main' type='text' name='pic1' 
											value='<?php 
													if (isset($_SESSION['temp_cre_ep1'])) {
														echo $_SESSION['temp_cre_ep1'];
													}
													else{
														echo "";
													}
												?>' 
											required><br>
										<a class='j_input_main'>Divisi Prosedur</a><br>
										<select class='input_main' name='divisi' required>
											<option value=''></option>
												<?php
													$a=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
													while ($c=mysqli_fetch_array($a)) {
														if (isset($_SESSION['temp_cre_dpr'])){
															if ($_SESSION['temp_cre_dpr'] == $c['no_divisi_prosedur']) {
																echo "<option value='$c[no_divisi_prosedur]' selected>$c[divisi_prosedur]</option>";}
															else{
																echo "<option value='$c[no_divisi_prosedur]'>$c[divisi_prosedur]</option>";}
														}
														else{
															echo "<option value='$c[no_divisi_prosedur]'>$c[divisi_prosedur]</option>";
														}
													}
												?>
										</select><br>
										<a class='j_input_main'>Prosedur *</a><br>
										<select class='input_main' name='prosedur' id='prosedur' required>
											<option value=''></option>
												<?php
													$a=mysqli_query($conn, "SELECT * from master_prosedur order by master_prosedur");
													while ($c=mysqli_fetch_array($a)) {
														if (isset($_SESSION['temp_cre_pro'])){
															if ($_SESSION['temp_cre_pro'] == $c['no_master_prosedur']) {
																echo "<option value='$c[no_master_prosedur]' selected>$c[master_prosedur]</option>";}
															else{
																echo "<option value='$c[no_master_prosedur]'>$c[master_prosedur]</option>";}
														}
														else{
															echo "<option value='$c[no_master_prosedur]'>$c[master_prosedur]</option>";
														}
													}
												?>
										</select><br>
											
											<!-- Script Improving Bima -->

										<a class='j_input_main'>Kategori Prosedur *</a><br>
										<select class='input_main' name='jenis' id="ik" onload="check()" onchange="check()" required>
											<option value=''></option>
												<?php
													$a=mysqli_query($conn, "SELECT * from jenis_prosedur");
													while ($c=mysqli_fetch_array($a)) {
														if (isset($_SESSION['temp_cre_jpr'])){
															if ($_SESSION['temp_cre_jpr'] == $c['no_jenis_prosedur']) {
																echo "<option value='$c[no_jenis_prosedur]' selected>$c[jenis_prosedur]</option>";}
															else{
																echo "<option value='$c[no_jenis_prosedur]'>$c[jenis_prosedur]</option>";}
														}
														else{
															echo "<option value='$c[no_jenis_prosedur]'>$c[jenis_prosedur]</option>";}
													}
												?>
										</select><br>
										
										<a id="txt_sh_1" class='j_input_main'>Jenis Instruksi Kerja <font size="1" color="red"> *) Wajib & hanya dapat diisi jika pilihan kategori prosedur = instruksi kerja</font><br></a>
											<select class='input_main' name='j_ik_user' id="j_ik" onchange="checkik()">
											<?php
												$a=mysqli_query($conn, "SELECT * from jenis_ik");
												while ($c=mysqli_fetch_array($a)) {
													if (isset($_SESSION['temp_cre_jik'])){
														if ($c['kode_ik'] == '1') {
															echo "<option value='$c[kode_ik]' hidden>$c[jenis_ik]</option>";}
														elseif ($_SESSION['temp_cre_jik'] == $c['kode_ik']) {
															echo "<option value='$c[kode_ik]' selected>$c[jenis_ik]</option>";}
														else{
															echo "<option value='$c[kode_ik]'>$c[jenis_ik]</option>";}
													}
													else{
														if ($c['kode_ik'] == '1') {
															echo "<option value='$c[kode_ik]' hidden>$c[jenis_ik]</option>";}
														else{
															echo "<option value='$c[kode_ik]'>$c[jenis_ik]</option>";}
													}
												}
												?>
										<br></select>

										<a style="display: none;" id="txt_sh_0" class='j_input_main'>Generate Nama File <font size="1" color="red"> *) Wajib & hanya dapat diisi jika pilihan kategori prosedur = instruksi kerja</font><br></a>
											<input id='button_gnnf' style="margin-top: 10px;margin-left: 0px;margin-bottom: 10px;font-size: 15px;padding: 8px 169px;background: #399bf3;display: none;" id='button_submit' class='submit_main' type='button' value='Generate' onclick="this.form.submit()">

										<a id="txt_sh_2" class='j_input_main'>Attachment FMEA <font size="1" color="red"> *) Max File = 1MB, Wajib & hanya dapat diisi jika pilihan kategori prosedur = instruksi kerja</font><br></a>
											<input class='file_main' type='file' id="file_fmea" name='file_fmea_user' onchange="valid1(this)"><br>

										<script>
											function checkik(){
												var dropaza = document.getElementById("j_ik");
						    					var curraza = dropaza.options[dropaza.selectedIndex].value;

						    					if (curraza == '2') {
													document.getElementById('txt_sh_0').style.display = "block";
									        		document.getElementById('button_gnnf').style.display = "block";
						    					}
						    					else{
													document.getElementById('txt_sh_0').style.display = "block";
									        		document.getElementById('button_gnnf').style.display = "block";
						    					}
											}

											function check(){
												var dropdown = document.getElementById("ik");
						    					var current_value = dropdown.options[dropdown.selectedIndex].value;

											    if (current_value == "2") {
													document.getElementById('txt_sh_1').style.display = "block";
													document.getElementById('j_ik').style.display = "block";
						        					document.getElementById('j_ik').required = true;
											    	document.getElementById('j_ik').value = "";
													document.getElementById('txt_sh_2').style.display = "block";
						        					document.getElementById('file_fmea').style.display = "block";
						        					document.getElementById('file_fmea').required = true;
												}
						        				else {
													document.getElementById('txt_sh_0').style.display = "none";
									        		document.getElementById('button_gnnf').style.display = "none";
													document.getElementById('txt_sh_1').style.display = "none";
						        					document.getElementById('j_ik').style.display = "none";
						        					document.getElementById('j_ik').required = false;
						        					document.getElementById('j_ik').value = "1";
													document.getElementById('txt_sh_2').style.display = "none";
							        				document.getElementById('file_fmea').style.display = "none";
						        					document.getElementById('file_fmea').required = false;
												}
											}
												
											window.onload = function(){

												document.getElementById('ugg').style.display = "none";
												document.getElementById('ubr').style.display = "none";
												document.getElementById('ugg2').style.display = "none";
												document.getElementById('ubr2').style.display = "none";

												var fgenerate = document.getElementById("file");
												var dropdown = document.getElementById("ik");
												var current_value = dropdown.options[dropdown.selectedIndex].value;

												if (current_value != '2') {
													document.getElementById('j_ik').value = "";
													document.getElementById("j_ik").required = false;
							        				document.getElementById("file_fmea").required = false;
													document.getElementById('j_ik').style.display = "none";
													document.getElementById('file_fmea').style.display = "none";
													document.getElementById('txt_sh_1').style.display = "none";
													document.getElementById('txt_sh_2').style.display = "none";
												}

												if ($fgenerate != '') {
													document.getElementById('txt_sh_0').style.display = "none";
									        		document.getElementById('button_gnnf').style.display = "none";
												}
											}
												
											function valid1(file) {
												var FileSize = file.files[0].size / 1024 / 1024; // in MB
												if (FileSize > 2) {
													document.getElementById('ubr').style.display = "none";
													document.getElementById('ugg').style.display = "block";
													document.getElementById('button_submit').style.display = "none";}
												else {
												    document.getElementById('ugg').style.display = "none";
												    document.getElementById('ubr').style.display = "block";
									        		document.getElementById('button_submit').style.display = "block";}
												}

											function valid2(file) {
												var FileSize = file.files[0].size / 1024 / 1024; // in MB
												if (FileSize > 2) {
													document.getElementById('ubr2').style.display = "none";
													document.getElementById('ugg2').style.display = "block";
													document.getElementById('button_submit').style.display = "none";}
												else {
												    document.getElementById('ugg2').style.display = "none";
												    document.getElementById('ubr2').style.display = "block";
									        		document.getElementById('button_submit').style.display = "block";}
									    	}
										</script>

										<div class='alert_adm alert' id="ugg" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
										<div class='alert_adm alert2' id="ubr" style='width:70px;'>File is OK !</div>

										<!-- Script Improving Bima -->

										<a class='j_input_main'>Detail Kategori</a><br>
											<input class='input_main' type='input' name='detail' value=''><br>
										<a class='j_input_main'>Nama File Prosedur *</a><br>
											<input class='input_main readonly' id='nama_file_prosedur' type='text' name='file' value='<?php echo $temp_namaik ?>' required readonly><br>
										<a class='j_input_main'>Sebelum Perubahan *</a><br>
											<textarea style='width:100%;height:80px'  name='sebelumperubahan' required></textarea><br>
										<a class='j_input_main'>Setelah Perubahan *</a><br>
											<textarea style='width:100%;height:80px' name='setelahperubahan' required></textarea><br>
										<a class='j_input_main'>Alasan *</a><br>
											<textarea style='width:100%;height:80px' name='alasan' required></textarea><br>
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
														hr = h - 56;}
													else if (h > 48) {
														hr = h - 49;}
													else if (h > 41) {
														hr = h - 42;}
													else if (h > 34) {
														hr = h - 35;}
													else if (h > 27) {
														hr = h - 28;}
													else if (h > 20) {
														hr = h - 21;}
													else if (h > 13) {
														hr = h - 14;}
													else if (h > 6) {
														hr = h - 7;}
													else if (h >= 0) {
														hr = h;}
													else{
														hr = h;}
													if (hr == 1) {
														selisih -= 2;}
													else if (hr == 2) {
														selisih -= 2;}	
													if(selisih < 3){
														$('#alert_tanggal').show();
														$('#button_submit').hide();}
													else{
														if (selisih == 0) {
															$('#alert_tanggal').show();
															$('#button_submit').hide();}
														else if (selisih == 6) {
															$('#alert_tanggal').show();
															$('#button_submit').hide();}
														else{
															$('#alert_tanggal').hide();
															$('#button_submit').show();}
													}
													document.getElementById("asd").value = selisih;
												});
											});
										</script>

										<div id='alert_tanggal' class='alert_adm alert' style='display:none;'>tanggal dibutuhkan minimal 3 hari kerja sesudah tanggal UPP</div>
										<a class='j_input_main'>Permohonan Tgl Berlaku *</a><br>
										<?php
											echo "
												<select id='thndibutuhkan' class='input_main' style='width:100px;' name='tahun' required>
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
												<select id='blndibutuhkan' class='input_main'  style='width:190px;' name='bulan' required>
													<option value=''></option>";
														$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
														$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
														$monthlength=count($month2);

														for ($x=0; $x < 12; $x++) {
															$i=$x+1;
															echo "<option value='$monthvalue[$x]'>$month2[$x]</option>";}
											echo "
												</select>
												<select id='tgldibutuhkan' class='input_main' style='width:100px;' name='tanggal' required>
													<option value=''></option>";
														for ($i=1; $i <= 31 ; $i++) {
															if ($i<10) {
																$i='0'.$i;}
															echo "<option value='$i'>$i</option>";}
											echo "
												</select><br>";
										?>
										<a class='j_input_main'>Attachment File User</a><font size="1" color="red"> ) Max File = 1MB</font><br>
										<input class='file_main' type='file' name='file_user' onchange="valid2(this)"><br>
										<div class='alert_adm alert' id="ugg2" style='width:230px;'>File Upload max Size is 1MB / 1024KB !</div>
										<div class='alert_adm alert2' id="ubr2" style='width:70px;'>File is OK !</div>
										<a class='j_input_main'>Kategori Perubahan *</a><br>
										<select class='input_main' name='kat_perubahan' required>
											<option value=''></option>
											<?php
												$a=mysqli_query($conn, "SELECT * from kat_perubahan");
												while ($c=mysqli_fetch_array($a)) {
													echo "
														<option value='$c[kat_perubahan]'>$c[kat_perubahan]
													";
												}
											?>
										</select><br>
										<a class='j_input_main'>Kategori Mesin</a><br>
										<select class='input_main' name='kat_mesin'>
											<option value=''></option>
											<?php
												$a=mysqli_query($conn, "SELECT * from kat_mesin");
												while ($c=mysqli_fetch_array($a)) {
													echo "
														<option value='$c[kat_mesin]'>$c[kat_mesin]
													";
												}
											?>
										</select><br>
						                   <a class='j_input_main'>Perlu Sosialisasi Lapangan ? *</a><br>
										<label>
											<input id='cek_pic' class='radio_main' type='radio' name='cek_pic' value='ya' onclick="document.getElementById('ubahpic').style.display = 'block';
						                       document.getElementById('pic').value = '';
						                        "  required> Ya
										</label>
										<label>
											<input id='cek_pic2' class='radio_main' type='radio' name='cek_pic' value='tidak' onclick="document.getElementById('ubahpic').style.display = 'none';
												document.getElementById('pic').value = '484ea5618aaf3e9c851c28c6dbca6a1f'"> Tidak
										</label>
						                <div id="ubahpic" style="margin:0;padding:0; height:50px; display:none">
											<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>
											<input class='input_main' type='text' name='pic' id="pic" value='' required>
						                </div><br/>
											<a class='j_input_main'>Perlu Distribusi Hardcopy ? *</a><br>
											<label>
												<input id='cek_ddd' class='radio_main' type='radio' name='cek_ddd' value='ya' required> Ya
											</label>
											<label>
												<input id='cek_ddd2' class='radio_main' type='radio' name='cek_ddd' value='tidak'> Tidak
											</label>
											<br>
											<a style='font-size:12px;'><i>*) wajib diisi</i></a>
										<input style='margin-left:308px;' id='button_submit' class='submit_main' type='submit' value='Ajukan'>
								<?php echo "</div>
							</form>
						</div>
					</div>
				";
			break;
		}
	}
?>
<div class='judul_main' style='position:fixed;'>Usulan Perubahan Prosedur</div>

<a href='main?index=upp&action=buat#popup'><button class='submit_main fl' style='margin-top: 60px;margin-left:20px;'>Create New UPP</button></a><br><br><br>

<form style='margin-bottom:0px;' action='main?index=upp' method='post' enctype='multipart/form-data'>
		<br><br><br>&emsp; 
		<select class='input_main' name='status' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
			<option value=''>Pilih Status</option>
				<?php
					$a=mysqli_query($conn, "SELECT * from upp GROUP BY status");
					while ($c=mysqli_fetch_array($a)) {
						if ($status==$c['status']) {
							echo "
								<option value='$c[status]' selected>$c[status]</option>
							";
						}
						else{
							echo "
								<option value='$c[status]'>$c[status]</option>
							";
						}
					}
				?>
		</select>

	<!--

	<?php

	/*

	echo "
		<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
			<option value=''>Pilih Tahun</option>";
				$year=date('Y') + 1;
				for ($i=$year; $i > 1997; $i--) {
					if ($tahun==$i) {
						echo "
							<option value='$i' selected>$i</option>";}
					else{
						echo "
							<option value='$i'>$i</option>";}
				}
				echo "
		</select>
					
		<select class='input_main' name='bulan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
			<option value=''>Pilih Bulan</option>";
				$month=array('01','02','03','04','05','06','07','08','09','10','11','12');
				$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
				$monthlength=count($month);
				for ($x=0; $x < $monthlength; $x++) {
					if ($month[$x]==$bulan) {
						$bulantampil=$month2[$x];
						echo "
							<option value='$month[$x]' selected>$month2[$x]</option>";}
					else{
						echo "
							<option value='$month[$x]'>$month2[$x]</option>
								";}
				}
		echo "
			</select>";

		*/

	?>

	-->

		<select class='input_main' name='t_lokasi' style='width:185px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Pilih Lokasi</option>
				<?php
					$a=mysqli_query($conn, "SELECT * from plant");
					while ($c=mysqli_fetch_array($a)) {
						if ($lokasi==$c['plant']) {
							echo "
								<option value='$c[plant]' selected>$c[plant]</option>
							";
						}
						else{
							echo "
								<option value='$c[plant]'>$c[plant]</option>
							";
						}
					}
				?>
		</select>

		<select class='input_main' name='t_prosedur' style='width:340px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Prosedur</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM upp
						INNER JOIN master_prosedur
						ON upp.no_master_prosedur = master_prosedur.no_master_prosedur
						GROUP BY upp.no_master_prosedur");
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

		<select class='input_main' name='t_nama_bb' style='width:160px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Nama BB / Produk</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM upp
						GROUP BY nama_bb");
					while ($c=mysqli_fetch_array($a)) {
						if ($nama_bb==$c['nama_bb']) {
							echo "
								<option value='$c[nama_bb]' selected>$c[nama_bb]</option>
							";
						}
						else{
							echo "
								<option value='$c[nama_bb]'>$c[nama_bb]</option>
							";
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

</form>
		
<div class='form_main' style='margin-top: 0px;'>
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

			if (isset($searchcari)) {
				$a=mysqli_query($conn, "SELECT * FROM upp
						inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur
						inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
						inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					WHERE 
						pengaju LIKE '%$searchcari%' 
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR sebelumperubahan LIKE '%$searchcari%'
						OR setelahperubahan LIKE '%$searchcari%'
						OR alasan LIKE '%$searchcari%'
						ORDER BY ".$sort." LIMIT $awal,$akhir
					");
				$page1=mysqli_query($conn, "SELECT * FROM upp
						inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur
						inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
						inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
					WHERE 
						pengaju LIKE '%$searchcari%' 
						OR detail_prosedur LIKE '%$searchcari%'
						OR nama_folder LIKE '%$searchcari%'
						OR sebelumperubahan LIKE '%$searchcari%'
						OR setelahperubahan LIKE '%$searchcari%'
						OR alasan LIKE '%$searchcari%'
					");
			}
		
			else {
				$a=mysqli_query($conn, "
					SELECT * FROM upp 
						inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
						inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur
						inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
						inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
						WHERE no != ''
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM upp 
						inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur
						inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur
						inner join jenis_ik	on upp.jenis_ik = jenis_ik.kode_ik 
						inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
						WHERE no != '' ".$filter);}

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
						echo "<td><a href='main?index=upp&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=upp&step=create&hal=$hal3$sorturl";
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
						echo "<td><a href='main?index=upp&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=upp&step=create&hal=$hal3$sorturl";
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
							echo"<td><a href='main?index=upp&step=create&hal=$hal2$sorturl";
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
						echo "<td><a href='main?index=upp&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=create&hal=$page$sorturl";
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
					/**/
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
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='status') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=status&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=status&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=status&order=ASC$halurl'>";
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
						if ($sortby=='no') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=no&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=no&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=no&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=lokasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=email_pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=pic2&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=divisi_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=divisi_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=divisi_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=master_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=master_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=master_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=nama_bb&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=nama_bb&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=nama_bb&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=jenis_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=jenis_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=jenis_prosedur&order=ASC$halurl'>";
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
						if ($sortby=='jenis_ik.jenis_ik') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=jenis_ik.jenis_ik&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=jenis_ik.jenis_ik&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=jenis_ik.jenis_ik&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Jenis IK
					</a>
					";
				?>
			</td>
			<td>File FMEA</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='detail_prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=detail_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=detail_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=detail_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=nama_folder&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=sebelumperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=setelahperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=alasan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
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
						if ($sortby=='upp.permohonan_tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=upp.permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=upp.permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=upp.permohonan_tgl_berlaku&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Harus Proses
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
								echo "<a href='main?index=upp&step=create&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=kat_perubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=kat_mesin&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=pic&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=cek_ddd&order=ASC$halurl'>";
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
						if ($sortby=='kat_delay') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=kat_delay&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=kat_delay&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=kat_delay&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_kirim&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_kirim&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_kirim&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}  
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_pic2&order=ASC$halurl'>";
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
			<td>Attachment File Prosedur</td>
            <td>Attachment File Daftar Hadir</td>
            <td>Daftar Hadir PIC Sosialisasi Lapangan</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
				 			}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_berlaku&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_sosialisasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_sosialisasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_sosialisasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_filling&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_filling&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_filling&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_distribusi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_distribusi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_distribusi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_kembali&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_kembali&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_kembali&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=no_spd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=no_spd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=no_spd&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=tgl_pengecekan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=tgl_pengecekan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=tgl_pengecekan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=kesesuaian_dokumen&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=kesesuaian_dokumen&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=kesesuaian_dokumen&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=create&sort=keterangan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=keterangan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=keterangan&order=ASC$halurl'>";
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
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no_revisi') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=no_revisi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=no_revisi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=no_revisi&order=ASC$halurl'>";
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
						if ($sortby=='no_revisi_cover') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=no_revisi_cover&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=no_revisi_cover&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=no_revisi_cover&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						No. Revisi Cover
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='report1') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=report1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=report1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=report1&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						LT Tgl Berlaku Vs Tgl Permohonan Berlaku OK
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='report2') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=report2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=report2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=report2&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						LT Proses UPP OK
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='report3') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=create&sort=report3&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=create&sort=report3&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=create&sort=report3&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tgl Berlaku Vs Tgl Sosialisasi OK
					</a>
					";
				?>
			</td>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		$tmp_tgl = $c['permohonan_tgl_berlaku'];
		$tmp_tgl = date('Y-m-d', strtotime('-3 days', strtotime($tmp_tgl)));
		$tgl_now = date('Y-m-d');
		if ($tgl_now > $tmp_tgl and $c['status'] != 'batal' and $c['status'] != 'closed') {
			$warna = 'red';}
		else{
			$warna = 'black';}
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					";
						if ($c['status']=='closed') {
							echo "<td style='background:#92d050;'>$c[status]</td>";
						}
						elseif ($c['status']=='batal') {
							echo "<td style='background:red;color:white;'>$c[status]</td>";
						}
						else {
							echo "<td style='background:#fcff00;'>$c[status]</td>";
						}
					echo "
					<td><font color='$warna'>$c[no_upp]</td>
					<td><font color='$warna'>$c[tgl_upp]</td>
					<td><font color='$warna'>$c[lokasi]</td>
					<td><font color='$warna'>$c[pengaju]</td>
					<td><font color='$warna'>$c[email_pengaju]</td>
					<td><font color='$warna'>$c[pic1]</td>
					<td><font color='$warna'>$c[pic2]</td>
					<td><font color='$warna'>$c[divisi_prosedur]</td>
					<td><font color='$warna'>$c[master_prosedur]</td>
					<td><font color='$warna'>$c[nama_bb]</td>
					<td><font color='$warna'>$c[jenis_prosedur]</td>
					
					<td><font color='$warna'>$c[jenis_ik]</td>
					<td>
					";

					//Bima

					if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "

					</td>
					
					<td><font color='$warna'>$c[detail_prosedur]</td>
					<td><font color='$warna'>$c[nama_folder]</td>
					<td><font color='$warna'>$sebelumperubahan</td>
					<td><font color='$warna'>$setelahperubahan</td>
					<td><font color='$warna'>$alasan</td>
					<td><font color='$warna'>$c[permohonan_tgl_berlaku]</td>
					<td><font color='$warna'>$tmp_tgl</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'><font color='$warna'>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[kat_perubahan]</td>
					<td><font color='$warna'>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td><font color='$warna'>$c[pic]</td>";
					}
					else
					{
						echo"<td><font color='$warna'>Tidak ada</td>";
					}
					echo"
					<td><font color='$warna'>$c[cek_ddd]</td>
					<td><font color='$warna'>$c[kat_delay]</td>
					<td><font color='$warna'>$c[tgl_kirim]</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
		
					echo "
					</td>
					<td><font color='$warna'>$c[tgl_pic1]</td>
					<td><font color='$warna'>$c[tgl_pic2]</td>
					<td>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
						echo"</td><td>";
						if ($c['pic']!='484ea5618aaf3e9c851c28c6dbca6a1f') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=Form/Daftar Hadir/F.Y.203 (FDH - Form Daftar Hadir).doc'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=file_upload/daftar_hadir/$c[file_daftar_hadir]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[tgl_berlaku]</td>
					<td><font color='$warna'>$c[tgl_sosialisasi]</td>
					<td><font color='$warna'>$c[tgl_filling]</td>
					<td><font color='$warna'>$c[tgl_distribusi]</td>
					<td><font color='$warna'>$c[tgl_kembali]</td>
					<td><font color='$warna'>$c[no_spd]</td>
					<td><font color='$warna'>$c[tgl_pengecekan]</td>
					<td><font color='$warna'>$c[kesesuaian_dokumen]</td>
					<td><font color='$warna'>$c[keterangan]</td>
					<td><font color='$warna'>$c[no_revisi]</td>
					<td><font color='$warna'>$c[no_revisi_cover]</td>
					<td><font color='$warna'>$c[report1]</td>
					<td><font color='$warna'>$c[report2]</td>
					<td><font color='$warna'>$c[report3]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					";
						if ($c['status']=='closed') {
							echo "<td style='background:#92d050;'>$c[status]</td>";
						}
						elseif ($c['status']=='batal') {
							echo "<td style='background:red;color:white;'>$c[status]</td>";
						}
						else {
							echo "<td style='background:#fcff00;'>$c[status]</td>";
						}
					echo "
					<td><font color='$warna'>$c[no_upp]</td>
					<td><font color='$warna'>$c[tgl_upp]</td>
					<td><font color='$warna'>$c[lokasi]</td>
					<td><font color='$warna'>$c[pengaju]</td>
					<td><font color='$warna'>$c[email_pengaju]</td>
					<td><font color='$warna'>$c[pic1]</td>
					<td><font color='$warna'>$c[pic2]</td>
					<td><font color='$warna'>$c[divisi_prosedur]</td>
					<td><font color='$warna'>$c[master_prosedur]</td>
					<td><font color='$warna'>$c[nama_bb]</td>
					<td><font color='$warna'>$c[jenis_prosedur]</td>
					
					<td><font color='$warna'>$c[jenis_ik]</td>
					<td>
					";

					//Bima

					if ($c['file_fmea']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_fmea]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "

					</td>
					
					<td><font color='$warna'>$c[detail_prosedur]</td>
					<td><font color='$warna'>$c[nama_folder]</td>
					<td><font color='$warna'>$sebelumperubahan</td>
					<td><font color='$warna'>$setelahperubahan</td>
					<td><font color='$warna'>$alasan</td>
					<td><font color='$warna'>$c[permohonan_tgl_berlaku]</td>
					<td><font color='$warna'>$tmp_tgl</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'><font color='$warna'>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[kat_perubahan]</td>
					<td><font color='$warna'>$c[kat_mesin]</td>";
					
					if($c['pic'] != '484ea5618aaf3e9c851c28c6dbca6a1f')
					{
					echo"
					<td><font color='$warna'>$c[pic]</td>";
					}
					else
					{
						echo"<td><font color='$warna'>Tidak ada</td>";
					}
					echo"
					<td><font color='$warna'>$c[cek_ddd]</td>
					<td><font color='$warna'>$c[kat_delay]</td>
					<td><font color='$warna'>$c[tgl_kirim]</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
		
					echo "
					</td>
					<td><font color='$warna'>$c[tgl_pic1]</td>
					<td><font color='$warna'>$c[tgl_pic2]</td>
					<td>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
						echo"</td><td>";
						if ($c['pic']!='484ea5618aaf3e9c851c28c6dbca6a1f') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=Form/Daftar Hadir/F.Y.203 (FDH - Form Daftar Hadir).doc'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=file_upload/daftar_hadir/$c[file_daftar_hadir]'><font color='$warna'><u>Download</a>";
						}
						else{
							echo "<font color='$warna'>no file";
						}
					echo "
					</td>
					<td><font color='$warna'>$c[tgl_berlaku]</td>
					<td><font color='$warna'>$c[tgl_sosialisasi]</td>
					<td><font color='$warna'>$c[tgl_filling]</td>
					<td><font color='$warna'>$c[tgl_distribusi]</td>
					<td><font color='$warna'>$c[tgl_kembali]</td>
					<td><font color='$warna'>$c[no_spd]</td>
					<td><font color='$warna'>$c[tgl_pengecekan]</td>
					<td><font color='$warna'>$c[kesesuaian_dokumen]</td>
					<td><font color='$warna'>$c[keterangan]</td>
					<td><font color='$warna'>$c[no_revisi]</td>
					<td><font color='$warna'>$c[no_revisi_cover]</td>
					<td><font color='$warna'>$c[report1]</td>
					<td><font color='$warna'>$c[report2]</td>
					<td><font color='$warna'>$c[report3]</td>
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#ik').change(function() {
			var ik = $('#ik').val();
			switch (ik){
				case '2':
					$('#nama_file_prosedur').removeClass('readonly');
					$('#nama_file_prosedur').addClass('readonly');
					$('#nama_file_prosedur').prop('readonly', true)
					console.log(ik);
				break;
				default :
					$('#nama_file_prosedur').removeClass('readonly');
					$('#nama_file_prosedur').prop('readonly', false)
					console.log(ik);
				break;
			}
		});
	});
</script>