<?php 

include("../../config/db.php");
session_start();
$valid = true;
if(isset($_POST['niveau']) && !empty($_POST['niveau'])){
    $niveau = $_POST['niveau'];
}else{
    $valid = false;
}
if(isset($_POST['titre']) && !empty($_POST['titre'])){
    $titre = $_POST['titre'];
}else{
    $valid = false;
}
if(isset($_POST['contenu']) && !empty($_POST['contenu'])){
    $contenu = $_POST['contenu'];
}else{
    $valid = false;
}
if(isset($_POST['env']) && !empty($_POST['env'])){
    $env = $_POST['env'];
}else{
    $valid = false;
}
if(isset($_POST['bibliographie']) && !empty($_POST['bibliographie'])){
    $bib = $_POST['bibliographie'];
}else{
    $valid = false;
}
if(isset($_POST['keywords']) && !empty($_POST['keywords'])){
    $keywords = $_POST['keywords'];
}else{
    $valid = false;
}
$departement = $_SESSION['departement'];
$encadreur = $_POST['encadreur'];

if($valid){
    $query="INSERT INTO `sujet`(`titre`, `encadreur`, `contenu`, `keywords`, `environement`, `bibliographie`, `valid`, `nb_choix`, `etat`, `dateValidation`, `niveau`, `departement`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)"; 

$sql = $pdo->prepare($query);
if($sql->execute([$titre,$encadreur,$contenu,$keywords,$env,$bib,0,0,0,NULL,$niveau,$departement])){
    echo "Sujet déposé avec succes";
}else{
    echo "not inserted";
   }

}else{
    echo "Invalid inputs";
}


?>