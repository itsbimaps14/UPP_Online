<?php
	include 'inc.php';
	if (isset($_GET['index'])) {
		$index=$_GET['index'];
	}
	else{
		$index='home';
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
?>
<html>
<head>
	<title>Nutrifood Indonesia | Inspiring a Nutritious Life</title>
	<link rel='stylesheet' type='text/css' href='style/style.css'>
	<link rel='icon' type='text/jpg' href='img/nutrifood-logo-noword.png'>
	<script type='text/javascript' src='style/jquery.min.js'></script>
	<script type='text/javascript' src='style/jquery.table2excel.js'></script>
	<script>
		$(document).ready(function(){
			$('#menudrop').click(function() {
				$('.dropdown_menu').slideToggle(300);
			});
			$('#user').click(function() {
				$('.dropdown').slideToggle(300);
			});
			var index = '<?php Print($index); ?>';
			if (index == 'home') {
				$('.menu_ver').removeClass('active');
				$('#menu1').addClass('active');
			}
			else if (index == 'prosedur') {
				$('.menu_ver').removeClass('active');
				$('#menu2').addClass('active');
			}
			else if (index == 'upp') {
				$('.menu_ver').removeClass('active');
				$('#menu3').addClass('active');
			}
			else if (index == 'dde') {
				$('.menu_ver').removeClass('active');
				$('#menu4').addClass('active');
			}
			else if (index == 'keluhan') {
				$('.menu_ver').removeClass('active');
				$('#menu5').addClass('active');
			}
			else if (index == 'ddd') {
				$('.menu_ver').removeClass('active');
				$('#menu6').addClass('active');
			}
			else if (index == 'validasi') {
				$('.menu_ver').removeClass('active');
				$('#menu7').addClass('active');
			}
			else if (index == 'msds') {
				$('.menu_ver').removeClass('active');
				$('#menu8').addClass('active');
			}
			else if (index == 'userguide') {
				$('.menu_ver').removeClass('active');
				$('#menu9').addClass('active');
			}
			$('#button').click(function() {
				$('#menu').toggleClass('width0px');
				$('#nav').toggleClass('hide');
				$('#main').toggleClass('m-left-0 width100pc');
				$('#button').toggleClass('m-left-min40');
				$('#hide').toggleClass('hide');
				$('#show').toggleClass('show');
			});
		});
		$(document).on('click', function(event){
			var $trigger = $('#anti_hide');
			if($trigger != event.target && !$trigger.has(event.target).length){
				$('.dropdown_menu').slideUp(300);
			}
		});
	</script>
</head>
<body>
	<?php
		if (!isset($_SESSION['username'])) {
			echo "
				<div id='popup_login' class='popup'>
					<a href='#'>
						<div class='popup_exit'></div>
					</a>
					<div class='process_top' style='margin-top:150px;'>
						Login
					</div>
					<div class='form_process'>
						<form action='login' method='post'>
							<a class='j_input_main'>Username</a><br>
							<input class='input_main' type='input' name='username' placeholder='username' style='width:100%;' required><br>
							<a class='j_input_main'>Password</a><br>
							<input class='input_main' type='password' name='password' placeholder='password' style='width:100%;' required><br>
							<input style='margin-left:5px;' class='submit_main fl' type='submit' value='Login'>
							<div class='cb'></div>
						</form>
					</div>
				</div>
			";
		}
	?>
	<div id='c_head'>
		<a class='logo fl' href='home'>
			<img src='img/prosedur_online.png'>
		</a>
		<a href='home' id='menu1' class='menu_ver fl'>
			Home
		</a>
		<a href='main?index=prosedur' id='menu2' class='menu_ver fl'>
			Procedure
		</a>
		<a href='main?index=upp' id='menu3' class='menu_ver fl'>
			UPP Online
		</a>
		<a href='main?index=dde' id='menu4' class='menu_ver fl'>
			DDE
		</a>
		<a href='main?index=keluhan' id='menu5' class='menu_ver fl'>
			Keluhan
		</a>
		<a href='main?index=ddd' id='menu6' class='menu_ver fl'>
			DDD
		</a>
		<a href='main?index=validasi' id='menu7' class='menu_ver fl'>
			Validasi IK
		</a>
		<a href='main?index=msds' id='menu8' class='menu_ver fl'>
			MSDS
		</a>
		<a href='main?index=userguide' id='menu9' class='menu_ver fl'>
			User Guide
		</a>
		<?php
			if (isset($_SESSION['username'])) {
				if (($_SESSION['level'])=='admin'){
					echo "
						<a href='admin' id='menu9' class='menu_ver fl'>
							Admin
						</a>
					";
				}
				echo "
					<nav id='anti_hide' class='fr'>
						<ul>
							<li>
								<div id='menudrop' class='menu'>
									<a href='#'>
										<img class='material-icons small' style='margin: 12px 8px;width:16px;height:8px;' src='img/chevron_bottom.png'>
									</a>
								</div>
								<div class='cb'></div>
								<div class='dropdown_menu'>
									<ul>
										<li>
											<a href='gantipass'>
												<div class='sub_menu'>Ganti Password</div>
											</a>
										</li>
									</ul>
									<ul>
										<li>
											<a href='logout'>
												<div class='sub_menu'>Logout</div>
											</a>
										</li>
									</ul>
								</div>
								<div class='cb'></div>
							</li>
						</ul>
					</nav>
					";
					$a=mysqli_query($conn, "SELECT * FROM anggota WHERE username = '$_SESSION[username]'");
					$c=mysqli_fetch_array($a);
					echo"
						<a class='username fr'>
							$c[nama_lengkap]
						</a>
					";
			}
			else{
				echo "
					<a class='login fr' href='#popup_login'>
						Login
					</a>
				";
			}
		?>
		<div class='cb'></div>
	</div>
	<div id='c_main'>
		<?php
			switch ($index) {
				case 'gantipass':
					include 'gantipass.php';
				break;
				case 'home':
					include 'main_home.php';
				break;
				case 'prosedur':
					include 'main_prosedur.php';
				break;
				case 'upp':
					include 'main_upp.php';
				break;
				case 'dde':
					include 'main_dde.php';
				break;
				case 'keluhan':
					include 'main_keluhan.php';
				break;
				case 'ddd':
					include 'main_ddd.php';
				break;
				case 'validasi':
					include 'main_validasi.php';
				break;
				case 'msds':
					include 'main_msds.php';
				break;
				case 'ddd_db':
					include 'main_ddd_db.php';
				break;
				case 'ddd_pd':
					include 'main_ddd_pd.php';
				break;
				case 'ddd_mm':
					include 'main_ddd_mm.php';
				break;
				case 'userguide':
					include 'main_userguide.php';
				break;
				default:
				break;
			}
		?>
	</div>
</body>
</html>