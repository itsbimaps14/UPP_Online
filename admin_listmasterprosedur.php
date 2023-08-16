<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nama_prosedur=test($_POST['nama_prosedur']);
					$nm_prosedur=test($_POST['nm_prosedur']);

					if ($a=mysqli_query($conn, "INSERT INTO master_prosedur (master_prosedur,nm_prosedur)
																values ('$nama_prosedur','$nm_prosedur')
								")){
							header('location:admin?index=listmasterprosedur');
					}
					else{
						echo "<div class='alert_adm alert'>tambah master prosedur gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listmasterprosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Master Prosedur
						</div>
						<div class='form_process'>
							<form action='admin?index=listmasterprosedur&action=tambah' method='post'>
								<a class='j_input_main'>Nama Prosedur</a><br>
								<input class='input_main' type='input' name='nama_prosedur' placeholder='Nama Prosedur' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama File Prosedur</a><br>
								<input class='input_main' type='input' name='nm_prosedur' placeholder='Nama File Prosedur' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from master_prosedur WHERE no_master_prosedur=$id  ");
				header('location:admin?index=listmasterprosedur');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from master_prosedur where no_master_prosedur='$id'");
				$c=mysqli_fetch_array($a);
				$nama_prosedur=$c['master_prosedur'];
				$nm_prosedur=$c['nm_prosedur'];
				echo "
					<form action='admin?index=listmasterprosedur&action=edit&id=$id' method='post'>
					<div class='judul_main'>Master Prosedur</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$nama_prosedur=test($_POST['nama_prosedur']);
						$nm_prosedur=test($_POST['nm_prosedur']);

						if ($a=mysqli_query($conn, "UPDATE master_prosedur
									SET master_prosedur='$nama_prosedur',
									nm_prosedur='$nm_prosedur'
									WHERE no_master_prosedur = '$id'
									")){
								header('location:admin?index=listmasterprosedur');
						}
						else{
							echo "<div class='alert_adm alert'>update master prosedur gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Nama Prosedur</a><br>
						<input class='input_main' type='text' name='nama_prosedur' value='$nama_prosedur' required autofocus><br>
						<a class='j_input_main'>Nama File Prosedur</a><br>
						<input class='input_main' type='text' name='nm_prosedur' value='$nm_prosedur' required autofocus><br>
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
		<div class='judul_main'>List Master Prosedur</div>
		<div class='form_main'>	
			<a href='admin?index=listmasterprosedur&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Prosedur</td>
					<td>Nama File Prosedur</td>
					<td>Edit</td>
					<td>Hapus</td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from master_prosedur order by master_prosedur");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[master_prosedur]</td>
					<td style='text-align:center;'>$c[nm_prosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterprosedur&action=edit&id=$c[no_master_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterprosedur&action=hapus&id=$c[no_master_prosedur]'>
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
					<td style='text-align:left;'>$c[master_prosedur]</td>
					<td style='text-align:center;'>$c[nm_prosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterprosedur&action=edit&id=$c[no_master_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listmasterprosedur&action=hapus&id=$c[no_master_prosedur]'>
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