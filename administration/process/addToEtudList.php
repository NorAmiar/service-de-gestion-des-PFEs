<?php 
include("../../config/db.php");
session_start();
$ok=true;
$obligatoires=array('mat','nom','prenom','email','moyenne','pin','niveau');
foreach($obligatoires as $obligatoire){
  if( ! (isset($_POST[$obligatoire]) && trim($_POST[$obligatoire])!='') ){
    $ok=false;
    break;
  }
}
if($ok){
    $mat = $_POST['mat'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $moyenne = $_POST['moyenne'];
    $pin = $_POST['pin'];
    $niveau = $_POST['niveau'];
    $departement = $_SESSION['departement'];
    $query = "INSERT INTO `etudiant`(`matricule`, `departement`, `nom`, `prenom`, `email`, `moyenne_e`, `pin`, `niveau`) VALUES (?,?,?,?,?,?,?,?)";
    $sql = $pdo->prepare($query);
    if($sql->execute([$mat,$departement,$nom,$prenom,$email,$moyenne,$pin,$niveau])){
        echo "Etudiant ajouté avec succes";
    }else{
        echo "Eurreur etudiant existe déja ? ";
    }
}
else{
    //champ vide
}
?>