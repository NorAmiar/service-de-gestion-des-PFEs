<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

    


   
        $encadreurs = array();
        $query = "SELECT * FROM `encadreur` WHERE `departement`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$departement]);
        if($sql->rowCount()>0){
            while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                $encadreurs[]= $result['username'];
            }
           
        }

                echo json_encode($encadreurs,JSON_UNESCAPED_UNICODE);
          
    

?>