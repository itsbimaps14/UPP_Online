<?php
	$filter = "";
	$searchcari ="";
	if (isset($_POST['kd_plant']) OR isset($_POST['nm_plant']) or isset($_POST['searchcari'])){
		if($_POST['kd_plant'] != ''){
			$filter = "";
			$filter = $filter."and kd_plant = '".$_POST['kd_plant']."'";
			$kd_plant = $_POST['kd_plant'];
		}
		if($_POST['nm_plant'] != ''){
			$filter = $filter."and nm_plant = '".$_POST['nm_plant']."'";
			$nm_plant = $_POST['nm_plant'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
			$kd_plant=$nm_plant='';
		}
		if ($_POST['kd_plant'] == "" AND $_POST['nm_plant'] == "" AND $_POST['searchcari'] == ""){
			header("location:admin?index=kodeplant");
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
					$kd_plant=test($_POST['kd_plant']);
					$nm_plant=test($_POST['nm_plant']);

					if ($a=mysqli_query($conn, "INSERT INTO tbl_listkdplant (kd_plant,nm_plant)
																values ('$kd_plant','$nm_plant')
								")){
							header('location:admin?index=kodeplant');
					}
					else{
						echo "<div class='alert_adm alert'>tambah kodeplant gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=kodeplant'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Tambah Kode Plant
						</div>
						<div class='form_process'>
							<form action='admin?index=kodeplant&action=tambah' method='post'>
								<a class='j_input_main'>Kode Plant *</a><br>
								<input class='input_main' type='input' name='kd_plant' placeholder='Example : A' style='width:100%;' required><br>
								<a class='j_input_main'>Nama Kode Plant</a><br>
								<input class='input_main' type='input' name='nm_plant' placeholder='Example : All Ciawi' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'hapus':
				$a=mysqli_query($conn, "SELECT * from tbl_listkdplant where no = '$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$a=mysqli_query($conn, "DELETE from tbl_listkdplant WHERE no = '$id'");
					header('location:admin?index=kodeplant');
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=kodeplant'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Hapus Kode Plant
						</div>
						<div class='form_process'>
							<form action='admin?index=kodeplant&action=hapus&id=$id' method='post'>
								<table>
									<tr><td><a class='j_input_main'>ID<td><a class='j_input_main'>: $id</a><br>
									<tr><td><a class='j_input_main'>Kode Plant<td><a class='j_input_main'>: $c[kd_plant]</a><br>
									<tr><td><a class='j_input_main'>Nama Kode Plant<td><a class='j_input_main'>: $c[nm_plant]</a><br>
								</table>
								<br>
								<a style='font-size:12px;'>Hapus Kode Workcenter dengan Detail diatas ?</a><br><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Hapus'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;

			case 'edit':
				$a=mysqli_query($conn, "SELECT * from tbl_listkdplant where no = '$id'");
				$c=mysqli_fetch_array($a);

				$kd_plant=$c['kd_plant'];
				$nm_plant=$c['nm_plant'];

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kd_plant=test($_POST['kd_plant']);
					$nm_plant=test($_POST['nm_plant']);
					if ($a=mysqli_query($conn, "UPDATE tbl_listkdplant SET 
							kd_plant='$kd_plant',
							nm_plant='$nm_plant'
							WHERE no = '$id'")){

							header('location:admin?index=kodeplant');
						}
					else{
						echo "<div class='alert_adm alert'>update kode plant gagal</div>";
					}
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=kodeplant'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Ubah Kode Plant
						</div>
						<div class='form_process'>
							<form action='admin?index=kodeplant&action=edit&id=$id' method='post'>
								<a class='j_input_main'>Kode Workcenter *</a><br>
								<input class='input_main' type='input' name='kd_plant' value='$kd_plant' style='width:100%;' required><br>
								<a class='j_input_main'>Keterangan Workcenter</a><br>
								<input class='input_main' type='input' name='nm_plant' value='$nm_plant' style='width:100%;'><br>
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
		
		<div class='judul_main'>List Kode Plant</div>
		<div class='form_main'>
			<div class='fl'>
				<a href='admin?index=kodeplant&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
				<form action='admin?index=kodeplant' method='post' enctype='multipart/form-data' style='margin-bottom:0px;'>
					<select class='input_main' name='kd_plant' onchange='this.form.submit()' style='font-family:arial;width:130px;'>
						<option value=''>Kode Plant</option>";
							$a = mysqli_query($conn , "SELECT kd_plant FROM tbl_listkdplant GROUP BY kd_plant ORDER BY kd_plant ASC");
								while($c=mysqli_fetch_array($a)){
									if ($kd_plant==$c['kd_plant']) {
										echo "<option value='$c[kd_plant]' selected>$c[kd_plant]</option>";}
									else{
										echo "<option value='$c[kd_plant]'>$c[kd_plant]</option>";}
								}
					echo "
					</select>
					<select class='input_main' name='nm_plant' onchange='this.form.submit()' style='font-family:arial;width:160px;'>
						<option value=''>Nama Kode Plant</option>";
							$a = mysqli_query($conn , "SELECT nm_plant FROM tbl_listkdplant GROUP BY nm_plant ORDER BY nm_plant ASC");
								while($c=mysqli_fetch_array($a)){
									if ($nm_plant==$c['nm_plant']) {
										echo "<option value='$c[nm_plant]' selected>$c[nm_plant]</option>";}
									else{
										echo "<option value='$c[nm_plant]'>$c[nm_plant]</option>";}
								}
					echo "
					</select>";
							if (isset($searchcari)) {
								echo "<input class='input_main' name='searchcari' value='$searchcari' placeholder='Search by Keyword [Nama / Kode Plant]' style='width:300px;margin-left:10px;' onchange='this.form.submit()'>";
							}
							else{
								echo "<input class='input_main' name='searchcari' placeholder='Search by Keyword' style='width:300px;margin:0px;' onchange='this.form.submit()'>";
							}
					echo"
				</form>
			</div>
			<div class='cb'></div>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Kode Plant</td>
					<td>Nama Kode Plant</td>
					<td colspan='2'>Action</td>
				</tr>
	";
	$rowscount=1;
	if ($searchcari!='') {
		$a=mysqli_query($conn, "SELECT * from tbl_listkdplant WHERE kd_plant LIKE '%$searchcari%' OR nm_plant LIKE '%$searchcari%'");
	}
	else{
		$a=mysqli_query($conn, "SELECT * from tbl_listkdplant WHERE no != '0' ".$filter." ORDER BY no DESC");
	}
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[kd_plant]</td>
					<td style='text-align:left;'>$c[nm_plant]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=kodeplant&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=kodeplant&action=hapus&id=$c[no]#popup'>
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
					<td style='text-align:left;'>$c[kd_plant]</td>
					<td style='text-align:left;'>$c[nm_plant]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=kodeplant&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=kodeplant&action=hapus&id=$c[no]#popup'>
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

<!-- Bima Putra S | SuBZero14 | 2017 | bimaputras.sz14@gmail.com | SMK Negeri 1 CIMAHI -->