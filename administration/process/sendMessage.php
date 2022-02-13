<?php 
include("../../config/db.php");
include("../../config/func.php");
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
    $c = $sql->execute([$expiditeur,"admin",$recepteur,$type,$now,$objet,$contenu,0,$departement]);
    if($type=="encadreur"){
        $query = "SELECT * FROM `encadreur` WHERE `username`=.";
        $sql = $pdo->prepare($query);
        $sql->execute([$recepteur]);
        if($sql->rowCount()==1){
            $result = $sql->fecth(PDO::FETCH_ASSOC);
            $mail= $result['email'];
            //send_mail($mail,$objet,$contenu);
        }
    }else{
        $query = "SELECT * FROM `compte_etudiants` WHERE `user`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$recepteur]);
        if($sql->rowCount()==1){
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            $id= $result['idCompte'];
            $query2 = "SELECT * FROM `etudiant` WHERE `id_compte`=?";
            $sql2= $pdo->prepare($query2);
            $sql2->execute([$id]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC))
                $mail= $result['email'];
                //send_mail($mail,$objet,$contenu);
            }

        }
    }
    

    
    if($c){
        echo "Message envoyé avec success";
    }else{
        echo "Eurreur d'envoi";
    }
}
?>