<?php
	require_once 'Handler.php';
	Handler::getInstance();

	class User implements query{
		private static $instance = null;
		public static function getInstance(){
			if(self::$instance == null){
				self::$instance = new User();
			}
			return self::$instance;
		}

		public static function myProfile( $username ){
			$pre = Handler::$con->prepare( User::myProfile );
			$pre->bindValue(1, $username, PDO::PARAM_STR );
			// echo "<pre>";
			// $pre->debugDumpParams();
			// echo "</pre>";
			$pre->execute();

			return $pre->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function updatePassword( $username, $new_pass ){
			$pre = Handler::$con->prepare( User::updatePassword );
			$pre->bindValue(1, md5($new_pass), PDO::PARAM_STR );
			$pre->bindValue(2, $username, PDO::PARAM_STR );

			if( $pre->execute() ){
				return true;
			}else{
				return false;
			}
		}
	}


?>