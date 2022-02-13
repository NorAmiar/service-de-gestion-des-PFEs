<div class="row">

<div class="container-fluid" >
      <div class="row">

      <div class="col-md-6 col-xs-12">
      <a href="themes.php" > <div class="w3-card-4 card1" >
              <div align="center">
                  <b><span class="glyphicon glyphicon-th-list"></span><br> Consulter Les Themes</b><br><br>
              </div>
          </div></a><br>
          </div>
          <div class="col-md-6 col-xs-12">
          <a href="choix.php" ><div class="w3-card-4 card2" >
              <div align="center">
                 <b><span class="glyphicon glyphicon-th-list"></span><br> Mes Choix</b><br><br>
              </div>
          </div></a>
          </div>
      </div>
      <br>
      <div class="row">

<div class="col-md-6 col-xs-12">
<?php 
$query = "SELECT * FROM `sujet` WHERE `titre`=?";
$sql = $pdo->prepare($query);
$sql->execute([$_SESSION['theme']]);
$result = $sql->fetch(PDO::FETCH_ASSOC);
?>
<a href="theme.php?id=<?php echo $result['id']; ?>" > <div class="w3-card-4 card3" >
      <div align="center">
          <b><span class="glyphicon glyphicon-check"></span><br> Mon Theme</b><br>
      </div>
  </div></a>
  </div>
  <div class="col-md-6 col-xs-12">
  <a href="rdv.php" ><div class="w3-card-4 card4" >
      <div align="center">
         <b><span class="glyphicon glyphicon-pencil"></span> <br> Mes Rendez-Vous</b><br><br>
      </div>
  </div></a>
  </div>
</div>
<br>
<div class="row">

<div class="col-md-6 col-xs-12">
<a href="messagerie.php" > <div class="w3-card-4 card5" >
      <div align="center">
          <b><span class="glyphicon glyphicon-envelope"></span><br> Gestion de Messagerie</b><br>
      </div>
  </div></a>
  </div>
  <div class="col-md-6 col-xs-12">
  <a href="contact.php" ><div class="w3-card-4 card6" >
      <div align="center">
         <b><span class="glyphicon glyphicon-envelope"></span><br> Envoyez un message</b>
      </div>
  </div></a>
  </div>
</div>
<br>


</div>

               </div>

