<?php 
include("../../config/db.php");
session_start();
$nom = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
$prenom = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
$pseudo = filter_var($_POST['pseudo'],FILTER_SANITIZE_STRING);
$mdp =   password_hash($_POST['mdp'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$number = $_POST['number'];
$grade = $_POST['grade']; 
$domaines = filter_var($_POST['domaines'],FILTER_SANITIZE_STRING);
$departement = $_SESSION['departement'];
$query = "INSERT INTO `encadreur`(`departement`, `nom`, `prenom`, `email`, `username`, `password`, `number`, `grade`, `domaine`) VALUES (?,?,?,?,?,?,?,?,?)";
$sql = $pdo->prepare($query);
if($sql->execute([$departement,$nom,$prenom,$email,$pseudo,$mdp,$number,$grade,$domaines])){
    echo "done";
}



?>