<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

    


   
        $encadreurs = array();
      

        
            
            $query = "SELECT * FROM `etudiant` WHERE `departement`=? AND `id_compte` IS NULL";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    $encadreurs[]= [$result['matricule'],$result["nom"]." ".$result["prenom"]];
                }
                echo json_encode($encadreurs,JSON_UNESCAPED_UNICODE);
            }
        
    

?>