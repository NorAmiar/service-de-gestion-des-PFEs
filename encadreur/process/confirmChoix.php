<?php 
    include("../../config/db.php");
    session_start();
    $id = $_POST['id'];
    $departement = $_SESSION['departement'];
    if(!empty($id)){

   
        $query2 = "UPDATE `choix` SET `etat`= ? WHERE `id`=? AND `departement`=? ";
        $sql2 = $pdo->prepare($query2);
        $c = $sql2->execute([1,$id,$departement]);


     

        if($c){
            echo "Choix confirmé avec succes";
        }else{
            echo "Choix non confirmé";
        }




    }else{
        echo "eurreur";
    }




    
    
    

?>