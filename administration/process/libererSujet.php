<?php 
    include("../../config/db.php");
    session_start();
    if(!empty($_POST['id']))
    {
       $id = $_POST['id'];

        $query = "UPDATE `sujet` SET `etat`=? WHERE `departement`=? AND `id`=?";
        $sql = $pdo->prepare($query);
        $c1 = $sql->execute([0,$_SESSION['departement'],$id]);
        $query = "SELECT * FROM  `sujet` WHERE `departement`=? AND `id`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement'],$id]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        $titre = $result["titre"];

        $query = "UPDATE `compte_etudiants` SET `sujet`=? WHERE `sujet`=? AND `departement`=?";
        $sql = $pdo->prepare($query);
        $c2 = $sql->execute(["",$titre,$_SESSION['departement']]);
        
        if($c1 && $c2)
        {
            echo "Sujet liberé avec succes";
        }else{
            echo "eurreur";
        }
    }else{
        echo "eurreur";
    }



?>