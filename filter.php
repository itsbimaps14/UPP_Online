		<select class='input_main' name='tgl_berlaku' style='width:240px;margin:0px;' onchange='this.form.submit()'>
			<option value=''>Kesesuaian Dokumen</option>
				<?php
					$a=mysqli_query($conn, "SELECT * FROM upp
						GROUP BY permohonan_tgl_berlaku");
					while ($c=mysqli_fetch_array($a)) {
						$take_pic = md5($c['pic']);
						if ($pic_lap==$c['pic']) {
							echo "
								<option value='$c[permohonan_tgl_berlaku]' selected>$take_pic</option>
							";
						}
						else{
							echo "
								<option value='$c[permohonan_tgl_berlaku]'>$take_pic</option>
							";
						}
					}
				?>
		</select>

		<!-- prosedur,nama bahanbaku / produk, detail kategori, nama file, permohonan tanggal berlaku, pic sosialisasi lapangan, tgl berlaku, kesesuaian dokumen -->
