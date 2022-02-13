<?php 
include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

if(!empty($_POST['pin'])){
    $pin = $_POST['pin'];

    $query = "SELECT * FROM `etudiant` WHERE `pin`=? AND `departement`=?";
    $sql = $pdo->prepare($query);
    $sql->execute([$pin,$departement]);
    if($sql->rowCount()!=0){
        echo "exist";
    }
}
        
    

?>