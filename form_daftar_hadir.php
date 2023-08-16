<?php
	$folder = "Form/Daftar Hadir/";
	header ("Content-Type: octet/stream");
	header ("Content-Disposition: attachment;
		filename=\"F.Y.203 (FDH - Form Daftar Hadir).doc\"");
	$fp = fopen($folder."F.Y.203 (FDH - Form Daftar Hadir).doc", "r");
	$data = fread($fp, filesize($folder."F.Y.203 (FDH - Form Daftar Hadir).doc"));
	fclose($fp);
	print $data;
?>