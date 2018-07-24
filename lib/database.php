<?php
	class Database{
		public $host   = DB_HOST;
		public $user   = DB_USER;
		public $pass   = DB_PASS;
		public $dbname = DB_NAME;

		public $link;
		public $error;
		function __construct(){
			$this ->connectDB();
		}

		private function connectDB(){

			$this ->link = new mysqli($this -> host, $this -> user, $this -> pass, $this -> dbname);

			if(!$this ->link){

				$this ->error ="connection failed".$this ->link ->connect_error ;
			}
		}

		// insert data

		public function insert($data){

			$insert_row = $this ->link ->query($data) or die($this ->link ->error.__LINE__);

			if($insert_row){

				return $insert_row;
			}else{

				return false;
			}

		}

		// select data

		public function select($data){

			$result = $this ->link ->query($data) or die($this ->link ->error.__LINE__);

			if($result ->num_rows >0){

				return $result;
			}else{

				return false;
			}

		}

		// delete data

		public function delete($data){

			$result = $this ->link ->query($data) or die($this ->link ->error.__LINE__);

			if($result){

				return $result;
			}else{

				return false;
			}

		}
	}
?>