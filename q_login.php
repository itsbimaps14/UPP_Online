<?php
	include 'inc.php';
	$username=test($_POST['username']);
	$password=md5(test($_POST['password']));
									
	$d=mysqli_query($conn, "SELECT * from anggota where username = '$username'");
	$e=mysqli_num_rows($d);
	$a=mysqli_query($conn, "SELECT * from anggota where username = '$username' and password = '$password'");
	$b=mysqli_num_rows($a);
	$c=mysqli_fetch_array($a);

	if ($e==0) {
		echo "<div class='alert_adm alert' style='width:94%'>username belum terdaftar</div>";
	}
	elseif ($b==0) {
		echo "<div class='alert_adm alert' style='width:94%'>password salah</div>";
		$lupapassword='lupapassword';
	}
	else{
		$_SESSION['username'] = $c['username'];
		$_SESSION['level'] = $c['level'];
		$_SESSION['department'] = $c['no_department'];
		$_SESSION['email'] = $c['email'];
		if ($c['level']=='admin') {
			header('location:admin');
		}
		elseif ($c['level']=='user') {
			header('location:home');
		}
		elseif ($c['level']=='qa') {
			header('location:main?index=upp&step=approval2');
		}
		elseif ($c['level']=='approval1') {
			header('location:main?index=upp&step=approval1');
		}
		elseif ($c['level']=='msds') {
			header('location:main?index=msds');
		}
	}
?>