<?php
    class clsObjectAccess
    {
        use trtBasic;
        /**  Location for overloaded data.  */
        private $data = array();

        
        public function __set($name, $value)
        {
            $this->data[$name] = $value;
        }
        
        public function set_array($data_arr)
        {
           foreach($data_arr as $key=>$val){
                if($this->data[$key]!=$val){
                    $this->data[$key] = $val;
                    $this->call_event($key,$val);
                }
                
            }
            
        }

        public function call_event($key,$val)
        {
           //print_r($this->data);
            
        }

        public function print_variable_array()
        {
           print_r($this->data);
            
        }
        
        public function __get($name)
        {
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }

            
        }

        public function __isset($name)
        {
            return isset($this->data[$name]);
        }

        public function __unset($name)
        {
            unset($this->data[$name]);
        }
    }