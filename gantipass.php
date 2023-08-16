<?php
	echo "
		<form action='gantipass' method='post' enctype='multipart/form-data'>
			<div class='judul_main'>Ganti Password</div>
			<div class='form_main'>
				";
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$password1=md5(test($_POST['password1']));
					$password2=md5(test($_POST['password2']));
					$panjangpassword=strlen($_POST['password2']);
					$password3=md5(test($_POST['password3']));
					$username=$_SESSION['username'];

					$a=mysqli_query($conn, "SELECT * FROM anggota WHERE USERNAME = '$username'");
					$c=mysqli_fetch_array($a);

					if ($password1 != $c['password']) {
						echo "<div class='alert_adm alert'>password lama salah</div>";
					}
					elseif ($_POST['password2'] != $_POST['password3']) {
						echo "<div class='alert_adm alert'>password verifikasi salah</div>";
					}
					else{
						$a=mysqli_query($conn, "UPDATE anggota 	SET password='$password2'
											WHERE username = '$username'
											");
						header('location:home');
					}
				}
				echo "
					<a class='j_input_main'>Password Lama</a><br>
					<input class='input_main' type='password' name='password1' required><br>
					<a class='j_input_main'>Password Baru</a><br>
					<input class='input_main' type='password' name='password2' required><br>
					<a class='j_input_main'>Verifikasi Password Baru</a><br>
					<input class='input_main' type='password' name='password3' required><br>
			</div>
			<input class='submit_main' style='margin-left:320px;' type='submit' value='Input'>
		</form>
	";
?>