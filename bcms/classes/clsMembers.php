<?php

    class clsMembers{
        use trtBasic;
        
        function __construct(){
            
            
		}

        

        

        
        public function Pre_LogOut(){
            //exit();
            session_start();
            session_destroy();
            $Message="You are logged out";
            //print $Message;
            $location_action=$this->cls->clsContent->Get_Location_Target();
            header("Location: ".$location_action);
        }

        public function LogOut(){
            $Message="You are logged out";
            print $Message;
            return $Message;
        }

        
        public function Pre_Login(){
            //print "\n HHH55 \n";
            if(isset($_POST['Submit'])){
                if($_POST['Submit']){
                    
                    $user_details=$this->Check_Login($_POST['username'],$_POST['password']);
                    if(count($user_details)>0){
                        //$return_array=array("details"=>$data_user_details,"accounr"=>$data_user_account,"level"=>$data_user_level,"profile"=>$data_user_profile);
                        //$this->log->general('Member Login Checked-',1);
                        $_SESSION['member_array']=$user_details;
                        $_SESSION['membersID']=$user_details["account"]['id'];
                        clsClassFactory::$cf_cls->clsSession->session_set_globals();
                        //print "\n HHH55 \n";
                        //PRINT_R($_SESSION);
                        /*
                        if(isset($_SESSION['PAGENAME'])){
                            $destination=$_SESSION['PAGENAME'];
                        }else{
                            $destination="/members/home/";
                        }
                        header("Location: ".$destination);
                        */ 
                        $this->Message="Logged In";
                    }else{
                        $this->Message="Incorrect Email Or Password";
                    }
                }
            }else{
                //$this->Message="Incorrect Email Or Password";
            }
            //clsSystem::$vars->Message=$this->Message;
            $this->output=$this->Message;
            return $this->output;
        }
        
        
        public function Member_Register(){
            
            $this->output=$this->cls->clsFormCreator->Member_Register_Form();
            return $this->output;
        }


        public function Member_Login(){
            //print "\n DDD";
            //$this->cls->clsLinks->Setup_Domain();
            if(isset($_SESSION['membersID'])){
                if($_SESSION['membersID']){
                    $membersID=$_SESSION['membersID'];
                    $loggin=true;
                }else{
                    $loggin=false;
                }
            }else{
                $loggin=false;
            }
            
            if($loggin){
                //$text_data['debug'][]="loged in";
                //print "You are now logged in!!!";

            }else{
                $this->var['domain']['debug'][]="show log in";
                //print "xxx".$this->Message;
                $this->output=$this->Message;
                //$this->output.=$this->cls->clsFormCreator->Create_Login_Form();
                
                $this->output.='
                <form name="form1" method="post" action="/login/">
                <table width="300" border="2" align="center" cellpadding="2" cellspacing="1" bgcolor="#97C8F9" id="table">
                    <tr>
                    <td bgcolor="#E6E6E6"><strong>Username:</strong></td>
                    <td bgcolor="#FFFFFF"><input type="text" name="username" id="username"></td>
                    </tr>
                    <tr>
                    <td bgcolor="#E6E6E6"><strong>Password:</strong></td>
                    <td bgcolor="#FFFFFF"><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                    <td colspan="2" align="right" bgcolor="#E6E6E6"><a href="/forgot-password/">Forgotten Your Details?</a>        <input type="submit" name="Submit" id="Submit" value="Submit"></td>
                    </tr>
                    <tr>
                    <td colspan="2" align="right" bgcolor="#E6E6E6"><a href="/register/">Register</a></td>
                    </tr>
                </table>
                </form>
                ';
                
            };
            //clsSystem::$vars->Message=$this->Message;
            return $this->output;
        }


        

        public function Check_Login($UserName,$Password){
            $return_array=array();
            $sql="SELECT * FROM mod_login_details where username='".$UserName."' and password='".$Password."' LIMIT 0,1";
            $data=$this->db->rawQuery($sql);
            $data_user_details=$this->db->Fetch_Assoc($data);
            if(count($data_user_details)){
                $sql="SELECT * FROM mod_user_accounts where mod_login_detailsID='".$data_user_details['id']."' LIMIT 0,1";
                //print $sql;
                $data=$this->db->rawQuery($sql);
                $data_user_account=$this->db->Fetch_Assoc($data);

                $sql="SELECT * FROM mod_user_levels where id='".$data_user_account['mod_login_detailsID']."' LIMIT 0,1";
                $data=$this->db->rawQuery($sql);
                $data_user_level=$this->db->Fetch_Assoc($data);

                $sql="SELECT * FROM mod_user_profile where id='".$data_user_account['mod_user_profileID']."' LIMIT 0,1";
                $data=$this->db->rawQuery($sql);
                $data_user_profile=$this->db->Fetch_Assoc($data);
                $return_array=array("details"=>$data_user_details,"account"=>$data_user_account,"level"=>$data_user_level,"profile"=>$data_user_profile);
            }else{

                print "Error";
            }
            //print_r($return_array);
            return $return_array;
        }

        public function Member_Admin_Login(){
            if(isset($_GET['file'])){
                $file_name=$_GET['file'];
                header("Location: http://assets.localhost/".$file_name);
            }
                
                $load_file="./Admin_Start_Include.php";
            if(file_exists($load_file)){
                    include_once($load_file);
            }else{
            }
                
            $login=false;
            
            if(isset($_GET['Message']))$Message=$_GET['Message'];
            if(isset($_GET['hash'])){
                $login=true;
                $sql="UPDATE administrators SET administratorActive=1 WHERE hash='".$_GET['hash']."'";
                $data=$this->db->rawQuery($sql);
                $sql="SELECT * FROM administrators where hash='".$_GET['hash']."' LIMIT 0,1";
            }

            if(isset($_POST['Submit'])){
                if($_POST['Submit']!=""){
                    $login=true;
                    //$r=new ReturnRecord();
                    $sql="SELECT * FROM administrators where username='$_POST[UserName]' and password='$_POST[Password]' AND administratorActive=1 LIMIT 0,1";
                    //print $sql;
                    
                }
            }

            if($login){
                $data=$this->db->rawQuery($sql);
                $dataarray=$this->db->Fetch_Array($data);
                    if(isset($dataarray[0])){
                        if($dataarray[0]>0){ //admin login ok
                            
                            $session_data["administratorsID"]=$dataarray[0];
                            $session_data["SU"]=$dataarray[6];
                            $session_data["clientsID"]=$dataarray[7];
                            $session_data["username"]=$dataarray[3];

                            $session_data['original_clientsID']=$session_data["clientsID"];//$dataarray[2];
                            $session_data['original_administratorsID']=$session_data["administratorsID"];//$dataarray[0];
                            
                            if($session_data["SU"]=="CWL"){
                                $sql="SELECT MIN( domains.id) FROM domains WHERE  clientsID=".$session_data['clientsID'];
                            }else{
                                $sql="SELECT MIN( domains.id) FROM domains,administrators_domains WHERE domains.id=administrators_domains.domainsID";
                                $sql.=" AND administratorsID=$session_data[administratorsID] AND clientsID=$session_data[clientsID]";
                            }
                            
                            $rslt=$this->db->rawQuery($sql);
                            if($rslt){
                                if($this->dbNumRows($rslt)>0){
                                    $data=$this->db->Fetch_Array($rslt);
                                    if($data[0]>0){
                                        $session_data['original_domainsID']=$data[0];
                                        $_COOKIE['original_domainsID']=$data[0];
                                    }
                                }
                            }
                            $_SESSION=$session_data;
                    
                            $loc="Location: main/logged-in/index.php";
                            header($loc);
                        }else{	//admin login bad
                            $Message="Incorrect Username or Password";
                        };
                    }else{
                        $Message="Incorrect Username or Password";
                    }

                }
                $this->output='
                 
                <form name="form1" method="post" action="">
                        

                <table  border="0" align="center" cellpadding="0" cellspacing="0">
                
                    <tr>
                    <td align="center" ><table width="100%"  border="0" cellspacing="0" cellpadding="10">
                        <tr>
                            <td><table  border="0" align="center" cellpadding="0" cellspacing="6" class="ManagementLoginBox">
                            <tr>
                                <td height="20" colspan="2" align="center" ><span class="blacktextbold">Welcome to Creative Web Logics Website Builder</span></td>
                                </tr>
                            <tr>
                                <td height="20" colspan="2" align="center" ><span class="RedText"><?php print $Message; ?></span></td>
                                </tr>
                                <tr>
                                <td width="130" height="20" align="right" ><span class="blacktextbold"><strong>Username:</strong> &nbsp;</span> </td>
                                <td width="212"><input name="UserName" type="text" class="loginfield" id="UserName"></td>
                                </tr>
                                <tr>
                                <td  width="130" height="20" align="right"><span class="blacktextbold"><strong>Password:</strong> &nbsp;</span> </td>
                                <td><input name="Password" type="password" class="loginfield" id="Password"></td>
                                </tr>
                                <tr>
                                <td colspan="2" align="center">
                                <input name="Login_Code" type="hidden" value="123456789"> 	
                                <input name="Submit" type="submit" class="loginbutton" value="Login"> <a href="register.php">Register</a>
                                </td>
                                </tr>
                                
                            </table>
                            
                            </td>
                        </tr>
                    </table></td>
                    <td>
                    
                    </td>
                    </tr>
                    
                    
                </table>
                
                </form>';
        }


        public function Pre_Register(){
            if(!isset($_POST['name'])) $_POST['name']="";
            if(!isset($_POST['address'])) $_POST['address']="";
            if(!isset($_POST['suburb'])) $_POST['suburb']="";
            if(!isset($_POST['abn'])) $_POST['abn']="";
            if(!isset($_POST['phone'])) $_POST['phone']="";
            if(!isset($_POST['mobile'])) $_POST['mobile']="";
            if(!isset($_POST['fax'])) $_POST['fax']="";
            if(!isset($_POST['email'])) $_POST['email']="";
            if(!isset($_POST['website'])) $_POST['website']="";
            if(!isset($_POST['contact_name'])) $_POST['contact_name']="";
            if(!isset($_POST['password'])) $_POST['password']="";
            if(!isset($_POST['postcode'])) $_POST['postcode']="";
            
            
            
            if(isset($_POST['Submit'])){
                if($_POST['Submit']){
                    
                    $continue=true;
                    
                    
                    if($continue){
                        //$this->log->general('Member Resister',1);
                        $subdomain=$this->as->dirify(trim(str_replace(" ","-",$_POST['name'])));
                        $sql="INSERT INTO users VALUES ('NULL', '$_POST[name]', '$_POST[address]', '$_POST[suburb]', '$_POST[state]', '$_POST[postcode]', '$subdomain', '$_POST[phone]', '$_POST[mobile]', '$_POST[fax]', '$_POST[email]', '$_POST[website]', '$_POST[contact_name]', '$_POST[password]',  '1', '0', '$_POST[abn]', '', '$_POST[mod_business_categoriesID]','New')";
                        //print $sql;
                        $rslt=$this->db->RawQuery($sql);
                        if($rslt){
                            if($this->var['domain']['AEmail']!=""){
                                $Simple="New user id is ".$this->db->Insert_Id();
                                foreach($_POST as $key=>$val){
                                    $Simple.="\n $key=$val";	
                                }
                                
                                $sql="SELECT id FROM users WHERE email='$_POST[email]'";
                                $rslt=$this->db->RawQuery($sql);
                                if($this->db->NumRows($rslt)>0){
                                    $data=$this->db->Fetch_Array($rslt);
                                    $Simple.="\n WARNING DUPLICATE Email FOUND ON USER $data[0]";
                                }
                                /*
                                $m=new SendMail();
                                $m->Body($Simple,$Simple);
                                $m->To(array("BCMSL Admin"=>$this->var['domain']['AEmail']));
                                $m->From("BCMSL Bot","info@".DOMAINNAME);
                                $m->Subject("New User Has Registered on ".DOMAINNAME);
                                $m->Send();
                                $Message="Success";
                                */
                            }
                            
                            header("Location: /Registration-Complete/");
                        }else{
                            print "error ".$this->db->Error();	
                        }
                    }
                }
            }
        }

        public function Pre_User_Details(){
	
            if(isset($_POST['Submit'])){
                if($_POST['Submit']){
                    
                    $membersID=$_SESSION['membersID'];
                    /*
                    $m= new UpdateDatabase($log);
                    $m->Set_Log($log);
                    $m->Set_Database($r);
                    //$m->Set_Log_All();
                    $m->AddPosts($_POST,$_FILES);
                    $m->AddSkip(array("id"));
                    $m->AddTable("users");
                    $m->AddID($_SESSION['membersID']);
                    $m->DoStuff();
                    */
                }
            }
        }

        public function Pre_Postal_Address(){
            if(isset($_POST['Submit'])){
                if($_POST['Submit']){
                    /*
                    $membersID=$_SESSION['membersID'];
                    $m= new AddToDatabase($log);
                    $m->ChangeInsertType("REPLACE");
                    $m->Set_Log($log);
                    $m->Set_Database($r);
                    //$m->Set_Log_All();
                    $m->AddPosts($_POST,$_FILES);
                    $m->AddSkip(array("id"));
                    $m->AddTable("user_details");
                    $m->AddID($_SESSION['membersID']);
                    $m->DoStuff();
                    */
                }
            }
        }


        public function Postal_Address(){
            //echo "\n\n ===================================================================================== 777 \n\n";
            $membersID=$_SESSION['membersID'];
            //$r=new ReturnRecord();
            $this->dbAddTable("user_details");
        
            $this->dbAddSearchVar($_SESSION['membersID']);
            $Memb=$this->dbGetRecord();
            
            $user_details_array=array('name','address','suburb','state','postcode','abn','phone','mobile','fax','email','website','contact_name','password','business_description');
            foreach($user_details_array as $key=>$val){
                if(!isset($Memb[$val])){
                    $Memb[$val]="";
                } 
            }
            $this->output='
            
            <form method="post" action="'.$this->var['content']['PAGENAME'].'">
            <div align="center">
                <center>
                <?php print $Message;?>
                <table width="391" border="0" alig-="left" cellpadding="3" cellspacing="1" bgcolor="#97C8F9">
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Name :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="name" type="text" id="name" value="'.$Memb['name'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Address :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="address" type="text" id="address" value="'.$Memb['address'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Suburb :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="suburb" type="text" id="suburb" value="'.$Memb['suburb'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">State :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="state" type="text" id="state" value="'.$Memb['state'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Postcode :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="postcode" type="text" id="postcode" value="'.$Memb['postcode'].'" /></td>
                    </tr>
                    <tr bgcolor="#C6C6CD" >
                                <td width="35%" align="left"><strong>*Country</strong></td>
                                <td align="left"><select name="countryID" onChange="setDelivery(this.value)">
                                ';
                                $sql=$this->db->rawQuery("SELECT id,Country_Name FROM countries");
                                while($myrow=$this->db->Fetch_Array($sql)){
                                    if($Memb['countryID']==$myrow[0]){
                                        $this->output.='<option value="'.$myrow[0].'" selected>'.$myrow[1].'</option>';
                                    }else{
                                        $this->output.='"<option value="'.$myrow[0].'">'.$myrow[1].'</option>';
                                    };
                                }
                                $this->output.='</select></td>
                    
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Phone Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="phone" type="text" id="phone" value="'.$Memb['phone'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Mobile Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="mobile" type="text" id="mobile" value="'.$Memb['mobile'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Fax Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="fax" type="text" id="fax" value="'.$Memb['fax'].'" /></td>
                    </tr>
                </table>
                </center>
            </div>
            <div align="center">
                <center>
                <p>
                    <input type="submit" value="Update Details"
            name="Submit" id="Submit" />
                </p>
                </center>
            </div>
            </form>';
        }
        public function Change_Password(){
            $this->output=__METHOD__;
            $this->output=$this->cls->clsFormCreator->Create_Change_Password();
            return $this->output;
        }

        public function Pre_Change_Password(){
			if(isset($_POST['Submit'])){
                if($_POST['Submit']){
                    
                  
                    
                };
            }
		}

        public function Add_Member(){
            //$this->output=$this->cls->clsFormCreator->Create_User_Details();
            //$this->output="Add_Member";
            $this->output=__METHOD__;
            //$this->output=$this->cls->clsFormCreator->Create_Members_List_Table();
            return $this->output;
        }

        public  function Modify_Member(){
            $this->output=__METHOD__;
            $this->output=$this->cls->clsHTMLContent->create_members_list();
            //$this->output=$this->cls->clsFormCreator->Create_Members_List_Table();
            return $this->output;
        }

        

        public function Pre_Modify_Member(){
            $this->output=__METHOD__;
            return $this->output;
        }

        public function Pre_Edit_Member(){
            $this->output=__METHOD__;
            return $this->output;
        }

        public function Edit_Member(){
            //$this->output=$this->cls->clsFormCreator->Create_User_Details();
            $this->output=__METHOD__;
            return $this->output;
        }
   
        public function User_Details(){
            $left_output="<br><br>";
            $right_output="";

            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=user_details/'>User Details</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=postal_addresses/'>Postal Addresses</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=contact_details/'>Contact Details</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=company_details/'>Organization Details</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=tax_details/'>Tax Details</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/'>Interests</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=orders/'>Orders</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=account/'>Account</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=events/'>Events</a><br>";
            $left_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=groups/'>Groups</a><br>";
            switch($this->var['content']['get_variables']['page']){
                case "add_postal":
                    //$right_output=$this->Create_Postal_Address($this->var['content']['original_uri']);
                break;
                case "user_details":
                    //$right_output=$this->Create_User_Details();
                break;
                case "postal_addresses":
                    $right_output.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=add_postal/'>Add Postal Address</a><br><br><br>";
                    //$right_output.=$this->Create_Postal_Addresses_List();
                break;
                case "interests":
                    $interest_menu="";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=movies/'>Movies</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=tv_shows/'>TV Shows</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=artists/'>Artists</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=books/'>Books</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=sports/'>Sports Teams</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=athletes/'>Athletes</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=people/'>People</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=restraunts/'>Restraunts</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=applications/'>Applications</a><br>";
                    $interest_menu.="<a href='".$this->var['content']["TOTALPAGENAME"]."page=interests/page2=games/'>Games</a><br>";
                    switch($this->var['content']['get_variables']['page2']){
                        case "movies":
                            $interests_right_output="Show Movies Liked";
                        break;
                        case "tv_shows":
                            $interests_right_output="Show TV Shows Liked";
                        break;
                        case "artists":
                            $interests_right_output="Show Artists Liked";
                        break;
                        case "books":
                            $interests_right_output="Show Books Liked";
                        break;
                        case "sports":
                            $interests_right_output="Show Sports Liked";
                        break;
                        case "athletes":
                            $interests_right_output="Show Athletes Liked";
                        break;
                        case "people":
                            $interests_right_output="Show People Liked";
                        break;
                        case "restraunts":
                            $interests_right_output="Show Restraunts Liked";
                        break;
                        case "applications":
                            $interests_right_output="Show Applications Liked";
                        break;
                        case "games":
                            $interests_right_output="Show Games Liked";
                        break;
                    }
                    $right_output="<table width='100%'><tr><td width='200px' valign='top'>".$interest_menu."</td><td>".$interests_right_output."</td></tr></table>";
                    
                break;
                default:
                    
                    
                break;
            }
            $this->output="<table width='100%'><tr><td width='200px' valign='top'>".$left_output."</td><td>".$right_output."</td></tr></table>";
            return $this->output;
        }

        public function User_Details_old(){
            //echo "\n\n ===================================================================================== 777 \n\n";
            $membersID=$_SESSION['membersID'];
            /*
            //$r=new ReturnRecord();
            $this->db->AddTable("users");
        
            $this->db->AddSearchVar($_SESSION['membersID']);
            $Memb=$this->db->GetRecord();
            */
            $Memb=array();
            $user_details_array=array('name','address','suburb','state','postcode','abn','phone','mobile','fax','email','website','contact_name','password','business_description');
            foreach($user_details_array as $key=>$val){
                if(!isset($Memb[$val])){
                    $Memb[$val]="";
                } 
            }
            if(!isset($Memb['countryID'])){
                $Memb['countryID']=0;
            }

            $this->output='            
            <form method="post" action="'.$this->var['content']['PAGENAME'].'">
            <div align="center">
                <center>
                '.$this->Message.'
                <table width="391" border="0" alig-="left" cellpadding="3" cellspacing="1" bgcolor="#97C8F9">
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Name :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="name" type="text" id="name" value="'.$Memb['name'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Address :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="address" type="text" id="address" value="'.$Memb['address'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Suburb :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="suburb" type="text" id="suburb" value="'.$Memb['suburb'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">State :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="state" type="text" id="state" value="'.$Memb['state'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Postcode :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="postcode" type="text" id="postcode" value="'.$Memb['postcode'].'" /></td>
                    </tr>
                    <tr bgcolor="#C6C6CD" >
                                <td width="35%" align="left"><strong>*Country</strong></td>
                                <td align="left"><select name="countryID" onChange="setDelivery(this.value)">
                                ';
                                $sql=$this->db->rawQuery("SELECT id,Country_Name FROM countries");
                                while($myrow=$this->db->Fetch_Array($sql)){
                                    if($Memb['countryID']==$myrow[0]){
                                        $this->output.='<option value="'.$myrow[0].'" selected>'.$myrow[1].'</option>';
                                    }else{
                                        $this->output.='<option value="'.$myrow[0].'">'.$myrow[1].'</option>';
                                    };
                                }
                                $this->output.='
                                </select></td>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">ABN:</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="abn" type="text" id="abn" value="'.$Memb['abn'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Phone Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="phone" type="text" id="phone" value="'.$Memb['phone'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Mobile Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="mobile" type="text" id="mobile" value="'.$Memb['mobile'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Fax Number :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="fax" type="text" id="fax" value="'.$Memb['fax'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Email Address :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="email" type="text" id="email" value="'.$Memb['email'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" height="24" align="right" bgcolor="#E6E6E6"><font size="2">Web Site :</font></td>
                    <td width="197" bgcolor="#FFFFFF">
                        http://            
                        <input name="website" type="text" id="website" value="'.$Memb['website'].'" /></td>
                    </tr>
                    <tr>
                    <td width="179" align="right" bgcolor="#E6E6E6"><font size="2">Contact Name :</font></td>
                    <td width="197" bgcolor="#FFFFFF"><input name="contact_name" type="text" id="contact_name" value="'.$Memb['contact_name'].'" /></td>
                    </tr>
                    <tr>
                    <td align="right" bgcolor="#E6E6E6">Password :</td>
                    <td bgcolor="#FFFFFF"><input name="password" type="text" id="password" value="'.$Memb['password'].'" /></td>
                    </tr>
                    <tr>
                    <td colspan="2" align="center" bgcolor="#E6E6E6">Directory Description</td>
                    </tr>
                    <tr>
                    <td colspan="2" align="center" bgcolor="#E6E6E6"><textarea name="business_description" cols="50" rows="5" id="business_description">'.$Memb['business_description'].'</textarea></td>
                    </tr>
                </table>
                </center>
            </div>
            <div align="center">
                <center>
                <p>
                    <input type="submit" value="Update Details"
            name="Submit" id="Submit" />
                </p>
                </center>
            </div>
            </form>
                    </td>';
                    return $this->output;
            }


            


            public function Pre_Forgot_Password(){
                if(isset($_POST['Submit'])&&isset($_POST['email'])){
                    $rslt=$this->db->RawQuery('SELECT password,name,email,id FROM users WHERE email="'.$_POST['email'].'"');
                    if($rslt){
                        $Simple="Dear Member here are the details you requested.\n";
                        //$this->m=new SendMail();
                        while($data=$this->db->Fetch_Array($rslt)){
                            //$m->To(array($data[1]=>$data[2]));
                            $Simple.="Your name is: $data[1] \n Your email is $data[2].\n Your password is $data[0] \n";
                            $Simple.="------------------------------------------------------------------------------\n";
                        }
                        /*
                        $this->m->Body($Simple,$Simple);
                        
                        $this->m->From(DOMAINNAME." Admin","admin@".DOMAINNAME);
                        $this->m->Subject("Your password reminder");
                        $this->m->Send();
                    */
                        $Message="Password sent..";
                    }else{
                        $Message="Email not found";
                    }
                }
            }

            public function Forgot_Password(){
                $this->output.="<form name='form1' method='post' action='".$_SERVER['REQUEST_URI']."'>
                    <table width='334' border='0' align='center' cellpadding='2' cellspacing='1' bgcolor='#97C8F9' id='table'>
                        <tr>
                        <td colspan='2' align='center' bgcolor='#FFFFFF'><strong>Please enter your email and click Submit and we will email you your password:-</strong></td>
                        </tr>
                        <tr>
                        <td width='131' bgcolor='#E7E7E7'><strong>Email:</strong></td>
                        <td width='192' bgcolor='#FFFFFF'><input type='text' name='email' id='email'></td>
                        </tr>
                        <tr>
                        <td colspan='2' align='right' bgcolor='#E7E7E7'><input type='submit' name='Submit' id='Submit' value='Submit'></td>
                        </tr>
                    </table>
                    </form>
                ";
            }


            public function Change_Password_Form(){
                $this->output='<p align="center">&nbsp;</p>
                    <p><font size="2">To <strong><span class="Morone">update your password</span></strong> simply type in your current password, and then type in your new password twice. This will
                    ensure that you did not mis-type your new password.</font></p>
                    <form action="'.$_SERVER['REQUEST_URI'].'"  method="post" name="form2" id="form2" >
                    <span class="RedText"><?php print $Message; ?></span><br />
                    <br />
                    <table width="70%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#97C8F9" id="table">
                        <tr>
                        <td width="295" bgcolor="#FFFFFF"><strong> Current Password</strong></td>
                        <td width="241" bgcolor="#FFFFFF"><input name="cpassword" type="password" class="formfield1" id="cpassword" /></td>
                        </tr>
                        <tr>
                        <td bgcolor="#FFFFFF"><strong>New Password</strong></td>
                        <td bgcolor="#FFFFFF"><input name="password" type="password" class="formfield1" id="password" /></td>
                        </tr>
                        <tr>
                        <td bgcolor="#FFFFFF"><strong>Retype New Password</strong></td>
                        <td bgcolor="#FFFFFF"><input name="password2" type="password" class="formfield1" id="password2" /></td>
                        </tr>
                        <tr>
                        <td colspan="2" align="right" bgcolor="#E6E6E6"><input name="Submit" type="submit" class="formbuttons" value="Save" onclick="return confirmSubmit()" /></td>
                        </tr>
                    </table>
                    </form>
                    <p><font size="2">Note:&nbsp; If you would like <strong><span class="Morone">to update
                    your User Details</span></strong> you will need to send an email to <a href="mailto:admin@noodnet.com">admin@noodnet.com</a> with your new details and a Nood
                    Network Administrator will update your details.</font></p>';

            }



            public function HTML_Output(){
            print $this->output;
        }

        public function Member_Add(){
            $this->output='
            <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td valign="top"><form action="index.php"  method="post" name="form2" >
                <span class="pageheading">Add New Member </span><span class="RedText"><?php print $Message; ?></span><br>
                <br>
                Complete the member details below.<br>
                <br>
                <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
                <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                <tr>
                    <td class="tabletitle"><strong>Sub Domain</strong></td>
                    <td class="tablewhite"><input name="subdomain" type="text" id="subdomain" size="45"></td>
                </tr>
                <tr>
                    <td width="163" class="tabletitle"><strong> Business Name<span class="RedText">*</span></strong></td>
                    <td width="352" class="tablewhite"><input name="name" type="text" id="name" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Contact Name</strong></td>
                    <td class="tablewhite"><input name="contact_name" type="text" id="contact_name" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong> Email<span class="RedText">*</span></strong></td>
                    <td class="tablewhite"><input name="email" type="text" id="email" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Address</strong></td>
                    <td class="tablewhite"><input name="address" type="text" id="address" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Suburb</strong></td>
                    <td class="tablewhite"><input name="suburb" type="text" id="suburb" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>State</strong></td>
                    <td class="tablewhite"><input name="state" type="text" id="state" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Postcode</strong></td>
                    <td class="tablewhite"><input name="postcode" type="text" id="postcode" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Phone</strong></td>
                    <td class="tablewhite"><input name="phone" type="text" id="phone" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Mobile</strong></td>
                    <td class="tablewhite"><input name="mobile" type="text" id="mobile" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Fax</strong></td>
                    <td class="tablewhite"><input name="fax" type="text" id="fax" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Website</strong></td>
                    <td class="tablewhite"><input name="website" type="text" id="website" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Password</strong></td>
                    <td class="tablewhite"><input name="password" type="text" id="password" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Status</strong></td>
                    <td class="tablewhite">
                    <select name="status" id="accesslvl">
                    <option value="New" 
                    
                    
                </select>
                </td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Abn</strong></td>
                    <td class="tablewhite"><input name="abn" type="text" id="abn" size="45"></td>
                </tr>
                <tr>
                    <td class="tabletitle"><strong>Business Category</strong></td>
                    <td class="tablewhite"><SELECT NAME="mod_business_categoriesID" id="mod_business_categoriesID">';

                    $Count=0;
                    $sql="SELECT id,CategoryTitle FROM mod_business_categories WHERE ((domainsID=".$_SESSION['domainsID'].") OR  (domainsID=0)) ORDER BY CategoryTitle";
                
                            $sq2=$this->db->rawQuery($sql);  
                            while ($myrow = $this->db->Fetch_Array($sq2)) {
                                $this->output.='<option value="'.$myrow[0].'"';
                                //if($Insert['mod_business_categoriesID']==$myrow[0]){
                                    //$this->output.='"selected"';
                                //} 
                                $this->output.='">$myrow[1]</option>"';
                            };
                            $this->output.='
                                </SELECT></td>
                            </tr>
                            <tr>
                                <td class="tabletitle"><strong>Directory Description</strong></td>
                                <td class="tablewhite"><textarea name="business_description" cols="45" rows="4" id="business_description"></textarea></td>
                            </tr>
                            </table>
                            <p><br>
                            <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
                            </p>
                            </form></td>
                        </tr>
                    </table>';
                        }
                    
                    }