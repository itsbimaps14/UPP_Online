<?php
	include 'inc.php';
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
	elseif (($_SESSION['level'])!='admin'){
		header('location:home');
	}
	if (isset($_GET['index'])) {
		$index = $_GET['index'];
	}
	else{
		$index = 'awal';
	}
?>
<html>
<head>
	<title>Nutrifood Indonesia | Inspiring a Nutritious Life</title>
	<link rel='stylesheet' type='text/css' href='style/style.css'>
	<link rel='icon' type='text/jpg' href='img/nutrifood-logo-noword.png'>
	<script src='style/jquery.min.js'></script>
	<script>
		$(document).ready(function(){
			$('#user').not(':first').hide();
			$('#user').click(function() {
				$('nav li i.open').find('.dropdown').not($(this)).slideToggle(300);
				$('nav li').find('.open').not($(this)).removeClass('open');
				$(this).toggleClass('open');
				$(this).parent('nav li').find('.dropdown').slideToggle(300);
			});
		});
		$(document).ready(function(){
			$('#menudrop').click(function() {
				$('.dropdown_menu').slideToggle(300);
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
		<a href='main?index=validasi' id='menu8' class='menu_ver fl'>
			Validasi IK
		</a>
		<a href='main?index=msds' id='menu9' class='menu_ver fl'>
			MSDS
		</a>
		<a href='main?index=userguide' id='menu10' class='menu_ver fl'>
			User Guide
		</a>
		<a href='admin' id='menu7' class='menu_ver fl active'>
			Admin
		</a>
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
		<?php
			$a=mysqli_query($conn, "SELECT * FROM anggota WHERE username = '$_SESSION[username]'");
			$c=mysqli_fetch_array($a);
			echo"
				<a class='username fr'>
					$c[nama_lengkap]
				</a>
			";
		?>
		<div class='cb'></div>
	</div>
	<div id='c_main'>
		<div class='c_nav fl'>
			<div>
				<style type='text/css'>
				.copyright{
					color: white;
				}
				.copyright:hover{
					color: #cacaca;
				}
				</style>
				<p style='font-size:10px;color:white;margin-left:30px;position:fixed;bottom:0;'>
				Made By <a class='copyright' href='mailto:bagusgood123@gmail.com'>Bagus Sukmayady Ahmad</a> &copy; 2015<br>
                Developed By <a class='copyright' href='mailto:rizalsidikp24@gmail.com'>Rizal Sidik Permana</a> &copy; 2016<br>
                Improved By <a class='copyright' href='mailto:bimaputras.sz14@gmail.com'>Bima Putra Sudimulya</a> &copy; 2017
                </p>
			</div>
			<nav>
				<ul>
					<li>
						<a id='user' href='#'>
							<div class='nav'>
								User Management
							</div>
						</a>
						<div class='dropdown'>
							<ul>
								<li>
									<a href='admin?index=signup'>
										<div class='sub_nav'>
											Sign Up
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listuser'>
										<div class='sub_nav'>
											List User
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listdepartment'>
										<div class='sub_nav'>
											List Department
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listplant'>
										<div class='sub_nav'>
											List Plant
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listdivisiprosedur'>
										<div class='sub_nav'>
											List Divisi Prosedur
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listmasterprosedur'>
										<div class='sub_nav'>
											List Master Prosedur
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listjenisprosedur'>
										<div class='sub_nav'>
											List Jenis Prosedur
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listkatperubahan'>
										<div class='sub_nav'>
											List Kategori Perubahan
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listkatmesin'>
										<div class='sub_nav'>
											List Kategori Mesin
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listgolongankasus'>
										<div class='sub_nav'>
											List Golongan Kasus
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=listmasterddd'>
										<div class='sub_nav'>
											List Master DDD
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=workcenter'>
										<div class='sub_nav'>
											List Workcenter
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=namaproses'>
										<div class='sub_nav'>
											List Nama Proses
										</div>
									</a>
								</li>
								<li>
									<a href='admin?index=kodeplant'>
										<div class='sub_nav'>
											List Kode Plant
										</div>
									</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</nav>
		</div>
		<div class='main_admin fl'>
			<?php
				switch ($index) {
					case 'signup':
						include 'admin_signup.php';
					break;
					case 'listuser':
						include 'admin_listuser.php';
					break;
					case 'listdepartment':
						include 'admin_listdepartment.php';
					break;
					case 'listplant':
						include 'admin_listplant.php';
					break;
					case 'listdivisiprosedur':
						include 'admin_listdivisiprosedur.php';
					break;
					case 'listmasterprosedur':
						include 'admin_listmasterprosedur.php';
					break;
					case 'listjenisprosedur':
						include 'admin_listjenisprosedur.php';
					break;
					case 'listkatperubahan':
						include 'admin_listkatperubahan.php';
					break;
					case 'listkatmesin':
						include 'admin_listkatmesin.php';
					break;
					case 'listgolongankasus':
						include 'admin_listgolongankasus.php';
					break;
					case 'listmasterddd':
						include 'admin_listmasterddd.php';
					break;
					case 'workcenter':
						include 'admin_workcenter.php';
					break;
					case 'namaproses':
						include 'admin_namaproses.php';
					break;
					case 'kodeplant':
						include 'admin_kodeplant.php';
					break;
				}
			?>
		</div>
		<div class='cb'></div>
	</div>
</body>
</html>