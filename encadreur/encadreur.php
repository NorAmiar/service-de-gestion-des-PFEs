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
    <div class="col-md-3 col-xs-12">
                <!-- load profile ticket : name email number .. ect -->
                <div class="row well">
                <?php include("layouts/profileTicket.php"); ?>
                </div>
                     <!-- load sidebar Menu  -->
                    
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
        <center><h1 ><?php echo $result['username'] ?></h1></center>
        <p><b id="nomENC">Nom  : </b><?php echo $result['nom'];?></p>
        <p><b id="prenomENC">Prénom : </b><?php echo $result['prenom'];?></p>
        <p><b id="emailENC">Email : </b><?php echo $result['email'];?></p>
        <p><b id="numeroENC">Numéro : </b> <?php echo 0 . $result['number']; ?> </p>
        <p><b id="gradeENC">Grade : </b><?php echo $result['grade']; ?></p>
        <p><b id="domainesENC">Domaines : </b><?php echo $result['domaine']; ?></p>
        <center>
        <?php 
            if($result['username']==$_SESSION['user']){
                $json = json_encode($result);
                ?>
                 <button class="btn btn-primary" onclick='editProfile(<?php echo $json; ?>);' id="modifier profileENC">Modifier Profile </button> 
                <?php
            }else{
                ?>
                     <button class="btn btn-primary" onclick='sendMessage();' id="envoyerUnMessageENC">Envoyer un message </button> 
                <?php
            }
        ?>
       </center>
        
       

       
    

                </div>

    </div>

    </div>






    <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p id="envoyerUnMessageENC1">
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="sendMessage">
                <div class="form-group">
                    <label for="objet" id="objetENC">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageENC">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <input type="hidden" id="user" value="<?php echo $user ; ?>" readonly>
                <center><button class="btn btn-primary" id="envoyerENC">Envoyez</button></center>
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
          <p>&nbsp;</p id="modifierMonProfileENC">
          Modifier Mon Profile
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="editEncadreur" method="POST">
                <div class="container-fluid">
                <div class="form-group">
                        <input type="hidden" name="id" id="id" class="form-control" >
                    </div>
         
                    </div>
                <div class="col-md-6 col-xs-12">
                <div class="form-group">
                        <label for="nom" id="nomENC">Nom :</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom" id="prenomENC">Prenom :</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pseudo" id="pseudoENC">Pseudo :</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mdp" id="motDePasseENC">Mot de passe :</label>
                        <input type="password" name="mdp" minlength="8" id="mdp" class="form-control" required>
                    </div>
                </div>
                  <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                        <label for="email" id="emailENC">Email :</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                   
                  
                    <div class="form-group">
                        <label for="number" id="numérooENC">Numéro :</label>
                        <input type="number" name="number" max="9999999999" id="number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="grade" id="gradeENC">Grade :</label>
                        <select name="grade" class="form-control" id="grade">
                            <option value="Maitre de conference classe A" id="maitreDeConferenceClasseAENC">Maitre de conference classe A</option>
                            <option value="Maitre de conference classe B" id="maitreDeConferenceClasseBENC">Maitre de conference classe B</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="domaines" id="domainesDeRecherchesENC">Domaines de recherches :</label>
                        <input type="text" name="domaines" id="domaines" class="form-control" required>
                    </div>

                  </div> 
                    
                    
                   
                    <div align="center">
                        <button class="btn btn-primary" id="modifierENC" > Modifier </button>
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
    $(document).ready(function(){
        x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('encadreur.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('encadreur.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('encadreur.json','ar');
       }
    });

   // gestion de button de la langue 
          $("#fr").click(function(){
            $.MultiLanguage("encadreur.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("encadreur.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("encadreur.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });


    function editProfile(id){
        $("#id02").css('display','block');
        $("#id").val(id['id']);
            $("#matricule").val(id['matricule']);
            $("#nom").val(id['nom']);
            $("#prenom").val(id['prenom']);
            $("#pseudo").val(id['username']);
            $("#email").val(id['email']);
            $("#number").val(id['number']);
            $("#grade").val(id['grade']);
            $("#domaines").val(id['domaine']);
    }
    $("#editEncadreur").submit(function(){

var id = $("#id").val();
var nom = $("#nom").val();
var prenom = $("#prenom").val();
var pseudo = $("#pseudo").val();
var mdp = $("#mdp").val();
var email = $("#email").val();
var number = $("#number").val();
var grade = $("#grade").val();
var domaines = $("#domaines").val();
$.post( "process/editEncadreur.php", {id:id,nom:nom,prenom:prenom,pseudo:pseudo,mdp:mdp,email:email,number:number,grade:grade,domaines:domaines}, function( data ) {
            if(data == "done"){
                
                window.alert("encadreur est modifié");
                location.reload();
            }else{
                window.alert("error");
            }
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