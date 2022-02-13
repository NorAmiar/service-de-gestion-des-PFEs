<?php 

include("../config/db.php");
$user="";
if(!empty($_GET['user'])){
    $user = $_GET['user'];
}

?>

<html>
<?php include("layouts/head.php"); ?>

    <body>
    <?php include("layouts/navbar.php") ?>
    <div class="container-fluid">
    <div class="col-md-3 col-xs-12 ">
        <div class="row well">
        <?php include("layouts/profileTicket.php"); ?>
        </div>
        <?php include("layouts/sidebar.php"); ?>
        </div>
           
    <div class="col-md-9 col-xs-12 ">
        <div class="container-fluid">
            <?php  
            $departement = $_SESSION['departement'];
                $query = "SELECT * FROM `encadreur` WHERE `username`=? AND `departement`=?";
                $sql= $pdo->prepare($query);
                $sql->execute([$user,$departement]);
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $result['username'];
               
            ?>
        <center><h1><?php echo $result['username'] ?></h1></center>
        <p><b id="nom">Nom  : </b><?php echo $result['nom'];?></p>
        <p><b id="prenom">Prénom : </b><?php echo $result['prenom'];?></p>
        <p><b id="email">Email : </b><?php echo $result['email'];?></p>
        <p><b id="numero">Numéro : </b> <?php echo 0 . $result['number']; ?> </p>
        <p><b id="grade">Grade : </b><?php echo $result['grade']; ?></p>
        <p><b id="domaines">Domaines : </b><?php echo $result['domaine']; ?></p>
        <?php 
            if(!empty($_SESSION['theme'])){
               $query2 = "SELECT * FROM `sujet` WHERE `titre`=? AND `encadreur`=? AND `departement`=?";
               $sql2=$pdo->prepare($query2);
               $sql2->execute([$_SESSION['theme'],$result['username'],$_SESSION['departement']]);
               if($sql2->rowCount()==1){
                   ?>
                   <button class="btn btn-primary" onclick="newRDV();" id="DemanderUnRendezVous" >Demander un Rendez Vous </button> 
                   <?php
               }
            }
                ?>
                     <button class="btn btn-primary" onclick='sendMessage();' id="EnvoyerUnMessage">Envoyer un message </button> 
              
       
        
       

       
    

                </div>

    </div>

    </div>






    <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p id="EnvoyerUnMessageE"> 
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="sendMessage">
                <div class="form-group">
                    <label for="objet" id="Objet">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="message">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <input type="hidden" id="user" value="<?php echo $user ; ?>" readonly>
                <center><button class="btn btn-primary" id="envoyez">Envoyez</button></center>
            </form>
    </div>


    </div>
</div>

     
<div id="demandeRDV" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('demandeRDV').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>

    <h1 align="center" style="color:#4fbfa8;" id="DemanderUnRendezVousE">Demander Un Rendez Vous</h1>
        <form id="demande_click" >
       
        <div class="form-group">
                <label for="date" id="date">Date :</label>
                <?php $today = date("Y-m-d"); ?>
                    <input type="date" name="date" id="newDate" min="<?php echo $today; ?>" class="form-control" required> 
            </div>
            <div class="form-group">
                    <label for="heure" id="heure">Heure : </label>
                    <input type="time" id="newHeure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieu">Lieu : </label>
                    <input type="text" name="lieu" id="newLieu" class="form-control" required>
                </div>
                
       
            <div align="center">            
                <button class="btn btn-large" id="demander" >Demander</button>
                </div>
            </form>
           
      </div>
    </div>
  </div>
     
<script>
             function getCookie(name) {
                            var value = "; " + document.cookie;
                            var parts = value.split("; " + name + "=");
                            if (parts.length == 2) return parts.pop().split(";").shift();
                            }
    function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function newRDV(){
    $("#demandeRDV").css('display','block');
}
$("#demande_click").submit(function(){
    var date = $("#newDate").val();
    var heure = $("#newHeure").val();
    var lieu = $("#newLieu").val();

    $.post("process/submitRDV.php",{date:date,heure:heure,lieu:lieu},function(data){
       window.alert(data);
       location.reload();
   });
    
    return false;
});
    function sendMessage(){
        $("#id01").css('display','block');
    }
  
    $("#sendMessage").submit(function(){
        var objet = $("#objet").val();
        var contenu = $("#msg").val();
        const type = "encadreur";
        var recepteur = $("#user").val();
     
        $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
             window.alert(data);
    });
        return false;
    });
</script>

</body>
</html>