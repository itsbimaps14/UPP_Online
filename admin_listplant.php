<?php
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$plant=test($_POST['plant']);

					if ($a=mysqli_query($conn, "INSERT INTO plant (plant)
																values ('$plant')
								")){
							header('location:admin?index=listplant');
					}
					else{
						echo "<div class='alert_adm alert'>tambah plant gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listplant'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:200px;'>
							Form Plant
						</div>
						<div class='form_process'>
							<form action='admin?index=listplant&action=tambah' method='post'>
								<a class='j_input_main'>Plant</a><br>
								<input class='input_main' type='input' name='plant' placeholder='Plant' style='width:100%;' required autofocus><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from plant WHERE no=$id  ");
				header('location:admin?index=listplant');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from plant where no='$id'");
				$c=mysqli_fetch_array($a);
				$plant=$c['plant'];
				echo "
					<form action='admin?index=listplant&action=edit&id=$id' method='post'>
					<div class='judul_main'>Plant</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$plant=test($_POST['plant']);

						if ($a=mysqli_query($conn, "UPDATE plant 	SET plant='$plant'
									WHERE no = '$id'
									")){
								header('location:admin?index=listplant');
						}
						else{
							echo "<div class='alert_adm alert'>update plant gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Plant</a><br>
						<input class='input_main' type='text' name='plant' value='$plant' required autofocus><br>
					</div>
					<input class='submit_main' style='margin-left:305px;' type='submit' value='Update'>
				</form>
				";
			break;
			default:
					# code...
			break;
		}
	}
	else{
	}

	echo "
		<div class='judul_main'>List Plant</div>
		<div class='form_main'>	
			<a href='admin?index=listplant&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Nama Plant</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=1;
	$a=mysqli_query($conn, "SELECT * from plant order by plant");
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[plant]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listplant&action=edit&id=$c[no]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listplant&action=hapus&id=$c[no]'>
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
					<td style='text-align:left;'>$c[plant]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listplant&action=edit&id=$c[no]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listplant&action=hapus&id=$c[no]'>
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