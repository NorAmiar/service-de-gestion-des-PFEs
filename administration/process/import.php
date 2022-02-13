<?php

include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];




    
    $filename=$_FILES["file"]["tmp_name"];    
 
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
        $the_big_array = []; 
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
            $the_big_array[] = $getData;	
           }
      
           fclose($file);  
     }
  
  $n = sizeof($the_big_array);
  $array_pins = [];
     
$insert = false;



 for($i=0;$i<$n;$i++){ 
         
        
                $mat =  $the_big_array[$i][0] ; 
                $nom = $the_big_array[$i][1]; 
                $prenom = $the_big_array[$i][2];  
                $email = $the_big_array[$i][3];
                $moyenne = $the_big_array[$i][4]; 
                $niveau = $the_big_array[$i][5]; 
                $x = rand(1111,9999); echo $x; array_push($array_pins,$x);
                $query = "INSERT INTO `etudiant`(`matricule`, `departement`, `nom`, `prenom`, `email`, `moyenne_e`, `pin`, `id_compte`,`niveau`) VALUES (?,?,?,?,?,?,?,?,?)";
                $sql = $pdo->prepare($query);
                if($sql->execute([$mat,$departement,$nom,$prenom,$email,$moyenne,$x,NULL,$niveau])){
                  $insert = true;
                }else{
                  $insert=false;
                }
         
                 }


 if($insert){
   ?>
   <script>
    window.alert("Liste des etudiants importée avec success");
    document.location.href = "../gestionEtudiant.php";
   </script>
   
   <?php
 }else{
  ?>
  <script>
   window.alert("Eurreur d'importation");
   document.location.href = "../importEtudiant.php";
  </script>
  
  <?php
 }                
 //for($i=0;$i<$n;$i++){
  // $the_big_array[$i][5]=$array_pins[$i];
//
// }

 // Create an array of elements 
 
    
 // Open a file in write mode ('w') 
 //$fp = fopen('persons.csv', 'w'); 
   
 // Loop through file pointer and a line 
// foreach ($the_big_array as $fields) { 
   //  fputcsv($fp, $fields); 
 //} 
   
 //fclose($fp); 
 ?> 

