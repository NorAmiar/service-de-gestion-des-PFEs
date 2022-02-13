<?php 

include("../config/db.php");
session_start();
$user = "";
if(!empty($_GET['user'])){
    $user = $_GET['user'];
} 
?>
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
<body>
    <?php include("layouts/navbar.php") ?>
    <div class="container-fluid">
   
                     <!-- load sidebar Menu  -->
                    
                     <?php include("layouts/sidebar.php"); ?>
       
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
        <p><b id="MoyenneDeCompte">Moyenne de Compte  : </b><?php echo $result['moyenne_compte'];?></p>
        <p><b id="TypeDeCompte">Type de compte : </b><?php echo $result['typeC'];?></p>
        <p><b id="Niveau">Niveau : </b><?php echo $result['niveau'];?></p>
        <p><b id="Sujet">Sujet : </b> <?php echo $result['sujet']; ?> </p>
        <button class="btn btn-primary" onclick='sendMessage();' id="EnvoyerUnMessage">Envoyer un message </button> 
       
              
        <br>
        <h2 id="InformationSurLesEtudiants">Information sur les etudiants : </h2>
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
        <p><b id="moyenne">Moyenne : </b> <?php echo $result2['moyenne_e']; ?> </p>
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
                <center><button class="btn btn-primary" id="envoyez">Envoyez</button></center>
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
        $.MultiLanguage("profile.json","fr");
       }else if(x=="en"){
        $.MultiLanguage("profile.json","en");
       }else if(x=="ar"){
        $.MultiLanguage("profile.json","ar");
       }
});
       $("#fr").click(function(){
            $.MultiLanguage("profile.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("profile.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("profile.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $("#sendMessage").submit(function(){
        var objet = $("#objet").val();
        var contenu = $("#msg").val();
        const type = "etudiant";
        var recepteur = $("#user").val();
     
        $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
             window.alert(data);
             location.reload();
    });
        return false;
    });


    function sendMessage(){
        $("#id01").css('display','block');
    }

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