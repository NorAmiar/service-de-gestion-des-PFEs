<?php 
    include("../../config/db.php");
    session_start();
    $departement=$_SESSION['departement'];
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id = $_POST['id'];
        $query = "UPDATE `sujet` SET `valid`=?, `dateValidation`=? WHERE `id`=?";
        $sql = $pdo->prepare($query);
        if($sql->execute([1,date('Y-m-d H:i:s'),$id])){
            echo "Sujet validé avec succes";
        }
    }
?>