<?php 
include("../../config/db.php");
session_start();
$departement=$_SESSION['departement'];
if(isset($_POST['mat']) && !empty($_POST['mat'])){
    $mat = $_POST['mat'];
    $query = "DELETE FROM `etudiant` WHERE `matricule`=? AND `departement`=?";
    $sql = $pdo->prepare($query);
    if($sql->execute([$mat,$departement])){
        echo "Etudiant supprimé de la liste";
    }
}
?>