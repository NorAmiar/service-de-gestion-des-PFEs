<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $query = "UPDATE `rdv` SET `statut`=? WHERE `departement`=? AND `id`=?";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([1,$departement,$id]);
    if($c){
        echo "Rendez Vous validé avec success";
    }else{
        echo "eurreur";
    }

}
?>