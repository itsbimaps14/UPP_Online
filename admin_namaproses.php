<?php
	$filter = "";
	$searchcari ="";
	if (isset($_POST['no_pros']) OR isset($_POST['nm_pros']) or isset($_POST['searchcari'])){
		if($_POST['no_pros'] != ''){
			$filter = "";
			$filter = $filter."and no_pros = '".$_POST['no_pros']."'";
			$no_pros = $_POST['no_pros'];
		}
		if($_POST['nm_pros'] != ''){
			$filter = $filter."and nm_pros = '".$_POST['nm_pros']."'";
			$nm_pros = $_POST['nm_pros'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
			$no_pros=$nm_pros='';
		}
		if ($_POST['no_pros'] == "" AND $_POST['nm_pros'] == "" AND $_POST['searchcari'] == ""){
			header("location:admin?index=namaproses");
		}
	}

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_pros=test($_POST['no_pros']);
					$nm_pros=test($_POST['nm_pros']);

					if ($a=mysqli_query($conn, "INSERT INTO tbl_listnamapros (no_pros,nm_pros)
																values ('$no_pros','$nm_pros')
								")){
							header('location:admin?index=namaproses');
					}
					else{
						echo "<div class='alert_adm alert'>tambah namaproses gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=namaproses'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Tambah Nama Proses
						</div>
						<div class='form_process'>
							<form action='admin?index=namaproses&action=tambah' method='post'>
								<a class='j_input_main'>Kode Prosedur *</a><br>
								<select class='input_main' name='no_pros' style='width:100%;' required autofocus>
									<option value=''>Kode Prosedur</option>
									";
										$d=mysqli_query($conn, "SELECT no_pros from tbl_listworkcenter GROUP BY no_pros ORDER BY no_pros ASC");
										while ($f=mysqli_fetch_array($d)) {
											echo "<option value='$f[no_pros]'>$f[no_pros]</option>";
										}
							echo "
								</select><br>
								<a class='j_input_main'>Nama Proses *</a><br>
								<input class='input_main' type='input' name='nm_pros' placeholder='Example : 01' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'hapus':
				$a=mysqli_query($conn, "SELECT * from tbl_listnamapros where no = '$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$a=mysqli_query($conn, "DELETE from tbl_listnamapros WHERE no = '$id'");
					header('location:admin?index=namaproses');
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=namaproses'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Hapus Nama Proses
						</div>
						<div class='form_process'>
							<form action='admin?index=namaproses&action=hapus&id=$id' method='post'>
								<table>
									<tr><td><a class='j_input_main'>ID<td><a class='j_input_main'>: $id</a><br>
									<tr><td><a class='j_input_main'>No Prosedur<td><a class='j_input_main'>: $c[no_pros]</a><br>
									<tr><td><a class='j_input_main'>Nama Proses<td><a class='j_input_main'>: $c[nm_pros]</a><br>
								</table>
								<br>
								<a style='font-size:12px;'>Hapus Kode Nama Proses dengan Detail diatas ?</a><br><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Hapus'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;

			case 'edit':
				$a=mysqli_query($conn, "SELECT * from tbl_listnamapros where no = '$id'");
				$c=mysqli_fetch_array($a);

				$no_pros1=$c['no_pros'];
				$nm_pros1=$c['nm_pros'];

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$no_pros1=test($_POST['no_pros1']);
					$nm_pros1=test($_POST['nm_pros1']);
					if ($a=mysqli_query($conn, "UPDATE tbl_listnamapros SET 
							no_pros='$no_pros1',
							nm_pros='$nm_pros1'
							WHERE no = '$id'")){

							header('location:admin?index=namaproses');
						}
					else{
						echo "<div class='alert_adm alert'>update nama proses gagal</div>";
					}
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=namaproses'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Ubah Nama Proses
						</div>
						<div class='form_process'>
							<form action='admin?index=namaproses&action=edit&id=$id' method='post'>
								<a class='j_input_main'>Kode Prosedur *</a><br>
								<select class='input_main' name='no_pros1' style='width:100%;' required autofocus>
									<option value=''>Kode Prosedur</option>
									";
										$d=mysqli_query($conn, "SELECT nm_prosedur from master_prosedur ORDER BY nm_prosedur ASC");
										while ($f=mysqli_fetch_array($d)) {
											if ($no_pros1 == $f['nm_prosedur']) {
												echo "<option value='$f[nm_prosedur]' selected>$f[nm_prosedur]</option>";
											}
											else{
												echo "<option value='$f[nm_prosedur]'>$f[nm_prosedur]</option>";
											}
										}
							echo "
								</select><br>
								<a class='j_input_main'>Nama Proses *</a><br>
								<input class='input_main' type='input' name='nm_pros1' value='$nm_pros1' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Ubah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
	echo "
		
		<div class='judul_main'>List Nama Proses</div>
		<div class='form_main'>
			<div class='fl'>
				<a href='admin?index=namaproses&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
				<form action='admin?index=namaproses' method='post' enctype='multipart/form-data' style='margin-bottom:0px;'>
					<select class='input_main' name='no_pros' onchange='this.form.submit()' style='font-family:arial;width:130px;'>
						<option value=''>Prosedur</option>";
							$a = mysqli_query($conn , "SELECT no_pros FROM tbl_listworkcenter GROUP BY no_pros ORDER BY no_pros ASC");
								while($c=mysqli_fetch_array($a)){
									if ($no_pros==$c['no_pros']) {
										echo "<option value='$c[no_pros]' selected>$c[no_pros]</option>";}
									else{
										echo "<option value='$c[no_pros]'>$c[no_pros]</option>";}
								}
					echo "
					</select>
					<select class='input_main' name='nm_pros' onchange='this.form.submit()' style='font-family:arial;width:160px;'>
						<option value=''>Nama Proses</option>";
							$a = mysqli_query($conn , "SELECT nm_pros FROM tbl_listnamapros GROUP BY nm_pros ORDER BY nm_pros ASC");
								while($c=mysqli_fetch_array($a)){
									if ($nm_pros==$c['nm_pros']) {
										echo "<option value='$c[nm_pros]' selected>$c[nm_pros]</option>";}
									else{
										echo "<option value='$c[nm_pros]'>$c[nm_pros]</option>";}
								}
					echo "
					</select>";
							if (isset($searchcari)) {
								echo "<input class='input_main' name='searchcari' value='$searchcari' placeholder='Search by Keyword [Nama Proses]' style='width:250px;margin-left:10px;' onchange='this.form.submit()'>";
							}
							else{
								echo "<input class='input_main' name='searchcari' placeholder='Search by Keyword' style='width:250px;margin:0px;' onchange='this.form.submit()'>";
							}
					echo"
				</form>
			</div>
			<div class='cb'></div>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>No. Prosedur</td>
					<td>Nama Proses</td>
					<td colspan='2'>Action</td>
				</tr>
	";
	$rowscount=1;
	if ($searchcari!='') {
		$a=mysqli_query($conn, "SELECT * from tbl_listnamapros WHERE nm_pros LIKE '%$searchcari%'");
	}
	else{
		$a=mysqli_query($conn, "SELECT * from tbl_listnamapros WHERE no != '0' ".$filter." ORDER BY no DESC");
	}
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[no_pros]</td>
					<td style='text-align:left;'>$c[nm_pros]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=namaproses&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=namaproses&action=hapus&id=$c[no]#popup'>
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
					<td style='text-align:left;'>$c[no_pros]</td>
					<td style='text-align:left;'>$c[nm_pros]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=namaproses&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td >
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=namaproses&action=hapus&id=$c[no]#popup'>
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
	"; ?>

<!-- Bima Putra Sudimulya | SuBZero14 a.k.a SynithisNomi | bimaputras.sz14@gmail.com | 2017 | SMK Negeri 1 Cimahi -->