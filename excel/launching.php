<?php
	include "../inc.php";
	$awal = 0;
	$a=mysqli_query($conn, "SELECT * FROM informasi_produk WHERE jenis = 'launching' AND status='aktif' ORDER BY no desc");
	

?>
<table id='tableID' class='table_admin' border="1">
			<tr class='top_table'>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kode Oracle</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama Produk</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kode Formula</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. SK</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Follow Up</td>
				<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status Follow Up </td>
				
			</tr>
          <?php
					$rowscount=$awal+1;
					while ($c=mysqli_fetch_array($a)) {
						if ($rowscount % 2 == 1) {
							echo "
								<tr class='main_table_home odd'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
										
									echo "
								</tr>
							";
						}
						elseif ($rowscount % 2 == 0) {
							echo "
								<tr class='main_table_home even'>
									<td>$rowscount</td>
									<td>$c[kode_oracle]</td>
									<td>$c[nama_produk]</td>
									<td>$c[kode_form]</td>
									<td>$c[no_sk]</td>
									<td>$c[follow_up]</td>
									<td>$c[status_follow_up]</td>
									";
									echo "
								</tr>
							";
						}
						$rowscount++;
					}
				?>
			</table>