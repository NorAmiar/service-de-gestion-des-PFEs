<?php 
include("../../config/db.php");
session_start();

$departement = $_SESSION['departement'];
$encadreur = $_SESSION['user'];
if(!empty($_POST['date']) && !empty($_POST['heure']) && !empty($_POST['lieu']) && !empty($_POST['user'])){
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $lieu = $_POST['lieu'];
    $user = $_POST['user'];
    
    $query = "INSERT INTO `rdv`(`encadreur`, `compte_etudiant`, `date`, `time`, `lieu`, `statut`, `validEncadreur`, `validEtudiant`, `departement`) VALUES (?,?,?,?,?,?,?,?,?)";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([$encadreur,$user,$date,$heure,$lieu,0,1,0,$departement]);
    if($c){
        echo "Vous avez demander un rendez vous avec success";
    }else{
        echo "eurreur";
    }


    
}


?>