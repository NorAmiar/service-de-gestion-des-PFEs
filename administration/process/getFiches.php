<?php 
include("../../config/db.php");
session_start();

    
$id = $_POST["id"];

   
        
            $fiches = array();
            $query = "SELECT * FROM `fiche_suivi` WHERE `id_sujet` = ?";
            $sql = $pdo->prepare($query);
            $sql->execute([$id]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    $fiches[]= $result["id"];
                }
                    
                
                echo json_encode($fiches,JSON_UNESCAPED_UNICODE);
            }
        
    

?>