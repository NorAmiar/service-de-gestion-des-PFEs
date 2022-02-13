<?php 

include("../config/db.php");

$query ="SELECT * FROM `choix` WHERE 1 ORDER BY `moyenne_compte` DESC ";
$sql = $pdo->prepare($query);
$sql->execute();

$result = array();



while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $result[]=$row;
}

echo json_encode($result);

?>