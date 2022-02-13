<?php 
include("config/db.php");
$query = file_get_contents("gpfe.sql");
$stmt = $pdo->prepare($query);
$importBDD = $stmt->execute();
if ($importBDD)
     echo "Importation de BDD avec success";
else 
     echo "Probleme dans l'importation de BDD";

if($importBDD){

?>

<table>
<thead>
<th>Pseudo</th>
<th>Email</th>
<th>Mot de passe</th>
<th>Departement</th>
</thead>
<tbody>
<td></td>
<td></td>
<td></td>
<td></td>
</tbody>
</table>
<?php 
}
?>