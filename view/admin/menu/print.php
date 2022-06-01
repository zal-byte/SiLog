<?php
	session_start();

	require_once '../../../controller/print.php';

	REPORT::getInstance();
	REPORT::CETAK($_SESSION['select_date'], $_SESSION['barang']);

?>