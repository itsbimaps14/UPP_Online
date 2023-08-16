<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$jenis_prosedur=test($_POST['jenis_prosedur']);
					$nf_jprosedur=test($_POST['nf_jprosedur']);

					if ($a=mysqli_query($conn, "INSERT INTO jenis_prosedur (jenis_prosedur,nf_jprosedur)
																values ('$jenis_prosedur','$nf_jprosedur')
								")){
							header('location:admin?index=listjenisprosedur');
					}
					else{
						echo "<div class='alert_adm alert'>tambah jenis prosedur gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listjenisprosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Jenis Prosedur
						</div>
						<div class='form_process'>
							<form action='admin?index=listjenisprosedur&action=tambah' method='post'>
								<a class='j_input_main'>Nama Jenis Prosedur</a><br>
								<input class='input_main' type='input' name='jenis_prosedur' placeholder='Nama Jenis Prosedur' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama File Jenis Prosedur</a><br>
								<input class='input_main' type='input' name='nf_jprosedur' placeholder='Nama File Jenis Prosedur' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from jenis_prosedur WHERE no_jenis_prosedur=$id  ");
				header('location:admin?index=listjenisprosedur');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from jenis_prosedur where no_jenis_prosedur='$id'");
				$c=mysqli_fetch_array($a);
				$jenis_prosedur=$c['jenis_prosedur'];
				$nf_jprosedur=$c['nf_jprosedur'];
				echo "
					<form action='admin?index=listjenisprosedur&action=edit&id=$id' method='post'>
					<div class='judul_main'>Jenis Prosedur</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$jenis_prosedur=test($_POST['jenis_prosedur']);
						$nf_jprosedur=test($_POST['nf_jprosedur']);

						if ($a=mysqli_query($conn, "UPDATE jenis_prosedur
									SET jenis_prosedur='$jenis_prosedur',
									nf_jprosedur='$nf_jprosedur'
									WHERE no_jenis_prosedur = '$id'
									")){
								header('location:admin?index=listjenisprosedur');
						}
						else{
							echo "<div class='alert_adm alert'>update jenis prosedur gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Nama Jenis Prosedur</a><br>
						<input class='input_main' type='text' name='jenis_prosedur' value='$jenis_prosedur' required autofocus><br>
						<a class='j_input_main'>Nama File Jenis Prosedur</a><br>
						<input class='input_main' type='text' name='nf_jprosedur' value='$nf_jprosedur' required><br>
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
		<div class='judul_main'>List Jenis Prosedur</div>
		<div class='form_main'>	
			<a href='admin?index=listjenisprosedur&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Jenis Prosedur</td>
					<td>Nama File Jenis Prosedur</td>
					<td>Edit</td>
					<td>Hapus</td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from jenis_prosedur order by jenis_prosedur");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[jenis_prosedur]</td>
					<td style='text-align:center;'>$c[nf_jprosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listjenisprosedur&action=edit&id=$c[no_jenis_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listjenisprosedur&action=hapus&id=$c[no_jenis_prosedur]'>
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
					<td style='text-align:left;'>$c[jenis_prosedur]</td>
					<td style='text-align:center;'>$c[nf_jprosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listjenisprosedur&action=edit&id=$c[no_jenis_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listjenisprosedur&action=hapus&id=$c[no_jenis_prosedur]'>
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