
<?php
include '../inc.php';
$page1=mysqli_query($conn, "SELECT * FROM dde, department WHERE dde.no_department = department.no");

?>
<table id='tableID' class='table_admin' border="1">
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal DDE</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Department</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama Dokumen</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Sumber/Edisi/Tahun</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kirim</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Terima</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Copy</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Bentuk Penyimpanan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kembali</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kode</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>File Attachment</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Batal</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Batal</td>
			</tr>
			<?php
				$rowscount=1;
				while ($c=mysqli_fetch_array($page1)) {
					if ($rowscount % 2 == 1) {
						echo "
							<tr class='main_table odd'>
								";
									if ($c['status']=='closed') {
										echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									elseif ($c['status']=='batal') {
										echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									else {
										echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
								echo "
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_dde]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_dde]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode_department]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_dokumen]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[sumber_edisi_tahun]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_terima]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[bentuk_penyimpanan]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode]</td>
								<td style='font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>
								";
									if ($c['nama_file']!='') {
										echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a>";
									}
									else{
										echo "no file";
									}
								echo "
								</td>
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
									if ($c['status']=='closed') {
										echo "<td style='background:#92d050;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									elseif ($c['status']=='batal') {
										echo "<td style='background:red;color:white;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
									else {
										echo "<td style='background:#fcff00;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>";
									}
								echo "
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_dde]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_dde]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode_department]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[nama_dokumen]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[sumber_edisi_tahun]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[pengaju]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_terima]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[no_copy]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[bentuk_penyimpanan]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[kode]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>
								";
									if ($c['nama_file']!='') {
										echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[nama_file]'>download</a>";
									}
									else{
										echo "no file";
									}
								echo "
								</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[tgl_batal]</td>
								<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 14px;padding: 2px;text-align: center;'>$c[alasan_batal]</td>
								";
								echo "
							</tr>
						";
					}
					$rowscount++;
				}
			?>
		</table>