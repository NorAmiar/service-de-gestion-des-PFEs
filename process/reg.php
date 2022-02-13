<?php 
include("../config/db.php");

$type="";
if (isset($_POST['ty']) && !empty($_POST['ty'])) {
    $type =  $_POST['ty'];
}
if (isset($_POST['user']) && !empty($_POST['user'])) {
    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
  
}
if (isset($_POST['pass']) && !empty($_POST['pass'])) {
    $pass = $_POST['pass'];
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
 
}
if (isset($_POST['pin']) && !empty($_POST['pin'])) {
    $pin = $_POST['pin'];
}
if (isset($_POST['pin2']) && !empty($_POST['pin2'])) {
    $pin2 = $_POST['pin2'];
}
if (isset($_POST['pin3']) && !empty($_POST['pin3'])) {
    $pin3 =  $_POST['pin3'];
}
if (isset($_POST['departement']) && !empty($_POST['departement'])) {
    $departement =  $_POST['departement'];
}

if($type=="Monome"){
    $c1 = false;
    $c2 = false;
    $c3 = false;
    $c4 = false;
    $query2 = "SELECT * FROM `etudiant` WHERE `pin`= ? AND `id_compte` IS NULL";
    $sql2 = $pdo->prepare($query2);
    if($sql2->execute([$pin])){
        $c1 =true;
    }else{
        $c1=false;
    }
    $result = $sql2->fetch(PDO::FETCH_ASSOC);
    $moyenne = $result['moyenne_e'];
    $niveau = $result['niveau'];
    $query = "INSERT INTO `compte_etudiants`(`departement`, `user`, `pass`, `moyenne_compte`, `typeC`,`niveau`) VALUES (?,?,?,?,?,?)";
    $sql = $pdo->prepare($query);
    if($sql->execute([$departement,$user,$hashedPassword,$moyenne,$type,$niveau])){
        $c2 = true;
    }else{
        $c2=false;
    }
       
        $query3 = "SELECT `idCompte` FROM `compte_etudiants` WHERE `user`= ?";
        $sql3 = $pdo->prepare($query3);
        if($sql3->execute([$user])){
            $c3 = true;
        }else{
            $c3=false;
        }
        $result = $sql3->fetch(PDO::FETCH_ASSOC);
        $id = $result['idCompte'];
        $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `pin`=?";
        $sql1 = $pdo->prepare($query1);
        if($sql1->execute([$id,$pin])){
            $c4=true;
        }else{
            $c4=false;
        }

        if($c1 && $c2 && $c3 && $c4){
            echo "Compte inscrit Avec Succes";
        }else{
            echo "Vous avez déja un compte";
        }
         
        

    
}else{
    if($type=="Binome"){
        $c1 = false;
        $c2 = false;
        $c3 = false;
        $c4 = false;


        $query2 = "SELECT * FROM `etudiant` WHERE `pin` IN(?,?) AND `id_compte` IS NULL";
        $sql2 = $pdo->prepare($query2);
        
        if($sql2->execute([$pin,$pin2]) && $sql2->rowCount()==2){
            $c1 = true;
        }
        // if option max or moy
        $queryX = "SELECT * FROM `departement` WHERE `nom` = ?";
        $sqlX = $pdo->prepare($queryX);
        $sqlX->execute([$departement]);
        $resultX = $sqlX->fetch(PDO::FETCH_ASSOC);
        $moyenne = 0;
        $rows = []; 
        while($result = $sql2->fetch(PDO::FETCH_ASSOC)){
            $rows[] = $result;
            $moyenne = $moyenne + $result['moyenne_e'];
            $niveau = $result['niveau'];
            
        }
        if($resultX["moy"]){
           
            if($rows[0]['moyenne_e']>$rows[1]['moyenne_e']){
                $moyenne = $rows[0]['moyenne_e'];
            }else{
                $moyenne = $rows[1]['moyenne_e'];
            }
        }else{
          
            $moyenne = $moyenne/2;
            $moyenne = round($moyenne, 2);
        }



      
       
        if($rows[0]['niveau'] != $rows[1]['niveau']){
            echo "Niveau déffirent des étudiants verifier vos PIN";
        }else{
        
        $query = "INSERT INTO `compte_etudiants`(`departement`, `user`, `pass`, `moyenne_compte`, `typeC`,`niveau`) VALUES (?,?,?,?,?,?)";
        $sql = $pdo->prepare($query);
        if($sql->execute([$departement,$user,$hashedPassword,$moyenne,$type,$niveau])){
            $c2 = true;
        }
       
        $query3 = "SELECT `idCompte` FROM `compte_etudiants` WHERE `user`= ?";
        $sql3 = $pdo->prepare($query3);
        if($sql3->execute([$user])){
            $c3 = true;
        }
        $result = $sql3->fetch(PDO::FETCH_ASSOC);
        $id = $result['idCompte'];
        $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `pin` IN (?,?)";
        $sql1 = $pdo->prepare($query1);
        if($sql1->execute([$id,$pin,$pin2])){
            $c4 = true;
        }
        if($c1 && $c2 && $c3 && $c4){
            echo "Compte inscrit Avec Succes" ;
        }else{
            echo "Un de vous a déja un compte";
        }
    }
    }else{
        if($type=="Trinome"){
            $c1 = false;
            $c2 = false;
            $c3 = false;
            $c4 = false;
            $query2 = "SELECT * FROM `etudiant` WHERE `pin` IN(?,?,?) AND `id_compte` IS NULL";
            $sql2 = $pdo->prepare($query2);
            if($sql2->execute([$pin,$pin2,$pin3]) && $sql2->rowCount()==3){
                $c1 = true;
            }
            
            $queryX = "SELECT * FROM `departement` WHERE `nom` = ?";
            $sqlX = $pdo->prepare($queryX);
            $sqlX->execute([$departement]);
            $resultX = $sqlX->fetch(PDO::FETCH_ASSOC);


            $moyenne = 0;
            $rows = []; 
            while($result = $sql2->fetch(PDO::FETCH_ASSOC)){
                $rows[] = $result;
                $moyenne = $moyenne + $result['moyenne_e'];
                $niveau = $result['niveau'];
            }
            if($rows[0]['niveau'] != $rows[1]['niveau'] && $rows[2]["niveau"]){
                echo "Niveau déffirent des étudiants verifier vos PIN";
            }else{
            if($resultX["moy"]){
                if($rows[0]['moyenne_e']>$rows[1]['moyenne_e'] && $rows[0]['moyenne_e']>$rows[2]['moyenne_e']){
                    $moyenne = $rows[0]['moyenne_e'];
                }else{
                    if($rows[1]['moyenne_e']>$rows[0]['moyenne_e'] && $rows[1]['moyenne_e']>$rows[2]['moyenne_e']){

                    $moyenne = $rows[1]['moyenne_e'];
                    }else{

                        $moyenne = $rows[2]['moyenne_e'];
                    }

                }
            }else{
            $moyenne = $moyenne/3;
            $moyenne = round($moyenne, 2);
            }
            $query = "INSERT INTO `compte_etudiants`(`departement`, `user`, `pass`, `moyenne_compte`, `typeC`,`niveau`) VALUES (?,?,?,?,?,?)";
            $sql = $pdo->prepare($query);
            if($sql->execute([$departement,$user,$hashedPassword,$moyenne,$type,$niveau])){
                $c2=true;
            }
           
            $query3 = "SELECT `idCompte` FROM `compte_etudiants` WHERE `user`= ?";
            $sql3 = $pdo->prepare($query3);
            if($sql3->execute([$user])){
                $c3 = true;
            }
            $result = $sql3->fetch(PDO::FETCH_ASSOC);
            $id = $result['idCompte'];
            $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `pin` IN (?,?,?)";
            $sql1 = $pdo->prepare($query1);
            if($sql1->execute([$id,$pin,$pin2,$pin3])){
                $c4 = true;
            }

            if($c1 && $c2 && $c3 && $c4){
                echo "Compte inscrit Avec Succes";
            }else{
                echo "Un de vous a déja un compte";
            }
             
        }
    }
    }

}


?>