<?php 
include("../config/db.php");
session_start();
$user = "";
if(!empty($_GET['user'])){
    $user = $_GET['user'];
}
?>
<!DOCTYPE html>
<html>
    <head>
	    <title>Gestion des PFEs | Université 8 Mai 1945 Guelma</title>
	    <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="../static/css/w3.css">
        <link rel="stylesheet" href="../static/css/admin.css">
        <link href="../static/css/bootstrap.min.css" rel="stylesheet">
        <script src="../static/js/jquery.js" ></script>
        <script src="../static/js/datatables.min.js"></script>
        <script src="../static/js/multi.min.js" ></script>
        <script src="../static/js/bootstrap.min.js"></script>
    
        <link rel="stylesheet" href="../static/css/datatables.min.css">
     
    </head>
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body style="background-color:#e5ebf0;">
    <?php include("layouts/navbar.php"); ?>
        <br>
        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
            <div class="col-md-9 col-xs-12 " >
            
            <?php 
                $query = "SELECT * FROM `encadreur` WHERE `username`=? AND `departement`=?";
                $departement = $_SESSION['departement'];
                $sql = $pdo->prepare($query);
                $sql->execute([$user,$departement]);
                $result = $sql->fetch(PDO::FETCH_ASSOC);

            ?>
                <center><h2><?php echo $result['username']; ?></h2></center>
            <p><b id="nom">Nom : </b><?php echo $result['nom']; ?></p>
            <p><b id="prénom">Prénom : </b><?php echo $result['prenom']; ?></p>
            <p><b id="email">Email : </b><?php echo $result['email']; ?></p>
            <p><b id="numéro">Numéro : </b><?php echo 0 . $result['number']; ?></p>
            <p><b id="grade">Grade : </b><?php echo $result['grade']; ?></p>
            <p><b id="domaines">Domaines : </b><?php echo $result['domaine']; ?></p>

        <br>
        <center><button onclick="showSendMessage();" class="btn btn-large"  id="EnvoyerUnMessage">Envoyer un message</button></center>
            </div>
        </div>
     

        <div id="message" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('message').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p>
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form id="sendMessage">
                <div class="form-group">
                    <label for="objet" id="objet1">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="message">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>" readonly>
                <center><button class="btn btn-primary" id="envoyer">Envoyez</button></center>
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
    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('encadreur.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('encadreur.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('encadreur.json','ar');
       }
} );
function showSendMessage(){
    $("#message").css('display','block');
}
$("#sendMessage").submit(function(){
    var objet = $("#objet").val();
    var contenu = $("#msg").val();
    var recepteur = $("#user").val();
    const type = "encadreur";
    $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
        window.alert(data);
    });
    return false;
});
</script>
    </body>
    <?php 
     }else{
         
    
    ?>
<script>
    window.alert("Something Wrong .. ? ");
    document.location.href = "../index.php";
</script>
        <?php 
        
     }
        ?>
    </html>