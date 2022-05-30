<?php


	class Connection{
		private static $instance = null;
		public static function getInstance(){
			if( self::$instance == null ){
				self::$instance = new Connection();
			}
			return self::$instance;
		}
		private static $con = null;
		public function __construct(){
			if( self::$con == null ){
				self::$con = new PDO("mysql:host=localhost;dbname=silog","root","");
			}
		}

		public static function getConnection(){
			return self::$con;
		}
	}


?>