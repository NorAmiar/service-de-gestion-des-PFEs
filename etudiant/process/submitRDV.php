<?php 
include("../../config/db.php");
session_start();

$departement = $_SESSION['departement'];
$query = "SELECT * FROM `sujet` WHERE `titre`=? AND `departement`=?";
$sql = $pdo->prepare($query);
$sql->execute([$_SESSION['theme'],$departement]);
if($sql->rowCount()==1){
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $encadreur = $result['encadreur'];


    if(!empty($_POST['date']) && !empty($_POST['heure']) && !empty($_POST['lieu'])){
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $user = $_SESSION['user'];
        
        $query = "INSERT INTO `rdv`(`encadreur`, `compte_etudiant`, `date`, `time`, `lieu`, `statut`, `validEncadreur`, `validEtudiant`, `departement`) VALUES (?,?,?,?,?,?,?,?,?)";
        $sql = $pdo->prepare($query);
        $c = $sql->execute([$encadreur,$user,$date,$heure,$lieu,0,0,1,$departement]);
        if($c){
            echo "Vous avez demander un rendez vous avec success";
        }else{
            echo "eurreur";
        }
    
    
        
    }
}



?>