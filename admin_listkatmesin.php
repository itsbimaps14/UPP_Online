<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kat_mesin=test($_POST['kat_mesin']);

					if ($a=mysqli_query($conn, "INSERT INTO kat_mesin (kat_mesin)
																values ('$kat_mesin')
								")){
							header('location:admin?index=listkatmesin');
					}
					else{
						echo "<div class='alert_adm alert'>tambah kategori mesin gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listkatmesin'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Kategori Mesin
						</div>
						<div class='form_process'>
							<form action='admin?index=listkatmesin&action=tambah' method='post'>
								<a class='j_input_main'>Nama Kategori Mesin</a><br>
								<input class='input_main' type='input' name='kat_mesin' placeholder='Kategori Mesin' style='width:100%;' required autofocus><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from kat_mesin WHERE no_kat_mesin=$id  ");
				header('location:admin?index=listkatmesin');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from kat_mesin where no_kat_mesin='$id'");
				$c=mysqli_fetch_array($a);
				$kat_mesin=$c['kat_mesin'];
				echo "
					<form action='admin?index=listkatmesin&action=edit&id=$id' method='post'>
					<div class='judul_main'>Kategori Mesin</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$kat_mesin=test($_POST['kat_mesin']);

						if ($a=mysqli_query($conn, "UPDATE kat_mesin
									SET kat_mesin='$kat_mesin'
									WHERE no_kat_mesin = '$id'
									")){
								header('location:admin?index=listkatmesin');
						}
						else{
							echo "<div class='alert_adm alert'>update kategori mesin gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Nama Kategori Mesin</a><br>
						<input class='input_main' type='text' name='kat_mesin' value='$kat_mesin' required autofocus><br>
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
		<div class='judul_main'>List Kategori Mesin</div>
		<div class='form_main'>	
			<a href='admin?index=listkatmesin&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Kategori Mesin</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from kat_mesin order by kat_mesin");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[kat_mesin]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listkatmesin&action=edit&id=$c[no_kat_mesin]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listkatmesin&action=hapus&id=$c[no_kat_mesin]'>
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
					<td style='text-align:left;'>$c[kat_mesin]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listkatmesin&action=edit&id=$c[no_kat_mesin]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listkatmesin&action=hapus&id=$c[no_kat_mesin]'>
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