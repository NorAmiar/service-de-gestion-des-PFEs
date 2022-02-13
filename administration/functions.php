<?php

include("../../config/db.php");
session_start();
$departement = $_SESSION['departement'];

 if(isset($_POST["Import"])){
    
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
  }   
  $n = sizeof($the_big_array);
  $array_pins = [];
     
$insert = false;



 for($i=0;$i<$n;$i++){ 
         
        
                $mat =  $the_big_array[$i][0] ; echo $mat; 
                $nom = $the_big_array[$i][1]; echo $nom; 
                $prenom = $the_big_array[$i][2]; echo $prenom; 
                $email = $the_big_array[$i][3]; echo $email; 
                $moyenne = $the_big_array[$i][4]; echo $moyenne; 
                $x = rand(1111,9999); echo $x; array_push($array_pins,$x);
                $query = "INSERT INTO `etudiant`(`matricule`, `departement`, `nom`, `prenom`, `email`, `moyenne_e`, `pin`, `id_compte`) VALUES (?,?,?,?,?,?,?,?)";
                $sql = $pdo->prepare($query);
                if($sql->execute([$mat,$departement,$nom,$prenom,$email,$moyenne,$x,NULL])){
                  $insert = true;
                }else{
                  $insert=false;
                }
         
                 }


 if($insert){
   echo "Liste des etudiants importée avec success";
 }else{
   echo "erreur";
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

