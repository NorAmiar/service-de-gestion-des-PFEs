<?php 
    include("../../config/db.php");
    session_start();
    $nb = $_POST['nb'];
    $departement = $_SESSION['departement'];
    if(!empty($nb)){
//
$query2 = "UPDATE `departement` SET `limitSujet`=? WHERE `nom`=? ";
$sql2 = $pdo->prepare($query2);
$c = $sql2->execute([$nb,$departement]);

  if($c){
      echo "parametre changé";
  }else{
      echo "eurreur";
  }
    }else{
        echo "eurreur";
    }


    

?>