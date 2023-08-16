<?php
	$awal=0;
	$filter="";
	$hariini=date("Y-m-d");
	if (isset($_POST['tahun'])) {
		$tahun=$_POST['tahun'];
		if ($tahun!='') {
			$filter.=" AND tahun = ".$tahun;
		}
	}
	else{
		$tahun = '';
	}
	if (isset($_POST['bulan'])) {
		$bulan=$_POST['bulan'];
		if ($bulan!='') {
			$filter.=" AND bulan = ".$bulan;
		}
	}
	else{
		$bulan = '';
	}
	if (isset($_POST['lokasi'])) {
		$lokasi=$_POST['lokasi'];
		if ($lokasi!='') {
			$filter.=" AND lokasi = '".$lokasi."'";
		}
	}
	else{
		$lokasi = '';
	}
	if (isset($_POST['divisi'])) {
		$divisi=$_POST['divisi'];
		if ($divisi!='') {
			$filter.=" AND upp.no_divisi_prosedur = '".$divisi."'";
		}
	}
	else{
		$divisi = '';
	}
	if (isset($_POST['prosedur'])) {
		$prosedur=$_POST['prosedur'];
		if ($prosedur!='') {
			$filter.=" AND upp.no_master_prosedur = '".$prosedur."'";
		}
	}
	else{
		$prosedur = '';
	}
	if (isset($_POST['jenis'])) {
		$jenis=$_POST['jenis'];
		if ($jenis!='') {
			$filter.=" AND upp.no_jenis_prosedur = '".$jenis."'";
		}
	}
	else{
		$jenis = '';
	}
	if (isset($_POST['detail'])) {
		$detail=$_POST['detail'];
		if ($detail!='') {
			$filter.=" AND upp.detail_prosedur = '".$detail."'";
		}
	}
	else{
		$detail = '';
	}
	if (isset($_POST['folder'])) {
		$folder=$_POST['folder'];
		if ($folder!='') {
			$filter.=" AND upp.nama_folder = '".$folder."'";
		}
	}
	else{
		$folder = '';
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
			$sort="tgl_kepuasan DESC";
			$sortby='';
			$sorturl='';
		}
	}
	else{
		$sort="tgl_kepuasan DESC";
		$sortby='';
		$sorturl='';
	}
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'edit':
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
					$tahun=test($_POST['thnfilling']);
					$bulan=test($_POST['blnfilling']);
					$tanggal=test($_POST['tglfilling']);
					$tgl_filling=$tahun.'-'.$bulan.'-'.$tanggal;
					$tahun=test($_POST['thndistribusi']);
					$bulan=test($_POST['blndistribusi']);
					$tanggal=test($_POST['tgldistribusi']);
					$tgl_distribusi=$tahun.'-'.$bulan.'-'.$tanggal;
					$tahun=test($_POST['thnkembali']);
					$bulan=test($_POST['blnkembali']);
					$tanggal=test($_POST['tglkembali']);
					$tgl_kembali=$tahun.'-'.$bulan.'-'.$tanggal;
					$no_spd=test($_POST['no_spd']);
					$tgl_pengecekan=test($_POST['tgl_pengecekan']);;
					$kesesuaian_dokumen=test($_POST['kesesuaian_dokumen']);
					$keterangan=test($_POST['keterangan']);
					$tgl_kepuasan=test($_POST['tgl_kepuasan']);;
					$kepuasan=test($_POST['kepuasan']);
					$alasan_kepuasan=test($_POST['alasan_kepuasan']);

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

					if ($a=mysqli_query($conn, "UPDATE upp SET lokasi = '$lokasi',
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
													tgl_filling = '$tgl_filling',
													tgl_distribusi = '$tgl_distribusi',
													tgl_kembali = '$tgl_kembali',
													no_spd = '$no_spd',
													tgl_pengecekan = '$tgl_pengecekan',
													kesesuaian_dokumen = '$kesesuaian_dokumen',
													keterangan = '$keterangan',
													tgl_kepuasan = '$tgl_kepuasan',
													kepuasan = '$kepuasan',
													alasan_kepuasan = '$alasan_kepuasan',
													report1 = '$report1',
													report2 = '$report2',
													report3 = '$report3',
													report4 = '$report4'
													WHERE 	no_upp = '$no_upp'
													")) {
						header('location:main?index=upp&step=close');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE no_upp ='$id'");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=close&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;width:470px;'>
							Usulan Perubahan Prosedur
						</div>
						<div class='form_process' style='overflow:auto;width:460px;height:470px;'>
							<form action='main?index=upp&step=close&action=edit&id=$id#popup' method='post'  enctype='multipart/form-data'>
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
									<a class='j_input_main'>PIC Sosialisasi Lapangan *</a><br>
									<input class='input_main' type='text' name='pic' value='$c[pic]' required><br>
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
									<a class='j_input_main'>Tanggal Filling</a><br>
									<select class='input_main' style='width:100px;' name='thnfilling' required>
										<option value=''></option>
										";
											$tahun=substr($c['tgl_filling'],0,4);
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
									<select class='input_main'  style='width:190px;' name='blnfilling' required>
										<option value=''></option>
										";
											$monthvalue=array('01','02','03','04','05','06','07','08','09','10','11','12');
											$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
											$monthlength=count($month2);
											$bulan=substr($c['tgl_filling'],5,2);
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
									<select class='input_main' style='width:100px;' name='tglfilling' required>
										<option value=''></option>
										";
											$tgl=substr($c['tgl_filling'],8,2);
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
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_pengecekan' value='$c[tgl_pengecekan]' required readonly><br>
									<a class='j_input_main'>Kesesuaian Dokumen</a><br>
									<label>
									";
										if ($c['kesesuaian_dokumen']=='ok') {
											echo "<input class='radio_main' type='radio' name='kesesuaian_dokumen' value='ok' checked required> Ok";
										}
										else{
											echo "<input class='radio_main' type='radio' name='kesesuaian_dokumen' value='ok' required> Ok";
										}
									echo "
									</label>
									<label>
									";
										if ($c['kesesuaian_dokumen']=='tidak ok') {
											echo "<input class='radio_main' type='radio' name='kesesuaian_dokumen' value='tidak ok' checked> Tidak Ok";
										}
										else{
											echo "<input class='radio_main' type='radio' name='kesesuaian_dokumen' value='tidak ok'> Tidak Ok";
										}
									echo "
									</label>
									<br>
									<a class='j_input_main'>Keterangan</a><br>
									<textarea class='input_main' name='keterangan'>$c[keterangan]</textarea><br>
									<a class='j_input_main'>Tanggal Kepuasan</a><br>
									<input id='pengajuan' class='input_main readonly' type='date' name='tgl_kepuasan' value='$c[tgl_kepuasan]' required readonly><br>
									<a class='j_input_main'>Kepuasan User</a><br>
									<label>
									";
										if ($c['kepuasan']=='puas') {
											echo "<input class='radio_main' type='radio' name='kepuasan' value='puas' checked required> Puas";
										}
										else{
											echo "<input class='radio_main' type='radio' name='kepuasan' value='puas' required> Puas";
										}
									echo "
									</label>
									<label>
									";
										if ($c['kepuasan']=='tidak puas') {
											echo "<input class='radio_main' type='radio' name='kepuasan' value='tidak puas' checked> Tidak Puas";
										}
										else{
											echo "<input class='radio_main' type='radio' name='kepuasan' value='tidak puas'> Tidak Puas";
										}
									echo "
									</label>
									<br>
									<a class='j_input_main'>Alasan Kepuasan</a><br>
									<textarea class='input_main' name='alasan_kepuasan'>$c[alasan_kepuasan]</textarea><br>
									<a style='font-size:12px;'><i>*) wajib diisi</i></a>
								</div>
								<input style='margin-left:304px;' class='submit_main' type='submit' value='Update'>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
?>
<div class='judul_main' style='position: fixed;'>Report Usulan Perubahan Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
		echo "
			<form style='margin-bottom:0px;' action='main?index=upp&step=close' method='post' enctype='multipart/form-data'>
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
				<select class='input_main' name='lokasi' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
					<option value=''>Pilih Lokasi</option>
					";
						$d=mysqli_query($conn, "SELECT * from plant order by plant");
							while ($f=mysqli_fetch_array($d)) {
								if ($lokasi == $f['plant']) {
									echo "
										<option value='$f[plant]' selected>$f[plant]</option>
									";
								}
								else {
									echo "
										<option value='$f[plant]'>$f[plant]</option>
									";
								}
						}
					echo "
				</select>
				<select class='input_main' name='divisi' style='width:200px;margin:0px;' onchange='this.form.submit()'>
					<option value=''>Pilih Divisi Prosedur</option>
					";
						$a=mysqli_query($conn, "SELECT * from upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur group by divisi_prosedur.divisi_prosedur order by divisi_prosedur.divisi_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from upp inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur where upp.no_divisi_prosedur='$divisi' group by master_prosedur.master_prosedur order by master_prosedur.master_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from upp inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur where upp.no_divisi_prosedur='$divisi' AND upp.no_master_prosedur='$prosedur' group by jenis_prosedur.jenis_prosedur order by jenis_prosedur.jenis_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from upp where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' group by detail_prosedur order by detail_prosedur");
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
						$a=mysqli_query($conn, "SELECT * from upp where no_divisi_prosedur='$divisi' AND no_master_prosedur='$prosedur' and no_jenis_prosedur='$jenis' and detail_prosedur='$detail' group by nama_folder order by nama_folder");
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
				<select class='input_main' name='sort' onchange='this.form.submit()' style='font-family:arial;width:200px;'>
					<option value=''>Sort By</option>
					";
					$sorttampil=array('No. Upp','Tanggal UPP','Lokasi','Pengaju','Prosedur','Nama Bahan Baku/Produk','Jenis Prosedur','Nama File Prosedur','Permohonan Tanggal Berlaku','Kategori Perubahan','Kategori Mesin','Cek DDD','Kategori Delay','Tanggal Berlaku','Tanggal Sosialisasi','Tanggal Filling','Tanggal Distribusi','Tanggal Pengecekan','Kesesuaian Dokumen','No. Revisi','No. Revisi Cover','Tanggal Kepuasan','Kepuasan');
					$sortarray=array('no','tgl_upp','lokasi','pengaju','prosedur','nama_bb','prosedur2','prosedur3','permohonan_tgl_berlaku','kat_perubahan','kat_mesin','cek_ddd','kat_delay','tgl_berlaku','tgl_sosialisasi','tgl_filling','tgl_distribusi','tgl_pengecekan','kesesuaian_dokumen','no_revisi','no_revisi_cover','tgl_kepuasan','kepuasan');
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
		echo"<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=close' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE no_upp='$id' AND status='closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00'");
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=close' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		elseif ($filter!="") {
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00'".$filter." ORDER BY ".$sort);
			$b=mysqli_num_rows($a);
			$alert2='Jumlah : '.$b;
		}
		else if(isset($_POST['kw']))
			{
				$kw = $_POST['kw'];
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or upp.no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%') ORDER BY tgl_kirim desc
				");
				$b=mysqli_num_rows($a);
			$alert2='Jumlah : '.$b;
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
			$awal=($hal-1)*30;
			$akhir=30;
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				inner join tbl_status on upp.status_sementara = tbl_status.id_status
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' ".$filter);
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
						echo "<td><a href='main?index=upp&step=close&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=close&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=close&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=close&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=close&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=close&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=close&hal=$page$sorturl'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					echo "
					</tr>
				</table>
			";}
		}
		if (isset($alert)) {
			echo "<div class='alert_adm alert'>$alert</div>";
		}
		if (isset($alert2)) {
			echo "<div class='alert_adm alert2'>$alert2</div>";
		}
	?>
	<a href="excel/export.php?file=close"><button id='download' class='button_download fl'>Export To Excel</button></a>
	<div class='cb'></div>
	<table id='tableID' class='table_admin'>
		<tr class='top_table'>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status Sementara</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. UPP</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal UPP</td> 
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Lokasi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Manager Approver (PIC 1)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Approver 2</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Divisi Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama Bahan Baku/Produk</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Detail Kategori</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama File</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Sebelum Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Setelah Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Permohonan Tanggal Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File User</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Mesin</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>PIC Sosialisasi Lapangan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Cek ddd</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Delay</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kirim</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Master</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Approval (PIC 1)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Approval (PIC 2)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Approval Validasi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Prosedur</td>
            <td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Hasil Daftar Hadir</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Sosialisasi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Filling</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Distribusi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kembali Dokumen lama + SPD</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. SPD</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Pengecekan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kesesuaian Dokumen</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Keterangan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Revisi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Revisi Cover</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Tgl Berlaku Vs Tgl Permohonan Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Prosess UPP OK</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Tgl Berlaku Vs Tgl Sosialisasi OK</td>
			<td style='font-family:arial;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Action</td>
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
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nm_status]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_upp]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_upp]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[lokasi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pengaju]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_bb]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$sebelumperubahan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$setelahperubahan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$alasan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[permohonan_tgl_berlaku]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;' style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_perubahan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_mesin]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[cek_ddd]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;' style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_delay]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[vi_pic_app]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
						echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=file_upload/daftar_hadir/$c[file_daftar_hadir]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_berlaku]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_sosialisasi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_filling]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_distribusi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_spd]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pengecekan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kesesuaian_dokumen]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[keterangan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi_cover]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[alasan_kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report3]</td>
					<td style='padding:10px;font-family:arial;vertical-align:middle;font-size: 13px;text-align: center;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=close&action=edit&id=$c[no_upp]#popup'>
							edit
						</a>
					</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nm_status]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_upp]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_upp]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[lokasi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pengaju]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_bb]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$sebelumperubahan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$setelahperubahan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$alasan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[permohonan_tgl_berlaku]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_perubahan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_mesin]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[cek_ddd]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_delay]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[vi_pic_app]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
						echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
						echo "<a style='padding-right:5px;color: blue;' href='download.php?index=file_upload/daftar_hadir/$c[file_daftar_hadir]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_berlaku]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_sosialisasi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_filling]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_distribusi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_spd]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pengecekan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kesesuaian_dokumen]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[keterangan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi_cover]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[alasan_kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report3]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;text-align: center;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=close&action=edit&id=$c[no_upp]#popup'>
							edit
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