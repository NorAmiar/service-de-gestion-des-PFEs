<?php 

include("../../config/db.php");

$title = $_POST['title'];
$valid = true;
$query = "SELECT * FROM `sujet` WHERE `titre`=?";
$sql = $pdo->prepare($query);
$sql->execute([$title]);
if($sql->rowCount()>0){
    $valid = false;
}

$query2 = "SELECT * FROM `sujetHistory` WHERE `titre`=?";
$sql2 = $pdo->prepare($query2);
$sql2->execute([$title]);

if($sql2->rowCount()>0){
    $valid = false;
}

if($valid){
    echo "true";
}else{
    echo "false";
}

?>