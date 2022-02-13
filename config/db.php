<?php 
   //connexion base de donnée
    try{
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
        $pdo = new PDO("mysql:host=localhost;dbname=gpfe","root","amine07!",$options);
     }
     catch(PDOException $e){
        echo $e->getMessage();
     }
?>