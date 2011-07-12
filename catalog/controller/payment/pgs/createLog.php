<?php
Class createLog{
	private $name = 'ps.txt';
	private $type = 'ab';
	public $log;
	
	function setType($type = '') {
		$this -> type = $type;
	}
	function setFileName($name = ''){
		$this -> name = $name;
	}
	public function setLog($log){
		$this -> log = $this -> log . $log;
	}
	public function createlog(){
		$f = @fopen ($this -> name, $this -> type);
		@fwrite($f, $this -> log . "\n\n");
		@fclose($f);		
	}
}
?>
