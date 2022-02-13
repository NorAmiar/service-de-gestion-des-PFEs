<?php 

include("../config/db.php");
session_start();

//recupiration des données depuis le formulaire 
$user = $_POST['user'];
$user = filter_var($user, FILTER_SANITIZE_STRING);
$pass = $_POST['pass'];







if(!empty($user) && !empty($pass)){ //test si les donnée ne sont pas vide ..

    //president
    $query1="SELECT * FROM `president` WHERE `user`=?";
    //administration
    $query2="SELECT * FROM administration WHERE username=?";
    //encadreurs
    $query3="SELECT * FROM encadreur WHERE username=?";
    //etudiants
    $query4="SELECT * FROM compte_etudiants WHERE user=?";

    $sql1 = $pdo->prepare($query1);
    $sql1->execute(array($user));
    if($sql1->rowCount() == 1){
        //presedent redirect + session vars
        $result = $sql1->fetch(PDO::FETCH_ASSOC);
        $departement = $result['departement'];
                    $hash = $result['password'];
                    if(password_verify ($pass , $hash )){
                        $_SESSION['departement']=$departement;

                        $_SESSION['role']="president";
                        echo "president";
                    }else{
                        echo "Incorrect password";
                    }
    }else{
        $sql2 = $pdo->prepare($query2);
        $sql2->execute(array($user));
        if($sql2->rowCount() == 1){
            //admin redirect + session vars
            $result = $sql2->fetch(PDO::FETCH_ASSOC);
                    $hash = $result['password'];
                    $departement = $result['departement'];
                    if(password_verify ($pass , $hash )){
                        if($result["super"]){
                            $_SESSION['user']= $result['username'];
                            $_SESSION['role']="superadmin";
                            echo "superadmin";
                        }else{

                       
                        $_SESSION['user']= $result['username'];
                        $_SESSION['role']="admin";
                        $_SESSION['departement']=$departement;
                        echo "admin";
                    }
                    }else{
                        echo "Incorrect password";
                    }
        }else{
            $sql3 = $pdo->prepare($query3);
            $sql3->execute(array($user));
            if($sql3->rowCount() == 1){
                //reditect encadreur + session
                $result = $sql3->fetch(PDO::FETCH_ASSOC);
                    $hash = $result['password'];
                    if(password_verify ($pass , $hash )){
                        $_SESSION['user']= $result['username'];
                        $_SESSION['role']= "encadreur";
                        $_SESSION['email']= $result['email'];
                        $_SESSION['nom']= $result['nom'];
                        $_SESSION['prenom'] = $result['prenom'];
                        $_SESSION['number'] = $result['number'];
                        $_SESSION['departement'] = $result['departement'];
                        echo "encadreur";
                    }else{
                        echo "Incorrect password";
                    }
            }else{
                $sql4 = $pdo->prepare($query4);
                $sql4->execute(array($user));
                if($sql4->rowCount() == 1){
                    //redirect etudiant + session
                    $result = $sql4->fetch(PDO::FETCH_ASSOC);
                    $hash = $result['pass'];
                    if(password_verify ($pass , $hash )){
                        $_SESSION['id'] = $result['idCompte'];
                        $_SESSION['user']=$result['user'];
                        $_SESSION['role']="etudiant";
                        $_SESSION['niveau']= $result['niveau'];
                        $_SESSION['theme'] = $result['sujet'];
                        $_SESSION['departement']= $result['departement'];
                        $_SESSION['moyenne'] = $result['moyenne_compte'];

                        echo "etudiant";
                    }else{
                        echo "Incorrect password";
                    }
                    
                    
                }else{
                    //eurreur cridentials 
                    echo "Pseudo n'existe pas";
                }
            }    
        } 
    } 

}

?>