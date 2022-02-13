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
                $query = "SELECT * FROM `compte_etudiants` WHERE `user`=? AND `departement`=?";
                $sql= $pdo->prepare($query);
                $sql->execute([$user,$departement]);
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $result['user'];
                $idCompte = $result['idCompte'];
            ?>
        <center><h1><?php echo $result['user'] ?></h1></center>
        <p><b id="moyenneDeCompteE" >Moyenne de Compte  : </b><?php echo $result['moyenne_compte'];?></p>
        <p><b id="ttypeDeCompteE">Type de compte : </b><?php echo $result['typeC'];?></p>
        <p><b id="nniveauDeCompteE">Niveau : </b><?php echo $result['niveau'];?></p>
        <p><b id="sujetE">Sujet : </b> <?php echo $result['sujet']; ?> </p>
        <?php 
            if($result['user']==$_SESSION['user']){
                ?> 
                <button class="btn btn-primary" onclick='editProfile();' id="modifierProfileE">Modifier profile </button> 
                <?php 
            }else{
                ?> 
                <button class="btn btn-primary" onclick='sendMessage();' id="envoyerUnMessageE">Envoyer un message </button> 
                <?php
            }
        ?>
        

        <?php 
         
           if(!empty($result['sujet'])){
               $query = "SELECT * FROM `sujet` WHERE `titre`=? AND `encadreur`=? AND `departement`=?";
               $sql = $pdo->prepare($query);
                $sql->execute([$result['sujet'],$_SESSION['user'],$departement]);
                if($sql->rowCount()==1){
                    ?>
                     <button class="btn btn-primary" onclick="demandeRDV();" id="ddemanderUnRDVE1" >Demander un RDV</button>
                    <?php
                }
           }else{
            $sujets = [];
            $query2 = "SELECT * FROM `sujet` WHERE `encadreur` = ? AND `departement` = ?";
            $sql2 = $pdo->prepare($query2);
            $sql2->execute([$_SESSION['user'],$_SESSION['departement']]);
            if($sql2->rowCount()>0){
                
              while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                      array_push($sujets,$result2['titre']);
                  }
                   $in  = str_repeat('?,', count($sujets) -1 ) . '?';
                         
            $query = "SELECT * FROM `choix` WHERE `sujet` IN ($in) AND `user`=? AND `departement` = ?" ;
            $sql = $pdo->prepare($query);
            $inputs = $sujets;
            array_push($inputs,$user);
            array_push($inputs,$_SESSION['departement']);
            
            $sql->execute($inputs);
            if($sql->rowCount()==1){
                ?>
                <button class="btn btn-primary" onclick="demandeRDV();" id="demanderUnRDVE2">Demander un RDV</button>
               <?php


              }
              
            }
           }
        ?>
       

        <br>
        <h2 id="informationSurLesEtudiants">Information sur les etudiants : </h2>
        <?php 
            $query2 = "SELECT * FROM `etudiant` WHERE `id_compte`=? AND `departement`=? ";
            $sql2 = $pdo->prepare($query2);
            $sql2->execute([$idCompte,$departement]);
            if($sql2->rowCount()>0){
                while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                    
        ?>

        <p><b id="nom">Nom : </b> <?php echo $result2['nom']; ?> </p>  
        <p><b id="prenom">Prénom : </b> <?php echo $result2['prenom']; ?></p>
        <p><b id="email">Email : </b><a href="mailto:<?php echo $result2['email']; ?>"><?php echo $result2['email']; ?></a></p>
        <p><b id="moyenne"> Moyenne : </b> <?php echo $result2['moyenne_e']; ?> </p>
        <br>
        <?php 

                }
            }
        ?>
       
    

                </div>

    </div>

    </div>






    <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p id="envoyeyUnMessageE">
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="sendMessage">
                <div class="form-group">
                    <label for="objet" id="objetE">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageE">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <input type="hidden" id="user" value="<?php echo $user ; ?>" readonly>
                <center><button class="btn btn-primary" id="envoyerE">Envoyez</button></center>
            </form>
    </div>


    </div>
</div>
<div id="id02" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id02').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p id="DemanderUnRDVEE">
          Demandez Un Rendez-Vous
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="submitRDV">
                <div class="form-group">
                    <label for="objet" id="dateE">Date : </label>
                    <?php $today = date("Y-m-d"); ?>
                    <input type="date" name="date" id="date" min="<?php echo $today; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="heure" id="heureE">Heure : </label>
                    <input type="time" id="heure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieuE">Lieu : </label>
                    <input type="text" name="lieu" id="lieu" class="form-control" required>
                </div>
                <input type="hidden" id="userRDV" value="<?php echo $user ; ?>" readonly>
                <center><button class="btn btn-primary" id="demanderE">Demander</button></center>
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
    $("#submitRDV").submit(function(){
        var date = $("#date").val();
        var heure = $("#heure").val();
        var lieu = $("#lieu").val();
        var user = $("#userRDV").val();
      
        $.post("process/submitRDV.php",{date:date,heure:heure,lieu:lieu,user:user},function(data){
            window.alert(data);
        });
        $(this).trigger("reset");
        return false;
    });


    function sendMessage(){
        $("#id01").css('display','block');
    }
    function demandeRDV(){
        $("#id02").css('display','block');
    }
    $("#sendMessage").submit(function(){
        var objet = $("#objet").val();
        var contenu = $("#msg").val();
        const type = "etudiant";
        var recepteur = $("#user").val();
     
        $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
             window.alert(data);
    });
        return false;
    });
</script>

</body>
</html>