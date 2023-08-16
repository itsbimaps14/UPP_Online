<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$jenis_ddd=test($_POST['jenis_ddd']);
					$no_copy_master=test($_POST['no_copy_master']);
					$penerima=test($_POST['penerima']);
					$pj=test($_POST['pj']);

					if ($a=mysqli_query($conn, "INSERT INTO master_ddd (jenis_ddd,no_copy_master,penerima,pj)
																values ('$jenis_ddd','$no_copy_master','$penerima','$pj')
								")){
							header('location:admin?index=listmasterddd');
					}
					else{
						echo "<div class='alert_adm alert'>tambah master ddd gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listmasterddd'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:100px;'>
							Form Master DDD
						</div>
						<div class='form_process'>
							<form action='admin?index=listmasterddd&action=tambah' method='post'>
								<a class='j_input_main'>Kategori</a><br>
								<select class='input_main' name='jenis_ddd' style='width:100%;' required autofocus>
									<option value=''></option>
									";
									$jenisarraytampil=array('Internal','Eksternal');
									$jenisarray=array('internal','eksternal');
									$jenislength=count($jenisarray);

									for ($x=0; $x < $jenislength; $x++) {
										echo "
											<option value='$jenisarray[$x]'>$jenisarraytampil[$x]</option>
										";
									}
									echo "
								</select><br>
								<a class='j_input_main'>No. Copy</a><br>
								<input class='input_main' type='input' name='no_copy_master' placeholder='No. Copy' style='width:100%;' required><br>
								<a class='j_input_main'>Penerima</a><br>
								<input class='input_main' type='input' name='penerima' placeholder='Penerima' style='width:100%;' required><br>
								<a class='j_input_main'>Penanggung Jawab</a><br>
								<input class='input_main' type='input' name='pj' placeholder='Penanggung Jawab' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from master_ddd WHERE no_master_ddd=$id  ");
				header('location:admin?index=listmasterddd');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from master_ddd where no_master_ddd='$id'");
				$c=mysqli_fetch_array($a);
				$jenis_ddd=$c['jenis_ddd'];
				$no_copy_master=$c['no_copy_master'];
				$penerima=$c['penerima'];
				$pj=$c['pj'];
				echo "
					<form action='admin?index=listmasterddd&action=edit&id=$id' method='post'>
					<div class='judul_main'>Master DDD</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$jenis_ddd=test($_POST['jenis_ddd']);
						$no_copy_master=test($_POST['no_copy_master']);
						$penerima=test($_POST['penerima']);
						$pj=test($_POST['pj']);

						if ($a=mysqli_query($conn, "UPDATE master_ddd
									SET jenis_ddd='$jenis_ddd',
									no_copy_master='$no_copy_master',
									penerima='$penerima',
									pj='$pj'
									WHERE no_master_ddd = '$id'
									")){
								header('location:admin?index=listmasterddd');
						}
						else{
							echo "<div class='alert_adm alert'>update master ddd gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Kategori</a><br>
						<select class='input_main' name='jenis_ddd' required autofocus>
							<option value=''></option>
							";
							$jenisarraytampil=array('Internal','Eksternal');
							$jenisarray=array('internal','eksternal');
							$jenislength=count($jenisarray);
							for ($x=0; $x < $jenislength; $x++) {
								if ($jenisarray[$x]==$jenis_ddd) {
									echo "
									<option value='$jenisarray[$x]' selected>$jenisarraytampil[$x]</option>
									";
								}
								else{
									echo "
									<option value='$jenisarray[$x]'>$jenisarraytampil[$x]</option>
									";
								}
							}
							echo "
						</select><br>
						<a class='j_input_main'>No. Copy</a><br>
						<input class='input_main' type='input' name='no_copy_master' value='$no_copy_master' placeholder='No. Copy' required><br>
						<a class='j_input_main'>Penerima</a><br>
						<input class='input_main' type='input' name='penerima' value='$penerima' placeholder='Penerima' required><br>
						<a class='j_input_main'>Penanggung Jawab</a><br>
						<input class='input_main' type='input' name='pj' value='$pj' placeholder='Penanggung Jawab' required><br>
					</div>
					<input class='submit_main' style='margin-left:305px;' type='submit' value='Update'>
				</form>
				";
			break;
		}
	}
	else{
	}

	echo "
		<div class='judul_main'>List Master DDD</div>
		<div class='form_main'>	
			<a href='admin?index=listmasterddd&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Kategori</td>
					<td>No. Copy</td>
					<td>Penerima</td>
					<td>Penanggung Jawab</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from master_ddd order by no_master_ddd");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[jenis_ddd]</td>
					<td style='text-align:left;'>$c[no_copy_master]</td>
					<td style='text-align:left;'>$c[penerima]</td>
					<td style='text-align:left;'>$c[pj]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterddd&action=edit&id=$c[no_master_ddd]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterddd&action=hapus&id=$c[no_master_ddd]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> hapus
						</a>
					</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[jenis_ddd]</td>
					<td style='text-align:left;'>$c[no_copy_master]</td>
					<td style='text-align:left;'>$c[penerima]</td>
					<td style='text-align:left;'>$c[pj]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterddd&action=edit&id=$c[no_master_ddd]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterddd&action=hapus&id=$c[no_master_ddd]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/warning.png'> hapus
						</a>
					</td>
				</tr>
			";
		}
		else{

		}
		$rowscount++;
	}
	echo "
			</table>
		</div>
	";
?>