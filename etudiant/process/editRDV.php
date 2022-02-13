<?php 
include("../../config/db.php");
session_start();

$departement = $_SESSION['departement'];
if(!empty($_POST['date']) && !empty($_POST['heure']) && !empty($_POST['lieu']) && !empty($_POST['id'])){
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $lieu = $_POST['lieu'];
    $id = $_POST['id'];
    
    $query = "UPDATE `rdv` SET `date`=?,`time`=?,`lieu`=?,`validEncadreur`=?,`validEtudiant`=? WHERE `id`=? AND `departement`=?";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([$date,$heure,$lieu,0,1,$id,$departement]);
    if($c){
        echo "Vous avez modifier le rendez vous avec success";
    }else{
        echo "eurreur";
    }


    
}


?>