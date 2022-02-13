<?php 
include("../../config/db.php");
    session_start();
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id = $_POST["id"];
        $email = $_POST["email"];
        $user = $_POST["user"];
        $pass = password_hash($_POST["pass"],PASSWORD_DEFAULT);
        $query = "UPDATE `administration` SET `username`=?,`password`=?,`email`=? WHERE `id`=?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$user,$pass,$email,$id])){
           echo "Admin modifié avec success";
        }else{
            echo "Eurreur";
        }

    }else{
        echo "Eurreur dans la saisie des informations";
    }
?>