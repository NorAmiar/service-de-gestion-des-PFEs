<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

    
$id = $_POST["id"];

   
        
            
            $query = "SELECT * FROM `sujet` WHERE `departement`=? AND `id` = ?";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement,$id]);
            if($sql->rowCount()==1){
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                    
                
                echo json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        
    

?>