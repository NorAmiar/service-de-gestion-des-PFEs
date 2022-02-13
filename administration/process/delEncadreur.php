<?php 

include("../../config/db.php");

if(isset($_POST['mat']) && !empty($_POST['mat'])){
    $mat = $_POST['mat'];
    $query = "DELETE FROM `encadreur` WHERE `id`=? ";
    $sql = $pdo->prepare($query);
    if($sql->execute([$mat])){
        echo "done";
    }
}

?>