<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $query = "DELETE FROM `rdv` WHERE `departement`=? AND `id`=?";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([$departement,$id]);
    if($c){
        echo "Rendez Vous annulé avec success";
    }else{
        echo "eurreur";
    }

}
?>