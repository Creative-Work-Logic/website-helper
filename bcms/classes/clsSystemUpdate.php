<?php

    class clsSystemUpdate{
        use trtBasic;
        var $class_inserted=array();
        var $class_list=array();
        var $class_db_return=array();
         
        function __construct(){
			
			
		}

        public function create_database_class_list()
        {
            $return_array=array();
            $this->class_list=clsClassFactory::$class_list;
            $count=0;
            foreach($this->class_list as $key=>$val){
                $count++;
                $class_return=$this->cls->clsDatabaseCRUD->Exec_Create("REPLACE","Assoc","list_classes",array("id"=>$count,"class_name"=>$val));
                $this->class_inserted[$val]=$count;//$class_return["new_insert_id"];
            }
            //print_r($this->class_inserted);
            return $this->class_inserted;
            
        }

        public function return_all_database_class_items()
        {
            $return_array=array();
            $this->class_list=clsClassFactory::$class_list;
            foreach($this->class_list as $key=>$class_name){
                $class_return=$this->return_database_class_item($class_name);
                $this->class_db_return[$class_name]=$class_return;
            }
            
            return $this->class_db_return;
            
        }

        public function return_database_class_item($class_name)
        {
            $return_array=array();
            $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("list_classes","Assoc",array("*"),array("class_name"=>$class_name));
            
            return $return_array;
            
        }

        public function create_database_class_methods_list()
        {
            $return_array=array();
            $list_classID=0;
            $class_count=0;
            $count=0;
            //print_r($this->class_list);
            foreach($this->class_list as $class_key=>$class_name){
                $class_count++;
                /*
                if(isset($this->class_inserted[$class_name])){
                    $list_classID=$this->class_inserted[$class_name];
                }else{
                    $return=$this->return_database_class_item($class_name);
                    if(isset($return['id'])){
                        $list_classID=$return['id'];
                    }
                    
                }
                    */
                
                $list_classID=$class_count;
                if($list_classID>0){
                    $methods= $this->cls->get_class_object($class_name);
                    //print_r($methods);
                    foreach($methods as $method_key=>$method_name){
                        $count++;
                        $class_return=$this->cls->clsDatabaseCRUD->Exec_Create("REPLACE","Assoc","list_class_methods",array("id"=>$count,"list_classID"=>$list_classID,"method_name"=>$method_name));
                        $this->class_inserted[$method_name]=$count;
                    }
                }
                
            }
            
            return $this->class_inserted;
            
        }


        public function return_all_database_class_methods()
        {
            $return_array=array();
            $class_count=0;
            $this->class_list=clsClassFactory::$class_list;
            foreach($this->class_list as $key=>$class_name){
                $class_count++;
                ///$class_return=$this->class_db_return[$class_name];
                $return_array[$class_name][]=$this->return_database_class_method($class_count);
            }
            
            return $return_array;
            
        }

        public function return_database_class_method($list_classID)
        {
            $return_array=array();
            $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("list_class_methods","Assoc",array("*"),array("list_classID"=>$list_classID));
            
            return $return_array;
            
        }
        
    }

