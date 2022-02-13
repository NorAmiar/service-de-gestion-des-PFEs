<?php 
    include("../../config/db.php");
    session_start();
    $departement = $_SESSION['departement'];

    if(!empty($_POST['id'])){

    $id = $_POST['id'];
        $c1 = false;
        $c2 = false;
        $c3 = false;
        $c4 = false;
        $query = "SELECT * FROM `choix` WHERE `id`=? AND `departement`=? ";
        $sql = $pdo->prepare($query);
        $c1 = $sql->execute([$id,$departement]);
        if($sql->rowCount()>0){
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            $idCompte = $result['idCompte'];
            $sujet = $result['sujet'];

        }

        $query1 ="UPDATE `sujet` SET `etat`= ? WHERE `titre`=?";
        $sql1 = $pdo->prepare($query1);
        $c2 = $sql1->execute([1,$sujet]);

        $query2 = "UPDATE `compte_etudiants` SET `sujet`= ? WHERE `idCompte`=? AND `departement`=? ";
        $sql2 = $pdo->prepare($query2);
        $c3 = $sql2->execute([$sujet,$idCompte,$departement]);


        $query3 = "DELETE FROM `choix` WHERE `sujet`= ? AND `departement`=? ";
        $sql3 = $pdo->prepare($query3);
        $c4 = $sql3->execute([$sujet,$departement]);

        if($c1 && $c2 && $c3 && $c4){
            echo "Choix confirmé avec succes";
            $_SESSION['theme'] = $sujet;
        }else{
            echo "Choix non confirmé";
        }




    }else{
        echo "eurreur";
    }




    