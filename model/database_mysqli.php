<?php
    $db_info = 'localhost';
    $username = 'f1306676_root';
    $password = '12345';
    $dbname = 'f1306676_assignment4_db';

    $db_con = new mysqli($db_info, $username, $password, $dbname);
    if($db_con->connect_errno){
        die('Mysqli database not connected. Error: '.$db_con->connect_errno);
    }
?>
