<?php 

include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];
if(!empty($_POST['option']) && isset($_POST['etat']))
{
    $etat = $_POST['etat'];
    $option = $_POST['option'];
    change($option,$etat,$pdo,$departement);
}

function change($option,$etat,$pdo,$departement){
    $query = "UPDATE `departement` SET `$option`= ? WHERE `nom`=?";
    $sql = $pdo->prepare($query);
    $c = $sql->execute([$etat,$departement]);
    if ($c){
        echo "L'option a été changé avec succes";
    }else{
        echo "eurreur";
    }

}

?>