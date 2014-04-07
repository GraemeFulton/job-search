<?php

Class Database_Connect{
    
    
    public function ssh_connection(){
        
        if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");
        // log in at server1.example.com on port 22
        if(!($con = ssh2_connect("lostgrad.com", 1414))){
            echo "fail: unable to establish connection\n";
        } else {
            // try to authenticate with username root, password secretpassword
            if(!ssh2_auth_password($con, "graylien3042", "Z1days1ZO")) {
                echo "fail: unable to authenticate\n";
            } else {
                // allright, we're in!
                echo "okay: logged in...\n";
             //   die("okay: logged in...\n");
            }
        }
        
        
    }
    
    public function connect_database(){
        
          $DB_USER= 'graylien89';
          $DB_NAME='lgwp';
          $DB_PASS='jinkstron3042';
          $DB_HOST='localhost';
          
//           $DB_USER= 'root';
//          $DB_NAME='lgwp';
//          $DB_PASS='jinkster2312';
//          $DB_HOST='localhost';
           //set class database connection
          return new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);
          
    }
    
}
?>
