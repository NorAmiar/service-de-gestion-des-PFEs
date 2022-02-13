<?php 
include("../../config/db.php");
session_start();
$id = $_POST['id'];
$user = $_POST['pseudo'];
$type = $_POST['type'];
$moyenne = $_POST['moyenne'];
$niveau = $_POST['niveau']; 

$query = "UPDATE `compte_etudiants` SET `user`=?,`moyenne_compte`=?,`typeC`=?,`niveau`=? WHERE `idCompte` = ?";
$sql = $pdo->prepare($query);
if($sql->execute([$user,$moyenne,$type,$niveau,$id])){
    echo "Compte modifier avec succes";
}



?>