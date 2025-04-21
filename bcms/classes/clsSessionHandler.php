<?php
class clsSessionHandler implements SessionHandlerInterface
{
    use trtBasic;
    private $savePath="./bcms/sessions/";

    
    
    function __construct(){

        //$this->Set_Log(clsClassFactory::$cf_all_vars['log']);
        //$this->Set_DataBase(clsClassFactory::$cf_all_vars['r']);
        //$this->Set_Session(clsClassFactory::$cf_all_vars['sess']);
        
    }

    

    function Set_Session($sess){
        $this->sess=$sess;
        
        
    }

    
    public function open($savePath, $sessionName): bool
    {
		
		if($savePath!=""){
			$this->savePath = $savePath;
		}
		print("XX4".$this->savePath);
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0777);
        }
        
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    #[\ReturnTypeWillChange]
    public function read($id)
    {
        print("XX3->".$id." \n");
        return (string)@file_get_contents("$this->savePath/sess_$id");
    }

    public function write($id, $data): bool
    {
        
        $output=file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
        print("XX2-".$output."-".$data);
        return $output;
    }

    public function destroy($id): bool
    {
        $file = "$this->savePath/sess_$id";
        if (file_exists($file)) {
            unlink($file);
        }

        return true;
    }

    #[\ReturnTypeWillChange]
    public function gc($maxlifetime)
    {
        foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                unlink($file);
            }
        }

        return true;
    }
}

