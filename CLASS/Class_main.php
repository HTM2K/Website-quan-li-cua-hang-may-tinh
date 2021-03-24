<!--Tham khảo PDO https://laptrinhx.com/pdo-va-nhung-dieu-can-biet-2573156674/ -->
<?php
class Main{
	
	function data_to_sql_update($tbl,$data){
		if (!$tbl || !$data) return "";
		$fields = array();
		$vals = array();
		foreach ($data as $k=>$v){
			$vals[] = "{$k}=n'" . sql_str($v) . "'";
		}
		$vals = implode(",",$vals);
		return "update {$tbl} set {$vals}";
	}
	function data_to_sql_insert($tbl,$data){
		if (!$tbl || !$data) return "";
		$fields = array();
		$vals = array();
		foreach ($data as $k=>$v){
			$fields[] = $k;
			$vals[] = "n'" . sql_str($v) . "'";
		}
		$fields = implode(",",$fields);
		$vals = implode(",",$vals);
		return "insert into {$tbl} ({$fields}) values ({$vals})";
	}
	function logDebug($mess){
		error_log( date('d.m.Y h:i:s') . " $mess \n", 3, "log.log");
	}
	function connect(){
		global $link;
		if ($link) return 0;
		$link = mysqli_connect('localhost', 'root', '');
		if (!$link) {
			die('<br/>Khong ket noi duoc: ' . mysqli_error());
		}	
		mysqli_select_db($link,'computer_store') or die('Could not select database.');
		mysqli_query($link,"SET NAMES 'utf8'");
	}
	
	function close(){
		global $link;
		if($link){
			mysqli_close($link);
			$link = 0;
		}
	}
	function select_one($sql){
		$data = $this->exec_select($sql);
		if (!$data) return null;
		return $data[0];
	}
	function select_list($sql){
		return $this->exec_select($sql);
	}
	function exec_select($sql){
		$this->logDebug("sql=[$sql]");//de fix bug
		$this->connect();
		global $link;
		$ret = isset($ret) ? $ret : array();
		//$res = mysqli_query($link,$sql) ;
		$res = $link->query($sql);
		$row = array();
		//Lay loi sau khi thuc hien truy van
		$err = mysqli_error($link);
		//kiem tra
		if ($err){
			print("Khong the select duoc");
			$this->logDebug("Khong the select duoc,ERROR=[" . $err . "]" );
			$this->logDebug(  "COUNT=[0]" );
			return null;
		}
		//Khong co loi
		if ($res ){
			$i = 1;
			//lay tung dong ket qua
			//while( $row = mysqli_fetch_array($res,MYSQL_ASSOC) )
			while( $row = $res->fetch_array(MYSQLI_ASSOC) )
			{				
				$ret[]= $row ;
			}
			//mysql_free_result($res);
			$res->free_result();
		}	
		$this->close();
		return $ret;
	}
	function exec_update($sql){
		$this->logDebug( "<!-- sql=[$sql] -->");//de fix bug
		$this->connect();
		global $link;
		//$res = mysqli_query($link,$sql) ;
		$res = $link->query($sql);
		$row = array();
		//Lay loi sau khi thuc hien truy van
		$err = mysqli_error($link);
		//$err = $link->error();
		//kiem tra
		if ($err){
			print("Khong thể select duoc,ERROR=[" . $err . "]" );
			print(  "COUNT=[0]" );
			return -1;
		}
		//$ret = mysqli_affected_rows();
		//$ret = $res->affected_rows();
		$this->close();
		return 1;
	}
	function sql_str($val){
		if($val === 0)  return '0' ;
		if($val === null) {
			return 'NULL';
		}
		global $link;
		if(!$link) connect();
		if (get_magic_quotes_gpc()) {
			return "" . mysqli_real_escape_string($link,stripslashes($val)) . "" ;
		}
		return "" . mysqli_real_escape_string($link,$val)  . "" ;
	}
}
?>