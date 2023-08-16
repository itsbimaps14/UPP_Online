<?php
	$username=$email=$department=$nama=$tanggal='';
	echo "
		<form action='admin?index=signup' method='post'>
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

				if ($b!=0) {
					echo "<div class='alert_adm alert'>username sudah digunakan</div>";
				}
				else{
					$alert = 'aman';
				}
				if ($_POST['password'] != $_POST['password2']) {
					echo "<div class='alert_adm alert'>password verifikasi salah</div>";
				}
				else{
					$alert2 = 'aman';
				}

				if ($alert == 'aman' and $alert2 == 'aman') {
					echo "<div class='alert_adm alert2'>berhasil mendaftar</div>";
					$a=mysqli_query($conn, "insert into anggota (username,email,password,no_department,nama_lengkap,tgl_lahir)
						values ('$username','$email','$password','$department','$nama','$tanggal')
						");
				}
				else{
				}
			}
			$username=$email=$department=$nama=$tanggal='';
	echo "
				<a class='j_input_main'>Username</a><br>
				<input id='focus_awal' class='input_main' type='text' name='username' value='$username' required autofocus><br>	
				<a class='j_input_main'>E-mail</a><br>
				<input class='input_main' type='email' name='email' value='$email' required><br>
				<a class='j_input_main'>Password</a><br>
				<input class='input_main' type='password' name='password' required><br>				
				<a class='j_input_main'>Password verification</a><br>
				<input class='input_main' type='password' name='password2' required><br>
			</div>
			<div class='judul_main'>Personal Information</div>
			<div class='form_main'>
				<a class='j_input_main'>Department</a><br>
				<select class='input_main' name='department' required>
				<option value=''></option>
	";
			$a=mysqli_query($conn, "SELECT * from department order by department");
			while ($c=mysqli_fetch_array($a)) {
				echo "
				<option value='$c[no]'>$c[kode_department] - $c[department] - $c[lokasi]</option>
				";
			}
	echo "
				</select><br>
				<a class='j_input_main'>Full name</a><br>
				<input class='input_main' type='text' name='nama'  value='$nama' required><br>
				<a class='j_input_main'>Birthday</a><br>
				<select class='input_main' style='width:100px;' name='tanggal' required>
					<option value=''></option>
					";
						for ($i=1; $i <= 31 ; $i++) {
							if ($i<10) {
								$i='0'.$i;
							}
							echo "
							<option value='$i'>$i</option>
							";
						}
					echo "
				</select>
				<select class='input_main'  style='width:190px;' name='bulan' required>
					<option value=''></option>
					";
						$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						$monthlength=count($month2);

						for ($x=0; $x < 12; $x++) {
							$i=$x+1;
							echo "
								<option value='$i'>$month2[$x]</option>
							";
						}
					echo "
				</select>
				<select class='input_main' style='width:100px;' name='tahun' required>
					<option value=''></option>
					";
						$tahunnow = date('Y');
						for ($i=$tahunnow; $i >= 1980 ; $i--) {
							echo "
								<option value='$i'>$i</option>
							";
						}
					echo "
				</select><br>
			</div>
			<input class='submit_main' type='submit' value='Sign Up'>
		</form>
	";
?>