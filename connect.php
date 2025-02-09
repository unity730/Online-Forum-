<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";
try{
$conn =mysqli_connect($host,
                      $user,
                      $pass,
                      $db);
                    }
catch(mysqli_sql_exception){
     echo "Could not connect <br> ";
    }                   
?>