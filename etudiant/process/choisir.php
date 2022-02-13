<?php 
include("../../config/db.php");
session_start();

$today = date("Y-m-d");
$departement = $_SESSION['departement'];
$titre = $_POST['titre'];
$user = $_SESSION['user'];
$idCompte = $_SESSION['id'];
$moyenne = $_SESSION['moyenne'];

$nbLimit = 5;
$query = "SELECT * FROM `departement` WHERE `departement` = ? ";
$sql = $pdo->prepare($query);
$sql->execute([$departement]);
$result = $sql->fetch(PDO::FETCH_ASSOC);

if($result["limitSujet"] != null){
    $nbLimit = $result["limitSujet"];
}

$query = "SELECT * FROM `choix` WHERE `idCompte` = ? ";
$sql = $pdo->prepare($query);
$sql->execute([$idCompte]);

$priotity = $sql->rowCount();

$query2="SELECT * FROM `choix` WHERE `user`= ? AND `sujet`= ? AND `departement`= ? ";
$sql2 = $pdo->prepare($query2);
$sql2->execute([$user,$titre,$departement]);

if($sql2->rowCount()>0){
    echo "Vous avez deja choisi ce theme";
}else{
    if($priotity==$nbLimit){
        echo "Vous avez deja choisi 5 choix ! ";
    }else{
        if(!empty($titre)){
          
            $query="INSERT INTO `choix`(`idCompte`, `user`, `moyenne_compte`, `sujet`, `dateChoix`, `departement`, `priority`) VALUES (?,?,?,?,?,?,?)";
            $sql = $pdo->prepare($query);
            if($sql->execute([$idCompte,$user,$moyenne,$titre,$today,$departement,$priotity])){
              
                $query2 = "SELECT * FROM `sujet` WHERE `titre`=? AND `departement`=? ";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$titre,$departement]);
                $result = $sql2->fetch(PDO::FETCH_ASSOC);
                $nb_choix = $result['nb_choix'] + 1;
                $query3 = "UPDATE `sujet` SET `nb_choix`=? WHERE `titre`=? AND `departement`=?";
                $sql3 = $pdo->prepare($query3);
                $sql3->execute([$nb_choix,$titre,$departement]);
                echo "Choix fait avec success";
            }else{
                echo "eurreur";
            }
            }
    }
    

}



?>