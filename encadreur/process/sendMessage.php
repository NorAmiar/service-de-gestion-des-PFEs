<?php 
include("../../config/db.php");
session_start();
if(!empty($_POST['objet']) && !empty($_POST['contenu']) && !empty($_POST['recepteur']) && !empty($_POST['type'])){
    $objet = $_POST['objet'];
    $contenu = $_POST['contenu'];
    $recepteur = $_POST['recepteur'];
    $type = $_POST['type'];
    $expiditeur = $_SESSION['user'];
    $departement = $_SESSION['departement'];
    $now = date("Y-m-d H:i:s");

    $query = "INSERT INTO `messagerie`(`expiditeur`, `natureExp`, `recepteur`, `natureRec`, `date`, `objet`, `contenu`, `statut`, `departement`) VALUES (?,?,?,?,?,?,?,?,?)";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([$expiditeur,"encadreur",$recepteur,$type,$now,$objet,$contenu,0,$departement]);
    if($c){
        echo "Message envoyé avec success";
    }else{
        echo "Eurreur d'envoi";
    }
}
?>