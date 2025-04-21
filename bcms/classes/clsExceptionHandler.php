<?php

class clsExceptionHandler extends Exception{
    //use trtBasic;
   private $MessageArray=array();
   
   function __construct(){
			
        $this->SetErrorHandler();
    }

    function SetErrorHandler()
    {
        //echo"gg";
        set_error_handler(array($this, 'myErrorHandler'));
    }

   public function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        //echo"22g";
        //var_dump($argv);
        $errors="";
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        // $errstr may need to be escaped:
        $errstr = htmlspecialchars($errstr);
        $errors=$this->select_errors($errno,$errstr);
        
        $errors.="  Fatal error on line $errline in file $errfile";
        $errors.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $errors.="Aborting...<br />\n";
        /* Don't execute PHP internal error handler */
        $this->add_errors($errors);
        return true;
    }

    function select_errors($errno,$errstr)
    {
        $errors="";
        switch ($errno) {
            case E_USER_ERROR:
                $errors.="<b>My ERROR</b> [$errno] $errstr<br />\n";
                //$errors.="  Fatal error on line $errline in file $errfile";
                //$errors.=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                //$errors.="Aborting...<br />\n";
                //exit(1);
                break;
            case E_USER_WARNING:
                $errors.="<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;
    
            case E_USER_NOTICE:
                $errors.="<b>My NOTICE</b> [$errno] $errstr<br />\n";
                break;
            case E_ERROR:
                $errors.="<b>E-Error</b> [$errno] $errstr<br />\n";
                break;
            case E_PARSE:
                $errors.="<b>E-Parse</b> [$errno] $errstr<br />\n";
                break;
            case E_CORE_ERROR:
                $errors.="<b>E_CORE_ERROR</b> [$errno] $errstr<br />\n";
                break;
            default:
                $errors.="Unknown error type: [$errno] $errstr<br />\n";
                break;
            }
        return $errors;
    }

    function add_errors($errors)
    {
        $this->ErrorMessageArray[]=$errors;
        
    }
    function output_errors()
    {
        //echo"--------------------All Errors-------------------------------<br><br>\n\n";
        if(count($this->ErrorMessageArray)>0){
            
            //print_r($this->ErrorMessageArray);
        }
        
    }
}

?>