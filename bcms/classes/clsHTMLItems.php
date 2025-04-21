<?php

    class clsHTMLItems{
        use trtBasic;
        public $Current_Page=0;

        function __construct(){
			
			
		}

        
        public function get_form_inputs($input_type){
			
            switch($input_type){
          case "select":

          break;
          case "input":

          break;
          case "textarea":

          break;
          case "label":

          break;
      }
  }

  public function get_all_list_output($item_titles=array(),$items=array(),$item_list=array()){
			
    $html_output="";
    
    $td_output="";
    $tr_output="";
    $config=array("style"=>"border:1px solid black;");
    $count=0;
    foreach($item_titles as $key=>$val){
        
        $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TH(array("align"=>"center"),$val);
        //$td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TD(array(),$item_inputs[$count]);
        
        $count++;
    }
    $html_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR($config,$td_output);
    $all_items=array();
    $all_item_array=array();
    $all_items=$item_list;
    
    if(isset($members_items)){
      $all_count=count($all_items);
      for($x=0;$x<$all_count;$x++){
        $all_details=array();
        $all_details=$all_items[$x];
        $all_item_array[$x]=$all_details;
        $all_item_count=$all_count;
        $td_output="";
        
        //for($y=0;$y<$members_item_count;$y++){
        foreach($all_details as $key=>$val){
          //foreach($val as $type_key=>$type_val){
            //print_r($val);
            $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TD(array(),$val);
          //}
        }
        //print($td_output);
        $html_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR($config,$td_output);
      }
    }
    
    

    $button_output=$this->cls->clsHTMLTagCreate->Create_Button(array("type"=>"submit"),"Submit");
    $td_output=$this->cls->clsHTMLTagCreate->Create_Table_TD(array("colspan"=>$all_item_count,"align"=>"right"),$button_output);
    $html_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR($config,$td_output);
    $html_output=$this->cls->clsHTMLTagCreate->Create_Table($config,$html_output);
    $config=array("action"=>$_SERVER['REQUEST_URI'],"method"=>"post");
    $html_output=$this->cls->clsHTMLTagCreate->Create_Form($config,$html_output);
    return $html_output;
}

public function get_form_output($item_titles=array(),$item_inputs=array()){
			
  $html_output="";
  //print_r($item_titles);
  //print_r($item_inputs);
  
  $count=0;
  foreach($item_titles as $key=>$val){
      $td_output="";
      $tr_output="";
      $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TH(array("align"=>"right"),$val);
      $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TD(array(),$item_inputs[$val]);
      $tr_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR(array(),$td_output);
      $html_output.=$tr_output;
      $count++;
  }
  $button_output=$this->cls->clsHTMLTagCreate->Create_Button(array("type"=>"submit"),"Submit");
  $td_output=$this->cls->clsHTMLTagCreate->Create_Table_TD(array("colspan"=>2,"align"=>"right"),$button_output);
  $html_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR(array(),$td_output);
  $html_output=$this->cls->clsHTMLTagCreate->Create_Table(array("style"=>"border:1px solid black;"),$html_output);
  $action=$this->cls->clsLinks->Create_Form_Action();
  $config=array("action"=>$action,"method"=>"post");
  $html_output=$this->cls->clsHTMLTagCreate->Create_Form($config,$html_output);
  return $html_output;
}

public function get_form_modify_output($item_titles=array(),$item_inputs=array(),$list_items=array()){
			
  $html_output="";
  //print_r($item_titles);
  //print_r($item_inputs);
  
  $count=0;
  foreach($item_titles as $key=>$val){
      //$td_output="";
      $tr_output="";
      $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TH(array("align"=>"right"),$val);
      
      $count++;
  }
  $tr_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR(array(),$td_output);
      $html_output.=$tr_output;
      $target_uri=$this->cls->clsLinks->Create_Local_Link("Edit",1112,0);
      print $target_uri;
  foreach($list_items as $key=>$val){
    $td_output="";
    $tr_output="";
    //print_r($val);
    $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TD(array(),$val["Name"]);
    if($this->var['domain']["original_db"]['SEOFriendlyLT']==13){
        $link_target=$target_uri.'&id='.$val["id"];
    }else{
        $link_target=$target_uri.'?id='.$val["id"];
    }
    $target_url=$this->cls->clsLinks->Create_HTML_Link("edit",$link_target);
    $td_output.=$this->cls->clsHTMLTagCreate->Create_Table_TD(array(),$target_url);
    $tr_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR(array(),$td_output);
    $html_output.=$tr_output;
    $count++;
}
//print_r($list_items);
$all_pages=$list_items['details']['Total_Rows'];
$total_pages=(int)($all_pages/10);
for($x=0;$x<$total_pages;$x++){
  $button_output.=$this->cls->clsLinks->Create_Page_Link($x);
}
  $button_output.=$this->cls->clsHTMLTagCreate->Create_Button(array("type"=>"submit"),"Submit");
  
  $td_output=$this->cls->clsHTMLTagCreate->Create_Table_TD(array("colspan"=>2,"align"=>"right"),$button_output);
  $html_output.=$this->cls->clsHTMLTagCreate->Create_Table_TR(array(),$td_output);
  $html_output=$this->cls->clsHTMLTagCreate->Create_Table(array("style"=>"border:1px solid black;"),$html_output);
  $action=$this->cls->clsLinks->Create_Form_Action();
  $config=array("action"=>$action,"method"=>"post");
  $html_output=$this->cls->clsHTMLTagCreate->Create_Form($config,$html_output);
  return $html_output;
}

  function Create_Country_Select($countryID=0){
      
      $output="";
      $output='<SELECT NAME="countryID" id="countryID">';
      
      
      $sql=$this->db->rawQuery("SELECT id,Country_Name FROM countries");
      while($myrow=$this->db->Fetch_Array($sql)){
          if($countryID==$myrow[0]){
              $output.="<option value='".$myrow[0]."' selected>$myrow[1]</option>";
          }else{
              $output.="<option value='".$myrow[0]."'>".$myrow[1]."</option>";
          };
      }
      $output.="</SELECT>";
      
      return $output;
      
  }

  

  

        
    }

