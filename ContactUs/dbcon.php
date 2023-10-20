<?php
$server = 'localhost';
$user = 'root';
$password ='';
$db = 'test1';

try{
    $con = new PDO("mysql:host=$server;dbname=$db", $user, $password);
}
catch(PDOException $e){
    echo 'Connection Failed!'. $e-> getMessage();
}
?>