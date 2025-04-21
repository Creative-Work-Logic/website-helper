<?php

    class clsHosting{
        use trtBasic;
        
       
        
        
        public function __construct($classes=array()){
            
            		}

               
       

        public function Pre_Create_Server_List(){
			$this->output=__METHOD__;
            return $this->output;
		}
        public function Pre_Create_Server_Add(){
			$this->output=__METHOD__;
            return $this->output;
		}

        public function Pre_Create_Server_Edit(){
			$this->output=__METHOD__;
            return $this->output;
		}
        public function Create_Server_List(){
            //print "XXD3";
            //$this->output="XXD4";
			$this->output=$this->cls->clsFormCreator->Create_Server_List_Table();
            return $this->output;
		}

        public function Create_Server_Edit(){
            //print "XXD3";
            //$this->output="XXD4";
			$this->output=$this->cls->clsFormCreator->Create_Server_Form();
            return $this->output;
		}

        public function Create_Server_Add(){
            $this->output=$this->cls->clsFormCreator->Create_Server_Form();
            return $this->output;
		}




        
    }

?>