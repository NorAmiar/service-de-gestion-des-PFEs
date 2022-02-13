<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

    

$rows = [];
   
$query = "SELECT * FROM `compte_etudiants` WHERE `departement`=? AND `niveau`=? AND `sujet`=?";
$sql = $pdo->prepare($query);
if($sql->execute([$departement,$_POST['niveau'],""]) && $sql->rowCount()>0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $rows[]=$row;
    }
}
echo json_encode($rows);
?>