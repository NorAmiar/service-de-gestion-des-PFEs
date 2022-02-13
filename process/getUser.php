<?php 
include("../config/db.php");


$departement = $_POST['departement'];
if(isset($_POST['pin']) && isset($_POST['pin2']) && isset($_POST['pin3'])){
    $pin1 = $_POST['pin'];
    $pin2 = $_POST['pin2'];
    $pin3 = $_POST['pin3'];
    $query = "SELECT * FROM `etudiant` WHERE `pin` IN (?,?,?) AND `departement`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$pin1,$pin2,$pin3,$departement]);
       
        $temp =  "";
        
        while($result = $sql->fetch(PDO::FETCH_ASSOC)){
            $temp = $temp .$result['nom'];
        }
        echo $temp ;
}else{
    if(isset($_POST['pin']) && isset($_POST['pin2'])){
        $pin1 = $_POST['pin'];
        $pin2 = $_POST['pin2'];
        $query = "SELECT * FROM `etudiant` WHERE `pin` IN (?,?) AND `departement`=?";
            $sql = $pdo->prepare($query);
            $sql->execute([$pin1,$pin2,$departement]);
           
            $temp =  "";
            
            while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                $temp = $temp .$result['nom'];
            }
            echo $temp;
    }else{
        if(isset($_POST['pin'])){
            $pin1 = $_POST['pin'];
            $query = "SELECT * FROM `etudiant` WHERE `pin`=? AND `departement`=?";
            $sql = $pdo->prepare($query);
            $sql->execute([$pin1,$departement]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            echo $result["nom"] . "_" . $result['prenom'];
        }
    }   
}

?>