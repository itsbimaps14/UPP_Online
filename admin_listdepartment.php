<?php
	if (isset($_POST['sortby'])) {
		$sortby=$_POST['sortby'];
	}
	else{
		$sortby = '';
	}
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		switch ($action) {
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$lokasi=test($_POST['lokasi']);
					$kode_department=test($_POST['kode_department']);
					$department=test($_POST['department']);

					if ($a=mysqli_query($conn, "INSERT INTO department (lokasi,kode_department,department)
																values ('$lokasi','$kode_department','$department')
								")){
							header('location:admin?index=listdepartment');
					}
					else{
						echo "<div class='alert_adm alert'>tambah department gagal</div>";
					}
				}
				echo "
					<div id='popup' class='popup'>
						<a href='admin?index=listdepartment'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:150px;'>
							Form Department
						</div>
						<div class='form_process'>
							<form action='admin?index=listdepartment&action=tambah' method='post'>
								<a class='j_input_main'>Lokasi</a><br>
								<select class='input_main' name='lokasi' style='width:100%;' required autofocus>
									<option value=''>Lokasi</option>
									";
										$d=mysqli_query($conn, "SELECT * from plant order by plant");
										while ($f=mysqli_fetch_array($d)) {
											if ($lokasi == $f['plant']) {
												echo "
													<option value='$f[plant]' selected>$f[plant]</option>
												";
											}
											else {
												echo "
													<option value='$f[plant]'>$f[plant]</option>
												";
											}
										}
							echo "
								</select><br>
								<a class='j_input_main'>Kode Department</a><br>
								<input class='input_main' type='input' name='kode_department' placeholder='XXX' style='width:100%;' required><br>
								<a class='j_input_main'>Department</a><br>
								<input class='input_main' type='input' name='department' placeholder='Department' style='width:100%;' required><br>
								<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Tambah'>
								<div class='cb'></div>
							</form>
						</div>
					</div>
				";
				break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from department WHERE no=$id  ");
				header('location:admin?index=listdepartment');
				break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from department where no='$id'");
				$c=mysqli_fetch_array($a);
				$lokasi=$c['lokasi'];
				$kode_department=$c['kode_department'];
				$department=$c['department'];
				echo "
					<form action='admin?index=listdepartment&action=edit&id=$id' method='post'>
					<div class='judul_main'>Form Department</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$lokasi=test($_POST['lokasi']);
						$kode_department=test($_POST['kode_department']);
						$department=test($_POST['department']);

						if ($a=mysqli_query($conn, "UPDATE department 	SET lokasi='$lokasi',
									kode_department='$kode_department',
									department='$department'
									WHERE no = '$id'
									")){
								header('location:admin?index=listdepartment');
						}
						else{
							echo "<div class='alert_adm alert'>update department gagal</div>";
						}
					}
				echo "
						<a class='j_input_main'>Lokasi</a><br>
						<select class='input_main text_pjs' name='lokasi' required autofocus>
							<option value=''>Lokasi</option>
							";
								$d=mysqli_query($conn, "SELECT * from plant order by plant");
								while ($f=mysqli_fetch_array($d)) {
									if ($lokasi == $f['plant']) {
										echo "
											<option value='$f[plant]' selected>$f[plant]</option>
										";
									}
									else {
										echo "
											<option value='$f[plant]'>$f[plant]</option>
										";
									}
								}
					echo "
						</select><br>
						<a class='j_input_main'>Kode Department</a><br>
						<input class='input_main' type='text' name='kode_department' value='$kode_department' required><br>
						<a class='j_input_main'>Department</a><br>
						<input class='input_main' type='text' name='department' value='$department' required>
					</div>
					<input class='submit_main' style='margin-left:305px;' type='submit' value='Update'>
				</form>
				";
				break;
	}
	}
	echo "
		
		<div class='judul_main'>List Department</div>
		<div class='form_main'>
			<div class='fl'>
				<a href='admin?index=listdepartment&action=tambah#popup'><button class='button_admin'>Tambah</button></a>
			</div>
			<div class='fl'>
				<form action='admin?index=listdepartment' method='post' enctype='multipart/form-data' style='margin-left:10px;margin-bottom:0px;'>
				<select class='input_main' name='sortby' onchange='this.form.submit()' style='font-family:arial;width:120px;margin:0px;'>
					<option value=''>Sort by</option>
					";
					$sortbyarraytampil=array('Lokasi','Kode Department','Department');
					$sortbyarray=array('lokasi','kode_department','department');
					$sortbylength=count($sortbyarray);

					for ($x=0; $x < $sortbylength; $x++) {
						if ($sortbyarray[$x]==$sortby) {
							echo "
							<option value='$sortbyarray[$x]' selected>$sortbyarraytampil[$x]</option>
							";
						}
						else{
							echo "
							<option value='$sortbyarray[$x]'>$sortbyarraytampil[$x]</option>
							";
						}
					}
					echo "
				</select>
				</form>
			</div>
			<div class='cb'></div>
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Lokasi</td>
					<td>Kode Department</td> 
					<td>Department</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=1;
	if ($sortby!='') {
		$a=mysqli_query($conn, "SELECT * from department order by $sortby");
	}
	else{
		$a=mysqli_query($conn, "SELECT * from department order by no");
	}
	while ($c=mysqli_fetch_array($a)) {
		echo "
		";			
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td style='text-align:left;'>$c[lokasi]</td>
					<td style='text-align:left;'>$c[kode_department]</td>
					<td style='text-align:left;'>$c[department]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdepartment&action=edit&id=$c[no]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdepartment&action=hapus&id=$c[no]'>
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
					<td style='text-align:left;'>$c[lokasi]</td>
					<td style='text-align:left;'>$c[kode_department]</td>
					<td style='text-align:left;'>$c[department]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdepartment&action=edit&id=$c[no]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listdepartment&action=hapus&id=$c[no]'>
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