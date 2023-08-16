<?php
	if (isset($_GET['step'])) {
		$step=$_GET['step'];
	}
	else{
		$step='create';
	}
	$filter="";
	if ($step=='close') {
		if (isset($_POST['tahun'])) {
			$tahun=$_POST['tahun'];
			if ($tahun!='') {
				$filter.=" AND tahun = ".$tahun;
			}
		}
		else{
			$tahun = '';
		}
		if (isset($_POST['bulan'])) {
			$bulan=$_POST['bulan'];
			if ($bulan!='') {
				$filter.=" AND bulan = ".$bulan;
			}
		}
		else{
			$bulan = '';
		}
		if (isset($_POST['lokasi'])) {
			$lokasi=$_POST['lokasi'];
			if ($lokasi!='') {
				$filter.=" AND lokasi = '".$lokasi."'";
			}
		}
		else{
			$lokasi = '';
		}
		if (isset($_POST['divisi'])) {
			$divisi=$_POST['divisi'];
			if ($divisi!='') {
				$filter.=" AND upp.no_divisi_prosedur = '".$divisi."'";
			}
		}
		else{
			$divisi = '';
		}
		if (isset($_POST['prosedur'])) {
			$prosedur=$_POST['prosedur'];
			if ($prosedur!='') {
				$filter.=" AND upp.no_master_prosedur = '".$prosedur."'";
			}
		}
		else{
			$prosedur = '';
		}
		if (isset($_POST['jenis'])) {
			$jenis=$_POST['jenis'];
			if ($jenis!='') {
				$filter.=" AND upp.no_jenis_prosedur = '".$jenis."'";
			}
		}
		else{
			$jenis = '';
		}
		if (isset($_POST['detail'])) {
			$detail=$_POST['detail'];
			if ($detail!='') {
				$filter.=" AND upp.detail_prosedur = '".$detail."'";
			}
		}
		else{
			$detail = '';
		}
		if (isset($_POST['folder'])) {
			$folder=$_POST['folder'];
			if ($folder!='') {
				$filter.=" AND upp.nama_folder = '".$folder."'";
			}
		}
		else{
			$folder = '';
		}
	}
	if (isset($_SESSION['username'])) {
		echo "
			<div id='button' class='m-left-235px'>
				<img id='hide' class='material-icons small' style='margin: 7px 11px;;width:10px;height:18px;' src='img/chevron_left.png'>
				<img id='show' class='material-icons small hide' style='margin: 7px 11px;;width:10px;height:18px;'  src='img/chevron_right.png'>
			</div>
		";
	}
	if (isset($_SESSION['username'])) {
		echo "
			<div id='menu' class='c_nav fl width270px'>
		";
	}
	else{
		echo "
			<div id='menu' class='c_nav fl width0px'>
		";
	}
	if (isset($_SESSION['username'])) {
		echo "
			<nav id='nav'>
		";
	}
	else{
		echo "
			<nav id='nav' class='hide'>
		";
	}
?>
		<ul>
			<li>
				<a id='user' href='#'>
					<div class='nav'>
						UPP ONLINE
					</div>
				</a>
				<div class='dropdown'>
					<ul>
						<li>
							<a href='main?index=upp&step=create'>
								<div class='sub_nav'>
									Create New UPP
								</div>
							</a>
						</li>
					</ul>
					<?php
						if (isset($_SESSION['username']) and $_SESSION['level'] != "qa" and $_SESSION['level'] != "approval1") {
							echo "
								<ul>
									<li>
										<a href='main?index=upp&step=proses'>
											<div class='sub_nav'>
												<span class='fl'>Process UPP</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'progress' OR status = 'not approved'");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=approval1'>
											<div class='sub_nav'>
												<span class='fl'>Approval Pic 1</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status='approval' AND tgl_pic1='0000/00/00' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=approval2'>
											<div class='sub_nav'>
												<span class='fl'>Approval Pic 2</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status='approval' AND tgl_pic2='0000/00/00' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=approved'>
											<div class='sub_nav'>
												<span class='fl'>UPP Approved</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status='approved' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=done'>
											<div class='sub_nav'>
												<span class='fl'>UPP Need To Check</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'need to check' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=kepuasan'>
											<div class='sub_nav'>
												<span class='fl'>Kepuasan User</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan='0000-00-00' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=close'>
											<div class='sub_nav'>
												<span class='fl'>UPP Close</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' ".$filter." order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=batal'>
											<div class='sub_nav'>
												<span class='fl'>UPP Batal</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'batal' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=report'>
											<div class='sub_nav'>
												<span class='fl'>UPP Report</span>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>
								<ul>
									<li>
										<a href='main?index=upp&step=file'>
											<div class='sub_nav'>
												File Master Prosedur
											</div>
										</a>
									</li>
								</ul>
							";
						}
						if (isset($_SESSION['username']) and $_SESSION['level'] == "qa")
						{
							echo"
							<ul>
									<li>
										<a href='main?index=upp&step=approval2'>
											<div class='sub_nav'>
												<span class='fl'>Approval Pic 2</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status='approval' AND tgl_pic2='0000/00/00' and pic2='".$_SESSION['email']."' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>";
						}
						if (isset($_SESSION['username']) and $_SESSION['level'] == "approval1")
						{
							echo"
							<ul>
									<li>
										<a href='main?index=upp&step=approval1'>
											<div class='sub_nav'>
												<span class='fl'>Approval Pic 1</span>
												<div class='jumlah_nav fl'>
													";
													$jumlah1=mysqli_query($conn, "SELECT * FROM upp WHERE status='approval' AND tgl_pic1='0000/00/00' and pic1='".$_SESSION['email']."' order by no desc");
													$jumlah=mysqli_num_rows($jumlah1);
													echo "
													$jumlah
												</div>
												<div class='cb'></div>
											</div>
										</a>
									</li>
								</ul>";
						}
					?>
				</div>
			</li>
		</ul>
	</nav>
</div>
<?php
	if (isset($_SESSION['username'])) {
		echo "
			<div id='main' class='main fl m-left-270px'>
		";
	}
	else{
		echo "
			<div id='main' class='main fl m-left-0 width100pc'>
		";
	}
?>
	<?php
		switch ($step) {
			case 'create':
				include 'main_upp_create.php';
			break;
			case 'proses':
				include 'main_upp_proses.php';
			break;
			case 'approval1':
				include 'main_upp_approval1.php';
			break;
			case 'approval2':
				include 'main_upp_approval2.php';
			break;
			case 'approved':
				include 'main_upp_approved.php';
			break;
			case 'done':
				include 'main_upp_done.php';
			break;
			case 'kepuasan':
				include 'main_upp_kepuasan.php';
			break;
			case 'close':
				include 'main_upp_close.php';
			break;
			case 'report':
				include 'main_upp_report.php';
			break;
			case 'batal':
				include 'main_upp_batal.php';
			break;
			case 'file':
				include 'main_upp_filemaster.php';
			break;
		}
	?>
</div>
<div class='cb'></div>