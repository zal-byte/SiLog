<?php

		require_once '../interface/query.php';
		require_once 'Barang.php';
		
		Barang::getInstance();

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			if(isset($_GET['request'])){

				$request = $_GET['request'];
				if($request == 'getBarang'){
					$id = Handler::VALIDATE($_GET, 'id_barang');
					Barang::getBarang( $id );
				}else if( $request == 'getBarangDigunakan'){
					$id_barang_digunakan = $_GET['id_barang_digunakan'];

					Barang::getBarangDigunakan( $id_barang_digunakan );
				}

			}
		}

?>