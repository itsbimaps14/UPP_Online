<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$divisi_prosedur=test($_POST['divisi_prosedur']);
					$nf_prosedur=test($_POST['nf_prosedur']);

					if ($a=mysqli_query($conn, "INSERT INTO divisi_prosedur (divisi_prosedur,nf_prosedur)
																values ('$divisi_prosedur','$nf_prosedur')
								")){
							header('location:admin?index=listdivisiprosedur');
					}
					else{
						echo "<div class='alert_adm alert'>tambah divisi prosedur gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listdivisiprosedur'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Divisi Prosedur
						</div>
						<div class='form_process'>
							<form action='admin?index=listdivisiprosedur&action=tambah' method='post'>
								<a class='j_input_main'>Nama Divisi Prosedur</a><br>
								<input class='input_main' type='input' name='divisi_prosedur' placeholder='Divisi Prosedur' style='width:100%;' required autofocus><br>
								<a class='j_input_main'>Nama File Divisi Prosedur</a><br>
								<input class='input_main' type='input' name='nf_prosedur' placeholder='Nama File Divisi Prosedur' style='width:100%;' required ><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from divisi_prosedur WHERE no_divisi_prosedur=$id  ");
				header('location:admin?index=listdivisiprosedur');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from divisi_prosedur where no_divisi_prosedur='$id'");
				$c=mysqli_fetch_array($a);
				$divisi_prosedur=$c['divisi_prosedur'];
				$nf_prosedur=$c['nf_prosedur'];
				echo "
					<form action='admin?index=listdivisiprosedur&action=edit&id=$id' method='post'>
					<div class='judul_main'>Divisi Prosedur</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$divisi_prosedur=test($_POST['divisi_prosedur']);
						$nf_prosedur=test($_POST['nf_prosedur']);

						if ($a=mysqli_query($conn, "UPDATE divisi_prosedur
									SET divisi_prosedur='$divisi_prosedur',
									nf_prosedur='$nf_prosedur'
									WHERE no_divisi_prosedur = '$id'
									")){
								header('location:admin?index=listdivisiprosedur');
						}
						else{
							echo "<div class='alert_adm alert'>update divisi prosedur gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Divisi Prosedur</a><br>
						<input class='input_main' type='text' name='divisi_prosedur' value='$divisi_prosedur' required autofocus><br>
						<a class='j_input_main'>Nama File Divisi Prosedur</a><br>
						<input class='input_main' type='text' name='nf_prosedur' value='$nf_prosedur' required autofocus><br>
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
		<div class='judul_main'>List Divisi Prosedur</div>
		<div class='form_main'>	
			<a href='admin?index=listdivisiprosedur&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Divisi Prosedur</td>
					<td>Nama Folder</td>
					<td>Edit</td>
					<td>Hapus</td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from divisi_prosedur order by divisi_prosedur");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[divisi_prosedur]</td>
					<td style='text-align:center;'>$c[nf_prosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdivisiprosedur&action=edit&id=$c[no_divisi_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdivisiprosedur&action=hapus&id=$c[no_divisi_prosedur]'>
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
					<td style='text-align:left;'>$c[divisi_prosedur]</td>
					<td style='text-align:center;'>$c[nf_prosedur]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdivisiprosedur&action=edit&id=$c[no_divisi_prosedur]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdivisiprosedur&action=hapus&id=$c[no_divisi_prosedur]'>
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