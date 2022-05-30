<?php


	date_default_timezone_set('Asia/Jakarta');

	require_once 'Handler.php';
	// include '../../interface/query.php';
	// use \interface\query;

	Handler::getInstance();

	class Barang implements query{
		private static $instance = null;
		public static function getInstance(){
			if( self::$instance == null ){
				self::$instance = new Barang();
			}
			return self::$instance;
		}


		//penggunaan

		public static function getBarangDigunakan( $id_barang_digunakan ){
			$pre = Handler::$con->prepare( Barang::cekDataBarangDigunakan );
			$pre->bindValue( 1 , $id_barang_digunakan, PDO::PARAM_INT );
			
			if( $pre->execute() ){
				echo json_encode( array('status'=>true, 'data'=>$pre->fetchAll(PDO::FETCH_ASSOC)));
			}else{
				echo json_encode(array('status'=>false));
			}
		}

		public static function edit_dataBarangDigunakan( $id_barang_digunakan, $tanggal, $jumlah ){
			$pre = Handler::$con->prepare( Barang::editDataBarangDigunakan );
			$pre->bindValue( 1, $tanggal, PDO::PARAM_STR );
			$pre->bindValue( 2, $jumlah, PDO::PARAM_INT );
			$pre->bindValue( 3, $id_barang_digunakan, PDO::PARAM_INT );

			if( $pre->execute() ){
				return true;
			}else{
				return false;
			}
			
		}

		private static function cek_dataBarangDigunakan( $id_barang_digunakan ){
			$pre = Handler::$con->prepare( Barang::cekDataBarangDigunakan );
			$pre->bindValue(1, $id_barang_digunakan, PDO::PARAM_INT );
			$pre->execute();

			$res = $pre->fetchAll(PDO::FETCH_ASSOC);

			if( count($res) > 0 ){
				return true;
			}else{
				return false;
			}
		}
		public static function hapus_dataBarangPenggunaan( $id_barang_digunakan ){
			$pre = Handler::$con->prepare( Barang::hapusDataBarangDigunakan );
			$pre->bindValue( 1, $id_barang_digunakan, PDO::PARAM_INT );
			if( self::cek_dataBarangDigunakan( $id_barang_digunakan ) != false ){
				if( $pre->execute() ){
					return [true, 'success'];
				}else{
					return [false, 'exec_error'];
				}			
			}else{
				return [false, 'not_found'];
			}

		}

		public static function cari_dataBarangPenggunaan( $cari, $limit, $page ){
			$pre = Handler::$con->prepare( Barang::cariDataBarangDigunakan );
			$pre->bindValue(":cari", "%" . $cari . "%", PDO::PARAM_STR );
			$pre->bindValue(":page", $page, PDO::PARAM_INT );
			$pre->bindValue(":limit", $limit, PDO::PARAM_INT );

			$pre->execute();
			// print_r($pre);
			$res = $pre->fetchAll(PDO::FETCH_ASSOC);
			// print_r($res);
			// echo "<pre>";
			// $pre->debugDumpParams();
			// echo "</pre>";
			return $res;	
		}
		
		public static function tambah_dataBarangPenggunaan( $id_barang, $jumlah, $tanggal ){

			$pre = Handler::$con->prepare( Barang::tambahDataBarangDigunakan );
			$pre->bindValue(1, $tanggal, PDO::PARAM_STR );
			$pre->bindValue(2, $jumlah, PDO::PARAM_INT );
			$pre->bindValue(3, $id_barang, PDO::PARAM_INT );

			$res = self::decreaseBarang( $id_barang, $jumlah );
			if($res[0] != false ){

					if( $pre->execute() ){
						return [true, 'success'];
					}else{
						return [false, 'exec_error'];
					}

			}else{
				return $res;
			}
		}

		private static function decreaseBarang( $id_barang, $jumlah ){
			$pre = Handler::$con->prepare( Barang::updateSisaBarang );

			$sisa = self::getBarangSisa( $id_barang )[0]['sisa_barang'];
			// echo $sisa;
			if( ($sisa - $jumlah) < 0 ){
				return [false, 'out_of_stock'];
			}else{
				$pre->bindValue(1, $sisa - $jumlah, PDO::PARAM_INT);
				$pre->bindValue(2, $id_barang, PDO::PARAM_INT);
				if( $pre->execute()){
					return [true];
				}else{
					return [false];
				}
			}
		}

		private static function getBarangSisa( $id_barang ){
			$pre = Handler::$con->prepare( Barang::cekDataBarang );
			$pre->bindValue(1, $id_barang, PDO::PARAM_INT );
			$pre->execute();

			return $pre->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getAllPenggunaan(){
			$pre = Handler::$con->prepare( Barang::semuaDataPenggunaan);
			$pre->execute();

			 return $pre->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function ambil_dataBarangPenggunaan( $limit, $page ){
			$pre = Handler::$con->prepare( Barang::dataBarangDigunakan );
			$pre->bindValue(1, $page, PDO::PARAM_INT );
			$pre->bindValue(2, $limit, PDO::PARAM_INT );
			$pre->execute();

			return $pre->fetchAll(PDO::FETCH_ASSOC);
		}

		//barang

		public static function getAllBarang(){
			$pre = Handler::$con->prepare( Barang::semuaDataBarang );
			$pre->execute();

			return $pre->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getBarang( $id_barang ){
			$pre = Handler::$con->prepare( Barang::cekDataBarang );
			$pre->bindValue(1, $id_barang, PDO::PARAM_INT );
			$pre->execute();

			$data = $pre->fetchAll(PDO::FETCH_ASSOC);
			header('Content-Type: application/json');
			if( count($data) > 0 ){
				echo json_encode(array('status'=>1, 'data'=>$data));
			}else{
				echo json_encode(array('status'=>0, 'msg'=>'No data'));
			}
		}

		private static function cek_dataBarang( $id_barang ){
			$pre = Handler::$con->prepare( Barang::cekDataBarang );
			$pre->bindValue(1, $id_barang, PDO::PARAM_INT );
			$pre->execute();

			if( count($pre->fetchAll(PDO::FETCH_ASSOC)) > 0 ){
				return true;
			}else{
				return false;
			}
		}

		public static function edit_dataBarang( $id_barang, $nama_barang, $jumlah_barang ){
			$pre = Handler::$con->prepare( Barang::editDataBarang );
			$pre->bindValue(1, $nama_barang, PDO::PARAM_STR );
			$pre->bindValue(2, $jumlah_barang, PDO::PARAM_INT);
			$pre->bindValue(3, $id_barang, PDO::PARAM_INT);
			if( self::cek_dataBarang( $id_barang ) != false ){
				if($pre->execute()){
					return [true, 'success'];
				}else{
					return [false, 'edit_error'];
				}
			}else{
				return [false, 'not_found'];
			}
		}


		public static function hapus_dataBarang( $id_barang ){
			$pre = Handler::$con->prepare( Barang::hapusDataBarang );
			$pre->bindValue(1, $id_barang, PDO::PARAM_INT);
			
			if( self::cek_dataBarang( $id_barang ) != false ){
				if( $pre->execute() ){
					return [true,'success'];
				}else{
					return [false,'error'];
				}
			}else{
				return [false,'not_found'];
			}

		}

		public static function ambil_dataBarang($limit = 5, $page = 1){


			$pre = Handler::$con->prepare( Barang::dataBarang );
			$pre->bindValue(':page', $page, PDO::PARAM_INT);
			$pre->bindValue(':limit', $limit, PDO::PARAM_INT);
			$pre->execute();

			$res = $pre->fetchAll(PDO::FETCH_ASSOC);

			return $res;
		}

		public static function cari_dataBarang( $nama_barang, $limit, $page){

			$pre = Handler::$con->prepare( Barang::cariDataBarang );
			$pre->bindValue(1, "%".$nama_barang."%", PDO::PARAM_STR);
			$pre->bindValue(2, $page, PDO::PARAM_INT);
			$pre->bindValue(3, $limit, PDO::PARAM_INT);
			$pre->execute();

			$res = $pre->fetchAll(PDO::FETCH_ASSOC);
			return $res;

		}

		public static function tambah_dataBarang( $nama_barang, $jumlah_barang ){

			$statement = Handler::PREPARE( Barang::tambahDataBarang, array(":nama_barang"=>$nama_barang,":jumlah_barang"=>$jumlah_barang,":sisa_barang"=>$jumlah_barang));


			if( $statement ){
				return true;
			}else
			{
				return false;
			}
		}


	}

?>