<?php 
    include("../../config/db.php");
    session_start();
    $departement=$_SESSION['departement'];
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id = $_POST['id'];
        $query = "DELETE FROM `sujet` WHERE `id`=? AND `departement`=?";
        $sql = $pdo->prepare($query);
        if($sql->execute([$id,$departement])){
            echo "Sujet supprimé avec succes";
        }
    }
?>