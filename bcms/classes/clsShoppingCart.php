<?php

    class clsShoppingCart Extends clsRootVariables{
        use trtBasic;
        
        
        function __construct(){
            
         
        }

                

        public function pre_order_page(){

        }

        public function show_order_page(){
            $this->output='<form name="form1" method="post" action="/shopping-cart/">
                <table border="0" cellpadding="3" cellspacing="1" id="ProductRow">
                  
                  <tr bgcolor="#C6C6CD" >
                    <td>&nbsp;</td>
                    <td><strong>Name</strong></td>
                    <td><strong>Description</strong></td>
                    <td><strong>Price</strong></td>
                    <td><strong>Amount</strong></td>
                  </tr>';
            $Count=0;
            $sql="SELECT id,Image,Name,SDesc,Price,ProductCode FROM Products";
					
					    
            $rslt=$this->db->RawQuery($sql);
            while($myrow=$this->db->Fetch_Array($rslt)){
                $this->output.='<tr bgcolor="'.(($Count%2)==0 ? "#CECECE" : "#E5E5E5").'" >
                <td width="16%">';
                if($myrow[1]!=""){
                    $this->output.='<img src="'.$myrow[1].'">';
                }
                $this->output.='</td>
                    <td width="36%">'.$myrow[2].'</td>
                    <td width="33%">'.$myrow[3].'</td>
                    <td width="6%">AU$'.$myrow[4].'</td>
                    <td width="9%" align="center"><input name="Products['.$myrow[5].']" type="text" id="Products['.$myrow[0].']" size="4"></td>
                  </tr>';
			};
            $this->output.='<tr bgcolor="#405175"  >
                <td colspan="5"><div align="right">
                    <input type="submit" name="Submit" value="Order">
                </div></td>
                </tr>
            </table>
            </form>';
            return $this->output;
        }

        public function pre_shopping_cart(){
            
            if(isset($_POST['Submit'])){
                if($_POST['Submit']=="Order"){
                    if(is_array($_POST)){
                        if(!isset($_SESSION['Products'])){
                            $_SESSION['Products']=array();
                        }
                        $item_count=0;
                        //print_r($_POST);
                        //foreach($_POST as $ID=>$Amount){
                        foreach($_POST['Products'] as $ID=>$Amount){
                            //echo"<br> \n\n->".$ID."-".$Amount."<br>ggg \n\n";
                            if(is_numeric($Amount)){
                                if($Amount>0){
                                    //echo"<br> \n\n->".$ID."-".$Amount."<br>ggg \n\n";
                                    //set_log(array($ID,$Amount),"xxx321");
                                     
                                    if(!isset($_SESSION['Products'][$ID])){
                                        $_SESSION['Products'][$ID]=0;
                                    }
                                    if(is_array($_SESSION['Products'][$ID])){
                                        $_SESSION['Products'][$ID]=0;
                                    }
                                    if($_SESSION['Products'][$ID]>0){
                                        if(!is_array($_SESSION['Products'][$ID])){
                                            $_SESSION['Products'][$ID]+=$Amount;
                                        }
                                    }else{
                                        $_SESSION['Products'][$ID]=$Amount;
                                    }
                                    //print_r($_SESSION);
                                }
                            }
                            $item_count++;
                        }
                        
                    }
                }
            }
            //echo"<pre>";
            //print_r($_POST);
            //print_r($_SESSION);
            if(isset($_POST['Submit'])){
                if($_POST['Submit']=="Change"){
                    //print_r($_SESSION);
                    if(is_array($_POST)){
                        foreach($_POST as $ID=>$Amount){
                            $str=substr($ID, 0, 7);  
                                    
                            if($str=="modify_"){
                                $ID=substr($ID, 7, strlen($ID)); 
                                if($ID!=$_POST['Submit']){
                                    if($Amount==0){
                                        unset($_SESSION['Products'][$ID]);
                                    }else{
                                        $_SESSION['Products'][$ID]=$Amount;
                                    }
                                }
                            }
                            
                        }
                    }
                    
                    if(isset($_POST['Delete'])){
                        if(is_array($_POST['Delete'])){
                            foreach($_POST['Delete'] as $ID=>$Amount){
                                if($ID!='Submit'){
                                    $str=substr($Amount, 0, 7);  
                                    
                                    if($str=="delete_"){
                                        //echo "\n\n 111fff".$str."=>".$_SESSION['Products'][$ID]."\n\n"."\n\n"; 
                                        //$_SESSION['Products'][$ID]=0;
                                        unset($_SESSION['Products'][$ID]);
                                    }else{
                                    //echo "\n\n gggf".$str."\n\n"; 
                                    }
                                    
                                }
                            }
                        }
                    }
                }
            }
        }

        
    

        public function show_shopping_cart(){
            
            $this->output='<form name="form1" method="post" action="">
            <table width="589"  border="0" cellpadding="3" cellspacing="1" id="ProductRow">
            
            <tr bgcolor="#C6C6CD" >
                <td width="144"><strong>Name</strong></td>
                <td><strong>Description</strong></td>
                <td><strong>Price</strong></td>
                <td><strong>Amount</strong></td>
                <td><strong>Delete</strong></td>
            </tr>';

            $Count=0;
            $Total=0;
            $cart_array=array();
            if(isset($_SESSION['Products'])){
                if(is_array($_SESSION['Products'])){
                    $product_array=$_SESSION['Products'];
                    //print_r($product_array);
                    foreach($product_array as $key=>$val){
                        if($val>0){
                            $sql="SELECT id,Image,Name,SDesc,Price,ProductCode FROM Products WHERE ProductCode='$key'";
                            $rslt=$this->db->RawQuery($sql);
                            //print ($sql);
                            while($myrow=$this->db->Fetch_Array($rslt)){
                                
                                if($myrow[5]==$key){
                                    //echo"\n\n yyy $key=>$val  \n\n";
                                    $sub_total=0;
                                    $sub_total=$val*$myrow[4];
                                    $Total+=$sub_total;
                                    $cart_array[$Count]=array(0=>$myrow,1=>$val,2=>$Count,3=>$key,4=>$sub_total,5=>$Total);
                                    $show=true;
                                }else{
                                    $show=false;
                                }
                                
                                if($show){
                                    $oa=$cart_array[$Count];
                                    //print_r($oa);
                                    $this->output.='<tr bgcolor="'.(($oa[2]%2)==0 ? "#CECECE" : "#E5E5E5").'" >
                                        <td>'.$oa[0][2].'</td>
                                        <td width="275">'.$oa[0][3].'</td>
                                        <td width="46">AU$'.$oa[0][4].'</td>
                                        <td width="46" align="center"><input name="modify['.$oa[0][5].'" type="text" size="4" value="'.$oa[1].'"></td>
                                        <td width="40" align="center"><input type="checkbox" name="Delete['.$oa[0][5].']" value="delete_'.$oa[0][0].'"></td>
                                        </tr>';
                                        
                                        $Count++;
                                }
                            };
                        }
                    }
                    
                };
            };


            $this->output.='<tr bgcolor="#C6C6CD"  >
                                        <td colspan="2" align="right">TOTAL</td>
                                        <td colspan="3">$'.$Total.'</td>
                                    </tr>
                        <tr bgcolor="#405175"  >
                        <td colspan="5"><div align="right">
                        <input type="submit" name="Submit" value="Change">
                        <br>
                        <br>
                        
                        </div></td>
                    </tr>
                    </table>
                </form>';
            return $this->output;
        }
    }

