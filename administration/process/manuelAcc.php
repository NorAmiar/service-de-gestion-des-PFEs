<?php 

include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

$ok=true;
$obligatoires=array('user','password','etuds','type');
foreach($obligatoires as $obligatoire){
   
  if( ! (isset($_POST[$obligatoire]) && !empty($_POST[$obligatoire])) ){
    $ok=false;
    break;
  }
}
if($ok){
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $type = $_POST['type'];
    $etuds = $_POST['etuds'];
if($type=="Monome"){
    $c1 = false;
    $c2 = false;
    $c3 = false;
    $c4 = false;
    $pin = $etuds[0];
    $query2 = "SELECT * FROM `etudiant` WHERE `matricule`= ? AND `id_compte` IS NULL  ";
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
        $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `matricule`=?";
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

        $pin = $etuds[0];
        $pin2 = $etuds[1];
        $query2 = "SELECT * FROM `etudiant` WHERE `matricule` IN(?,?) AND  `id_compte` IS NULL";
        $sql2 = $pdo->prepare($query2);
        
        if($sql2->execute([$pin,$pin2]) && $sql2->rowCount()<=2){
            $c1 = true;
            
        }

        $moyenne = 0;
        $rows = []; 
        while($result = $sql2->fetch(PDO::FETCH_ASSOC)){
            $rows[] = $result;
            $moyenne = $moyenne + $result['moyenne_e'];
            $niveau = $result['niveau'];
        }
        if($rows[0]['niveau'] != $rows[1]['niveau']){
            echo "Niveau déffirent des étudiants verifier les matricules";
        }else{
        $moyenne = $moyenne/2;
        $moyenne = round($moyenne, 2);
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
        $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `matricule` IN (?,?)";
        $sql1 = $pdo->prepare($query1);
        if($sql1->execute([$id,$pin,$pin2])){
            $c4 = true;
        }
        if($c1 && $c2 && $c3 && $c4){
            
            echo "Compte inscrit Avec Succes";
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
            $query2 = "SELECT * FROM `etudiant` WHERE `matricule` IN(?,?,?) AND `id_compte` IS NULL";
            $sql2 = $pdo->prepare($query2);
            $pin=$etuds[0];
            $pin2=$etuds[1];
            $pin3=$etuds[2]; 
            if($sql2->execute([$pin,$pin2,$pin3]) && $sql2->rowCount()==3){
                $c1 = true;
            }
    
            $moyenne = 0;
            $rows = []; 
            while($result = $sql2->fetch(PDO::FETCH_ASSOC)){
                $rows[] = $result;
                $moyenne = $moyenne + $result['moyenne_e'];
                $niveau = $result['niveau'];
            }
            if($rows[0]['niveau'] != $rows[1]['niveau'] && $rows[2]["niveau"]){
                echo "Niveau déffirent des étudiants verifier les matricules";
            }else{
            $moyenne = $moyenne/3;
            $moyenne = round($moyenne, 2);
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
            $query1 = "UPDATE `etudiant` SET `id_compte`=? WHERE `matricule` IN (?,?,?)";
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
}
else{
    //champ vide
}


?>