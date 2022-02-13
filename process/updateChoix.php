<?php

include("../config/db.php");
    $array= $_POST['affected'];


    for($i=0;$i<sizeof($array);$i++){
        $sujet = $array[$i][1];
        $id = $array[$i][0];
        $query ="UPDATE `sujet` SET `etat`= ? WHERE `titre`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([1,$sujet]);
        $query2 = "UPDATE `compte_etudiants` SET `sujet`= ? WHERE `idCompte`=?";
        $sql2 = $pdo->prepare($query2);
        $sql2->execute([$sujet,$id]);
    }
    
    $query3 = "DELETE FROM `choix` WHERE ?";
    $sql3 = $pdo->prepare($query3);
    $sql3->execute([1]);

?>