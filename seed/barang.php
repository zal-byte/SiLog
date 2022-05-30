<?php

	require_once '../vendor/autoload.php';
	require_once '../controller/Connection.php';

	Connection::getInstance();


	$faker = Faker\Factory::create('id_ID');

	// $query = "INSERT INTO barang (`nama_barang`,`jumlah_barang`,`sisa_barang`) VALUES (:nama_barang, :jumlah_barang, :sisa_barang)";

	$query = "INSERT INTO barang_digunakan (`tanggal`,`jumlah`,`id_barang`) VALUES (:tanggal, :jumlah, :id_barang)";


	$con = Connection::getConnection();

	for( $i = 0;  $i < 10; $i++){
		// $param = array(':nama_barang'=> $faker->name, ':jumlah_barang'=>$faker->numberBetween(2,9), ':sisa_barang'=>$faker->numberBetween(1,9));

		$param= array(':tanggal'=>$faker->date(), ':jumlah'=>$faker->numberBetween(1,9), ':id_barang'=>$i+1);

		$pr = $con->prepare($query);
		$pr = $pr->execute($param);
	}
?>