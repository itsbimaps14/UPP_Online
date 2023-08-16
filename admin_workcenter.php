<?php
	$filter = "";
	$searchcari ="";
	if (isset($_POST['no_pros']) OR isset($_POST['kode_workcenter']) or isset($_POST['searchcari'])){
		if($_POST['no_pros'] != ''){
			$filter = "";
			$filter = $filter."and no_pros = '".$_POST['no_pros']."'";
			$no_pros = $_POST['no_pros'];
		}
		if($_POST['kode_workcenter'] != ''){
			$filter = $filter."and kode_workcenter = '".$_POST['kode_workcenter']."'";
			$kode_workcenter = $_POST['kode_workcenter'];
		}
		if($_POST['searchcari'] != ''){
			$searchcari = $_POST['searchcari'];
			$no_pros=$kode_workcenter='';
		}
		if ($_POST['no_pros'] == "" AND $_POST['kode_workcenter'] == "" AND $_POST['searchcari'] == ""){
			header("location:admin?index=workcenter");
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
					$kode_prosedur=test($_POST['kode_prosedur']);
					$kode_workcenter=test($_POST['kode_workcenter']);
					$ket_workcenter=test($_POST['ket_workcenter']);

					if ($a=mysqli_query($conn, "INSERT INTO tbl_listworkcenter (no_pros,kode_workcenter,ket_workcenter)
																values ('$kode_prosedur','$kode_workcenter','$ket_workcenter')
								")){
							header('location:admin?index=workcenter');
					}
					else{
						echo "<div class='alert_adm alert'>tambah workcenter gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=workcenter'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Tambah Workcenter
						</div>
						<div class='form_process'>
							<form action='admin?index=workcenter&action=tambah' method='post'>
								<a class='j_input_main'>Kode Prosedur *</a><br>
								<select class='input_main' name='kode_prosedur' style='width:100%;' required autofocus>
									<option value=''>Kode Prosedur</option>
									";
										$d=mysqli_query($conn, "SELECT nm_prosedur from master_prosedur ORDER BY nm_prosedur ASC");
										while ($f=mysqli_fetch_array($d)) {
											echo "<option value='$f[nm_prosedur]'>$f[nm_prosedur]</option>";
										}
							echo "
								</select><br>
								<a class='j_input_main'>Kode Workcenter *</a><br>
								<input class='input_main' type='input' name='kode_workcenter' placeholder='Example : 01' style='width:100%;' required><br>
								<a class='j_input_main'>Keterangan Workcenter</a><br>
								<input class='input_main' type='input' name='ket_workcenter' placeholder='Example : Penerimaan' style='width:100%;'><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'hapus':
				$a=mysqli_query($conn, "SELECT * from tbl_listworkcenter where no = '$id'");
				$c=mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$a=mysqli_query($conn, "DELETE from tbl_listworkcenter WHERE no = '$id'");
					header('location:admin?index=workcenter');
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=workcenter'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Ubah Workcenter
						</div>
						<div class='form_process'>
							<form action='admin?index=workcenter&action=hapus&id=$id' method='post'>
								<table>
									<tr><td><a class='j_input_main'>ID<td><a class='j_input_main'>: $id</a><br>
									<tr><td><a class='j_input_main'>No Proedur<td><a class='j_input_main'>: $c[no_pros]</a><br>
									<tr><td><a class='j_input_main'>Kode Workcenter<td><a class='j_input_main'>: $c[kode_workcenter]</a><br>
									<tr><td><a class='j_input_main'>Kode Keterangan<td><a class='j_input_main'>: $c[ket_workcenter]</a><br>
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
				$a=mysqli_query($conn, "SELECT * from tbl_listworkcenter where no = '$id'");
				$c=mysqli_fetch_array($a);

				$no_pros1=$c['no_pros'];
				$kode_workcenter1=$c['kode_workcenter'];
				$ket_workcenter1=$c['ket_workcenter'];

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$kode_prosedur1=test($_POST['kode_prosedur1']);
					$kode_workcenter1=test($_POST['kode_workcenter1']);
					$ket_workcenter1=test($_POST['ket_workcenter1']);
					if ($a=mysqli_query($conn, "UPDATE tbl_listworkcenter SET 
							no_pros='$kode_prosedur1',
							kode_workcenter='$kode_workcenter1',
							ket_workcenter='$ket_workcenter1'
							WHERE no = '$id'")){

							header('location:admin?index=workcenter');
						}
					else{
						echo "<div class='alert_adm alert'>update department gagal</div>";
					}
				}

				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=workcenter'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Ubah Workcenter
						</div>
						<div class='form_process'>
							<form action='admin?index=workcenter&action=edit&id=$id' method='post'>
								<a class='j_input_main'>Kode Prosedur *</a><br>
								<select class='input_main' name='kode_prosedur1' style='width:100%;' required autofocus>
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
								<a class='j_input_main'>Kode Workcenter *</a><br>
								<input class='input_main' type='input' name='kode_workcenter1' value='$kode_workcenter1' style='width:100%;' required><br>
								<a class='j_input_main'>Keterangan Workcenter</a><br>
								<input class='input_main' type='input' name='ket_workcenter1' value='$ket_workcenter1' style='width:100%;'><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
		}
	}
	echo "
		
		<div class='judul_main'>List Workcenter</div>
		<div class='form_main'>
			<div class='fl'>
				<a href='admin?index=workcenter&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
				<form action='admin?index=workcenter' method='post' enctype='multipart/form-data' style='margin-bottom:0px;'>
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
					<select class='input_main' name='kode_workcenter' onchange='this.form.submit()' style='font-family:arial;width:160px;'>
						<option value=''>Kode Workcenter</option>";
							$a = mysqli_query($conn , "SELECT kode_workcenter FROM tbl_listworkcenter GROUP BY kode_workcenter ORDER BY kode_workcenter ASC");
								while($c=mysqli_fetch_array($a)){
									if ($kode_workcenter==$c['kode_workcenter']) {
										echo "<option value='$c[kode_workcenter]' selected>$c[kode_workcenter]</option>";}
									else{
										echo "<option value='$c[kode_workcenter]'>$c[kode_workcenter]</option>";}
								}
					echo "
					</select>";
							if (isset($searchcari)) {
								echo "<input class='input_main' name='searchcari' value='$searchcari' placeholder='Search by Keyword [Keterangan]' style='width:250px;margin-left:10px;' onchange='this.form.submit()'>";
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
					<td>Kode Workcenter</td>
					<td>Ket Workcenter</td>
					<td colspan='2'>Action</td>
				</tr>
	";
	$rowscount=1;
	if ($searchcari!='') {
		$a=mysqli_query($conn, "SELECT * from tbl_listworkcenter WHERE ket_workcenter LIKE '%$searchcari%'");
	}
	else{
		$a=mysqli_query($conn, "SELECT * from tbl_listworkcenter WHERE no != '0' ".$filter." ORDER BY no DESC");
	}
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[no_pros]</td>
					<td style='text-align:left;'>$c[kode_workcenter]</td>
					<td style='text-align:left;'>$c[ket_workcenter]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=workcenter&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=workcenter&action=hapus&id=$c[no]#popup'>
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
					<td style='text-align:left;'>$c[kode_workcenter]</td>
					<td style='text-align:left;'>$c[ket_workcenter]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=workcenter&action=edit&id=$c[no]#popup'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=workcenter&action=hapus&id=$c[no]#popup'>
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