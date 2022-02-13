<?php 

include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];
if(isset($_POST['id']) && !empty($_POST['id'])){
    $mat = $_POST['id'];
    $query = "DELETE FROM `compte_etudiants` WHERE `idCompte`=? AND `departement`=?";
    $sql = $pdo->prepare($query);
    if($sql->execute([$mat,$departement])){
        $query = "UPDATE `etudiant` SET `id_compte`=? WHERE `id_compte`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([NULL,$mat]);
        echo "done";
    }
}

?>