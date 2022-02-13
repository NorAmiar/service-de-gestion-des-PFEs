<?php 

include("../../config/db.php");
$id = $_POST["id"];
$query ="SELECT * FROM `president` WHERE `id`= ? ";
$sql = $pdo->prepare($query);
$sql->execute([$id]);

$result = array();



while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $result[]=$row;
}

echo json_encode($result);

?>