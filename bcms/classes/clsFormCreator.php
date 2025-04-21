<?php

    class clsFormCreator Extends clsFormGenerator{
      use trtBasic;
        public $html_data;     
        
        
       
        public function __construct($classes=array()){
            
            
        }

        

        
		

     
        
    function Create_Login_Form($Form_Action=""){
      $output=$this->Create_Members_Login_List_Table();


            //$output="";
            if($Form_Action==""){
                $Form_Action=$_SERVER['REQUEST_URI'];
            }
            
			return $output;
		}
    /*
      $this->Create_Members_Login_List_Table();


            $output="";
            if($Form_Action==""){
                $Form_Action=$_SERVER['REQUEST_URI'];
            }
            $output='
			<form name="form1" method="post" action="'.$Form_Action.'">
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
                </form>';
			return $output;
		}
        */
        
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

        function Create_DropDown($config=array(),$default=null,$items=array()){
            //print_r($items);
          $output="";
          $select_details=implode("=",$config);
          $output='<select '.$select_details.'>';

          foreach($items as $key=>$val){
            if(!is_null($default)){
              if($default==$val['id']){
                $selected_string="selected";
              }else{
                $selected_string="";
              }
            }else{
              $selected_string="";
            }
            $output.="<option value='".$val['id']."' ".$selected_string.">".$val['Name']."</option>";
                       
          }
          $output.="</select>";
          
          return $output;
          
        }

        function Create_TextBox($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<input '.$config_output.' value="'.$default.'">';
 
                      
          return $output;
          
        }

        function Create_Label($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<span '.$config_output.' >'.$default.'</span>';
 
                      
          return $output;
          
        }

        function Create_Table_TD($config=array(),$item=""){
            
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<td '.$config_output.'>';
          $output.=$item;
          
          $output.="</td>";
          
          return $output;
          
        }

        function Create_Table_TR($config=array(),$item=""){
            
          $output="";
          $select_details=implode("=",$config);
          $output='<tr '.$select_details.'>';
          $output.=$item;
          
          $output.="</tr>";
          
          return $output;
          
        }

        function Create_Table($config=array(),$item=""){
            
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          ///$select_details=implode("=",$config);
          $output='<table '.$config_output.'>';
          $output.=$item;
          
          $output.="</table>";
          
          return $output;
          
        }
        

function Create_Admin_Member_Register_Form($countryID=0,$domainsID=0,$mod_business_categoriesID=0,$Message="",$Form_Action=""){
            
                $output="";
                if($Form_Action==""){
                    $Form_Action=$_SERVER['REQUEST_URI'];
                }
    
                $country_html=$this->Create_Country_Select();//($countryID);
                $business_category_html="";//$this->Create_Business_Categories_Select();//($domainsID,$mod_business_categoriesID);
                $output='
                <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top"><form action="'.$Form_Action.'"  method="post" name="form2"  >
                      <span class="pageheading">Add New Account </span><span class="RedText">'.$Message.'</span><br>
                      <br>
                    <br>
                    <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
                    <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                      <tr>
                        <td class="tabletitle"><strong>Profile Domain</strong></td>
                        <td class="tablewhite"><input name="subdomain" type="text" id="subdomain" size="45"> .bizdirectory.online</td>
                      </tr>
                      <tr>
                        <td width="163" class="tabletitle"><strong> Business Name<span class="RedText">*</span></strong></td>
                        <td width="352" class="tablewhite"><input name="business_name" type="text" id="name" size="45"></td>
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
                        <td class="tabletitle"><strong>Address 1</strong></td>
                        <td class="tablewhite"><input name="address" type="text" id="address" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Address 2</strong></td>
                        <td class="tablewhite"><input name="address2" type="text" id="address" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Address 3</strong></td>
                        <td class="tablewhite"><input name="address3" type="text" id="address" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Suburb</strong></td>
                        <td class="tablewhite"><input name="suburb" type="text" id="suburb" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>City</strong></td>
                        <td class="tablewhite"><input name="city" type="text" id="city" size="45"></td>
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
                        <td class="tabletitle"><strong>Country</strong></td>
                        <td class="tablewhite">'.$country_html.'</td>
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
                        <td class="tabletitle"><strong>Username:</strong> </td>
                        <td class="tablewhite"><input name="username" type="text" id="UserName" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Password</strong></td>
                        <td class="tablewhite"><input name="password" type="text" id="password" size="45"></td>
                      </tr>
                      
                      <tr>
                        <td class="tabletitle"><strong>TAX Identifier</strong></td>
                        <td class="tablewhite"><input name="abn" type="text" id="abn" size="45"></td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Business Category</strong></td>
                        <td class="tablewhite">'.$business_category_html.'</td>
                      </tr>
                      <tr>
                        <td class="tabletitle"><strong>Directory Description</strong></td>
                        <td class="tablewhite"><textarea name="business_description" cols="45" rows="4" id="business_description"></textarea></td>
                      </tr>
                      
                      <tr>
                        <td colspan="2" align="center" class="tablewhite">
                        <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
                                  </td>
                      </tr>
                      </table>
                    <p><br>
                      
                      </p>
                    </form></td>
                </tr>
              </table>';
                    return $output;
                    
                }  

                function Create_Postal_Addresses_List(){
            
                  
                  
                  //$sql=$this->r->rawQuery("SELECT id FROM mod_link_tables WHERE mod_tablesID-From='31' AND mod_tablesID-To='32'");
                  $output_middle="";
                  $mod_link_tablesID=1;
                  $address_list=array();
                  $sql=$this->db->rawQuery("SELECT source_keyID FROM mod_link_tables_keys WHERE mod_link_tablesID='".$mod_link_tablesID."' AND destination_keyID='".$_SESSION['membersID']."'	");
                  while($myrow=$this->db->Fetch_Array($sql)){
                    $sql_text="SELECT id,name FROM mod_address_details WHERE id='".$myrow[0]."'";
                    $sql2=$this->db->rawQuery($sql_text);
                    //print $sql_text;
                    $data=$this->db->Fetch_Assoc($sql2);
                    $address_list[]=$data;
                    $output_middle.="<tr><td>".$data['name']."</td><td><a href='".$_SERVER['REQUEST_URI']."edit=".$data['id']."/'>Edit</a></td></tr>";
                  }
                  $output="<table>".$output_middle."</table>";
                  
                  
                  return $output;
                  
              }

                function Create_Postal_Address($Form_Action=""){
            
                  $output="";
                  if($Form_Action==""){
                      $Form_Action=$_SERVER['REQUEST_URI'];
                  }
      
                  $country_html=$this->Create_Country_Select();//($countryID);
                  $output='
                  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td valign="top"><form action="'.$Form_Action.'"  method="post" name="form2"  >
                        <span class="pageheading">Add New Postal Address </span><span class="RedText">'.$this->Message.'</span><br>
                        <br>
                      <br>
                      <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                        
                        <tr>
                          <td width="163" class="tabletitle"><strong>Address Name<span class="RedText">*</span></strong></td>
                          <td width="352" class="tablewhite"><input name="name" type="text" id="name" size="45"></td>
                        </tr>
                        
                        <tr>
                          <td class="tabletitle"><strong>Address 1</strong></td>
                          <td class="tablewhite"><input name="address" type="text" id="address" size="45"></td>
                        </tr>
                        <tr>
                          <td class="tabletitle"><strong>Address 2</strong></td>
                          <td class="tablewhite"><input name="address2" type="text" id="address" size="45"></td>
                        </tr>
                        <tr>
                          <td class="tabletitle"><strong>Address 3</strong></td>
                          <td class="tablewhite"><input name="address3" type="text" id="address" size="45"></td>
                        </tr>
                        <tr>
                          <td class="tabletitle"><strong>Suburb</strong></td>
                          <td class="tablewhite"><input name="suburb" type="text" id="suburb" size="45"></td>
                        </tr>
                        <tr>
                          <td class="tabletitle"><strong>City</strong></td>
                          <td class="tablewhite"><input name="city" type="text" id="city" size="45"></td>
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
                          <td class="tabletitle"><strong>Country</strong></td>
                          <td class="tablewhite">'.$country_html.'</td>
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
                          <td class="tabletitle"><strong>TAX Identifier</strong></td>
                          <td class="tablewhite"><input name="abn" type="text" id="abn" size="45"></td>
                        </tr>
                        
                        
                        
                        <tr>
                          <td colspan="2" align="center" class="tablewhite">
                          <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
                                    </td>
                        </tr>
                        </table>
                      <p><br>
                        
                        </p>
                      </form></td>
                  </tr>
                </table>';
                      return $output;
                      
                  } 

                  function Create_Change_Password($Form_Action=""){
                    $output="";
                    if($Form_Action==""){
                        $Form_Action=$_SERVER['REQUEST_URI'];
                    }
        
                    $output='
                  <p align="center">&nbsp;</p>
                  <p><font size="2">To <strong><span class="Morone">update your password</span></strong> simply type in your current password, and then type in your new password twice. This will
                    ensure that you did not mis-type your new password.</font></p>
                  <form action="'.$Form_Action.'"  method="post" name="form2" id="form2" >
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
                    return $output;
                    
                }

                  function Create_User_Details_oldest($Form_Action=""){
            
                    $output="";
                    if($Form_Action==""){
                        $Form_Action=$_SERVER['REQUEST_URI'];
                    }
        
                    $output='
                    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="top"><form action="'.$Form_Action.'"  method="post" name="form2"  >
                          <span class="pageheading">Edit User Details </span><span class="RedText">'.$this->Message.'</span><br>
                          <br>
                        <br>
                        <span class="RedText"><strong>*</strong></span><strong> Mandatory Fields </strong>
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" id="table">
                          
                          <tr>
                            <td width="163" class="tabletitle"><strong>First Name<span class="RedText">*</span></strong></td>
                            <td width="352" class="tablewhite"><input name="First_Name" type="text" id="First_Name" size="45"></td>
                          </tr>
                          
                          <tr>
                            <td class="tabletitle"><strong>Last Name</strong></td>
                            <td class="tablewhite"><input name="Last_Name" type="text" id="Last_Name" size="45"></td>
                          </tr>
                          <tr>
                            <td class="tabletitle"><strong>Birth Date</strong></td>
                            <td class="tablewhite"><input name="Last_Name" type="text" id="Last_Name" size="45"></td>
                          </tr>
                          
                          
                          
                          
                          <tr>
                            <td colspan="2" align="center" class="tablewhite">
                            <input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save" onClick="return confirmSubmit()">
                                      </td>
                          </tr>
                          </table>
                        <p><br>
                          
                          </p>
                        </form></td>
                    </tr>
                  </table>';
                        return $output;
                        
                    }


              public function Member_Register_Form($Message=""){
                  
                  
                $this->output='
                <script type="text/javascript">
                    <!--
                    function CheckAgree(){
                        var target=document.getElementById("IAgree");
                        if(target.checked){
                            return true;
                        }else{
                            alert("You must agree to the terms and conditions");
                            return false;
                        }
                    }
    
                    //-->
                    </script>';
                    
                    $this->output.='
                    <table width="100%">
                        <tr>
                            <td width="20%" valign="top">
                                <a href="/login/">Login</a><br>
                                <a href="/forgot-password/">Forgot Login</a>
                            </td>
                            <td width="80%">
                    <form action="'.$_SERVER['REQUEST_URI'].'" method="post" name="form1" />
                    '.$Message.'
                    <br>
                    <table width="434" border=0 align="center" cellpadding=2 cellspacing="1" bgcolor="#97C8F9" id="table">
                        <tr>
                        <td colspan="2" align="center" bgcolor="#E6E6E6"><strong>All Fields Are Mandatory</strong></td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"><strong>Business&nbsp; Name</strong></td>
                        <td width="240" bgcolor="#FFFFFF">
                            <INPUT NAME="name" TYPE="text" id="name" value="'.$_POST['name'].'" SIZE="26">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Business Address</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="address" TYPE="text" id="address" value="'.$_POST['address'].'" SIZE="40">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Suburb / Town / City</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="suburb" TYPE="text" id="suburb" value="'.$_POST['suburb'].'" SIZE="26">
                        </td>
                            
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>State</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <SELECT NAME="state" id="state">
                            <OPTION SELECTED VALUE="Queensland">Queensland
                                <OPTION VALUE="New South Wales">New South Wales
                                <OPTION VALUE="Victoria">Victoria
                                <OPTION VALUE="South Australia">South Australia
                                <OPTION VALUE="Western Australia">Western Australia
                                <OPTION VALUE="Tasmania">Tasmania
                                <OPTION VALUE="Australian Capital Territory">Australian Capital Territory
                                <OPTION VALUE="Northern Territory">Northern Territory
                            </SELECT>
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Postcode </strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="postcode" TYPE="text" id="postcode"
                     value="'.$_POST['postcode'].'" SIZE="8">
                        </td>
                        </tr>
                        <tr bgcolor="#C6C6CD" >
                            <td width="35%" align="left"><strong>*Country</strong></td>
                            <td align="left"><select name="countryID" onChange="setDelivery(this.value)">
                            ';
                            $sql=$this->db->rawQuery("SELECT id,Country_Name FROM countries");
                            while($myrow=$this->db->Fetch_Array($sql)){
                                if($_POST['countryID']==$myrow[0]){
                                    $this->output.='<option value="'.$myrow[0].'" selected>'.$myrow[1].'</option>';
                                }else{
                                    $this->output.='<option value="'.$myrow[0].'">'.$myrow[1].'</option>';
                                };
                            }
                            $this->output.='</select></td>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>ABN</strong></td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="abn" TYPE="text" id="abn" value="'.$_POST['abn'].'" SIZE="20">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Phone Number</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="phone" TYPE="text" id="phone" value="'.$_POST['phone'].'" SIZE="20">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Mobile Number</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="mobile" TYPE="text" id="mobile" value="'.$_POST['mobile'].'" SIZE="20">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Fax Number</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="fax" TYPE="text" id="fax" value="'.$_POST['fax'].'" SIZE="20">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>E-mail Address</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="email" TYPE="text" id="email"
                                 value="'.$_POST['email'].'" SIZE="40">
                                 
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Web Site</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            http://
                            <INPUT NAME="website" TYPE="text" id="website" value="'.$_POST['website'].'" SIZE="30">
                        </td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Contact Person</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"> 
                            <INPUT NAME="contact_name" TYPE="text" id="contact_name" value="'.$_POST['contact_name'].'" SIZE="26">
                        </td>
                        </tr>
                        <tr>
                        <td bgcolor="#E6E6E6"><strong>Password</strong></td>
                        <td bgcolor="#FFFFFF"><input name="password" type="text" id="password" value="'.$_POST['password'].'" size="26" /></td>
                        </tr>
                        <tr>
                        <td width="184" bgcolor="#E6E6E6"> <strong>Business Category</strong> </td>
                        <td width="240" bgcolor="#FFFFFF"><SELECT NAME="mod_business_categoriesID" id="mod_business_categoriesID">';
                        
                            $Count=0;
                            //$r=new ReturnRecord();
                            $sq2=$this->db->rawQuery("SELECT id,CategoryTitle FROM mod_business_categories WHERE  domainsID=0 ORDER BY CategoryTitle");  
                            while ($myrow = $this->db->Fetch_Array($sq2)) {
                                $this->output.='<option value="'.$myrow[0].'">'.$myrow[1].'</option>';
                            };
                            
                        $this->output.='</SELECT>
                        </td>
                        </tr>
                        <tr>
                        <td height="24" bgcolor="#E6E6E6"><p><strong>You Agree To <br />
                        </strong><strong><a href="/terms-and-conditions/" target="_blank">Terms &amp; Conditions</a></strong></p></td>
                        <td bgcolor="#FFFFFF"><input name="IAgree" type="checkbox" id="IAgree" value="1"></td>
                        </tr>
                        
                        <tr>
                        <td colspan="2" align="right" bgcolor="#E6E6E6"><input type="submit" name="Submit" id="Submit" value="Submit" onClick="return CheckAgree()"></td>
                        </tr>
                    </table>
                    </form>
    
                    </td>
                    </table>';
                  return $this->output;
              }

              function Create_User_Details($Form_Action=""){
                //echo" \n DDG |";
                
                $input['type_form']="Add";
                $this->output=$this->Create_Form($input);
                return $this->output;
              }

            public function Create_Form($input=array()){
              //print_r($input);
              switch($input['type_form']){
                case "Add";
                $table_array=array('width'=>"40%", 'border'=>0,'align'=>"center",'cellpadding'=>2,
                'cellspacing'=>"1" ,'bgcolor'=>"#EBEBEB", 'id'=>"table");

                $table_total=array('tags_columns'=>2,'tags_rows'=>4);

                $table_cols_array=array();
                $table_cols_array[]=array('align'=>"left",'bgcolor'=>"#CCC");
                $table_cols_array[]=array('align'=>"right",'bgcolor'=>"#FFFFFF");

                $input_item=array('id'=>'First_Name','name'=>'First_Name','type'=>"text",'value'=>"",'size'=>"45",'style'=>"",'class'=>"");
                $input['items'][]=$input_item;
                $input_item=array('id'=>'Last_Name','name'=>'Last_Name','type'=>"text",'value'=>"",'size'=>"45",'style'=>"",'class'=>"");
                $input['items'][]=$input_item;
                $input_item=array('id'=>'Birth_Date','name'=>'Birth_Date','type'=>"text",'value'=>"",'size'=>"45",'style'=>"",'class'=>"");
                $input['items'][]=$input_item;

                $tag_item=array('type'=>"label",'value'=>"<strong>First Name<span class='RedText'>*</span></strong>");
                $input['tags'][]=$tag_item;
                $tag_item=array('type'=>"label",'value'=>"<strong>Last Name<span class='RedText'>*</span></strong>");
                $input['tags'][]=$tag_item;Case
                $tag_item=array('type'=>"label",'value'=>"<strong>Birth Date<span class='RedText'>*</span></strong>");
                $input['tags'][]=$tag_item;

                $input['tags'][]=array('type'=>"submit",'value'=>'<input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save">');

                $total_cols=$table_total['tags_columns'];
                $total_rows=$table_total['tags_rows'];
                

                $input['cell_output'][0][0]=$input['tags'][0];
                $input['cell_output'][0][1]=$input['items'][0];
                $input['cell_output'][1][0]=$input['tags'][1];
                $input['cell_output'][1][1]=$input['items'][1];
                $input['cell_output'][2][0]=$input['tags'][2];
                $input['cell_output'][2][1]=$input['items'][2];
                $input['cell_output'][3][1]=$input['tags'][3];
                //$input['cell_output'][3][1]=$input['items'][3];


                //print_r($input);
                /*
                  row=0 col=0 
                  row=0 col=1 
                  row=1 col=0 
                  row=1 col=1 
                  row=2 col=0 
                  row=2 col=1 
                  row=3 col=0 
                  row=3 col=1 

                */
                $input['table_dimentions']=$table_total;

                $input['table_tags']['cols']=$table_cols_array;
                $input['table_tags']['rows']=array();
                $input['table_properties']=$table_array;
                
                //$this->output=$this->Create_Add_Form($input);
                break;
                case "Edit";
                break;
                case "Modify";
                break;
              }
              //$input['type_form']
              $this->output=$this->Create_HTML_Form($this->output);
              return $this->output;
            }
            // ==================================================================  new form builder types | create
            public function Create_Server_Form(){

                

                $item_array=$this->Create_Table_Elements();
                $text_input_item=$item_array[0];
                $drop_down_input_item=$item_array[1];
                $blank_item=$item_array[2];
                $hidden_item=$item_array[3];
                $button_item=$item_array[4];

                $input['header_tags']=array('id','Name','Organization','Main Url','Server Name','Server Admin','IP Hostname','Server Company_Site','');
                $input['header_tags_type']=array('blank','label','drop_down','label','label','label','label','label',"label");
                $input['select_items']=array('id','Name','mod_organizationID','Main_Url','ServerName','ServerAdmin','IP_Hostname','Server_Company_Site','id');
                $input['item_types']=array('blank','text_field','drop_down','text_field','text_field','text_field','text_field','text_field',"submit_button");
                $input['item_type_properties']=array($blank_item,$text_input_item,$drop_down_input_item,$text_input_item,$text_input_item,$text_input_item,$text_input_item,$text_input_item,$button_item);

                $table_total=array('tags_columns'=>2,'tags_rows'=>9);
                $input['table_total']=$table_total;
                /*
                $table_array=array('width'=>"40%", 'border'=>0,'align'=>"center",'cellpadding'=>2,
                'cellspacing'=>"1" ,'bgcolor'=>"#EBEBEB", 'id'=>"table");
              
                $table_cols_array=array();
                $table_cols_array[]=array('align'=>"left",'bgcolor'=>"#CCC");
                $table_cols_array[]=array('align'=>"right",'bgcolor'=>"#FFFFFF");
              
                $input['tags'][]=array('type'=>"submit",'value'=>'<input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save">');

                $total_cols=$table_total['tags_columns'];
                $total_rows=$table_total['tags_rows'];
                
              
                $input['table_dimentions']=$table_total;

                $input['table_tags']['cols']=$table_cols_array;
                $input['table_tags']['rows']=array();
                $input['table_properties']=$table_array;
                
                //$this->output=$this->Create_Editor_Form($input);

                */
                //Create_Edit_Table($input=array(),$edit_id=0,$sql_table,$order_by="id")
                if(isset($this->var["content_data"]['get_variables']['id'])){
                  $edit_id=$this->var["content_data"]['get_variables']['id'];
                }else{
                  $edit_id=null;
                }
                
                $this->output=$this->Create_Edit_Table($input,$edit_id,"servers","id");
                
                $this->output=$this->Create_HTML_Form($this->output,$_SERVER['REQUEST_URI']);
                return $this->output;
            }

            public function Edit_Domain_Form($edit_id=0){

                

              $item_array=$this->Get_Table_Elements();
              //print_r($item_array);
              /*
              $return_array["text"]=array('type'=>"text",'size'=>"45",'style'=>"",'class'=>"","value"=>'');
              $return_array["drop_down"]=array('type'=>"drop_down",'size'=>"45",'style'=>"",'class'=>"");
              $return_array["blank"]=array('type'=>'blank');
              $return_array["hidden"]=array('type'=>'hidden',"value"=>'',"html"=>'<input type="hidden" value="">');
              $return_array["submit_button"]=array('type'=>"submit_button","value"=>'Submit',"name"=>'Submit',"id"=>'','class'=>"formbuttons");
              */
              //$input['header_tags']=array('id','Name','Analytics','GSiteMapMeta','SiteTitle','AEmail','templatesID','serversID','mirrorID','PublicLT','SEOFriendlyLT');
              $input['header_tags']=array(0=>'Domain Name',1=>'Analytics',2=>'Google Site Map Meta',3=>'Site Title',4=>'Admin Email',5=>'Template',6=>'Server',7=>'Domain Mirror',
                  8=>'Exposure',9=>'SEO Friendly',10=>'id');
              $items=$input['header_tags'];
              $input['header_tags_type']=array('label','label','label','label','label','label','label','label',"label","label");
              /*
              //$input['item_types']=array('text_field','text_field','text_field','text_field','drop_down','drop_down','drop_down','drop_down','drop_down',"submit_button");
              $input['item_types']=array($items['Name']=>"text",$items['Analytics']=>"text",$items['Google Site Map Meta']=>"text",$items['Site Title']=>"text",
              $items['Admin Email']=>"text",$items['Template']=>"drop_down",$items['Server']=>"drop_down",$items['Domain Mirror']=>"drop_down",
              $items['Exposure']=>"drop_down",$items['SEO Friendly']=>"drop_down");
              */

              $input['item_types'][$items[0]]=array("name"=>$items[0],"type"=>"text","value"=>"");
              $input['item_types'][$items[1]]=array("name"=>$items[1],"type"=>"text","value"=>"");
              $input['item_types'][$items[2]]=array("name"=>$items[2],"type"=>"text","value"=>"");
              $input['item_types'][$items[3]]=array("name"=>$items[3],"type"=>"text","value"=>"");
              $input['item_types'][$items[4]]=array("name"=>$items[4],"type"=>"text","value"=>"");
              $input['item_types'][$items[5]]=array("name"=>$items[5],"type"=>"drop_down","value"=>array());
              $input['item_types'][$items[6]]=array("name"=>$items[6],"type"=>"drop_down","value"=>array());
              $input['item_types'][$items[7]]=array("name"=>$items[7],"type"=>"drop_down","value"=>array());
              $input['item_types'][$items[8]]=array("name"=>$items[8],"type"=>"drop_down","value"=>array());
              $input['item_types'][$items[9]]=array("name"=>$items[9],"type"=>"drop_down","value"=>array());
              $input['item_types'][$items[0]]=array("name"=>$items[10],"type"=>"hidden","value"=>"");


              //=====================================================================================================

              $where=array("id"=>$edit_id);
              $list_type['select_vars']=array('id','Name','Analytics','GSiteMapMeta','SiteTitle','AEmail','templatesID','serversID','mirrorID','PublicLT','SEOFriendlyLT');
              $list_type['select_req']=array("Table"=>"domains","Retrieve"=>"single","Search"=>array("id"=>$edit_id));
              $output_vars['domains']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],$where);

              //=====================================================================================================
              
              $list_type['select_vars']=array('id','Name');
              $list_type['select_req']=array("Table"=>"templates","Retrieve"=>"list","Search"=>"all");
              $output_vars['templates']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array());

              //--
              $default=$output_vars['domains']['templatesID'];
              $items=$output_vars['templates'];
              $drop_down=$this->Create_DropDown(array(),$default,$items);
              $output_vars['templates']['drop_down']=$drop_down;
              //print $drop_down;
              //=====================================================================================================
              
              $list_type['select_vars']=array('id','Name');
              $list_type['select_req']=array("Table"=>"servers","Retrieve"=>"list","Search"=>"all");
              $output_vars['servers']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array());
              $default=$output_vars['domains']['serversID'];
              $items=$output_vars['servers'];
              $drop_down=$this->Create_DropDown(array(),$default,$items);
              $output_vars['servers']['drop_down']=$drop_down;

              //=====================================================================================================

              
              $list_type['select_vars']=array('id','Name');
              $list_type['select_req']=array("Table"=>"domains","Retrieve"=>"list","Search"=>"all");
              $output_vars['domains_list']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array());
              $default=$output_vars['domains']['mirrorID'];
              $items=$output_vars['domains_list'];
              $drop_down=$this->Create_DropDown(array(),$default,$items);
              $output_vars['domains_list']['drop_down']=$drop_down;

              //=====================================================================================================

              
              $list_type['select_vars']=array('id','group_label',	'group_code');
              $list_type['select_req']=array("Table"=>"list_multi_select_item_groups","Retrieve"=>"list","Search"=>"all");
              $output_vars['list_multi_select_item_groups']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array());

              //=====================================================================================================

              $list_type['select_vars']=array('id','list_multi_select_item_groupsID',	'item_label');
              $list_type['select_req']=array("Table"=>"list_multi_select_items","Retrieve"=>"list","Search"=>"all");
              $output_vars['list_multi_select_items']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array("list_multi_select_item_groupsID"=>10));
              $items=array();
              foreach($output_vars['list_multi_select_items'] as $key=>$val){
                $items[]=array("id"=>$val['id'],"Name"=>$val['item_label']);
              }

              $default=$output_vars['domains']['PublicLT'];
              //$items=$output_vars['domains_list'];
              $drop_down=$this->Create_DropDown(array(),$default,$items);
              $output_vars['list_multi_select_items_publicLT']['drop_down']=$drop_down;

              //=====================================================================================================

              $list_type['select_vars']=array('id','list_multi_select_item_groupsID',	'item_label');
              $list_type['select_req']=array("Table"=>"list_multi_select_items","Retrieve"=>"list","Search"=>"all");
              $output_vars['list_multi_select_items']=$this->cls->clsDatabaseCRUD->Exec_Retrieve("Assoc",$list_type['select_req']['Table'],$list_type['select_vars'],array("list_multi_select_item_groupsID"=>6));
              $items=array();
              foreach($output_vars['list_multi_select_items'] as $key=>$val){
                $items[]=array("id"=>$val['id'],"Name"=>$val['item_label']);
              }

              $default=$output_vars['domains']['SEOFriendlyLT'];
              //$items=$output_vars['domains_list'];
              $drop_down=$this->Create_DropDown(array(),$default,$items);
              $output_vars['list_multi_select_items_SEOFriendlyLT']['drop_down']=$drop_down;

              //print_r($output_vars['list_multi_select_items_publicLT']['drop_down']);
              

              //=====================================================================================================
              //print_r($output_vars);
              
              $table_settings=array("width"=>'40%', "border"=>'0', "align"=>'center' ,"cellpadding"=>'2',"cellspacing"=>'1', "bgcolor"=>'#EBEBEB',"id"=>'table');

              $table_total=array('tags_columns'=>2,'tags_rows'=>10);
              $input['table_total']=$table_total;

              $this_total_rows="";
              foreach($output_vars['domains'] as $key=>$val){
                switch($key){

                  
                  case "SEOFriendlyLT":
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$output_vars['list_multi_select_items_SEOFriendlyLT']['drop_down'];
                  break;
                  case "PublicLT":
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$output_vars['list_multi_select_items_publicLT']['drop_down'];
                  break;
                  
                  case "mirrorID":
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$output_vars['domains_list']['drop_down'];
                  break;
                  case "serversID":
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$output_vars['servers']['drop_down'];
                  break;
                  case "templatesID":
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$output_vars['templates']['drop_down'];
                  break;
                  default:
                    $heading=$this->Create_Label(array("style"=>"color: white"),$key);
                    $item=$this->Create_TextBox(array(),$val);
                  break;

                }
                $this_heading=$this->Create_Table_TD(array(),$heading);
                $this_data=$this->Create_Table_TD(array(),$item);
                $this_total=$this_heading.$this_data;
                $this_total_rows.=$this->Create_Table_TR(array(),$this_total);
              }
              $this_table_data=$this->Create_Table($table_settings,$this_total_rows);
              
              $this->output.=$this_table_data;
              return $this->output;
          }

            // ==================================================================  new form builder types | create

            public function Create_Members_Login_List_Table(){
              //$this->cls->clsLinks->Setup_Domain();

              $item_array=$this->Create_Table_Elements();
              $text_input_item=$item_array[0];
              $drop_down_input_item=$item_array[1];
              $blank_item=$item_array[2];
              $hidden_item=$item_array[3];
              $button_item=$item_array[4];
              //print_r($item_array);
              //$table_total=$input['table_total'];         
              //$input['table_dimentions']=$table_total;
              $column_count=0;
              $table_total=array('tags_columns'=>2,'tags_rows'=>3,'end_rows'=>1);

              $input['table_dimentions']=$table_total;

              $table_constants=$this->Create_Table_Constants();
              $input['table_properties']=$table_constants[0];
              $input['table_tags_th']=$table_constants[1];
              $input['table_tags_td']=$table_constants[2];
              $input['table_tags_td_odd']=$table_constants[3];

              
              //$table_constants=$this->Create_Create_Table_Constants();
              $table_array=$table_constants[0];
              $table_cols_array=$table_constants[1];
              //print_r($table_constants);
              $input['table_tags']['cols']=$table_constants[1];
              $input['table_tags']['rows']=array();
              $input['table_properties']=$table_constants[0];
              
              $input['header_tags']=array('Username','Password');
              $input['header_tags_type']=array('label','label');
              $input['select_items']=array('username','password');
              $input['item_types']=array('text','text');
              //$input['edit_page']=array('target_uri'=>'/management/');
              $input['item_type_properties']=array($text_input_item,$text_input_item,$button_item);
              $table_total=array('tags_columns'=>2,'tags_rows'=>3);
              $input['table_total']=$table_total;
              $this->output=$this->Create_Input_Form($input);
              //$this->output="Hello Universe";
              //print $this->output;
              $form_action=$_SERVER['REQUEST_URI'];
              //print_r($_SERVER['REQUEST_URI']);
              //print_r($this->var['content']);
              if(isset($this->var['domain']["db"]['SEOFriendlyLT'])){
                if($this->var['domain']["db"]['SEOFriendlyLT']==13){
                  $content_pagesID=$this->var['content']['input']['cpid'];//$this->var['content']['cpid'];
                  //$content_pagesID=512;
                  //print_r($this->var['content']['input']['cpid']);
                  //$domain_name=$this->var['domain']["db"]['Name'];
                  //$guid=$this->cls->clsSession->get_guid();
                  $form_action=$this->cls->clsLinks->Create_Content_Pages_Link($content_pagesID);
                  //$form_action='http://'.$domain_name.$this->var['app']['ROOTDIR'].'index.php?guid='.$guid.'&cpid='.$content_pagesID;
                                
                }else{
                  $content_pagesURI=$_SERVER['REQUEST_URI'];
                  $form_action=$this->cls->clsLinks->Create_SEO_Friendly_Link($content_pagesURI);
                }
              }
              $this->output=$this->Create_HTML_Form($this->output,$form_action);
              return $this->output;
          }
           
            // ==================================================================  new form builder types | list tables

            public function Create_Content_Pages_List_Table(){
                $input['header_tags']=array('id','Page','Title','Menu Title','Changed','Exposure','Sort Order','Edit');
                $input['header_tags_type']=array('blank','label','label','label','label','label','label','label');
                $input['select_items']=array('id','URI','Title','MenuTitle','Changed','Exposure','Sort_Order','id');
                $input['item_types']=array('blank','label','label','label','label','label','label','edit_link');
                $input['edit_page']=array('target_uri'=>'/management-edit-administrator/');
                $this->output=$this->Create_List_Table($input,"content_pages","id");
                return $this->output;
            }

            public function Create_Server_List_Table(){
              $input['header_tags']=array('id','Name','Website','IP Hostname','Server Company Site','Edit');
              $input['header_tags_type']=array('blank','label','label','label','label','label');
              $input['select_items']=array('id','Name','Main_Url','IP_Hostname','Server_Company_Site','id');
              $input['item_types']=array('blank','label','label','label','label','edit_link');
              $input['edit_page']=array('target_uri'=>'/management-hosting-edit-servers/');
              $this->output=$this->Create_List_Table($input,"servers","id");
              return $this->output;
            }
            /*
          public function Create_Domains_List_Table(){
            $input['header_tags']=array('id','Name','Site Title','Edit');
            $input['header_tags_type']=array('blank','label','label','label');
            $input['select_items']=array('id','Name','SiteTitle','id');
            $input['item_types']=array('blank','label','label','edit_link');
            $input['edit_page']=array('target_uri'=>'/management-edit-administrator/');
            $this->output=$this->Create_List_Table($input,"domains","id");
            return $this->output;
          }
          */
          public function Create_Members_List_Table(){
            $input['header_tags']=array('id','Name','Email','Edit');
            $input['header_tags_type']=array('blank','label','label','label');
            $input['select_items']=array('id','Name','Email','id');
            $input['item_types']=array('blank','label','label','edit_link');
            $input['edit_page']=array('target_uri'=>'/management-modify-member/');

            $this->output=$this->Create_List_Table($input,"mod_user_accounts","id");
            return $this->output;
          }

          public function Create_Domains_List_Table(){
            $input['header_tags']=array('id','Name','SiteTitle','Edit');
            $input['header_tags_type']=array('blank','label','label','label');
            $input['select_items']=array('id','Name','SiteTitle','id');
            $input['item_types']=array('blank','label','label','edit_link');
            $input['edit_page']=array('target_uri'=>'/management-edit-domain/');

            $this->output=$this->Create_List_Table($input,"domains","id");
            return $this->output;
          }

          

          public function List_Server_Rows($retrieve_array=array()){

              
            $return_array=$this->List_Table_Rows("servers",$retrieve_array,"id");
            return $return_array;
          }

          

          public function List_Domains_Rows($retrieve_array=array()){
            
            $return_array=$this->List_Table_Rows("domains",$retrieve_array,"id");
            return $return_array;
          }

          

          public function List_Content_Pages_Rows($retrieve_array=array()){
            
            $return_array=$this->List_Table_Rows("content_pages",$retrieve_array,"id");
            return $return_array;
          }  


          
    }