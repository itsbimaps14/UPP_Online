<?php
	$awal=0;
	if (!isset($_SESSION['username'])) {
		if (!isset($_GET['id'])) {
			header('location:home');
		}
	}
	else{
	}
	$hariini=date("Y-m-d");
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'autopuas':
				if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_kepuasan = '$hariini',
											kepuasan = 'puas'
											WHERE 	no_upp = '$id'
											")){
					header('location:main?index=upp&step=kepuasan');
				}
				else{
					$alert='update gagal '.$id;
				}
				break;
			case 'puas':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_kepuasan=test($_POST['tgl_kepuasan']);
					$alasan="Saran : ".test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_kepuasan = '$tgl_kepuasan',
												kepuasan = 'puas',
												alasan_kepuasan = '$alasan'
												WHERE 	no_upp = '$id'
												")){
						header('location:main?index=upp&step=kepuasan');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=kepuasan&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Kepuasan
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=kepuasan&action=puas&id=$id' method='post'>
								<a class='j_input_main'>No. UPP</a><br>
								<input class='input_main' type='text' name='no_upp' value='$id' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Tanggal Kepuasan</a><br>
								<input class='input_main' type='date' name='tgl_kepuasan' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Saran</a><br>
								<textarea class='input_main' type='text' name='alasan' value='' required style='width:100%;max-width:100%;'></textarea><br>
								<input style='margin-left:5px;' class='submit_main fr' type='submit' value='Puas'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'tidak':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$tgl_kepuasan=test($_POST['tgl_kepuasan']);
					$alasan="Alasan : ".test($_POST['alasan']);
					if ($a=mysqli_query($conn, "UPDATE upp 	SET tgl_kepuasan = '$tgl_kepuasan',
												kepuasan = 'tidak puas',
												alasan_kepuasan = '$alasan'
												WHERE 	no_upp = '$id'
												")){
						header('location:main?index=upp&step=kepuasan');
					}
					else{
						$alert='update gagal '.$id;
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=upp&step=kepuasan&id=$id'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Kepuasan
						</div>
						<div class='form_process'>
							<form action='main?index=upp&step=kepuasan&action=tidak&id=$id' method='post'>
								<a class='j_input_main'>No. UPP</a><br>
								<input class='input_main' type='text' name='no_upp' value='$id' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Tanggal Kepuasan</a><br>
								<input class='input_main' type='date' name='tgl_kepuasan' value='$hariini' required style='background-color:#e7e7e7;width:100%;' readonly><br>
								<a class='j_input_main'>Alasan Tidak Puas</a><br>
								<textarea class='input_main' type='text' name='alasan' value='' required style='width:100%;max-width:100%;'></textarea><br>
								<input style='margin-left:5px;' class='submit_main fr' type='submit' value='Tidak Puas'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
?>
<div class='judul_main' style='position: fixed;'>Usulan Perubahan Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE no_upp='$id' AND status='closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan='0000-00-00'");
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=kepuasan' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else{
			$filter="";
			$sort="tgl_pengecekan ASC";
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
			$a=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan='0000-00-00' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT *,upp.no_upp FROM upp 
				inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
				inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
				inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
				LEFT JOIN validasi_ik_tmp ON upp.no_upp = validasi_ik_tmp.no_upp
				WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan='0000-00-00' ".$filter);
			$page2=mysqli_num_rows($page1);
			$page3=$page2/30;
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
						echo "<td><a href='main?index=upp&step=kepuasan&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=kepuasan&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=kepuasan&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=kepuasan&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=kepuasan&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=kepuasan&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=kepuasan&hal=$page$sorturl'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					echo "
					</tr>
				</table>
			";
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
			<td colspan='2'>Action</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=no&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=no&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=no&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=lokasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=email_pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=pic2&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=divisi_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=divisi_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=divisi_prosedur&order=ASC$halurl'>";
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
						if ($sortby=='prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=nama_bb&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=nama_bb&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=nama_bb&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=jenis_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=jenis_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=jenis_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=detail_prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=detail_prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=detail_prosedur&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=nama_folder&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=nama_folder&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=nama_folder&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=sebelumperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=setelahperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=alasan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
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
			<td>Attachment File User</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='kat_perubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=kat_perubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=kat_mesin&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=pic&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=cek_ddd&order=ASC$halurl'>";
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
						if ($sortby=='status') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=status&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=status&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=status&order=ASC$halurl'>";
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
						if ($sortby=='kat_delay') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_delay&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=kat_delay&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=kat_delay&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kirim&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kirim&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kirim&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic1&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pic2&order=ASC$halurl'>";
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
			<td>Tanggal Approval Validasi</td>
			<td>Attachment File Prosedur</td>
            <td>Attachment File Hasil Daftar Hadir</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='tgl_berlaku') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_berlaku&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_sosialisasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_sosialisasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_sosialisasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_filling&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_filling&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_filling&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_distribusi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_distribusi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_distribusi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kembali&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kembali&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_kembali&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=no_spd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=no_spd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=no_spd&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pengecekan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pengecekan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=tgl_pengecekan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=kesesuaian_dokumen&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=kesesuaian_dokumen&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=kesesuaian_dokumen&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=keterangan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=keterangan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=keterangan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi_cover&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi_cover&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=kepuasan&sort=no_revisi_cover&order=ASC$halurl'>";
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
		</tr>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		if (isset($_SESSION['username'])) {
			$start = new DateTime($hariini);
			$finish = new DateTime($c['tgl_pengecekan']);
			$leadtime=$start->diff($finish);
			$leadtime=$leadtime->days;
			if ($leadtime>2) {
				header('location:main?index=upp&step=kepuasan&action=autopuas&id='.$c['no_upp']);
			}
		}
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=kepuasan&action=puas&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> puas
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=kepuasan&action=tidak&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> tidak
						</a>
					</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[nama_bb]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>$c[permohonan_tgl_berlaku]</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>
					<td>$c[pic]</td>
					<td>$c[cek_ddd]</td>
					<td>$c[status]</td>
					<td>$c[kat_delay]</td>
					<td>$c[tgl_kirim]</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
					<td>$c[vi_pic_app]</td>
					<td>
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
					<td>$c[tgl_berlaku]</td>
					<td>$c[tgl_sosialisasi]</td>
					<td>$c[tgl_filling]</td>
					<td>$c[tgl_distribusi]</td>
					<td>$c[tgl_kembali]</td>
					<td>$c[no_spd]</td>
					<td>$c[tgl_pengecekan]</td>
					<td>$c[kesesuaian_dokumen]</td>
					<td>$c[keterangan]</td>
					<td>$c[no_revisi]</td>
					<td>$c[no_revisi_cover]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=kepuasan&action=puas&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:12px; height:9px; margin: 2px 0px 0px 3px;' src='img/done.png'> puas
						</a>
					</td>
					<td style='padding:10px;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=kepuasan&action=tidak&id=$c[no_upp]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> tidak
						</a>
					</td>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[pic2]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
					<td>$c[nama_bb]</td>
					<td>$c[jenis_prosedur]</td>
					<td>$c[detail_prosedur]</td>
					<td>$c[nama_folder]</td>
					<td>$sebelumperubahan</td>
					<td>$setelahperubahan</td>
					<td>$alasan</td>
					<td>$c[permohonan_tgl_berlaku]</td>
					<td>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[kat_perubahan]</td>
					<td>$c[kat_mesin]</td>
					<td>$c[pic]</td>
					<td>$c[cek_ddd]</td>
					<td>$c[status]</td>
					<td>$c[kat_delay]</td>
					<td>$c[tgl_kirim]</td>
					<td>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td>$c[tgl_pic1]</td>
					<td>$c[tgl_pic2]</td>
					<td>$c[vi_pic_app]</td>
					<td>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=file_upload/daftar_hadir/$c[file_daftar_hadir]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "</td>
					<td>$c[tgl_berlaku]</td>
					<td>$c[tgl_sosialisasi]</td>
					<td>$c[tgl_filling]</td>
					<td>$c[tgl_distribusi]</td>
					<td>$c[tgl_kembali]</td>
					<td>$c[no_spd]</td>
					<td>$c[tgl_pengecekan]</td>
					<td>$c[kesesuaian_dokumen]</td>
					<td>$c[keterangan]</td>
					<td>$c[no_revisi]</td>
					<td>$c[no_revisi_cover]</td>
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