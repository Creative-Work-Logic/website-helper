<?php

    class clsStatistics{
        use trtBasic;
        //class clsStatistics{
        private $size_data=array();
        private $size_total=0;
        private $time_data=array();
        private $time_taken_data=array();

        private $time_interval_data=array();
        private $time_interval_location_sample=array();
        private $time_interval_data_count=0;

        
        

        function __construct(){
            //parent::__construct();
            //echo "hello world jjj";
            $this->start_interval_timer();
		}
        
        public function test_output(){
            //echo "hello world";
        }

        public function start_timer($time_tag){
            //$this->time_data[$time_tag]=hrtime();
            if (function_exists('hrtime')) {
                $this->time_data[$time_tag]=hrtime(true);
            }else{
                $this->time_data[$time_tag]=microtime(true);
            }
            //microtime
        }

        public function start_interval_timer(){
            //$time_tag=0;
            //$this->time_interval_data_count=$time_tag;
            if (function_exists('hrtime')) {
                $this->time_interval_data[]=hrtime(true);
            }else{
                $this->time_interval_data[]=microtime(true);
            }
            $this->time_interval_data_count=0;
        }

        public function take_time_sample($location_sample=""){
            /*
            if(!isset($this->time_interval_data[$this->time_interval_data_count])){
                $this->time_interval_data[$this->time_interval_data_count]=0;
                $this->time_interval_data[$this->time_interval_data_count]=hrtime();
            }
            */
            
            if (function_exists('hrtime')) {
                $time=hrtime(true);
            }else{
                $time=microtime(true);
            }
            if(isset($this->time_interval_data[$this->time_interval_data_count])){
                $previous_timestamp=$this->time_interval_data[$this->time_interval_data_count];
                //print("\n xx1 \n".$previous_timestamp);
            }else{
                $previous_timestamp=$time;
                //print("\n xx2 \n".$previous_timestamp);
            }
            //print_r($time);
            //print("\n xx".$this->time_interval_data_count);
            
            //$this->time_interval_data_count++;
            $this->time_interval_data[$this->time_interval_data_count]=$time;
            $this->time_interval_location_sample[$this->time_interval_data_count]=$location_sample;
            $this->time_interval_data_count++;
        }

        public function retrieve_time_samples(){
            $return_array=array($this->time_interval_data,$this->time_interval_location_sample,$this->size_data,$this->size_total);
            return $return_array;
        }

        public function end_timer($time_tag){
            if (function_exists('hrtime')) {
                $this->time_taken_data[$time_tag]=hrtime()-$this->time_data[$time_tag];
            }else{
                $this->time_taken_data[$time_tag]=microtime()-$this->time_data[$time_tag];
                //$time=microtime(true);
            }
            
        }

        public function size_data($size_tag,$size){
            //print ("\n ".$size_tag."GG2255 Total Size->".$size." \n".$this->size_total);
            $this->size_data[][$size_tag]=$size;
            $this->size_total+=$size;
        }
/*
        function generate_size_tag(){
            $this->size_data[$size_tag]=$size;
        }
*/
        

public function variable_size_data($size_tag,$variable_array=array()){
            $serialized = serialize($variable_array);
            $size = strlen($serialized); // or mb_strlen($serialized, '8bit')
            
            $this->size_data[$size_tag]=$size;
        }
    }
