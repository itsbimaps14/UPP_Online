<?php
	include "../inc.php";
	$awal = 0;
	$a=mysqli_query($conn, "SELECT * FROM upp inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00' order by tgl_kepuasan DESC");
	

?>
<table id='tableID' class='table_admin' border="1">
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. UPP</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Divisi Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Prosedur</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Detail Kategori</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama File</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Sebelum Perubahan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Setelah Perubahan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Link Prosedur</td>
			</tr>
            <?php
					$rowscount=$awal+1;
					while ($c=mysqli_fetch_array($a)) {
						$sebelumperubahan=nl2br($c['sebelumperubahan']);
						$setelahperubahan=nl2br($c['setelahperubahan']);
						$alasan=nl2br($c['alasan']);
						if ($rowscount % 2 == 1) {
							echo "
								<tr class='main_table_home odd'>
									<td>$c[no_upp]</td>
									<td>$c[divisi_prosedur]</td>
									<td>$c[master_prosedur]</td>
									<td>$c[jenis_prosedur]</td>
									<td>$c[detail_prosedur]</td>
									<td>$c[nama_folder]</td>
									<td>$sebelumperubahan</td>
									<td>$setelahperubahan</td>
									<td>$alasan</td>
									<td>
									";
										if ($c['file_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
										}
										else{
											echo "no file";
										}
									echo "
									</td>
									<td>
									";
										if ($c['link_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
										}
										else{
											echo "no link";
										}
									echo "
									</td>
								</tr>
							";
						}
						elseif ($rowscount % 2 == 0) {
							echo "
								<tr class='main_table_home even'>
									<td>$c[no_upp]</td>
									<td>$c[divisi_prosedur]</td>
									<td>$c[master_prosedur]</td>
									<td>$c[jenis_prosedur]</td>
									<td>$c[detail_prosedur]</td>
									<td>$c[nama_folder]</td>
									<td>$sebelumperubahan</td>
									<td>$setelahperubahan</td>
									<td>$alasan</td>
									<td>
									";
										if ($c['file_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
										}
										else{
											echo "no file";
										}
									echo "
									</td>
									<td>
									";
										if ($c['link_prosedur']!='') {
											echo "<a style='padding-right:5px;color: blue;' href='$c[link_prosedur]'>go to link</a>";
										}
										else{
											echo "no link";
										}
									echo "
									</td>
								</tr>
							";
						}
						$rowscount++;
					}
				?>
			</table>