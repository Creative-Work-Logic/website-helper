<?php

    class clsMenu{
        use trtBasic;

        private $data=array();
        
        function __construct(){
            //print "\n ff=> \n";   
            
		}

        private function XXX(){
            return "Hello";
        }
                              

        public function Pre_Menu(){
			
		}

        public function Menu_Base(){
            //echo"\n ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //print($this->cls->clsSession->get_guid());
            $this->Update_All_Vars();
            $guid=$this->cls->clsSession->get_guid();
            
            //$this->cls->clsLinks->Setup_Domain();
            //print "\n ff=> \n";
            if(isset($this->var['domain_user'])){
                if(count($this->var['domain_user'])==0){
                    if(isset($this->var['domain']["original_db"])){
                        $domain_name=$this->var['domain']["original_db"]['Name'];
                        $SEOFriendly=$this->var['domain']["original_db"]['SEOFriendlyLT'];
                    }else{
                        $domain_name=$this->var['domain']["db"]['Name'];
                        $SEOFriendly=$this->var['domain']["db"]['SEOFriendlyLT'];
                    }
                    
                    if(!isset($_SESSION['administratorsID'])) $_SESSION['administratorsID']=0;
                    if(!isset($_SESSION['membersID'])) $_SESSION['membersID']=0;
                    //print_r($_SESSION);
                    if($_SESSION['membersID']>0){
                        $member_type=37;
                        $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                    }else{
                        $member_type=36;
                        $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                    }
            
                    $menu_hide_sql=" Menu_HideLT=13 AND ";
                    $side_menu_sql=" AND content_pages.parentID=0";
                    if($this->var['content']['db']['domainsID']==0){
                        $admin_menu_sql=" AND domainsID=0";
                        
                    }else{
                        $admin_menu_sql=" AND domainsID=".$this->var['domain']["db"]['id'];
                    }
                    
                    
                    $sql="SELECT URI AS uri,MenuTitle AS menutitle,id AS content_pagesid FROM content_pages WHERE ".$menu_hide_sql." ";
                        $sql.=$exposure." AND languagesID=".$this->var['content']['db']['languagesid']." ".$admin_menu_sql." ".$side_menu_sql." ORDER BY Sort_Order";
                    
                    $rslt=$this->db->RawQuery($sql);
                    $first=true;
                    $this->var['menu']['spacers']="|";
                    if($this->db->NumRows($rslt)>0){
                        
                    
                        while($data=$this->db->Fetch_Assoc($rslt)){
                            // show spacers in menu
                            if($this->var['menu']['spacers']){
                                if($first){
                                    $first=false;
                                    $data['first']=true;
                                }else{
                                    $data['first']=false;
                                }
                            }else{
                                // no show spacers in menu
                                $data['first']=true;
                            }
                            if($domain_name=='install.me'){
                                $base_address='/';
                            }else{
                                $base_address='http://'.$domain_name;
                            }
                            
                            if($SEOFriendly==13){
                                $data['link_address']=$this->cls->clsLinks->Create_Content_Pages_Link($data["content_pagesid"]);
                                //$data['link_address']=$base_address.$this->var['app']['ROOTDIR'].'index.php?guid='.$guid.'&cpid='.$data["content_pagesid"];
                            }else{
                                //echo"\n JJJ \n";
                                if(!isset($data["uri"])) $data["uri"]="";
								$new_link=$this->cls->clsLinks->Create_SEO_Friendly_Link($data["uri"]);
                                $data['link_address']=$new_link;
                                //$data['link_address']=$base_address.$data["uri"];
                            }
                            $this->var['menu']["db"][]=$data;
                            
                        }
                    }
                }else{
                    
                    $data=array();
                    $data['first']=true;
                    $data['link_address']='http://'.$this->var['domain']["db"]['Name'];
                    $data["menutitle"]="Directory Home";
                    $this->var['menu']["db"][]=$data;
                    
                }
            }
            if(isset($this->var['menu'])){
                return $this->var['menu'];
            }else{
                return null;
            }
            
        }

        public function Vertical_Menu_Base(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            $this->var=&clsClassFactory::$vrs;
            $guid=$this->cls->clsSession->get_guid();
            if(isset($this->var['domain_user'])){
                if(count($this->var['domain_user'])==0){
                    
                    if(isset($this->var['domain']["original_db"])){
                        $domain_name=$this->var['domain']["original_db"]['Name'];
                        if(isset($this->var['domain']["original_db"]['SEOFriendlyLT'])){
                            $SEOFriendly=$this->var['domain']["original_db"]['SEOFriendlyLT'];
                        }else{
                            $SEOFriendly="";
                        }
                    }else{
                        
                    //
                    //print_r($this->var['domain']["db"]);
                    //print "-123-".$this->var['domain']["db"]['SEOFriendlyLT']."--";
                        $domain_name=$this->var['domain']["db"]['Name'];
                        if(isset($this->var['domain']["db"]['SEOFriendlyLT'])){
                           
                            
                            $SEOFriendly=$this->var['domain']["db"]['SEOFriendlyLT'];
                            
                        }else{
                            
                            $SEOFriendly="";
                        }
                        
                    }
                    //print "--".$SEOFriendly."--";
                    
                    $side_menu_sql="";
                    $menu_hide_sql=" Menu_HideLT=13 AND ";
                    $group_by="GROUP BY URI";
                    if(!isset($_SESSION['membersID'])) $_SESSION['membersID']=0;
                    
                    if($_SESSION['membersID']>0){
                        $member_type=37;
                        $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                    }else{
                        $member_type=36;
                        $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                    }
                    if($this->var['content']['db']['domainsID']==0){
                        $admin_menu_sql="AND domainsID=0";
                    }else{
                        $admin_menu_sql="AND domainsID=".$this->var['domain']["db"]['id']." ";
                    }
                    
                    $sql="SELECT URI AS uri,MenuTitle AS menutitle,id AS content_pagesid FROM content_pages WHERE Menu_HideLT=13 AND ".$exposure." ".$side_menu_sql." ".$admin_menu_sql." ORDER BY Sort_Order;";
                    //print $sql;	
                    //$rslt=$this->db->RawQuery($sql);
                    $first=true;
                    //$row_count=$this->db->NumRows($rslt);
                    
                    $this->var['menu']['spacers']='<br>';
                    //print "\n ZZZ=>".$sql." | ".$this->var['content']['db']['id']." \n | XX3-> |  \n";
                    $sub_menu_source=$this->RecursiveMenuUp($this->var['content']['db']['id'],$member_type);
                    $pages=$this->RecursiveMenuDown($sub_menu_source,$member_type);
                    //print "\n  ||2XX->".$sub_menu_source." | ".var_export($pages,true)." \n";
                   // print "--".$SEOFriendly."--";
                    foreach($pages as $key=>$val){
                        if(is_array($val)){
                            $data["menutitle"]=$val['menutitle']." ".$this->var['menu']['spacers'];
                            
                            if($SEOFriendly==13){
                                $data['link_address']='http://'.$domain_name.$this->var['app']['ROOTDIR'].'index.php?guid='.$guid.'&cpid='.$val["content_pagesID"];
                                //$data['link_address']=$val['content_pagesID'];
                            }else{
                                $data['link_address']=$val['uri'];
                            }
                            
                            $this->var['menu']["vb"][]=$data;
                        }
                        
                    }
                    
                }else{
                    
                    $data=array();
                    $data['first']=true;
                    $data['link_address']='http://'.$this->var['domain']["db"]['Name'];
                    $data["menutitle"]="Directory Home";
                    $this->var['menu']["vb"][]=$data;
                    
                }
            }
        
            //print_r($this->var['menu']);
            return $this->var['menu'];
        }

        public function RecursiveMenuUp($current_pageID,$member_type=37){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //$member_type="Public";
            $exposure="(ExposureLT='".$member_type."' OR ExposureLT='38')";
            //$sql="SELECT id AS content_pagesID,parentID FROM content_pages WHERE Menu_Hide='No' AND ".$exposure." AND id='".$current_pageID."' ORDER BY Sort_Order;";
            $sql="SELECT id AS content_pagesID,parentID FROM content_pages WHERE  ".$exposure." AND id='".$current_pageID."' ORDER BY Sort_Order;";
            //print $sql;
            //print "\n KKK00=>".$sql."-- \n";
            $rslt=$this->db->RawQuery($sql);
            $row_count=$this->db->NumRows($rslt);
            $origin_pageID=0;
            //if($row_count>0){
                //print "\n KKK00000=>".$origin_pageID."--".$row_count." \n";
                while($data=$this->db->Fetch_Assoc($rslt)){
                    if($data['parentID']==0){
                        $origin_pageID=$data['content_pagesID'];
                        //print "\n KKK1=>".$origin_pageID."-- \n";
                    }else{
                        $origin_pageID=$this->RecursiveMenuUp($data['parentID'],$member_type);
                        //print_r($data);
                        //print "\n KKK2=>".$origin_pageID."-- \n";
                    }            
                }
            //}
            
                
            return $origin_pageID;
        }

        public function RecursiveMenuDown($current_pageID,$member_type=37){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //print "\n 66778=>".$current_pageID." | ".$member_type."\n";
            //$member_type="Public";
            /*
            $pages=array();
            $sub_array=array();
            
            $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
            $sql="SELECT URI AS uri,MenuTitle AS menutitle,id AS content_pagesID,parentID FROM content_pages WHERE Menu_HideLT=13 AND ".$exposure." AND parentID='".$current_pageID."' ORDER BY Sort_Order;";
            $rslt=$this->db->RawQuery($sql);
            $num_rows=$this->db->NumRows($rslt);
            //$data=$this->db->Fetch_Assoc($rslt);
            //print "\n uu=>".$num_rows." ||3XX->".$sql." | ".var_export($data,true)." \n";
            
            if($num_rows>0){// cant find page so load homepage for language/site
                //$data=$this->db->Fetch_Assoc($rslt);
                while($data=$this->db->Fetch_Assoc($rslt)){
                //foreach($data as $key=>$val){
                    $pages[] =$data;
                    print "\n ".$row_count." ||3XX->".$sql." | ".var_export($data,true)." \n";
                    $sub_array=$this->RecursiveMenuDown($data['content_pagesID'],$member_type);
                    foreach($sub_array as $key2=>$val2){
                        $pages[] = $val2;//array_merge($sub_array, $data);
                    }
                }
            }
            */
            
            $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
            $sql="SELECT URI AS uri,MenuTitle AS menutitle,id AS content_pagesID,parentID FROM content_pages WHERE Menu_HideLT=13 AND ".$exposure." AND parentID='".$current_pageID."' ORDER BY Sort_Order";
            
            $rslt=$this->db->RawQuery($sql);
            $row_count=$this->db->NumRows($rslt);
            
            $pages=array();
            $sub_array=array();
            
            $data=$this->db->Fetch_Multi_Assoc($rslt);
            //print " \n DCount".$row_count." | ".$sql." \n";
            
            //while($data=$this->db->Fetch_Assoc()){
            foreach($data as $key=>$val){
                //$pages[] =$data;
                //print "\n ".$row_count." ||3XX->".$sql." | ".var_export($val,true)." \n";
                $pages[] =$val;
                //$sub_array=$this->RecursiveMenuDown($data['content_pagesID'],$member_type);
                $sub_array=$this->RecursiveMenuDown($val['content_pagesID'],$member_type);
                $pages=array_merge($pages, $sub_array);
                /*
                foreach($sub_array as $key2=>$val2){
                    //$pages[] = $val2;//array_merge($sub_array, $data);
                    $pages[] = array_merge($sub_array, $data);
                }
                    */
            }
            
            
            return $pages;
            
        }

        public function Vertical_Menu_Base_New(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            $this->var=$this->var;
            /*
            $this->var['menu']=array();
            
            
            //$this->var['domain_user']=$this->var['domain_user'];
            $this->var['domain']=$this->vrs->domain_data;
            $this->var['content']=$this->vrs->content_data;
            $this->var['app']=$this->vrs->content_data;
            */
            //$this->var['domain_user']=$this->data['domain_user_data'];
            //$this->var['domain']=$this->vrs->domain_data;
            //$this->var['content']=$this->data['content_data'];
            //$this->var['app']=$this->vrs->content_data;

            if(count($this->var['domain_user'])==0){
                if(isset($this->var['domain']["original_db"])){
                    $domain_name=$this->var['domain']["original_db"]['Name'];
                    $SEOFriendly=$this->var['domain']["original_db"]['SEOFriendlyLT'];
                }else{
                    $domain_name=$this->var['domain']["db"]['Name'];
                    $SEOFriendly=$this->var['domain']["db"]['SEOFriendlyLT'];
                }
                $side_menu_sql="";
                $menu_hide_sql=" Menu_HideLT=13 AND ";
                $group_by="GROUP BY URI";
                
                if(!isset($_SESSION['administratorsID'])) $_SESSION['administratorsID']=0;
                if(!isset($_SESSION['membersID'])) $_SESSION['membersID']=0;
                
                if($_SESSION['membersID']>0){
                    $member_type=36;
                    $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                }elseif($_SESSION['administratorsID']>0){
                    $member_type="Admin";
                    $exposure="ExposureLT='".$member_type."'";
                }else{
                    $member_type=37;
                    $exposure="(ExposureLT='".$member_type."' OR ExposureLT=38)";
                }
                
                if($this->var['content']['db']['domainsID']==0){
                    $admin_menu_sql="AND domainsID=0";
                }
                $sql="SELECT URI AS uri,MenuTitle AS menutitle,id AS content_pagesid FROM content_pages WHERE Menu_HideLT=13 AND ".$exposure." ".$side_menu_sql." ".$admin_menu_sql." ORDER BY Sort_Order;";
                $rslt=$this->db->RawQuery($sql);
                $first=true;
                $row_count=$this->db->NumRows($rslt);
                
                $this->var['menu']['spacers']="<br>";
                while($data=$this->db->Fetch_Assoc($rslt)){
                    // show spacers in menu
                    if($this->var['menu']['spacers']){
                        if($first){
                            $first=false;
                            $data['first']=true;
                        }else{
                            $data['first']=false;
                        }
                    }else{
                        // no show spacers in menu
                        $data['first']=true;
                    }
                    
                    if($SEOFriendly=="No"){
                        $data['link_address']='http://'.$domain_name.$this->var['app']['ROOTDIR'].'index.php?guid=1&cpid='.$data["content_pagesid"];
                    }else{
                        $data['link_address']='http://'.$domain_name.$data["uri"];
                    }
                    $this->var['menu']["vb"][]=$data;
                }
            }else{
                $data=array();
                $data['first']=true;
                $data['link_address']='http://'.$this->var['domain']["db"]['Name'];
                $data["menutitle"]="Directory Home";
                $this->var['menu']["vb"][]=$data;
            }
            
            return $this->var['menu'];
        }

        public function Horizontal_Install(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //include($this->var['app']['MODULEBASEDIR']."menu/menu_base.php");
            $this->var['menu']=$this->Menu_Base();
            //print_r($this->var['menu']);
            $output_data="";
            foreach($this->var['menu']["db"] as $key=>$val){
                if($this->var['menu']['spacers']){
                    if($val['first']==false){
                        $output_data.=' | ';
                    }
                }
                $output_data.='<a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'"><span>'.$val["menutitle"].'</span></a>';
            }
            
            return $output_data;
        }

        public function Horizontal_Rounded_Install(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //include($this->var['app']['MODULEBASEDIR']."menu/menu_base.php");
            $this->var['menu']=$this->Menu_Base();
            //print_r($this->var['menu']);
            $output_data="";
            if(isset($this->var['menu']["db"])){
                foreach($this->var['menu']["db"] as $key=>$val){
                    if($this->var['menu']['spacers']){
                        if($val['first']==false){
                            $output_data.=' | ';
                        }
                    }
                    $output_data.='<a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'"><span>'.$val["menutitle"].'</span></a>';
                }
            }
            
            return $output_data;
        }
        

        public function Horizontal_Rounded(){
            
            $output_data="";
            
            //include($this->var['app']['MODULEBASEDIR']."menu/menu_base.php");
            $this->var['menu']=$this->Menu_Base();
            //print_r($this->var['menu']);
            $output_data="";
            $this->var['menu']['spacers']="|";
            if(isset($this->var['menu']["db"])){
                foreach($this->var['menu']["db"] as $key=>$val){
                    if($this->var['menu']['spacers']){
                        if($val['first']==false){
                            $output_data.=' | ';
                        }
                    }
                    if(!isset($val["menutitle"])) $val["menutitle"]="";
                    $output_data.='<a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'"><span>'.$val["menutitle"].'</span></a>';
                }
            }
            //echo"\n -FFF2---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            
            return $output_data;
        }

        public function Horizontal(){

        }

        public function LI_Menu(){
            //echo"\n ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //include($this->var['app']['MODULEBASEDIR']."menu/menu_base.php");
            $this->var['menu']=$this->Menu_Base();
            //print_r($this->var['menu']["db"]);
            $output_data="";
            foreach($this->var['menu']["db"] as $key=>$val){
                if($val['first']==false){
                    $output_data.=' | ';
                }
                $output_data.='<li><a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'"><span>'.$val["menutitle"].'</span></a></li>';
            }
            
            return $output_data;
        }
        public function LI_Rounded(){

        }
        public function LI(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            //include($this->var['app']['MODULEBASEDIR']."menu/menu_base.php");
            $this->var['menu']=$this->Menu_Base();
            //print_r($this->var['menu']);
            $output_data="";
            foreach($this->var['menu']["db"] as $key=>$val){
                if($this->var['menu']['spacers']){
                    if($val['first']==false){
                        $output_data.=' | ';
                    }
                }
                $output_data.='<li><a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'">'.$val["menutitle"].'</a></li>';
            }
            
            return $output_data;
        }

        public function Vertical_Sub_Page(){
            //echo"\n -QQ---Class=>".__CLASS__."--Method=>".__METHOD__."---------------------------------------------------------------------\n";
            $show_side_menu=true;
            //include($this->var['app']['MODULEBASEDIR']."menu/vertical_menu_base.php");
            $this->var['menu']=$this->Vertical_Menu_Base();
            //print_r($this->var['menu']);
            //print $sql;
            $output_data="";
            if(isset($this->var['menu']["vb"])){
                foreach($this->var['menu']["vb"] as $key=>$val){
                    if($this->var['menu']['spacers']){
                        if(isset($val['first'])){
                            if($val['first']==false){
                                $output_data.='<br>';
                            }
                        }
                        
                    }
                    $output_data.='<a id="link-item-id" class="link-item-cl" href="'.$val['link_address'].'"><span class="link-item-cl">'.$val["menutitle"].'</span></a>';
                }
                //print $output_data;
            }
            
            return $output_data;
        }

    }