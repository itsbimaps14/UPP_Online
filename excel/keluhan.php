<?php
	include "../inc.php";
	$a=mysqli_query($conn, "SELECT * FROM keluhan inner join prosedur on keluhan.no_prosedur = prosedur.no_prosedur inner join divisi_prosedur on prosedur.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on prosedur.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on prosedur.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur");

?>
<table id='tableID' class='table_admin' border="1">
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Keluhan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Divisi Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Jenis Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Detail Kategori</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama File</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Keluhan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Golongan Kasus</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Penyebab</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tindakan Koreksi</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tindakan Prevetive</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>PIC</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Closed</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Keterangan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Batal</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Batal</td>
				
			</tr>
		<?php
			$rowscount=1;
			while ($c=mysqli_fetch_array($a)) {
				$d=mysqli_query($conn, "SELECT * FROM keluhan where no_keluhan = '$c[no_keluhan]'");
				$f=mysqli_fetch_array($d);
				if ($rowscount % 2 == 1) {
					echo "
						<tr class='main_table odd'>
							";
								if ($f['status']=='closed') {
									echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='batal') {
									echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								else {
									echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
							echo "
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_keluhan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_keluhan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keluhan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[golongan_kasus]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[penyebab]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tindakan_koreksi]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tindakan_preventive]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pic]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_closed]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keterangan]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
							<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
							";
								
							echo "
						</tr>
					";
				}
				elseif ($rowscount % 2 == 0) {
					echo "
						<tr class='main_table even'>
							";
								if ($f['status']=='closed') {
									echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								elseif ($f['status']=='batal') {
									echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
								else {
									echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$f[status]</td>";
								}
							echo "
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_keluhan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_keluhan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keluhan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[golongan_kasus]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[penyebab]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tindakan_koreksi]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tindakan_preventive]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pic]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_closed]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[keterangan]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
							<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
							";
								
							echo "
						</tr>
					";
				}
				$rowscount++;
			}
			echo "
				</table>
			";
		?>