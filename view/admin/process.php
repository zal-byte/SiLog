<?php
	
	session_start();

	require_once('../../controller/Auth.php');
	require_once('../../controller/Barang.php');
	require_once('../../controller/User.php');

	Barang::getInstance();
	User::getInstance();
 

					

	if( isset($_SERVER) ){
		if( isset($_SERVER['REQUEST_METHOD']) ){
			if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

				if( isset($_POST) ){
					$request = $_POST['request'];

					if( $request == 'login' ){
						$response = Auth::login( $_POST['username'], $_POST['password']);
						if( $response['status'] == true ){
							$_SESSION['login'] = true;
							$_SESSION['username'] = $_POST['username'];
							header('location: dashboard.php');
						}else{
							$_SESSION['login_error'] = $response['msg'];
							header('location: index.php');
						}
					}else if( $request == 'edit'){
		    			$n_barang = Handler::VALIDATE($_POST, 'nama_barang');
		    			$j_barang = Handler::VALIDATE($_POST, 'jumlah_barang');
		    			$id_barang = Handler::VALIDATE($_POST, 'input_id_barang');

		    			$response = Barang::edit_dataBarang( $id_barang, $n_barang, $j_barang );
		    			if( $response[0] == true){
		    				$_SESSION['edit_success'] = 'Barang berhasil diperbarui';
		    			}else{
		    				if($response[1] == 'not_found'){
		    					//barang tidak ditemukan
		    					$_SESSION['edit_error'] = 'Barang tidak ada';
		    				}else if($response[1] == 'edit_error'){
		    					//barang gagal diperbarui
		    					$_SESSION['edit_error'] = 'Barang gagal diperbarui';
		    				}
		    			}
	    				header('location: dashboard.php?view=databarang');
    				}else if( $request == 'use'){
    					$id_barang = $_POST['id_barang'];
    					$jumlah = $_POST['g_jumlah'];
    					$tanggal = $_POST['g_tanggal'];

    					if($tanggal != null){
	    					$response = Barang::tambah_dataBarangPenggunaan( $id_barang, $jumlah , $tanggal);
	    					// print_r($response);
	    					if( $response[0] != false ){
	    							$_SESSION['use_success'] = "Barang berhasil digunakan";
	    					}else{
	    						if( $response[1] == 'out_of_stock' )
	    						{
	    							$_SESSION['use_error'] = "Jumlah yang akan digunakan lebih dari sisa barang";
	    						}else if( $response[1] == 'exec_error'){
	    							$_SESSION['use_error'] = "Query error";
	    						}else{
	    							$_SESSION['use_error'] = "Gagal barang digunakan";
	    						}
	    					}
    					}else{
    						$_SESSION['use_error'] = "Masukan tanggal dengan benar";
    					}
    					header('location: dashboard.php?view=databarang');
    				}else if( $request == 'updatePassword'){
    					$username = $_SESSION['username'];
    					
    					$new_pass = $_POST['new_password'];
    					$old_pass = $_POST['old_password'];
    					$verify_pass = $_POST['verify_password'];

    					$log = User::myProfile( $username )[0];
    					if( md5($old_pass) == $log['password'] ){

    						if( $new_pass == $verify_pass ){
    							$res = User::updatePassword( $username, $new_pass );
    							if( $res != false ){
    								$_SESSION['update_password_success'] = "Kata sandi berhasil diperbarui";
    							}else{
    								$_SESSION['update_password_error'] = "Kata sandi tidak dapat diperbarui";
    							}
    						}else{
    							$_SESSION['update_password_error'] = "Ketik ulang kata sandi tidak sama";
    						}
    					}else{
    						$_SESSION['update_password_error'] = "Kata sandi lama salah";
    					}

    					header('location: dashboard.php?view=userprofile');
    				}else if( $request == 'editPenggunaan'){
    					print_r($_POST);
    					$id_barang_digunakan = $_POST['id_barang_digunakan'];

    					$tanggal = $_POST['tanggal']; 
    					$jumlah = $_POST['jumlah'];

    					$response = Barang::edit_dataBarangDigunakan( $id_barang_digunakan, $tanggal, $jumlah );
    					if( $response != false ){
    						$_SESSION['edit_penggunaan_success'] = "Penggunaan berang berhasil diperbarui";
    					}else{
    						$_SESSION['edit_penggunaan_error'] = "Penggunaan barang gagal diperbarui";
    					}
    					header('location: dashboard.php?view=barangdigunakan');
    				}
				}

			}
		}else{
			echo "REQUEST_METHOD NULL";
		}
	}else{
		echo "NO RESPONSE";
	}

?>