<?php 
    include("../../config/db.php");
    session_start();
    if(isset($_POST['nomDep']) && !empty($_POST['nomDep'])){
        $c = false;
        $c1 = false;
        $c2 = false;
        $nomDep = $_POST['nomDep'];
        $pseudoAdmin = $_POST["pseudoAdmin"];
        $passAdmin = password_hash($_POST["passAdmin"],PASSWORD_DEFAULT);
        $emailAdmin = $_POST["emailAdmin"];
        $pseudoPresident = $_POST["pseudoPresident"];
        $passPresident = password_hash($_POST["passPresident"],PASSWORD_DEFAULT);
        $emailPresident = $_POST["emailPresident"];
        $query = "INSERT INTO `departement` (`nom`) VALUES(?)";
        $sql = $pdo->prepare($query);
        if($sql->execute([$nomDep])){
            $c = true;
        }
        $query = "INSERT INTO `administration` (`username`,`password`,`email`,`departement`) VALUES(?,?,?,?)";
        $sql = $pdo->prepare($query);
        if($sql->execute([$pseudoAdmin,$passAdmin,$emailAdmin,$nomDep])){
            $c1 = true;
        }
        $query = "INSERT INTO `president` (`user`,`password`,`email`,`departement`) VALUES(?,?,?,?)";
        $sql = $pdo->prepare($query);
        if($sql->execute([$pseudoPresident,$passPresident,$emailPresident,$nomDep])){
            $c2 = true;
        }
        if($c && $c1 && $c2){
            echo "Département ajouté avec success";
        }else{
            echo "Eurreur contactez l'equipe de developement";
        }
    }else{
        echo "Eurreur dans la saisie des informations";
    }
?>