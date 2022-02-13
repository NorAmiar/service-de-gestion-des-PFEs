<?php 
include("../../config/db.php");
session_start();

$id = $_POST['id'];
$matricule = $_POST['mat'];
$nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
$prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$moyenne = $_POST['moyenne'];
$niveau = $_POST['niveau']; 

$query = "UPDATE `etudiant` SET `matricule`=?,`nom`=?,`prenom`=?,`email`=?,`moyenne_e`=?,`niveau`=? WHERE `id` = ?";
$sql = $pdo->prepare($query);
if($sql->execute([$matricule,$nom,$prenom,$email,$moyenne,$niveau,$id])){
    echo "Etudiant modifier avec succes";
}



?>