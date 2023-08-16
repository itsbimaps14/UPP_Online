<?php
	$awal=0;
	$hariini=date("Y-m-d");	
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'tambahpruning':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kode_oracle=test($_POST['kode_oracle']);
					$nama_produk=test($_POST['nama_produk']);
					$kode_form=test($_POST['kode_form']);
					$no_sk=test($_POST['no_sk']);
					$follow_up=test($_POST['follow_up']);
					$status_follow_up=test($_POST['status_follow_up']);
					if ($a=mysqli_query($conn, "INSERT INTO informasi_produk (kode_oracle,nama_produk,kode_form,no_sk,jenis,follow_up,status_follow_up)
													VALUES	('$kode_oracle','$nama_produk','$kode_form','$no_sk','pruning','$follow_up','$status_follow_up')")) {
						header('location:home');
					}
					else {
						$alert='tambah informasi produk pruning gagal'.mysqli_errno($conn)." - ".mysqli_error($conn);
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='home'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;'>
							Form Produk Pruning
						</div>
						<div class='form_process'>
							<form action='main.php?index=home&action=tambahpruning' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Kode Oracle</a><br>
								<input class='input_main' type='input' name='kode_oracle' placeholder='Kode Oracle' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama Produk</a><br>
								<input class='input_main' type='input' name='nama_produk' placeholder='Nama Produk' style='width:100%;' required><br>
								<a class='j_input_main'>Kode Formula</a><br>
								<input class='input_main' type='input' name='kode_form' placeholder='Kode Formula' style='width:100%;' required><br>
								<a class='j_input_main'>No. SK</a><br>
								<input class='input_main' type='input' name='no_sk' placeholder='No. SK' style='width:100%;' required><br>
								<a class='j_input_main'>Follow Up</a><br>
								<textarea class='input_main' type='text' name='follow_up' style='width:100%;max-width:100%;'></textarea>
								<a class='j_input_main'>Status Follow Up</a><br>
								<textarea class='input_main' type='text' name='status_follow_up' style='width:100%;max-width:100%;'></textarea>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'tambahlaunching':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kode_oracle=test($_POST['kode_oracle']);
					$nama_produk=test($_POST['nama_produk']);
					$kode_form=test($_POST['kode_form']);
					$no_sk=test($_POST['no_sk']);
					$follow_up=test($_POST['follow_up']);
					$status_follow_up=test($_POST['status_follow_up']);
					if ($a=mysqli_query($conn, "INSERT INTO informasi_produk (kode_oracle,nama_produk,kode_form,no_sk,jenis,follow_up,status_follow_up)
													VALUES	('$kode_oracle','$nama_produk','$kode_form','$no_sk','launching','$follow_up','$status_follow_up')")) {
						header('location:home');
					}
					else {
						$alert='tambah informasi produk launching gagal';
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='home'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;'>
							Form Produk Launching
						</div>
						<div class='form_process'>
							<form action='main.php?index=home&action=tambahlaunching' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Kode Oracle</a><br>
								<input class='input_main' type='input' name='kode_oracle' placeholder='Kode Oracle' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama Produk</a><br>
								<input class='input_main' type='input' name='nama_produk' placeholder='Nama Produk' style='width:100%;' required><br>
								<a class='j_input_main'>Kode Formula</a><br>
								<input class='input_main' type='input' name='kode_form' placeholder='Kode Formula' style='width:100%;' required><br>
								<a class='j_input_main'>No. SK</a><br>
								<input class='input_main' type='input' name='no_sk' placeholder='No. SK' style='width:100%;' required><br>
								<a class='j_input_main'>Follow Up</a><br>
								<textarea class='input_main' type='text' name='follow_up' style='width:100%;max-width:100%;'></textarea>
								<a class='j_input_main'>Status Follow Up</a><br>
								<textarea class='input_main' type='text' name='status_follow_up' style='width:100%;max-width:100%;'></textarea>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'editpruning':
				$id=$_GET['id'];
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kode_oracle=test($_POST['kode_oracle']);
					$nama_produk=test($_POST['nama_produk']);
					$kode_form=test($_POST['kode_form']);
					$no_sk=test($_POST['no_sk']);
					$follow_up=test($_POST['follow_up']);
					$status_follow_up=test($_POST['status_follow_up']);
					if ($a=mysqli_query($conn, "UPDATE informasi_produk SET kode_oracle='$kode_oracle',
																			nama_produk='$nama_produk',
																			kode_form='$kode_form',
																			no_sk='$no_sk',
																			jenis='pruning',
																			follow_up='$follow_up',
																			status_follow_up='$status_follow_up'
																		WHERE no='$id'
																		")) {
						header('location:home');
					}
					else {
						$alert='edit informasi produk pruning gagal';
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE no='$id' order by no desc");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='home'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;'>
							Form Produk Pruning
						</div>
						<div class='form_process'>
							<form action='main.php?index=home&action=editpruning&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Kode Oracle</a><br>
								<input class='input_main' type='input' name='kode_oracle' value='$c[kode_oracle]' placeholder='Kode Oracle' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama Produk</a><br>
								<input class='input_main' type='input' name='nama_produk' value='$c[nama_produk]' placeholder='Nama Produk' style='width:100%;' required><br>
								<a class='j_input_main'>Kode Formula</a><br>
								<input class='input_main' type='input' name='kode_form' value='$c[kode_form]' placeholder='Kode Formula' style='width:100%;' required><br>
								<a class='j_input_main'>No. SK</a><br>
								<input class='input_main' type='input' name='no_sk' value='$c[no_sk]' placeholder='No. SK' style='width:100%;' required><br>
								<a class='j_input_main'>Follow Up</a><br>
								<textarea class='input_main' type='text' name='follow_up' style='width:100%;max-width:100%;'>$c[follow_up]</textarea>
								<a class='j_input_main'>Status Follow Up</a><br>
								<textarea class='input_main' type='text' name='status_follow_up' style='width:100%;max-width:100%;'>$c[status_follow_up]</textarea>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'editlaunching':
				$id=$_GET['id'];
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kode_oracle=test($_POST['kode_oracle']);
					$nama_produk=test($_POST['nama_produk']);
					$kode_form=test($_POST['kode_form']);
					$no_sk=test($_POST['no_sk']);
					$follow_up=test($_POST['follow_up']);
					$status_follow_up=test($_POST['status_follow_up']);
					if ($a=mysqli_query($conn, "UPDATE informasi_produk SET kode_oracle='$kode_oracle',
																			nama_produk='$nama_produk',
																			kode_form='$kode_form',
																			no_sk='$no_sk',
																			jenis='launching',
																			follow_up='$follow_up',
																			status_follow_up='$status_follow_up'
																		WHERE no='$id'
																		")) {
						header('location:home');
					}
					else {
						$alert='edit informasi produk launching gagal';
					}
				}
				$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE no='$id' order by no desc");
				$c=mysqli_fetch_array($a);
				echo "
					<div id='popup' class='popup'>
						<a href='home'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:50px;'>
							Form Produk Launching
						</div>
						<div class='form_process'>
							<form action='main.php?index=home&action=editlaunching&id=$id' method='post' enctype='multipart/form-data'>
								<a class='j_input_main'>Kode Oracle</a><br>
								<input class='input_main' type='input' name='kode_oracle' value='$c[kode_oracle]' placeholder='Kode Oracle' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama Produk</a><br>
								<input class='input_main' type='input' name='nama_produk' value='$c[nama_produk]' placeholder='Nama Produk' style='width:100%;' required><br>
								<a class='j_input_main'>Kode Formula</a><br>
								<input class='input_main' type='input' name='kode_form' value='$c[kode_form]' placeholder='Kode Formula' style='width:100%;' required><br>
								<a class='j_input_main'>No. SK</a><br>
								<input class='input_main' type='input' name='no_sk' value='$c[no_sk]' placeholder='No. SK' style='width:100%;' required><br>
								<a class='j_input_main'>Follow Up</a><br>
								<textarea class='input_main' type='text' name='follow_up' style='width:100%;max-width:100%;'>$c[follow_up]</textarea>
								<a class='j_input_main'>Status Follow Up</a><br>
								<textarea class='input_main' type='text' name='status_follow_up' style='width:100%;max-width:100%;'>$c[status_follow_up]</textarea>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
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
					$a=mysqli_query($conn, "UPDATE informasi_produk SET status='tidak aktif' WHERE no=$id  ");
					header('location:home');
				}
				elseif ($status=='tidak aktif') {
					$a=mysqli_query($conn, "UPDATE informasi_produk SET status='aktif' WHERE no=$id  ");
					header('location:home');
				}
				break;
		}
	}
?>
<div id='main' class='main fl m-left-0px width100pc'>
	<div id='desc-head'>
		<p class='desc-isi' style='font-size:25px;margin-bottom:10px;'>Selamat Datang di Portal Procedure Online</p>
		<p class='desc-isi'>Aplikasi Web berisi tentang prosedur - prosedur yang berlaku di PT. Nutrifood Indonesia</p>
		<p class='desc-isi'>Aplikasi ini juga mencakup proses Usulan Perubahan Prosedur (UPP) sesuai dengan kebutuhan</p>
		<p class='desc-isi'>SLA proses UPP : 3 hk (Process - final approval (tgl berlaku)).</p>
	</div>
	<div style='padding:20px 0px 0px 0px;width:360px;margin-left: 560px;'>
		<a href='//clickdata'>
			<div class='link-home fl'>Go to Click Data</div>
		</a>
		<div class='cb'></div>

	</div>
	<div style='padding:20px;padding-right:0px;width:97%;'>
		<div style='padding:10px;background-color:#028738;color:white;'>Sosialisasi Usulan Perubahan Prosedur Terbaru</div>
		<div>
        <?php
				
					echo "
						<div class='fl' style='margin:5px;margin-right:10px;'>";
							echo"<a  href=\"excel/export.php?file=terbaru\"><button style='margin-right:10px;' id='download' class='button_download fl'>Export To Excel</button></a>
						</div>
						<div class='cb'></div>
					";
				?>
			<?php
				$sortupp="tgl_kepuasan DESC";
				if (isset($_GET['sortupp'])) {
					$sortuppby=$_GET['sortupp'];
					if (isset($_GET['order'])) {
						$orderby=$_GET['order'];
						$sortupp=$sortuppby." ".$orderby;
						$sortuppurl='&sortupp='.$sortuppby.'&order='.$orderby;
					}
					else{
						$orderby='';
						$sortupp=$sortuppby;
						$sortuppurl='&sortupp='.$sortuppby;
					}
				}
				else{
					$sortuppby='';
					$sortuppurl='';
				}
				if (isset($_GET['halupp'])) {
					$halupp=$_GET['halupp'];
					$haluppurl='&halupp='.$halupp;
				}
				else{
					$halupp = 1;
					$haluppurl='';
				}
				$awal=($halupp-1)*5;
				$akhir=5;
				$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' ORDER BY ".$sortupp." LIMIT $awal,$akhir");
				$page1=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00'");
				$page2=mysqli_num_rows($page1);
				$page3=$page2/5;
				$page=floor($page3)+1;
				echo "
					<table style='padding:5px;font-size:14px;' class='page_number'>
						<tr>
						";
						if ($halupp<2) {
							echo "<td>First</a></td>";
							echo "<td>Previous</a></td>";
							$halupp2=$halupp;
						}
						elseif ($halupp<=2) {
							$halupp2=$halupp-1;
							$halupp3=$halupp-1;
							echo "<td><a href='main.php?index=home&halupp=1$sortuppurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&halupp=$halupp3$sortuppurl'>Previous</a></td>";
						}
						else{
							$halupp2=$halupp-2;
							$halupp3=$halupp-1;
							echo "<td><a href='main.php?index=home&halupp=1$sortuppurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&halupp=$halupp3$sortuppurl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($halupp2>$page) {
							}
							elseif ($halupp2==$halupp) {
								echo"<td style='font-family:arial;color: black;'>$halupp2</td>";
							}
							else {
								echo"<td><a href='main.php?index=home&halupp=$halupp2$sortuppurl'>$halupp2</a></td>";
							}
							$halupp2++;
						}
						if ($halupp<$page) {
							$halupp3=$halupp+1;
							echo "<td><a href='main.php?index=home&halupp=$halupp3$sortuppurl'>Next</a></td>";
							echo "<td><a href='main.php?index=home&halupp=$page$sortuppurl'>Last</a></td>";
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
				<tr class='top_table_home'>
					<td>
						<?php
							if (isset($sortupp)) {
								if ($sortuppby=='no') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortupp=no&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortupp=no&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortupp=no&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='divisi_prosedur') {
									if ($orderby=='ASC') {
										echo "<a href='main?index=home&sortupp=divisi_prosedur&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main?index=home&sortupp=divisi_prosedur&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main?index=home&sortupp=divisi_prosedur&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='master_prosedur') {
									if ($orderby=='ASC') {
										echo "<a href='main?index=home&sortupp=master_prosedur&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main?index=home&sortupp=master_prosedur&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main?index=home&sortupp=master_prosedur&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='jenis_prosedur') {
									if ($orderby=='ASC') {
										echo "<a href='main?index=home&sortupp=jenis_prosedur&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main?index=home&sortupp=jenis_prosedur&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main?index=home&sortupp=jenis_prosedur&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='detail_prosedur') {
									if ($orderby=='ASC') {
										echo "<a href='main?index=home&sortupp=detail_prosedur&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main?index=home&sortupp=detail_prosedur&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main?index=home&sortupp=detail_prosedur&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='nama_folder') {
									if ($orderby=='ASC') {
										echo "<a href='main?index=home&sortupp=nama_folder&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main?index=home&sortupp=nama_folder&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main?index=home&sortupp=nama_folder&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='sebelumperubahan') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortupp=sebelumperubahan&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortupp=sebelumperubahan&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortupp=sebelumperubahan&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='setelahperubahan') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortupp=setelahperubahan&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortupp=setelahperubahan&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortupp=setelahperubahan&order=ASC$haluppurl'>";
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
							if (isset($sortupp)) {
								if ($sortuppby=='alasan') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortupp=alasan&order=DESC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortupp=alasan&order=ASC$haluppurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortupp=alasan&order=ASC$haluppurl'>";
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
					<td>Attachment File</td>
					<td>Link Prosedur</td>
				</tr>
				<?php
					$rowscount=$awal+1;
					while ($c=mysqli_fetch_array($a)) {
						$sebelumperubahan=nl2br($c['sebelumperubahan']);
						$setelahperubahan=nl2br($c['setelahperubahan']);
						$alasan=nl2br($c['alasan']);
						if ($rowscount % 2 == 1) {
							echo "
								<tr class='main_table_home odd'>
									<td>$c[no_upp]</td>
									<td>$c[divisi_prosedur]</td>
									<td>$c[master_prosedur]</td>
									<td>$c[jenis_prosedur]</td>
									<td>$c[detail_prosedur]</td>
									<td>$c[nama_folder]</td>
									<td>$sebelumperubahan</td>
									<td>$setelahperubahan</td>
									<td>$alasan</td>
									<td>
									";
										if ($c['file_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
										}
										else{
											echo "no file";
										}
									echo "
									</td>
									<td>
									";
										if ($c['link_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
										}
										else{
											echo "no link";
										}
									echo "
									</td>
								</tr>
							";
						}
						elseif ($rowscount % 2 == 0) {
							echo "
								<tr class='main_table_home even'>
									<td>$c[no_upp]</td>
									<td>$c[divisi_prosedur]</td>
									<td>$c[master_prosedur]</td>
									<td>$c[jenis_prosedur]</td>
									<td>$c[detail_prosedur]</td>
									<td>$c[nama_folder]</td>
									<td>$sebelumperubahan</td>
									<td>$setelahperubahan</td>
									<td>$alasan</td>
									<td>
									";
										if ($c['file_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
										}
										else{
											echo "no file";
										}
									echo "
									</td>
									<td>
									";
										if ($c['link_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
										}
										else{
											echo "no link";
										}
									echo "
									</td>
								</tr>
							";
						}
						$rowscount++;
					}
				?>
			</table>
		</div>
	</div>	
	<div style='padding:20px;padding-right:0px;width:97%;'>
		<div style='padding:10px;background-color:#028738;color:white;'>Informasi Produk Pruning</div>
		<div>
			<?php
				
					echo "
						<div class='fl' style='margin:5px;margin-right:10px;'>";
						if (isset($_SESSION['username'])) {
						echo"
							<a href='main.php?index=home&action=tambahpruning#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>
							";
						}
							echo"<a  href=\"excel/export.php?file=pruning\"><button style='margin-right:10px;' id='download' class='button_download fl'>Export To Excel</button></a>
						</div>
						<div class='cb'></div>
					";
				?>
                
                
                <?php
				$sortpruning="no DESC";
				if (isset($_GET['sortpruning'])) {
					$sortpruningby=$_GET['sortpruning'];
					if (isset($_GET['order'])) {
						$orderby=$_GET['order'];
						$sortpruning=$sortpruningby." ".$orderby;
						$sortpruningurl='&sortpruning='.$sortpruningby.'&order='.$orderby;
					}
					else{
						$orderby='';
						$sortpruning=$sortpruningby;
						$sortpruningurl='&sortpruning='.$sortpruningby;
					}
				}
				else{
					$sortpruningby='';
					$sortpruningurl='';
				}
				if (isset($_GET['halpruning'])) {
					$halpruning=$_GET['halpruning'];
					$halpruningurl='&halpruning='.$halpruning;
				}
				else{
					$halpruning = 1;
					$halpruningurl='';
				}
				$awal=($halpruning-1)*5;
				$akhir=5;
				if (isset($_SESSION['username'])) {
					$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'pruning' ORDER BY ".$sortpruning." LIMIT $awal,$akhir");
					$page1=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'pruning' order by no desc");
				}
				else{
					$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'pruning' AND status='aktif' ORDER BY ".$sortpruning." LIMIT $awal,$akhir");
					$page1=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'pruning' AND status='aktif'  order by no desc");
				}
				$page2=mysqli_num_rows($page1);
				$page3=$page2/5;
				$page=floor($page3)+1;
				echo "
					<table style='padding:5px;font-size:14px;' class='page_number'>
						<tr>
						";
						if ($halpruning<2) {
							echo "<td>First</a></td>";
							echo "<td>Previous</a></td>";
							$halpruning2=$halpruning;
						}
						elseif ($halpruning<=2) {
							$halpruning2=$halpruning-1;
							$halpruning3=$halpruning-1;
							echo "<td><a href='main.php?index=home&halpruning=1$sortpruningurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&halpruning=$halpruning3$sortpruningurl'>Previous</a></td>";
						}
						else{
							$halpruning2=$halpruning-2;
							$halpruning3=$halpruning-1;
							echo "<td><a href='main.php?index=home&halpruning=1$sortpruningurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&halpruning=$halpruning3$sortpruningurl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($halpruning2>$page) {
							}
							elseif ($halpruning2==$halpruning) {
								echo"<td style='font-family:arial;color: black;'>$halpruning2</td>";
							}
							else {
								echo"<td><a href='main.php?index=home&halpruning=$halpruning2$sortpruningurl'>$halpruning2</a></td>";
							}
							$halpruning2++;
						}
						if ($halpruning<$page) {
							$halpruning3=$halpruning+1;
							echo "<td><a href='main.php?index=home&halpruning=$halpruning3$sortpruningurl'>Next</a></td>";
							echo "<td><a href='main.php?index=home&halpruning=$page$sortpruningurl'>Last</a></td>";
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
			<div class='cb'></div>
			<table class='table_admin'>
				<tr class='top_table_home'>
					<td>No</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='kode_oracle') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=kode_oracle&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=kode_oracle&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=kode_oracle&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Kode Oracle
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='nama_produk') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=nama_produk&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=nama_produk&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=nama_produk&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Nama Produk
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='kode_form') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=kode_form&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=kode_form&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=kode_form&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Kode Formula
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='no_sk') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=no_sk&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=no_sk&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=no_sk&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								No. SK
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='follow_up') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=follow_up&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=follow_up&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=follow_up&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Follow Up
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortpruning)) {
								if ($sortpruningby=='status_follow_up') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortpruning=status_follow_up&order=DESC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortpruning=status_follow_up&order=ASC$halpruningurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortpruning=status_follow_up&order=ASC$halpruningurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Status Follow Up
							</a>
							";
						?>
					</td>
					<?php
						if (isset($_SESSION['username'])) {
							echo "
								<td colspan='2'>Action</td>
							";
						}
					?>
				</tr>
				<?php
					$rowscount=$awal+1;
					while ($c=mysqli_fetch_array($a)) {
						if ($rowscount % 2 == 1) {
							echo "
								<tr class='main_table_home odd'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
										if (isset($_SESSION['username'])) {
											echo "
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=editpruning&id=$c[no]#popup'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
													</a>
												</td>
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=ubahaktif&id=$c[no]&status=$c[status]'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
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
								<tr class='main_table_home even'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
										if (isset($_SESSION['username'])) {
											echo "
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=editpruning&id=$c[no]#popup'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
													</a>
												</td>
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=ubahaktif&id=$c[no]&status=$c[status]'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
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
				?>
			</table>
		</div>
	</div>
	<div style='padding:20px;padding-right:0px;width:97%;'>
		<div style='padding:10px;background-color:#028738;color:white;'>Informasi Produk Launching</div>
		<div>
			<?php
				
					echo "
						<div class='fl' style='margin:5px;margin-right:10px;'>";
						if (isset($_SESSION['username'])) {
						echo"
							<a href='main.php?index=home&action=tambahlaunching#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>";
				}
							echo"
							<a  href=\"excel/export.php?file=launching\"><button style='margin-right:10px;' id='download' class='button_download fl'>Export To Excel</button></a>
						</div>
						<div class='cb'></div>
					";
				
				$sortlaunching="no DESC";
				if (isset($_GET['sortlaunching'])) {
					$sortlaunchingby=$_GET['sortlaunching'];
					if (isset($_GET['order'])) {
						$orderby=$_GET['order'];
						$sortlaunching=$sortlaunchingby." ".$orderby;
						$sortlaunchingurl='&sortlaunching='.$sortlaunchingby.'&order='.$orderby;
					}
					else{
						$orderby='';
						$sortlaunching=$sortlaunchingby;
						$sortlaunchingurl='&sortlaunching='.$sortlaunchingby;
					}
				}
				else{
					$sortlaunchingby='';
					$sortlaunchingurl='';
				}
				if (isset($_GET['hallaunching'])) {
					$hallaunching=$_GET['hallaunching'];
					$hallaunchingurl='&hallaunching='.$hallaunching;
				}
				else{
					$hallaunching = 1;
					$hallaunchingurl='';
				}
				$awal=($hallaunching-1)*5;
				$akhir=5;
				if (isset($_SESSION['username'])) {
					$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'launching' ORDER BY ".$sortlaunching." LIMIT $awal,$akhir");
					$page1=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'launching'  order by no desc");
				}
				else{
					$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'launching' AND status='aktif' ORDER BY ".$sortlaunching." LIMIT $awal,$akhir");
					$page1=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'launching' AND status='aktif' order by no desc");
				}
				$page2=mysqli_num_rows($page1);
				$page3=$page2/5;
				$page=floor($page3)+1;
				echo "
					<table style='padding:5px;font-size:14px;' class='page_number'>
						<tr>
						";
						if ($hallaunching<2) {
							echo "<td>First</a></td>";
							echo "<td>Previous</a></td>";
							$hallaunching2=$hallaunching;
						}
						elseif ($hallaunching<=2) {
							$hallaunching2=$hallaunching-1;
							$hallaunching3=$hallaunching-1;
							echo "<td><a href='main.php?index=home&hallaunching=1$sortlaunchingurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&hallaunching=$hallaunching3$sortlaunchingurl'>Previous</a></td>";
						}
						else{
							$hallaunching2=$hallaunching-2;
							$hallaunching3=$hallaunching-1;
							echo "<td><a href='main.php?index=home&hallaunching=1$sortlaunchingurl'>First</a></td>";
							echo "<td><a href='main.php?index=home&hallaunching=$hallaunching3$sortlaunchingurl'>Previous</a></td>";
						}
						for ($i=0; $i <= 4; $i++) {
							if ($hallaunching2>$page) {
							}
							elseif ($hallaunching2==$hallaunching) {
								echo"<td style='font-family:arial;color: black;'>$hallaunching2</td>";
							}
							else {
								echo"<td><a href='main.php?index=home&hallaunching=$hallaunching2$sortlaunchingurl'>$hallaunching2</a></td>";
							}
							$hallaunching2++;
						}
						if ($hallaunching<$page) {
							$hallaunching3=$hallaunching+1;
							echo "<td><a href='main.php?index=home&hallaunching=$hallaunching3$sortlaunchingurl'>Next</a></td>";
							echo "<td><a href='main.php?index=home&hallaunching=$page$sortlaunchingurl'>Last</a></td>";
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
			<div class='cb'></div>
			<table class='table_admin'>
				<tr class='top_table_home'>
					<td>No</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='kode_oracle') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=kode_oracle&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=kode_oracle&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=kode_oracle&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Kode Oracle
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='nama_produk') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=nama_produk&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=nama_produk&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=nama_produk&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Nama Produk
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='kode_form') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=kode_form&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=kode_form&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=kode_form&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Kode Formula
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='no_sk') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=no_sk&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=no_sk&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=no_sk&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								No. SK
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='follow_up') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=follow_up&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=follow_up&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=follow_up&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Follow Up
							</a>
							";
						?>
					</td>
					<td>
						<?php
							if (isset($sortlaunching)) {
								if ($sortlaunchingby=='status_follow_up') {
									if ($orderby=='ASC') {
										echo "<a href='main.php?index=home&sortlaunching=status_follow_up&order=DESC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_top.png'><br>";
									}
									else{
										echo "<a href='main.php?index=home&sortlaunching=status_follow_up&order=ASC$hallaunchingurl'>";
										echo "<img style='width:10px;' src='img/order_bottom.png'><br>";
									}
								}
								else{
									echo "<a href='main.php?index=home&sortlaunching=status_follow_up&order=ASC$hallaunchingurl'>";
								}
							}
							else{
								echo "<a>";
							}
							echo "
								Status Follow Up
							</a>
							";
						?>
					</td>
					<?php
						if (isset($_SESSION['username'])) {
							echo "
								<td colspan='2'>Action</td>
							";
						}
					?>
				</tr>
				<?php
					$rowscount=$awal+1;
					while ($c=mysqli_fetch_array($a)) {
						if ($rowscount % 2 == 1) {
							echo "
								<tr class='main_table_home odd'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
										if (isset($_SESSION['username'])) {
											echo "
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=editlaunching&id=$c[no]#popup'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
													</a>
												</td>
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=ubahaktif&id=$c[no]&status=$c[status]'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
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
								<tr class='main_table_home even'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
										if (isset($_SESSION['username'])) {
											echo "
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=editlaunching&id=$c[no]#popup'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
													</a>
												</td>
												<td>
													<a style='padding-right:5px;color: blue;' href='main?index=home&action=ubahaktif&id=$c[no]&status=$c[status]'> 
														<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[status]
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
				?>
			</table>
		</div>
	</div>
</div>
<div class='cb'></div>