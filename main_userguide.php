<?php
	$today = date('Y-m-d');
	$filter = "";

	/*
	if () {
		if (){
			header("location:main?index=msds");
		}
	}*/

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {
			case 'edit':

				$a = mysqli_query($conn, "SELECT * FROM tbl_pand WHERE no_pand = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nm_pand = test($_POST['nm_pand']);
					$kt_pand = test($_POST['kt_pand']);

					$fl_pand = $_FILES['fl_pand']['name'];

					if ($fl_pand != '') {

						unlink($c['fl_pand']);

						if (!file_exists('file_upload/user_guide/'.$nm_pand)) {
							mkdir('file_upload/user_guide/'.$nm_pand);}
					
						$folder1 = 'file_upload/user_guide/'.$nm_pand.'/';
						$file_user1 = $_FILES['fl_pand']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['fl_pand']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);

							mysqli_query($conn, "UPDATE tbl_pand SET
									fl_pand = '$file_fmea_rename'
									WHERE no_pand = '$id'
								");
						}
					}

					mysqli_query($conn, "UPDATE tbl_pand SET
									nm_pand = '$nm_pand',
									kt_pand = '$kt_pand',
									up_pand = '$_SESSION[username]'
									WHERE no_pand = '$id'
								");

					header("location:main?index=userguide");
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=userguide'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:15px;width:460px;'>
							Update User Guide
						</div>
						<div class='form_process' style='overflow:auto;width:450px;height:550px;'>
							<form action='main?index=userguide&action=edit&id=$id' method='post' enctype='multipart/form-data'>
								<div class='form_main'>
									<a class='j_input_main'>Nama Panduan *</a><br>
										<input class='input_main' type='text' name='nm_pand' value='$c[nm_pand]'><br>
									<a class='j_input_main'>Keterangan Panduan *</a><br>
										<textarea style='width:97.5%;height:290px' name='kt_pand'>$c[kt_pand]</textarea><br><br>
									<a class='j_input_main'>Attachment File Panduan</a><font size='1' color='red'> *) Max File = 1MB</font><br>
										<input class='file_main' type='file' name='fl_pand' onchange='valid(this)'><br>
									<div class='alert_adm alert' id='ugg' style='width:230px;display:none;'>File Upload max Size is 1MB / 1024KB !</div>
									<div class='alert_adm alert2' id='ubr' style='width:70px;display:none;'>File is OK !</div>
									<input style='margin-left:280px;' id='button_submit' class='submit_main' type='submit' value='Simpan'>
								</div>
							</form>
						</div>
					</div>
				";
			break;

			case 'hapus':
				$a = mysqli_query($conn, "SELECT * FROM tbl_pand WHERE no_pand = '$id'");
				$c = mysqli_fetch_array($a);

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					unlink($c['fl_pand']);
					mysqli_query($conn, "DELETE FROM tbl_pand WHERE no_pand = '$id'");
					header("location:main?index=userguide");
				}

				echo "
					<div id='popup' class='popup' style='overflow-y:scroll'>
						<a href='main?index=userguide'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:10px width;width:425px;' >
							Penghapusan User Guide
						</div>
						<div class='form_process' style='overflow:auto;width:415px;height:auto;'>
							<form action='main?index=userguide&action=hapus&id=$id' method='post' enctype='multipart/form-data'>
								<center>
									<a style='font-size:14px;'>Penghapusan Userguide dengan Nama Panduan : $c[nm_pand] <br>Klik button dibawah ini.</a><br><br>
								</center>
								<input style='margin-left:160px;' class='submit_main fl' type='submit' value='OK'>
							</form>
						</div>
					</div>";
			break;
			
			case 'tambah':
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nm_pand = test($_POST['nm_pand']);
					$kt_pand = test($_POST['kt_pand']);

					$fl_pand = $_FILES['fl_pand']['name'];

					if ($fl_pand != '') {
						if (!file_exists('file_upload/user_guide/'.$nm_pand)) {
							mkdir('file_upload/user_guide/'.$nm_pand);}
					
						$folder1 = 'file_upload/user_guide/'.$nm_pand.'/';
						$file_user1 = $_FILES['fl_pand']['name'];
						$file_user2 = test($file_user1);
						$tmp_file_user = $_FILES['fl_pand']['tmp_name'];
						$file_fmea_user = $folder1.$file_user1;
						$file_fmea_rename = $folder1.$file_user2;

						if (move_uploaded_file($tmp_file_user, $file_fmea_user)) {
							rename($file_fmea_user, $file_fmea_rename);

							mysqli_query($conn, "INSERT INTO tbl_pand (nm_pand,kt_pand,fl_pand,up_pand)
								VALUES ('$nm_pand','$kt_pand','$file_fmea_rename','$_SESSION[username]')");

						}
					}
					header("location:main?index=userguide");
				}
				echo "
					<div id='popup' class='popup'>
						<a href='main?index=userguide'>
							<div class='popup_exit'></div>
						</a>
						<div class='process_top' style='margin-top:15px;width:460px;'>
							Tambah User Guide
						</div>
						<div class='form_process' style='overflow:auto;width:450px;height:550px;'>
							<form action='main?index=userguide&action=tambah' method='post' enctype='multipart/form-data'>
								<div class='form_main'>
									<a class='j_input_main'>Nama Panduan *</a><br>
										<input class='input_main' type='text' name='nm_pand' placeholder='Contoh = Cara Generate Nama File' required><br>
									<a class='j_input_main'>Keterangan Panduan *</a><br>
										<textarea style='width:97.5%;height:290px' name='kt_pand' required></textarea><br><br>
									<a class='j_input_main'>Attachment File Panduan</a><font size='1' color='red'> *) Max File = 1MB</font><br>
										<input class='file_main' type='file' name='fl_pand' onchange='valid(this)' required><br>
									<div class='alert_adm alert' id='ugg' style='width:230px;display:none;'>File Upload max Size is 1MB / 1024KB !</div>
									<div class='alert_adm alert2' id='ubr' style='width:70px;display:none;'>File is OK !</div>
									<input style='margin-left:280px;' id='button_submit' class='submit_main' type='submit' value='Simpan'>
								</div>
							</form>
						</div>
					</div>
				";
			break;
		}
	}
