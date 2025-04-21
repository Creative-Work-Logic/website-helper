<?php
    class clsServerDetails{
        use trtBasic;
        private $Base_Directory="";

        private $r;

        private $sess;

        private $server_types=array();

        private $current_server_type="";

        

        function __construct(){
            /*
            $linux=new clsLinuxServer();
            $windows=new clsWindowsServer();
            $this->server_types['linux']=$linux;
            $this->server_types['windows']=$windows;
            $this->current_server_type='linux';
            //$this->current_server_type=$this->getServerOSType();
            */
        }


        public function get_all_server_globals()
        {
            //$output=var_export($_SERVER,true);
            $output=$_SERVER;
            return $output;
        }

        public function get_all_server_ini()
        {
            //$output[0]=ini_get('memory_limit');
            //$output[1]=ini_get('max_execution_time');

            $output=ini_get('INI_SYSTEM');
            return $output;
        }

        public function get_server_disk_info()
        {
            $output[0]=disk_total_space("/");
            $output[1]=disk_free_space("/");
            return $output;
        }

        public function getServerOSType() {
            //"s n r v m"
            
            $output[0]=php_uname('a');
            $output[1]=php_uname('s');
            $output[2]=php_uname('n');
            $output[3]=php_uname('r');
            $output[4]=php_uname('v');
            $output[5]=php_uname('m');
            return $output;
        }

        public function get_phpinfo(){
            $output=phpinfo();
            return $output;
        }

        public function get_pear_info(){
            //$output=nl2br(shell_exec('pear list'));
            $output = shell_exec('pear list');
            $lines = explode("\n", $output);
            $pearPackages = [];

            foreach ($lines as $line) {
                if (preg_match('/^([a-zA-Z0-9_]+)\s+([\d.]+)\s+(\w+)$/', trim($line), $matches)) {
                    $pearPackages[$matches[1]] = [
                        'version' => $matches[2],
                        'state' => $matches[3]
                    ];
                }
            }
            return $pearPackages;
        }

        public function get_pecl_info(){
            $output = shell_exec('pecl list');
            
            $lines = explode("\n", $output);
            $peclPackages = [];

            foreach ($lines as $line) {
                if (preg_match('/^([a-zA-Z0-9_]+)\s+([\d.]+)\s+(\w+)$/', trim($line), $matches)) {
                    $peclPackages[$matches[1]] = [
                        'version' => $matches[2],
                        'state' => $matches[3]
                    ];
                }
            }

            return $peclPackages;
        }


        public function get_all_server_details(){
            $server_output=array();
            $server_output[0]=$this->get_all_server_globals();
            $server_output[1]=phpversion();
            $server_output[2]=get_loaded_extensions();
            $server_output[3]=$this->get_all_server_ini();
            $server_output[4]=$this->getServerOSType();
            $server_output[5]=$this->get_server_disk_info();
            $server_output[6]=$this->get_pear_info();
            $server_output[7]=$this->get_pecl_info();
            //phpinfo(INFO_MODULES);
            


            //print_r($server_output);
            return $server_output;

        }
    }
