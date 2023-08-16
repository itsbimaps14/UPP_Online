<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$golongan_kasus=test($_POST['golongan_kasus']);

					if ($a=mysqli_query($conn, "INSERT INTO golongan_kasus (golongan_kasus)
																values ('$golongan_kasus')
								")){
							header('location:admin?index=listgolongankasus');
					}
					else{
						echo "<div class='alert_adm alert'>tambah golongan kasus gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listgolongankasus'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Golongan Kasus
						</div>
						<div class='form_process'>
							<form action='admin?index=listgolongankasus&action=tambah' method='post'>
								<a class='j_input_main'>Nama Golongan Kasus</a><br>
								<input class='input_main' type='input' name='golongan_kasus' placeholder='Golongan Kasus' style='width:100%;' required autofocus><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from golongan_kasus WHERE no_golongan_kasus=$id  ");
				header('location:admin?index=listgolongankasus');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from golongan_kasus where no_golongan_kasus='$id'");
				$c=mysqli_fetch_array($a);
				$golongan_kasus=$c['golongan_kasus'];
				echo "
					<form action='admin?index=listgolongankasus&action=edit&id=$id' method='post'>
					<div class='judul_main'>Golongan Kasus</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$golongan_kasus=test($_POST['golongan_kasus']);

						if ($a=mysqli_query($conn, "UPDATE golongan_kasus
									SET golongan_kasus='$golongan_kasus'
									WHERE no_golongan_kasus = '$id'
									")){
								header('location:admin?index=listgolongankasus');
						}
						else{
							echo "<div class='alert_adm alert'>update golongan kasus gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Nama Golongan Kasus</a><br>
						<input class='input_main' type='text' name='golongan_kasus' value='$golongan_kasus' required autofocus><br>
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
		<div class='judul_main'>List Golongan Kasus</div>
		<div class='form_main'>	
			<a href='admin?index=listgolongankasus&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Golongan Kasus</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from golongan_kasus order by golongan_kasus");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[golongan_kasus]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listgolongankasus&action=edit&id=$c[no_golongan_kasus]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listgolongankasus&action=hapus&id=$c[no_golongan_kasus]'>
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
					<td style='text-align:left;'>$c[golongan_kasus]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listgolongankasus&action=edit&id=$c[no_golongan_kasus]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listgolongankasus&action=hapus&id=$c[no_golongan_kasus]'>
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