?>
<div class='judul_main' style='position:fixed;'>User Guide</div><br><br><br>&emsp;
<?php
	if (isset($_SESSION['email'])) {
		echo "
			<div style='margin-left: 20px;'>
				<a href='main?index=userguide&action=tambah#popup'><button class='button_admin' style='margin-bottom:0px;'>Tambah</button></a>
			</div>
		";
	}
?>
<div class='form_main' style='margin-top: 0px;'>
	<?php
			$sort="no_pand DESC";
			if (isset($_GET['sort'])) {
				$sortby=$_GET['sort'];
				if (isset($_GET['order'])) {
					$orderby=$_GET['order'];
					$sort=$sortby." ".$orderby;
					$sorturl='&sort='.$sortby.'&order='.$orderby;
				}
				else{
					$orderby='';
					$sort=$sortby;
					$sorturl='&sort='.$sortby;
				}
			}
			else{
				$sortby='';
				$sorturl='';
			}
			if (isset($_GET['hal'])) {
				$hal=$_GET['hal'];
				$halurl='&hal='.$hal;
			}
			else{
				$hal = 1;
				$halurl='';
			}
			$awal=($hal-1)*10;
			$akhir=10;
			
			if (isset($id)) {
				$a=mysqli_query($conn, "
					SELECT * FROM tbl_pand
						WHERE no_pand = '$id'
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM tbl_pand
						WHERE no_pand = '$id' ".$filter);
			}

			else {
				$a=mysqli_query($conn, "
					SELECT * FROM tbl_pand
						WHERE no_pand != ''
						".$filter." ORDER BY ".$sort." LIMIT $awal,$akhir"
					);
				$page1=mysqli_query($conn, "
					SELECT * FROM tbl_pand
						WHERE no_pand != '' ".$filter);
			}

			$page2=mysqli_num_rows($page1);
			$page3=$page2/10;
			$page=floor($page3)+1;
			$alert2='Jumlah : '.$page2;
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
						echo "<td><a href='main?index=userguide&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=userguide&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Previous</a></td>";
					}
					else{
						$hal2=$hal-2;
						$hal3=$hal-1;
						echo "<td><a href='main?index=userguide&step=create&hal=1$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>First</a></td>";
						echo "<td><a href='main?index=userguide&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Previous</a></td>";
					}
					for ($i=0; $i <= 4; $i++) {
						if ($hal2>$page) {
						}
						elseif ($hal2==$hal) {
							echo"<td style='font-family:arial;color: black;'>$hal2</td>";
						}
						else {
							echo"<td><a href='main?index=userguide&step=create&hal=$hal2$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>$hal2</a></td>";
						}
						$hal2++;
					}
					if ($hal<$page) {
						$hal3=$hal+1;
						echo "<td><a href='main?index=userguide&step=create&hal=$hal3$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Next</a></td>";
						echo "<td><a href='main?index=userguide&step=create&hal=$page$sorturl";
						if(isset($_POST['st']))
					{
						echo"&st=".$_POST['st']."";
					}
					else if(isset ($_GET['st']))
					{
						echo"&st=".$_GET['st']."";
					}
						echo"'>Last</a></td>";
					}
					else{
						echo "<td>Next</a></td>";
						echo "<td>Last</a></td>";
					}
					echo "
					</tr>
				</table>
			";
		
		if (isset($alert)) {
			echo "<div class='alert_adm alert'>$alert</div>";
		}
		if (isset($alert2)) {
			echo "<div class='alert_adm alert2'>$alert2</div>";
		}
	?>
	<table class='table_admin'>
		<tr class='top_table'>
			<td>No</td>
			<td>Panduan</td>
			<td>Keterangan</td>
			<td>Attachement</td>
			<td>Pengunggah</td>
			<?php
				if (isset($_SESSION['username'])) {
					if ($_SESSION['level'] == 'admin') {
						echo "<td colspan='2'>Action</td>";
					}
				}
			?>
		</tr>
</div>
<?php	
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td>$rowscount</td>
					<td>$c[nm_pand]</td>
					<td>$c[kt_pand]</td>
					<td>
					";
						if ($c['fl_pand']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[fl_pand]'>Download</a>";
						}
						else{
							echo "no file";
						}
		
					echo "
					</td>
					<td>$c[up_pand]</td>";
					if (isset($_SESSION['username'])) {
						if ($_SESSION['level'] == 'admin') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=userguide&action=edit&id=$c[no_pand]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=userguide&action=hapus&id=$c[no_pand]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
									</a>
								</td>
							";
						}
					}
					echo"
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td>$rowscount</td>
					<td>$c[nm_pand]</td>
					<td>$c[kt_pand]</td>
					<td>
					";
						if ($c['fl_pand']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[fl_pand]'>Download</a>";
						}
						else{
							echo "no file";
						}
		
					echo "
					</td>
					<td>$c[up_pand]</td>";
					if (isset($_SESSION['username'])) {
						if ($_SESSION['level'] == 'admin') {
							echo "
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=userguide&action=edit&id=$c[no_pand]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/edit.png'> Edit
									</a>
								</td>
								<td style='padding:10px;'>
									<a style='padding-right:5px;color: blue;' href='main?index=userguide&action=hapus&id=$c[no_pand]#popup'>
										<img class='material-icons tiny' style='width:10px; height:10px; margin: 2px 0px 0px 3px;' src='img/reject.png'> Hapus
									</a>
								</td>
							";
						}
					}
					echo"
				</tr>
			";
		}
		$rowscount++;
	}
	echo "
		</table>
	</div>
	";
?>

<script type="text/javascript">
	function valid(file) {
		var FileSize = file.files[0].size / 1024 / 1024; // in MB
		if (FileSize > 2) {
			document.getElementById('ubr').style.display = "none";
			document.getElementById('ugg').style.display = "block";
			document.getElementById('button_submit').style.display = "none";}
		else {
		    document.getElementById('ugg').style.display = "none";
		    document.getElementById('ubr').style.display = "block";
			document.getElementById('button_submit').style.display = "block";}
		}
</script>