<?php


	require_once('Handler.php');
	require_once('../../interface/query.php');
	Handler::getInstance();
	class Auth implements query{
		private static $instance = null;
		private static $con = null;
		public static function getInstance(){
			if(self::$instance == null ){
				self::$instance = new Auth();
			}
			return self::$instance;
		}



		public static function login( $username, $password ){
			
			$res = Handler::PREPARE( Auth::adminLogin, array(':username'=>$username ));

			$data = $res->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0 ){
				if( md5($password) == $data[0]['password']){
					return array('status'=>true);
				}else{
					return array('status'=>false, 'msg'=>'Invalid password');
				}
			}else{
				return array('status'=>false, 'msg'=>'User not found');
			}
		}

	}
	
?>