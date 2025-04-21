<?php


    //echo"db-file-0-------------------|-666-|----------------------------------------------------------\n\n";
    $DBList=array();
    $DB=array();
    
        /*
        $DB['default']=false;
        $DB['server_tag']="db-hg-reseller.php";
        $DB['server_desc']="HostGator Reseller";
        $DB['current_dir']="D:/Program Files/Ampps/www/";
        $DB['hostname']="localhost";
        $DB['usernamedb']='root';
        $DB['passworddb']='mysql';
        $DB['dbName']='bubblelite';
        $DB['port']=3302;
        $DB['server_type']="MySQL";
        $DB['server_number'] = 1;
        $DB['db_server_id'] = $DB['server_type']."-".$DB['server_number'];
        $DBList[]=$DB;
    */
        $DB['default']=true;
        $DB['server_tag'] = "db-sqlite3.php";
        $DB['server_desc'] = "Sqlite";
        $DB['current_dir'] = "/var/www/html";
        $DB['hostname'] = "none";
        $DB['usernamedb'] = "none";
        $DB['passworddb'] = "none";
        $DB['dbName'] = './bcms/db/2024-bubblelite.db';
        $DB['port']="";
        $DB['server_type'] = "Sqlite";
        $DB['server_number'] = 1;
        $DB['db_server_id'] = $DB['server_type']."-".$DB['server_number'];
        $DBList[]=$DB;
        
        /*
        $DB['server_tag']="db-pgSQL.php";
        $DB['server_desc']="pgSQL";
        $DB['current_dir']="/var/www/html";
        $DB['server_number']=2;
        $DB['hostname']="localhost";
        $DB['usernamedb']="Edit This";
        $DB['passworddb']="Edit This";
        $DB['dbName']="cwy0ek0e_bubblelite2";
        $DB['server_type']="pgSQL";
        $DB['server_number'] = 1;
        $DB['db_server_id'] = $DB['server_type']."-".$DB['server_number'];
        */

    $server_DB_list=array();
    foreach($DBList as $key=>$val){
        $DB=$val;
        $DB['dbNames']=array($DB['dbName']);

        $server_DB=array('current_db_type'=>$DB['server_type'],'server_tag'=>$DB['server_tag'],'server_desc'=>$DB['server_desc']
        ,'current_dir'=>$DB['current_dir'],'server_number'=>$DB['server_number'],
        'hostname'=>$DB['hostname'],'usernamedb'=>$DB['usernamedb'],'passworddb'=>$DB['passworddb'],
        'dbName'=>$DB['dbName'],'dbNames'=>$DB['dbNames'],'port'=>$DB['port'],
        'db_server_id'=>$DB['db_server_id'],'server_type'=>$DB['server_type'],'default'=>$DB['default']);
        $server_DB_list[$DB['db_server_id']]=$server_DB;
    }
