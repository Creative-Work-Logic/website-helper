<?php

   class clsLog{
      use trtBasic;
      var $MessageArray=array();
      var $PriorityMessages=array();
      var $all_variables=array();
      var $all_class_methods=array();
      var $all_sql_commands=array();
      var $all_exceptions=array();
      var $log_standard_variables=array();
      var $output_level=5;

      var $unique_number=array();

      var $tag=array();      
      function __construct(){
         $this->add_tag("I_Am_Legend");
            
		}

      

   public function general($msg="",$num=0,$log_array=array()){
      
       $log_msg=array($num,$msg,var_export($log_array,true));
       if($num>=$this->output_level){
         if(!in_array($log_msg,$this->PriorityMessages)){
            $this->PriorityMessages[]=$log_msg;
         }
           
       }else{
         if(!in_array($log_msg,$this->MessageArray)){
           $this->MessageArray[]=$log_msg;
         }
       }
       
   }

   public function show_messages(){
      //print_r($this->MessageArray);
   }

   public function add_tag($value=""){
      $this->tag[]=$value;
      $this->add_message("add_tag",$value);
   }

   public function add_unique_number($number=0){
      $this->unique_number[]=$number;
      $this->add_message("add_unique_number",$number);
   }

   public function add_message($message_type="",$message_value=""){
      if(is_array($message_value)){
         $this->MessageArray[$message_type][]=var_export($message_value,true);
      }else{
         $this->MessageArray[$message_type][]=$message_value;
      }
      
   }
   public function debug_trace(){
      $output="";
      $output =var_export(debug_backtrace(),true);
      $this->add_message("debug_backtrace",$output);
   }
   public function add_static_variables(){
      $output="";
      $output = var_export(clsClassFactory::$vrs,true);//array_diff_assoc($this->all_variables, clsClassFactory::$vrs);
      //$this->all_variables[]=clsClassFactory::$vrs;
      //$this->all_variables[]=$output;
      //$this->log_standard_lines($output);

      $this->add_message("static_variables",$output);
   }

   public function add_class_method($class,$method){
      $output=array($class,$method);
      //$this->all_class_methods[]=$output;
      //$this->log_standard_lines($output);
      $this->add_message("class_method",$output);
   }
   
   
   public function add_sql_command($sql){
      $output=$sql;
      $this->add_message("sql_commands",$output);
      //$this->all_sql_commands[]=$output;
      //$this->log_standard_lines($output);
   }

   public function add_exception($e){
      $output=$e;
      $this->add_message("exception",$output);
      //$this->all_exceptions[]=$output;
      //$this->log_standard_lines($output);
   }

   public function add_error($error=""){
      $output=$error;
      $this->add_message("error",$output);
      //$this->all_exceptions[]=$output;
      //$this->log_standard_lines($output);
   }

   public function add_array($var_array=array()){
      $output=$var_array;
      $this->add_message("array",$output);
      //$this->all_exceptions[]=$output;
      //$this->log_standard_lines($output);
   }

   public function add_any($var_type="",$var_value="",$var_value_two=""){
      
      switch($var_type){
         case "array":
            $this->add_array($var_value);
         break;
         case "exception":
            $this->add_exception($var_value);
         break;
         case "sql_command":
            $this->add_sql_command($var_value);
         break;
         case "class_method":
            $this->add_class_method($var_value,$var_value_two);
         break;
         case "static":
            $this->add_static_variables();
         break;
         
      }
      //$this->add_message("array",$output);
      //$this->all_exceptions[]=$output;
      //$this->log_standard_lines($output);
   }

   public function set_logs($msg,$log_number,$current_class,$msg_two){
      $message_array=array($msg,$log_number,$current_class,$msg_two);
      $this->add_array($message_array);
   }
   
   public function user($msg,$num=1,$memberID=0,$member_name="") 
   { 
      
      $output=array("Msg"=>$msg,"Error_Code"=>$num,"memberID"=>$memberID,"member_name"=>$member_name);
      if($num>=3){
            $this->PriorityMessages[]=var_export($output,true);
      }else{
            $this->MessageArray[]=var_export($output,true);
      }
      $this->log_standard_lines($output);
   }

   public function log_standard_lines($msg) 
   { 
      /*
      $output=array();
      
      if(is_array($msg)){
         foreach($msg as $key=>$val){
            
            if(is_array($val)){
               $output[$key]=$this->recurse_array($val);
            }else{
               $output[$key]=$val;
            }
         }
         
      }else{
         $output["Start"]=$msg;
      }
   
      //$output=$this->recurse_array("Start",$msg);
      //$this->log_standard_variables=array_merge($this->log_standard_variables,$output);
      $this->log_standard_variables=array_merge($this->log_standard_variables,$output);
      */
   }

   public function display_all(){
      
      //print "\n PriorityMessages->".var_export($this->PriorityMessages,true);
      //print "\n MessageArray->".var_export($this->MessageArray,true);
      //print "\n all_variables->".var_export($this->all_variables,true);
      //print "\n all_class_methods->".var_export($this->all_class_methods,true);
      //print "\n all_sql_commands->".var_export($this->all_sql_commands,true);
      //print "\n all_exceptions->".var_export($this->all_exceptions,true);
      
      /*
      foreach($this->log_standard_variables as $key=>$val){
         print "\n ->".$val;

      }
         */
      
   }

   public function display_priority(){
      // print var_export($this->PriorityMessages,true);

   }

   
   public function display_normal(){
      //print var_export($this->MessageArray,true);

   }

   public function print_msg_arrays($msg) 
   { 
      //print($msg);
   }

   public function output_messages()
    {
      /*
      echo"--------------------All Logs-------------------------------<br><br>\n\n";
        
      
        
        echo"<pre>";
        if(count($this->PriorityMessages)>0){
            ///print_r($this->PriorityMessages);
         }
         echo"</pre>";
         */
    }
}