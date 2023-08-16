<?php
	$awal=0;
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		$id = $_GET['id'];
		switch ($action) {
			case 'ubahlevel':
				$level = $_GET['level'];
				if ($level=='user') {
					$a=mysqli_query($conn, "UPDATE anggota SET level='admin' WHERE no_anggota=$id  ");
					header('location:admin?index=listuser');
				}
				elseif ($level=='admin') {
					$a=mysqli_query($conn, "UPDATE anggota SET level='qa' WHERE no_anggota=$id  ");
					header('location:admin?index=listuser');
				}
				elseif ($level=='qa') {
					$a=mysqli_query($conn, "UPDATE anggota SET level='approval1' WHERE no_anggota=$id  ");
					header('location:admin?index=listuser');
				}
				elseif ($level=='approval1') {
					$a=mysqli_query($conn, "UPDATE anggota SET level='user' WHERE no_anggota=$id  ");
					header('location:admin?index=listuser');
				}
			break;
			case 'hapus':
				$a=mysqli_query($conn, "DELETE from anggota WHERE no_anggota=$id  ");
				header('location:admin?index=listuser');
			break;
			case 'edit':
				$a=mysqli_query($conn, "SELECT * from anggota where no_anggota='$id'");
				$c=mysqli_fetch_array($a);
				$username=$c['username'];
				$email=$c['email'];
				$nama=$c['nama_lengkap'];
				$tanggal=$c['tgl_lahir'];
				echo "
					<form action='admin?index=listuser&action=edit&id=$id' method='post'>
					<div class='judul_main'>User Information</div>
					<div class='form_main'>
				";
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$alert=$alert2=$alert3='urgent';
						$username=test($_POST['username']);
						$email=test($_POST['email']);
						$panjangusername=strlen($username);
						$password=md5(test($_POST['password']));
						$panjangpassword=strlen($_POST['password']);
						$password2=md5(test($_POST['password2']));
						$department=test($_POST['department']);
						$nama=test($_POST['nama']);
						$tahun=test($_POST['tahun']);
						$bulan=test($_POST['bulan']);
						$tanggal=test($_POST['tanggal']);
						$tanggal=$tahun.'-'.$bulan.'-'.$tanggal;

						$a=mysqli_query($conn, "SELECT * from anggota where username = '$username'");
						$b=mysqli_num_rows($a);
						$c=mysqli_fetch_array($a);

						if ($panjangpassword==0) {
							$alert2 = 'aman';
						}
						elseif ($_POST['password'] != $_POST['password2']) {
							echo "<div class='alert_adm alert'>password verifikasi salah</div>";
						}
						else{
							$alert2 = 'aman';
						}

						if ($alert2 == 'aman') {
							if ($_POST['password']=='') {
								$a=mysqli_query($conn, "UPDATE anggota 	SET username='$username',
									email='$email',
									no_department='$department',
									nama_lengkap='$nama',
									tgl_lahir='$tanggal'
									WHERE no_anggota = '$id'
									");
								header('location:admin?index=listuser');
							}
							else{
								$a=mysqli_query($conn, "UPDATE anggota 	SET username='$username',
									email='$email',
									password='$password',
									no_department='$department',
									nama_lengkap='$nama',
									tgl_lahir='$tanggal'
									WHERE no_anggota = '$id'
									");
								header('location:admin?index=listuser');
							}
						}
						else{
						}
					}
				echo "
						<a class='j_input_main'>Username</a><br>
						<input class='input_main' type='text' name='username' value='$username' required autofocus><br>	
						<a class='j_input_main'>E-mail</a><br>
						<input class='input_main' type='email' name='email' value='$email' required><br>
						<a class='j_input_main'>Password</a><br>
						<input class='input_main' type='password' name='password'><br>				
						<a class='j_input_main'>Password verification</a><br>
						<input class='input_main' type='password' name='password2'><br>
						</div>
						<div class='judul_main'>Personal Information</div>
						<div class='form_main'>
						<a class='j_input_main'>Department</a><br>
						<select class='input_main' name='department' required>
							<option value=''></option>
				";
					$d=mysqli_query($conn, "SELECT * from department order by department");
					while ($e=mysqli_fetch_array($d)) {
						if ($c['no_department']==$e['no']) {
							echo "
							<option value='$e[no]' selected>$e[kode_department] - $e[department] - $e[lokasi]</option>
							";
						}
						else{
							echo "
							<option value='$e[no]' >$e[kode_department] - $e[department] - $e[lokasi]</option>
							";
						}
					}
				echo "
						</select><br>
						<a class='j_input_main'>Full name</a><br>
						<input class='input_main' type='text' name='nama'  value='$nama' required><br>
						<a class='j_input_main'>Birthday</a><br>
						<select class='input_main' style='width:100px;' name='tanggal' required>
							<option value=''></option>
							";
								$tgl=substr($tanggal,8,2);
								for ($i=1; $i <= 31 ; $i++) {
									if ($i<10) {
										$i='0'.$i;
									}
									if ($i==$tgl) {
										echo "
											<option value='$i' selected>$i</option>
										";
									}
									else{
										echo "
											<option value='$i'>$i</option>
										";
									}
								}
							echo "
						</select>
						<select class='input_main'  style='width:190px;' name='bulan' required>
							<option value=''></option>
							";
								$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
								$monthlength=count($month2);
								$bulan=substr($tanggal,5,2);
								for ($x=0; $x < 12; $x++) {
									$i=$x+1;
									if ($i==$bulan) {
										echo "
											<option value='$i' selected>$month2[$x]</option>
										";
									}
									else{
										echo "
											<option value='$i'>$month2[$x]</option>
										";
									}
								}
							echo "
						</select>
						<select class='input_main' style='width:100px;' name='tahun' required>
							<option value=''></option>
							";
								$tahun=substr($tanggal,0,4);
								$tahunnow = date('Y');
								for ($i=$tahunnow; $i >= 1980 ; $i--) {
									if ($i==$tahun) {
										echo "
											<option value='$i' selected>$i</option>
										";
									}
									else{
										echo "
											<option value='$i'>$i</option>
										";
									}
								}
							echo "
						</select><br>
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
	$search='';
	echo "
		<div class='judul_main'>List User</div>
		<div class='form_main'>
			<form action='admin?index=listuser' method='post' enctype='multipart/form-data'>
				<input class='input_search' type='text' value='$search' name='search' placeholder='Username'>
				<input class='submit_search' type='submit' value='search'>
			</form>
			";
				if (isset($_POST['search'])) {
					$search=$_POST['search'];
					$a=mysqli_query($conn, "SELECT * FROM anggota INNER JOIN department WHERE anggota.username like'%$search%' AND anggota.no_department = department.no");
					$alert2='search : '.$search;
				}
				else{
					if (isset($_GET['hal'])) {
						$hal=$_GET['hal'];
					}
					else{
						$hal = 1;
					}
					$awal=($hal-1)*30;
					$akhir=30;
					$a=mysqli_query($conn, "SELECT * FROM anggota INNER JOIN department WHERE anggota.no_department = department.no LIMIT $awal,$akhir");
					$page1=mysqli_query($conn, "SELECT * FROM anggota");
					$page2=mysqli_num_rows($page1);
					$page3=$page2/30;
					$page=floor($page3)+1;
					echo "
						<table class='page_number'>
							<tr>
							";
							if ($hal<2) {
								echo "<td>First</a></td>";
								echo "<td>Previous</a></td>";
								$hal2=$hal;
							}
							elseif ($hal<=2) {
								$hal2=$hal-1;
								$hal3=$hal-1;
								echo "<td><a href='admin?index=listuser&hal=1'>First</a></td>";
								echo "<td><a href='admin?index=listuser&hal=$hal3'>Previous</a></td>";
							}
							else{
								$hal2=$hal-2;
								$hal3=$hal-1;
								echo "<td><a href='admin?index=listuser&hal=1'>First</a></td>";
								echo "<td><a href='admin?index=listuser&hal=$hal3'>Previous</a></td>";
							}
							for ($i=0; $i <= 4; $i++) {
								if ($hal2>$page) {
								}
								elseif ($hal2==$hal) {
									echo"<td style='font-family:arial;color: black;'>$hal2</td>";
								}
								else {
									echo"<td><a href='admin?index=listuser&hal=$hal2'>$hal2</a></td>";
								}
								$hal2++;
							}
							if ($hal<$page) {
								$hal3=$hal+1;
								echo "<td><a href='admin?index=listuser&hal=$hal3'>Next</a></td>";
								echo "<td><a href='admin?index=listuser&hal=$page'>Last</a></td>";
							}
							else{
								echo "<td>Next</a></td>";
								echo "<td>Last</a></td>";
							}
							echo "
							</tr>
						</table>
					";
				}
				if (isset($alert2)) {
					echo "<div class='alert_adm alert2'>$alert2<a href='admin?index=listuser' style='color:000;float:right;'>X</a></div>";
				}
			echo "
			<table class='table_admin'>
				<tr class='top_table'>
					<td>No</td>
					<td>Username</td>
					<td>E-mail</td> 
					<td>Level</td>
					<td>Department</td>
					<td>Nama Lengkap</td>
					<td>Tanggal Lahir</td>
					<td></td>
					<td></td>
				</tr>
	";
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td>$c[username]</td>
					<td>$c[email]</td>
					<td>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=ubahlevel&id=$c[no_anggota]&level=$c[level]'> 
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[level]
						</a>
					</td>
					<td>$c[kode_department]</td>
					<td>$c[nama_lengkap]</td>
					<td>$c[tgl_lahir]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=edit&id=$c[no_anggota]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=hapus&id=$c[no_anggota]'>
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
					<td>$c[username]</td>
					<td>$c[email]</td>
					<td>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=ubahlevel&id=$c[no_anggota]&level=$c[level]'> 
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/renew.png'> $c[level]
						</a>
					</td>
					<td>$c[kode_department]</td>
					<td>$c[nama_lengkap]</td>
					<td>$c[tgl_lahir]</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=edit&id=$c[no_anggota]'>
							<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> edit
						</a>
					</td>
					<td style='padding:0px;'>
						<a style='padding-right:5px;color: blue;' href='admin?index=listuser&action=hapus&id=$c[no_anggota]'>
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