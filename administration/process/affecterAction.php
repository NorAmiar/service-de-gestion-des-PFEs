<?php 
include("../../config/db.php");
include("../../config/func.php");
session_start();
$departement=$_SESSION['departement'];
$idSujet = $_POST['id'];
$user = $_POST['compte'];
$sujet = "";
$query1 ="UPDATE `sujet` SET `etat`= ? WHERE `id`=?";
        $sql1 = $pdo->prepare($query1);
        $c2 = $sql1->execute([1,$idSujet]);
            $query3 = "SELECT * FROM `sujet` WHERE `id`=?";
            $sql3 = $pdo->prepare($query3);
            $c3 = $sql3->execute([$idSujet]);
            if($c3 && $sql3->rowCount()==1){
                
            $res = $sql3->fetch(PDO::FETCH_ASSOC);
            $sujet = $res['titre'];


        }

        $query2 = "UPDATE `compte_etudiants` SET `sujet`= ? WHERE `user`=? AND `departement`=? ";
        $sql2 = $pdo->prepare($query2);
        $c1 = $sql2->execute([$sujet,$user,$departement]);
        $query3 = "SELECT * FROM `sujet` WHERE `id`=?";
        $sql3 = $pdo->prepare($query3);
        $sql3->execute([$idSujet]);
        if($sql3->rowCount()==1){
            $res = $sql3->fetch(PDO::FETCH_ASSOC);
            $enc = $res['encadreur'];
            $query6 = "SELECT * FROM `encadreur` WHERE `username`=?";
            $sql6 = $pdo->prepare($query6);
            $sql6->execute([$enc]);
            if($sql6->rowCount()==1){
                $res = $sql6->fetch(PDO::FETCH_ASSOC);
                $email = $res['email'];
                $contenu = "Un de vos sujets est affecté . Visitez la plateforme pour plus d'informations";
                //send_mail($email,"Sujet affecté",$contenu);
                //send email
            }
        }
        $query4 = "SELECT * FROM `compte_etudiants` WHERE `user`=?";
        $sql4 = $pdo->prepare($query4);
        $sql4->execute([$user]);
        if($sql4->rowCount()==1){
            $res = $sql4->fetch(PDO::FETCH_ASSOC);
            $userID = $res['idCompte'];
            $query5 = "SELECT * FROM `etudiant` WHERE `id_compte`=?";
            $sql5 = $pdo->prepare($query5);
            $sql5->execute([$userID]);
            if($sql5->rowCount()>0){
                while($row = $sql5->fetch(PDO::FETCH_ASSOC)){
                    $email = $row['email'];
                    $contenu = "Un sujet est affecté a votre compte . VIsitez la plateforme pour plus d'informations";
                    //send_mail($email,"Sujet affecté",$contenu);
                    //send email
                }
            }
        }
        if ($c1 && $c2){
            echo "Sujet affecté avec succes";
        }
?>