<?php
$awal=0;
	include "../inc.php";
	$a=mysqli_query($conn, "SELECT * FROM upp 
		inner join divisi_prosedur on upp.no_divisi_prosedur = divisi_prosedur.no_divisi_prosedur 
		inner join master_prosedur on upp.no_master_prosedur = master_prosedur.no_master_prosedur 
		inner join jenis_prosedur on upp.no_jenis_prosedur = jenis_prosedur.no_jenis_prosedur
		inner join tbl_status on upp.status_sementara = tbl_status.id_status
		WHERE status = 'closed' AND tgl_pengecekan!='0000-00-00' AND tgl_kepuasan!='0000-00-00'");

?>
<table id='tableID' class='table_admin' border="1">
		<tr class='top_table'>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status Sementara</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. UPP</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal UPP</td> 
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Lokasi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Pengaju</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Email Pengaju</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Manager Approver (PIC 1)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Approver 2</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Divisi Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama Bahan Baku/Produk</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Prosedur</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Detail Kategori</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Nama File</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Sebelum Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Setelah Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Permohonan Tanggal Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File User</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Perubahan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Mesin</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>PIC Sosialisasi Lapangan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Cek ddd</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Status</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kategori Delay</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kirim</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Master</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Approval (PIC 1)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Approval (PIC 2)</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Prosedur</td>
            <td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Attachment File Hasil Daftar Hadir</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Sosialisasi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Filling</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Distribusi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kembali Dokumen lama + SPD</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. SPD</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Pengecekan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kesesuaian Dokumen</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Keterangan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Revisi</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>No. Revisi Cover</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Tanggal Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Alasan Kepuasan</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Tgl Berlaku Vs Tgl Permohonan Berlaku</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Prosess UPP OK</td>
			<td style='font-family:arial;background-color:#616161;color:white;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>LT Tgl Berlaku Vs Tgl Sosialisasi OK</td>
			<td style='font-family:arial;vertical-align:middle;font-size: 14px;font-weight: bold;padding: 2px;text-align: center;'>Action</td>
		</tr>
<?php
	$rowscount=$awal+1;
	while ($c=mysqli_fetch_array($a)) {
		$sebelumperubahan=nl2br($c['sebelumperubahan']);
		$setelahperubahan=nl2br($c['setelahperubahan']);
		$alasan=nl2br($c['alasan']);
		if ($rowscount % 2 == 1) {
			echo "
				<tr class='main_table odd'>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nm_status]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_upp]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_upp]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[lokasi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pengaju]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_bb]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$sebelumperubahan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$setelahperubahan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$alasan</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[permohonan_tgl_berlaku]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;' style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_perubahan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_mesin]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[cek_ddd]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;' style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_delay]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
						echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download_hasil_daftar_hadir.php?file=$c[file_daftar_hadir]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_berlaku]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_sosialisasi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_filling]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_distribusi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_spd]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pengecekan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kesesuaian_dokumen]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[keterangan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi_cover]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[alasan_kepuasan]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report1]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report2]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report3]</td>
					<td style='padding:10px;font-family:arial;vertical-align:middle;font-size: 13px;text-align: center;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=close&action=edit&id=$c[no_upp]#popup'>
							edit
						</a>
					</td>
				</tr>
			";
		}
		elseif ($rowscount % 2 == 0) {
			echo "
				<tr class='main_table even'>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nm_status]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_upp]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_upp]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[lokasi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pengaju]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[email_pengaju]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[divisi_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[master_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_bb]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[jenis_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[detail_prosedur]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[nama_folder]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$sebelumperubahan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$setelahperubahan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$alasan</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[permohonan_tgl_berlaku]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_user']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_user]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_perubahan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_mesin]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[pic]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[cek_ddd]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[status]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kat_delay]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kirim]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_master']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_master]'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pic2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>
					";
						if ($c['file_prosedur']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='download.php?index=$c[file_prosedur]'>download</a>";
						}
						else{
							echo "no file";
						}
						echo"</td><td>";
						if ($c['file_daftar_hadir']!='') {
							echo "<a style='padding-right:5px;color: blue;' href='form_daftar_hadir.php'>download</a>";
						}
						else{
							echo "no file";
						}
					echo "
					</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_berlaku]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_sosialisasi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_filling]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_distribusi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kembali]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_spd]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_pengecekan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kesesuaian_dokumen]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[keterangan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[no_revisi_cover]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[tgl_kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[alasan_kepuasan]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report1]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report2]</td>
					<td style='background-color: #dfdfdf;font-family:arial;vertical-align:middle;font-size: 13px;padding: 2px;text-align: center;'>$c[report3]</td>
					<td style='font-family:arial;vertical-align:middle;font-size: 13px;text-align: center;'>
						<a style='padding-right:5px;color: blue;' href='main?index=upp&step=close&action=edit&id=$c[no_upp]#popup'>
							edit
						</a>
					</td>
				</tr>
			";
		}
		$rowscount++;
	}
	echo "
		</table>
	";