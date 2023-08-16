<?php
	$awal=0;
	$filter="";
	$hariini=date("Y-m-d");
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
	if (!isset($_SESSION['username'])) {
		header('location:home');
	}
?>
<div class='judul_main' style='position: fixed;'>Report Usulan Perubahan Prosedur</div>
<div class='form_main' style='margin-top: 46px;'>
	<?php
		echo "
			<form style='margin-bottom:0px;' action='main?index=upp&step=report' method='post' enctype='multipart/form-data'>
				<select class='input_main' name='tahun' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
					<option value=''>Pilih Tahun</option>
					";
					$year=date('Y');
					for ($i=$year; $i > 1997; $i--) {
						if ($tahun==$i) {
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
				<select class='input_main' name='bulan' onchange='this.form.submit()' style='font-family:arial;width:120px;'>
					<option value=''>Pilih Bulan</option>
					";
					$month=array('01','02','03','04','05','06','07','08','09','10','11','12');
					$month2=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					$monthlength=count($month);
					for ($x=0; $x < $monthlength; $x++) {
						if ($month[$x]==$bulan) {
							$bulantampil=$month2[$x];
							echo "
							<option value='$month[$x]' selected>$month2[$x]</option>
							";
						}
						else{
							echo "
							<option value='$month[$x]'>$month2[$x]</option>
							";
						}
					}
					echo "
				</select>
			</form>
		";
		if (isset($alert)) {
		echo "<div class='alert_adm alert'>$alert</div>";
		}
		if (isset($alert2)) {
			echo "<div class='alert_adm alert2'>$alert2</div>";
		}
	?>
	<form action='excel/export.php?file=report' method='post' enctype='multipart/form-data'>
		<?php
			echo "<input type='hidden' name='filter' value='$filter'>";
		?>
		<button id='download' class='button_download fl'>Export To Excel</button>
	</a>
	<div class='cb'></div>
	<table id='tableID' class='table_report'>
		<tr>
			<td class='left-td'>UPP PROGRESS</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp 
					inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
					inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
					inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur 
					WHERE status != 'closed' and status != 'batal' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
		<tr>
			<td class='left-td'>UPP CLOSE</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp 
					WHERE tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' AND status = 'closed' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
		<tr>
			<td class='left-td'>UPP BATAL</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'batal' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
		<tr>
			<td class='left-td'>[STATUS] LT Tgl Berlaku Vs Tgl Permohonan Berlaku OK</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' AND report1 = 'ok' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
		<tr>
			<td class='left-td'>[STATUS] LT Proses UPP OK</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' AND report2 = 'ok' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
		<tr>
			<td class='left-td'>[STATUS] Tgl Berlaku Vs Tgl Sosialisasi OK</td>
			<?php
				$a=mysqli_query($conn, "SELECT * FROM upp WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' AND report3 = 'ok' ".$filter);
				$jumlah=mysqli_num_rows($a);
				echo "
					<td class='right-td'>$jumlah</td>
				";
			?>
		</tr>
	</table>