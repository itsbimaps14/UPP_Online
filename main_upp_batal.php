<?php
	$awal=0;
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	else{
		$hariini=date("Y-m-d");
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
		}
	}
?>
<div class='judul_main' style='position: fixed;'>List Usulan Perubahan Prosedur Batal</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
	echo"<form  name='search' style='margin-bottom:0px;' action='main?index=upp&step=batal' method='post' enctype='multipart/form-data'>
			<input class='input_main' type='text' name='kw' placeholder='search keyword'>
			</form>";
		if (isset($_GET['id'])) {
			$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE no_upp='$id' AND status='batal'");
			echo "
				<div class='alert_adm alert2'>id : $id<a href='main?index=upp&step=batal' style='font-family:arial;color:000;float:right;'>X</a><div class='cb'></div></div>
			";
		}
		else{
			$filter="";
			$sort="tgl_batal DESC";
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
			$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'batal' ".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir");
			$page1=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'batal' ".$filter);
		if(isset($_POST['kw']))
			{
				$kw = $_POST['kw'];
			$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'batal' and (pic2 like '%$kw%' or pic1 like '%$kw%' or lokasi like '%$kw%' or tgl_upp like '%$kw%' or status like '%$kw%' or no_upp like '%$kw%' or pengaju like '%$kw%' or email_pengaju like '%$kw%' or pic1 like '%$kw%' or nama_folder like '%$kw%') ORDER BY tgl_kirim desc
				");
				$page1 = $a;
			}
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
						echo "<td><a href='main?index=upp&step=batal&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=batal&hal=$hal3$sorturl'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=upp&step=batal&hal=1$sorturl'>First</a></td>";
						echo "<td><a href='main?index=upp&step=batal&hal=$hal3$sorturl'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=upp&step=batal&hal=$hal2$sorturl'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=upp&step=batal&hal=$hal3$sorturl'>Next</a></td>";
						echo "<td><a href='main?index=upp&step=batal&hal=$page$sorturl'>Last</a></td>";
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
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='no_upp') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=no_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=no_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=no_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=tgl_upp&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=tgl_upp&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=tgl_upp&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=lokasi&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=lokasi&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=lokasi&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=email_pengaju&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=email_pengaju&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=email_pengaju&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=pic1&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=pic1&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=pic1&order=ASC$halurl'>";
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
						if ($sortby=='prosedur') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=prosedur&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=prosedur&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=prosedur&order=ASC$halurl'>";
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
						if ($sortby=='prosedur2') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=prosedur2&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=prosedur2&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=prosedur2&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Jenis Prosedur
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='prosedur3') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=prosedur3&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=prosedur3&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=prosedur3&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Nama File Prosedur
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='sebelumperubahan') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=sebelumperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=sebelumperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=sebelumperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=setelahperubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=setelahperubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=setelahperubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=alasan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=alasan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=alasan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=permohonan_tgl_berlaku&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=permohonan_tgl_berlaku&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=kat_perubahan&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=kat_perubahan&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=kat_perubahan&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=kat_mesin&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=kat_mesin&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=kat_mesin&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=pic&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=pic&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=pic&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=cek_ddd&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=cek_ddd&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=cek_ddd&order=ASC$halurl'>";
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
								echo "<a href='main?index=upp&step=batal&sort=status&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=status&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=status&order=ASC$halurl'>";
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
						if ($sortby=='tgl_batal') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=tgl_batal&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=tgl_batal&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=tgl_batal&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Tanggal Batal
					</a>
					";
				?>
			</td>
			<td>
				<?php
					if (isset($sort)) {
						if ($sortby=='alasan_batal') {
							if ($orderby=='ASC') {
								echo "<a href='main?index=upp&step=batal&sort=alasan_batal&order=DESC$halurl'>";
								echo "<img style='width:10px;' src='img/order_top.png'><br>";
							}
							else{
								echo "<a href='main?index=upp&step=batal&sort=alasan_batal&order=ASC$halurl'>";
								echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
							}
						}
						else{
							echo "<a href='main?index=upp&step=batal&sort=alasan_batal&order=ASC$halurl'>";
						}
					}
					else{
						echo "<a>";
					}
					echo "
						Alasan Batal
					</a>
					";
				?>
			</td>
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
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
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
					<td>$c[tgl_batal]</td>
					<td>$c[alasan_batal]</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>$c[no_upp]</td>
					<td>$c[tgl_upp]</td>
					<td>$c[lokasi]</td>
					<td>$c[pengaju]</td>
					<td>$c[email_pengaju]</td>
					<td>$c[pic1]</td>
					<td>$c[divisi_prosedur]</td>
					<td>$c[master_prosedur]</td>
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
					<td>$c[tgl_batal]</td>
					<td>$c[alasan_batal]</td>
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