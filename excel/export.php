<?php
// Fungsi header dengan mengirimkan raw data excel

// Mendefinisikan nama file ekspor "hasil-export.xls"
date_default_timezone_set('Asia/Jakarta');
$date = date("Y-m-d");

if(isset($_GET['file'])){
$file = $_GET['file'];
switch($file){
	case 'dde':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_DDE_".$date.".xls");
		include 'dde.php';
		break;
	case 'keluhan':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Keluhan_".$date.".xls");
		include 'keluhan.php';
		break;
	case 'ddd':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_DDD_".$date.".xls");
		include 'ddd.php';
		break;
	case 'close':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Close_".$date.".xls");
		include 'close.php';
		break;
	case 'report':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Report_".$date.".xls");
		include 'report.php';
		break;
	case 'terbaru':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Terbaru_".$date.".xls");
		include 'terbaru.php';
		break;
	case 'pruning':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Pruning_".$date.".xls");
		include 'pruning.php';
		break;
	case 'launching':
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=UPP_ONLINE_Launching_".$date.".xls");
		include 'launching.php';
		break;
}
}
?>