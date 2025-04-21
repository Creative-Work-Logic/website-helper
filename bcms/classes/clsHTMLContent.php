<?php

    class clsHTMLContent{
        use trtBasic;

        var $table_array=array();
        var $table_span_array=array();
        var $item_list=array();
        public $Current_Page=0;
        
        function __construct(){
			
			
		    }

        public function get_any_function(){
			
			      $return_class_array=array();
            $return_class_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("list_classes","Assoc",array("*"));
            
            $return_method_array=array();
            $return_method_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("list_class_methods","Assoc",array("*"));
            
		    }
        /*
          ==========================================================================
          Page add / list / edit
          ==========================================================================
        */
        public function create_page_fields($searchID=0){
          $return_output=array();
          $method_type=array("page");
          $item_titles=array();
          $item_input_array=array();
          $item_input_type_array=array();
          $item_input_type_variables=array();


          $item_titles=array("URI","Title","Menu Title","Language","Template","Exposure","Menu Hide","Home Page","Sort Order","Parent Page");
          $item_input_array=array("URI"=>"URI","Title"=>"Title","Menu Title"=>"MenuTitle","Language"=>"LanguagesID"
          ,"Exposure"=>"ExposureLT","Home Page"=>"HomePageLT",
            "Sort Order"=>"Sort_Order","Parent Page"=>"ParentID","select"=>"id");
          $item_input_type_array=array("URI"=>"text_box","Title"=>"text_box","Menu Title"=>"text_box"
            ,"Language"=>"drop_down","Exposure"=>"drop_down","Home Page"=>"drop_down",
            "Sort Order"=>"text_box","Parent Page"=>"drop_down","select"=>"link");
            if($searchID>0){
              $item_input_defaults=array("method"=>"get_input_defaults","searchID"=>$searchID,
              'method_type'=>$method_type,'input_values'=>$item_input_array);
            }

            
            $item_input_type_variables=array("URI"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"uriID",'name'=>"uri_name")
            ,"Title"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"titleID",'name'=>"title_name"),
            "Menu Title"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"menu_titleID",'name'=>"menu_title_name")
            ,"Language"=>array("method"=>"get_languages",'id'=>"lanuagesID",'name'=>"lanuagesID"),
            "Template"=>array("method"=>"get_templates",'id'=>"TemplatesID",'name'=>"TemplatesID"),
            "Exposure"=>array("method"=>"get_group_items","group_code"=>"item_groups_page_exposureID",'id'=>"Exposure",'name'=>"Exposure"),
            "Menu Hide"=>array("method"=>"get_group_items","group_code"=>"item_groups_Boolean_ModalID",'id'=>"Menu_Hide",'name'=>"Menu_Hide"),
            "Home Page"=>array("method"=>"get_group_items","group_code"=>"item_groups_Boolean_ModalID",'id'=>"Home_Page",'name'=>"Home_Page"),
            "Sort Order"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"sort_order",'name'=>"sort_order")
            ,"Parent Page"=>array("method"=>"get_page_lineage",'id'=>"parentID",'name'=>"parentID"),
            "select"=>array("method"=>"get_links",'type'=>"a",'id'=>"edit_id",'name'=>"edit_name"
            ,"href"=>"/management-page-modify/id='.$searchID.'/","title"=>"edit"));
            $return_output=array("item_titles"=>$item_titles,"item_inputs"=>$item_input_array,
            "item_input_types"=>$item_input_type_array,"item_input_type_variables"=>$item_input_type_variables);
            return $return_output;
        }

        public function create_add_domain_fields($searchID=0){
          $return_output=array();
          $method_type=array("page");
          $item_titles=array();
          $item_input_array=array();
          $item_input_type_array=array();
          $item_input_type_variables=array();


          $item_titles=array("Name","Site Title","Client","Template","Server","Mirror","Public","SEO Friendly");
          
            if($searchID>0){
              $item_input_defaults=array("method"=>"get_input_defaults","searchID"=>$searchID,
              'method_type'=>$method_type,'input_values'=>$item_input_array);
            }

            
            $item_input_type_variables=array("Name"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"Name",'name'=>"Name"),
            "Site Title"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"SiteTitle",'name'=>"SiteTitle"),
            "Client"=>array("method"=>"get_clients",'type'=>"text",'id'=>"ClientsID",'name'=>"ClientsID"),
            "Template"=>array("method"=>"get_templates",'id'=>"TemplatesID",'name'=>"TemplatesID"),
            "Server"=>array("method"=>"get_servers",'id'=>"ServersID",'name'=>"ServersID"),
            "Mirror"=>array("method"=>"get_mirrors",'id'=>"MirrorsID",'name'=>"MirrorsID"),
            "Public"=>array("method"=>"get_group_items","group_code"=>"item_groups_Boolean_ModalID",'id'=>"PublicLT",'name'=>"PublicLT"),
            "SEO Friendly"=>array("method"=>"get_group_items","group_code"=>"item_groups_Boolean_ModalID",'id'=>"SEOFriendlyLT",'name'=>"SEOFriendlyLT"),
            );
            $return_output=array("item_titles"=>$item_titles,"item_input_type_variables"=>$item_input_type_variables);
            return $return_output;
        }

        public function create_modify_templates_fields($searchID=0){
          $return_output=array();
          $method_type=array("page");
          $item_titles=array();
          $item_input_array=array();
          $item_input_type_array=array();
          $item_input_type_variables=array();


          $item_titles=array("Name","Edit");
          
            if($searchID>0){
              $item_input_defaults=array("method"=>"get_input_defaults","searchID"=>$searchID,
              'method_type'=>$method_type,'input_values'=>$item_input_array);
            }

            
            $item_input_type_variables=array("Name"=>array("method"=>"Create_Label",'type'=>"text",'id'=>"Name",'name'=>"Name"),
            
            "Edit"=>array("method"=>"Create_Label",'type'=>"text",'id'=>"edit_id",'name'=>"edit_name")
            );
            $return_output=array("item_titles"=>$item_titles,"item_input_type_variables"=>$item_input_type_variables);
            return $return_output;
        }

        public function create_add_member_fields($searchID=0){
          $return_output=array();
          $method_type=array("page");
          $item_titles=array();
          $item_input_array=array();
          $item_input_type_array=array();
          $item_input_type_variables=array();


          $item_titles=array("First Name","Last Name","Email","User Level","Client","User Types","User Account Types");
          
            if($searchID>0){
              $item_input_defaults=array("method"=>"get_input_defaults","searchID"=>$searchID,
              'method_type'=>$method_type,'input_values'=>$item_input_array);
            }

            
            $item_input_type_variables=array("First Name"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"First_Name",'name'=>"First_Name"),
            "Last Name"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"Last_Name",'name'=>"Last_Name"),
            "Email"=>array("method"=>"get_text_box",'type'=>"text",'id'=>"Email",'name'=>"Email"),
            "User Level"=>array("method"=>"get_group_items","group_code"=>"mod_user_levelsID",'id'=>"User_LevelID",'name'=>"User_LevelID"),
            "Client"=>array("method"=>"get_clients",'type'=>"text",'id'=>"ClientsID",'name'=>"ClientsID"),
            "User Types"=>array("method"=>"get_group_items","group_code"=>"item-groups-user-typesID",'id'=>"PublicLT",'name'=>"PublicLT"),
            "User Account Types"=>array("method"=>"get_group_items","group_code"=>"item-groups-user-account-typesID",'id'=>"SEOFriendlyLT",'name'=>"SEOFriendlyLT"),
            );
            $return_output=array("item_titles"=>$item_titles,"item_input_type_variables"=>$item_input_type_variables);
            return $return_output;
        }

        public function create_modify_template_form_fields(){
          $html_output="";
          $page_items=array();
          $page_items=$this->create_modify_templates_fields();
          $out=array();
          //print_r($page_items);
          foreach($page_items['item_titles'] as $item_titles){
            //print "IT=>".$item_titles." \n";
            //print "II=>".$page_items['item_inputs'][$item_titles]." \n";
           // print "IIT=>".$page_items['item_input_types'][$item_titles]." \n";
            //print "IITV=>".$page_items['item_input_type_variables'][$item_titles]." \n";
            $current=$page_items['item_input_type_variables'][$item_titles];
            //$out[$item_titles]=$this->cls->clsHTMLItemFunctions->get_test($current);//$current['method'];
            
            //print $current['method'];
          }
          //$where_array=array(),$order_by="",$max_rows=0,$page_number=1
          if(isset($_GET['page'])){
            $current_page=$_GET['page'];
          }else{
            $current_page=0;
          }
          $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("templates","Assoc",array("id","Name"),array(),"Name",10,$current_page);
          
          $html_output=$this->cls->clsHTMLItems->get_form_modify_output($page_items['item_titles'],$out,$return_array);
          //print_r($out);
          //print $html_output;
          return $html_output;
      }

        public function create_add_domain_form_fields(){
          $html_output="";
          $page_items=array();
          $page_items=$this->create_add_domain_fields();
          $out=array();
          //print_r($page_items);
          foreach($page_items['item_titles'] as $item_titles){
            //print "IT=>".$item_titles." \n";
            //print "II=>".$page_items['item_inputs'][$item_titles]." \n";
           // print "IIT=>".$page_items['item_input_types'][$item_titles]." \n";
            //print "IITV=>".$page_items['item_input_type_variables'][$item_titles]." \n";
            $current=$page_items['item_input_type_variables'][$item_titles];
            $out[$item_titles]=$this->cls->clsHTMLItemFunctions->get_test($current);//$current['method'];
            
            //print $current['method'];
          }
          $html_output=$this->cls->clsHTMLItems->get_form_output($page_items['item_titles'],$out);
          //print_r($out);
          //print $html_output;
          return $html_output;
      }

      public function create_add_member_form_fields(){
        $html_output="";
        $page_items=array();
        $page_items=$this->create_add_member_fields();
        $out=array();
        //print_r($page_items);
        foreach($page_items['item_titles'] as $item_titles){
          //print "IT=>".$item_titles." \n";
          //print "II=>".$page_items['item_inputs'][$item_titles]." \n";
         // print "IIT=>".$page_items['item_input_types'][$item_titles]." \n";
          //print "IITV=>".$page_items['item_input_type_variables'][$item_titles]." \n";
          $current=$page_items['item_input_type_variables'][$item_titles];
          $out[$item_titles]=$this->cls->clsHTMLItemFunctions->get_test($current);//$current['method'];
          
          //print $current['method'];
        }
        $html_output=$this->cls->clsHTMLItems->get_form_output($page_items['item_titles'],$out);
        //print_r($out);
        //print $html_output;
        return $html_output;
    }
   

        public function create_add_page_form_fields(){
          $html_output="";
          $page_items=array();
          $page_items=$this->create_page_fields();
          $out=array();
          //print_r($page_items);
          foreach($page_items['item_titles'] as $item_titles){
            //print "IT=>".$item_titles." \n";
            //print "II=>".$page_items['item_inputs'][$item_titles]." \n";
           // print "IIT=>".$page_items['item_input_types'][$item_titles]." \n";
            //print "IITV=>".$page_items['item_input_type_variables'][$item_titles]." \n";
            $current=$page_items['item_input_type_variables'][$item_titles];
            $out[$item_titles]=$this->cls->clsHTMLItemFunctions->get_test($current);//$current['method'];
            
            //print $current['method'];
          }
          $html_output=$this->cls->clsHTMLItems->get_form_output($page_items['item_titles'],$out);
          //print_r($out);
          //print $html_output;
          return $html_output;
      }
      /*
        public function create_add_page_form_fields(){
          $html_output="";

          $item_titles=array("URI","Title","Menu Title","Language","Template","Exposure","Menu Hide","Home Page","Sort Order","Parent Page");
          $item_input_array=array("URI"=>"text_Box","Title"=>"text_Box","Menu Title"=>"text_Box","Language"=>"text_Box"
          ,"Template"=>"text_Box","Exposure"=>"text_Box","Menu Hide"=>"text_Box","Home Page"=>"text_Box",
          "Sort Order"=>"text_Box","Parent Page"=>"text_Box");

          foreach($item_input_array as $key=>$val){
            $item_inputs[]=$this->Create_TextBox(array(),"");
          }

          
          $html_output=$this->get_form_output($item_titles,$item_inputs);

          return $html_output;
      }
      
      public function create_page_list(){
        $html_output="";
        

        $item_list_return=$this->create_page_list_array();

        $number_rows=count($item_input_array);
        //$number_rows=count($item_list_return);
        /*
        for($x=0;$x<$number_rows;$x++){
          $item_list["URI"]=$item_list_return[$x]["URI"];
          $item_list["Title"]=$item_list_return[$x]["Title"];
          $item_list["MenuTitle"]=$item_list_return[$x]["MenuTitle"];
          $item_list["LanguagesID"]=$item_list_return[$x]["LanguagesID"];
          $item_list["ExposureLT"]=$item_list_return[$x]["ExposureLT"];
          $item_list["HomePageLT"]=$item_list_return[$x]["HomePageLT"];
          $item_list["Sort_Order"]=$item_list_return[$x]["Sort_Order"];
          $item_list["ParentID"]=$item_list_returns[$x]["ParentID"];
          $item_list["select"]='<a href="/management-page-modify/id='.$item_list_return[$x]["id"].'/">edit</a>';
          $item_array[$x]=$item_list;
        }
        *//*
        $item_count=0;
        foreach($item_input_array as $key=>$val){
          $item_list[$val]=$item_list_return[$item_count][$val];
          $item_array[$item_count]=$item_list;
          $item_count++;
        }
        $item_array=$item_list;
        
        

        //$html_output=$this->get_page_list_output($item_titles,$item_inputs,$this->item_list);
        $html_output=$this->get_all_list_output($item_titles,$item_inputs,$item_array);

        return $html_output;
    }
    
    public function get_page_edit_defaults($itemID){
        
      $html_output="";
      $return_array=array();
      $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("content_pages","Assoc",array("*"),array("id"=>$itemID));
      
      return $return_array;
  }

    public function create_page_list_array(){
        
      $html_output="";
      $return_array=array();
      $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("content_pages","Assoc",array("*"));
      
      return $return_array;
  }
  
      
        ==========================================================================
          Members add / list / edit
          ==========================================================================
         
        
        public function create_member_form_fields(){
            $html_output="";

            $item_titles=array("First Name","Last Name","Email");

            $item_inputs[]=$this->Create_TextBox(array(),"");
            $item_inputs[]=$this->Create_TextBox(array(),"");
            $item_inputs[]=$this->Create_TextBox(array(),"");

            $html_output=$this->get_form_output($item_titles,$item_inputs);

            return $html_output;
		    }

        public function create_members_list(){
          $html_output="";
          $item_list=array();
          $item_titles=array("First Name","Last Name","Email","Select");

          $this->item_list=$this->create_members_list_array();

          $html_output=$this->get_all_list_output($item_titles,$item_inputs,$item_list);

          return $html_output;
      }
      
      public function create_members_list_array(){
        
        $html_output="";
        $return_array=array();
        $return_accounts=array();
        $return_profile=array();
        $return_profile=$this->cls->clsDatabaseCRUD->Exec_Retrieve("mod_user_profile","Assoc",array("*"));
        $member_count=count($return_profile);
        //print_r($return_profile);
        if($member_count>0){
          
          for($x=0;$x<$member_count;$x++){
            
            //$return_profile[$x]['user_profileID']=$return_profile[$x]['id'];
            if(isset($return_profile[$x])){
              $mod_user_profileID=$return_profile[$x]['id'];
              
            }else{
              $mod_user_profileID=$return_profile['id'];
              
            }
            
            //$return_method_array=array();
            $where_array=array("mod_user_profileID"=>$mod_user_profileID);
            
            $return_accounts[$x]=$this->cls->clsDatabaseCRUD->Exec_Retrieve("mod_user_accounts","Assoc",array("*"),$where_array,"",1,0);
            //print_r($return_accounts);
            $return_accounts[$x]['mod_user_accountsID']=$return_accounts[$x]['id'];
            //$return_array[$x]=array_merge($return_profile[$x],$return_accounts[$x]);
            $return_array[$x]=array_merge($return_profile[$x],$return_accounts[$x]);
            
          }
          
        }
        
        

        return $return_array;
    }
    
    */
        
    }

