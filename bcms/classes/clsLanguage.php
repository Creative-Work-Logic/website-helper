<?php

    class clsLanguage{
        use trtBasic;
        //class clsLanguage {

        
            
            function __construct(){
                
                
		}

        

                        
        

        public function Language_Init(){
            //
            if(isset($_POST['LanguagesID'])){
                if($_POST['LanguagesID']){
                    $_SESSION['LanguagesID']=$_POST['LanguagesID'];
                    $LanguagesID=$_POST['LanguagesID'];
                }elseif(!$_SESSION['LanguagesID']){
                    $_SESSION['LanguagesID']=1;
                    $LanguagesID=1;
                }
            }else{
                $_SESSION['LanguagesID']=1;
                $LanguagesID=1;
            }
            $this->var['app']['LANGUAGESID']=$LanguagesID;
            //define('LANGUAGESID',$LanguagesID);
            //
        }

        public function Language_Definitions(){
            //
			////$this->log->general("-Language Start-",1);
	
            $template_defs=array();
            
            //$query="SELECT Code,Definition FROM languages_definition WHERE languagesID=".LANGUAGESID." AND templatesID=".TEMPLATESID
            //$query="SELECT Code,Definition FROM languages_definition WHERE languagesID=".$app_data['LANGUAGESID']." AND templatesID=".$content_data["db"]['templatesid']
            
            /*
            $rslt=$r->RawQuery($query);
            $log->general("-Language Query-".$query,1);
            while($data=$r->Fetch_Array($rslt)){
                $template_defs[$data[0]]=$data[1];
            }
            */
			//
		}

        

        
    }