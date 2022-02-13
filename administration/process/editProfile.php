<?php 
include("../../config/db.php");
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$oldPassword = $_POST['oldPassword'];
$user = $_SESSION['user'];

$query = "SELECT * FROM administration WHERE username=?";
$sql = $pdo->prepare($query);
if($sql->execute([$user])){
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $hash = $result['password'];
                    if(password_verify ($oldPassword , $hash )){
                        $query2 = "UPDATE `administration` SET `password`=?,`email`=? WHERE `username`=?";
                        $sql2 = $pdo->prepare($query2);
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        if($sql2->execute([$hashedPassword,$email,$user])){
                            echo "Profile modifié avec succes";
                        }
                    }else{
                        echo "Mot de passe eronné";
                    }
}



?>