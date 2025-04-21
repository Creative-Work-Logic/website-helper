<?php

class clsExceptionHandler extends Exception
{
	//use trtBasic;

	public function __construct(){
		echo "0=>";
		//exit();
		set_exception_handler(array($this, 'errorMessage'));
		echo "2=>";
	}


	function handle(Throwable $ex)
	{
		//echo "0=>";
		echo "\n Error=>".var_export($ex,true)." \n";
	}

	

	function errorMessage() {
		//error message
		$errorMsg = 'Error on line ';//.$this->getLine().' in '.$this->getFile()
		//.': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
		print $errorMsg;
		return $errorMsg;
	  }
	}