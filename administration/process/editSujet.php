<?php 
include("../../config/db.php");
session_start();

$id = $_POST['id'];
$valid = true;

if(isset($_POST['niv']) && !empty($_POST['niv'])){
    $niveau = $_POST['niv'];
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
if(isset($_POST['bib']) && !empty($_POST['bib'])){
    $bib = $_POST['bib'];
}else{
    $valid = false;
}
if(isset($_POST['keywords']) && !empty($_POST['keywords'])){
    $keywords = $_POST['keywords'];
}else{
    $valid = false;
}
if(isset($_POST['encadreur']) && !empty($_POST['encadreur'])){
    $encadreur = $_POST['encadreur'];
}else{
    $valid = false;
}

if($valid){
    $query="UPDATE `sujet` SET `titre`=? , `encadreur`= ?, `contenu`= ?, `keywords`= ?, `environement`= ? , `bibliographie` = ?, `niveau`= ? WHERE `id` = ?"; 

$sql = $pdo->prepare($query);
if($sql->execute([$titre,$encadreur,$contenu,$keywords,$env,$bib,$niveau,$id])){
    echo "Sujet modifié avec succes";
}else{
    echo "not inserted";
   }

}else{
    echo "Invalid inputs";
}




?>