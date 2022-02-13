<?php 

include("config/db.php")
?>
<!DOCTYPE html>
<html>
    <head>
	    <title>Gestion des PFEs | Université 8 Mai 1945 Guelma</title>
	    <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="static/css/w3.css">
        <link rel="stylesheet" href="static/css/main2.css">
        <link href="static/css/bootstrap.min.css" rel="stylesheet">
        <script src="static/js/jquery.js" ></script>


        <script src="static/js/multi.min.js" ></script>
        <script src="static/js/bootstrap.min.js"></script>

    </head>
    <body>
    <!-- Debut de la bar de navigation (menu)   -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" id="headtitle" href="index.php">GESTION DES PROJETS FIN D'ETUDES</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" id ="info" >INFORMATIONS</a></li>
                        <li><a href="#" id="contact" >CONTACT</a></li>
                        <li><a href="#" id="equipedev" >EQUIPE DE DEVELOPPEMENT</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="lang">LANGUE <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a id="fr" href="#"><i><img src="static/images/fr.png" alt="fr" height="30px"> </i> FR</a></li>
                                <li><a id="eng" href="#"><i><img src="static/images/en.png" alt="en" height="30px"> </i> EN</a></li>
                                <li><a id="ar" href="#"><i><img src="static/images/ar.png" alt="ar" height="30px"> </i> AR</a></li>
                            </ul>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
    <!-- Fin de la bar de navigation (menu)   -->

    <!-- Debut du corp de site   -->
    <div class="container-fluid">
        <div class="row">
        <!-- Partie Droite  -->
            <div class="col-md-6 col-xs-12 container2">
                <div>
                   <button class="btn btn-custom" id="afficherCnx" >Connexion</button>
                   <br><br>
                   <button class="btn btn-custom" id="afficherIns" >Inscription</button>
                </div>
            </div>
        <!-- Partie Gauche -->
            <div class="col-md-6 col-xs-12 show">
                <!-- Connexion ou Inscription va afficher ici -->
            </div>
        </div>
    </div>
    <!-- Formulaire Connexion -->
    <div id="cnx" style="display:none;">
        <center>
            <form action="#" id="login" >
                <center><h2 id="cnxTitle">Connexion</h2></center>
                <br>
                <div class="form-group">
                    <input type="text" id="pseudo" class="form-control" placeholder="Pseudo">
                    <br>
                    <input type="password" id="password" class="form-control" placeholder="Mot De Passe">
                </div>
                <br>
                <button id="send" class="btn btn-custom" >CONNEXION</button>
                <br>
                <h4 id="mdpOublie">Mot de passe oublié ?</h4> <a id="clickHere" href="#">Cliquer ici</a>
            </form>
        </center>
    </div>
    <!-- Formulaire Inscription -->
    <div id="ins" style="display:none;">
        <center>
            <form action="#" id="register" >
                <center><h2 id="registerTitle">Inscription</h2></center>
                <br>
                <div class="form-group">
                    <select name="type" id="type" class="form-control" required>
                        <option value="" id="typeCompte">Type de Compte</option>
                        <option value="Monome" id="monome">Monome</option>
                        <option value="Binome" id="binome">Binome</option>
                        <option value="Trinome" id="trinome">Trinome</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="type" id="departement" class="form-control" required>
                            <?php 
                            
                            $query = "SELECT * FROM `departement` WHERE ?";
                            $sql = $pdo->prepare($query);
                            $sql->execute([1]);
                        
                            
                            while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                            
                            
                            ?>
                                <option value="<?php echo $result['nom']; ?>"><?php echo $result['nom']; ?></option>
                                <?php } 
                                ?>
                    </select>
                </div>

                        <div class="form-group">
                            <input placeholder="Pseudo" type="text" class="form-control" name="user" id="user" readonly >
                            <br>
                            <input type="password" class="form-control" minlength="8" name="pass" id="pass" placeholder="Mot De Passe" required>
                        </div>
                        <div class="form-group">
                                <input placeholder="Confirmer le Mot de Passe" type="password" class="form-control"  minlength="8" name="passConfirm" id="passConfirm" required>
                            
                            
                        </div>
                        <div class="form-group">
                            <label for="pin">PIN : </label>
                            <input type="number" class="form-control" name="pin" id="pin" required>
                        </div>
                        <div id="pin2" style="display:none;">
                            <div class="form-group">
                                <label for="pin">PIN 2 : </label>
                                <input type="number" class="form-control" name="pin_2" id="pin_2">
                            </div>
                        </div>
                        <div id="pin3" style="display:none;">
                            <div class="form-group">
                                <label for="pin">PIN 3 : </label>
                                <input type="number" class="form-control" name="pin_3" id="pin_3">
                            </div>
                
                        </div>
                        <br>
                        <button class="btn btn-custom" id="reg">Inscription</button>
                        <br>
                        <h4 id="insText">Vous ete membre déja ? </h4><a href="#" id="afficherCnx1">Cliquer ici</a>
                        
                    </form>
                    </center>
    </div>
    <!-- The Modal -->
<div id="infoModal" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('infoModal').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="infoTitle">Gestion des projets fin d'etudes</h1>
      <br><br>
     <p id="infoContent">Le systéme permet, d'une part, à l'administration de bien gérer et de bien contrôler les projets des étudiants dés la proposition des sujets par les enseignants jusqu’au les soutenances en passant par l'étape d'affectation, de sélection, de suivi, etc. Et d'une autre part, il permet aux étudiants de consulter les anciens projets, de sélectionner les nouveaux sujets proposés, de communiquer avec les enseignants et l'administration, de signaler les lacunes, de dépôt des rapports, etc. </p>
     <br><br>
        <b>© <?php echo date("Y"); ?></b> <b id="infoFooter"> Université 8 mai 1945 , Département d’informatique.</b>
     </div>
    </div>
  </div>
</div>
    <!-- The Modal -->
    <div id="contactModal" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('contactModal').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="contactTitle">Contactez Nous :</h1>
      <br><br>
     <p id="contactL1"> Université 8 mai 1945 - GUELMA BP 401 GUELMA 24000 - ALGERIE </p>
       <b id="contactL2"> Tél: 213 (0) 37 10 05 53</b>
       <b id=contactL3> Fax: </b>
        <b id="contactL4"> Email: </b>      
       <br><br>
        <b>© <?php echo date("Y"); ?> <b id="contactFooter"> Université 8 mai 1945 , Département d’informatique.</b></b>             
      </div>
    </div>
  </div>
</div>
 <!-- The Modal -->
 <div id="equipedevModal" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('equipedevModal').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="devTitle"> Equipe de devlopement :</h1>
      <br><br>
        <p><b id="devL1">Sous Encadrement de :</b> DR Halimi Khaled</p>
        <ul>
            <li>Badji Ahmed Amin et Amiar Nour El Houda<b> (2019-2020) </b></li>
            <li>Babes Mohamed Reda <b> (2018-2019) </b> </li>
            <li>Souilah Islem et Elaggoune Achraf <b> (2017-2018) </b> </li>
        </ul>
        <br><br>
        <b>© <?php echo date("Y"); ?> <b id="devFooter"> Université 8 mai 1945 , Département d’informatique.</b></b>
      </div>
    </div>
  </div>
</div>
    <script>
    headers={"content-type":["application/json"]}
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
         $("#info").click(function(){
            $("#infoModal").slideDown('slow');
         });
         $("#contact").click(function(){
            $("#contactModal").slideDown('slow');
         });
         $("#equipedev").click(function(){
            $("#equipedevModal").slideDown('slow');
         });
        $(document).ready(function(){
            //detection de height d'ecran
            $(".container2").css('height',$(document).height()-70);
        
        $.MultiLanguage("translate.json","fr");
            
        });
        $("#fr").click(function(){
            $.MultiLanguage("translate.json","fr");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("translate.json","en");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("translate.json","ar");
            setCookie("lang","ar",7);
            $(".w3-modal").css('text-align','right');
        });
  
        //afficher formulaire de connexion on button click 
        $("#afficherCnx").click(function(){
            $(".show")
                .hide()
                .html($("#cnx").html())
                .slideDown("slow");

            $(".container2").css('height',$(document).height()-70);
          
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#login").offset().top
    }, 2000);

//ajax connexion
            $("#login").submit(function(){
                var user = $("#pseudo").val();
        var pass = $("#password").val();
                    $.post( "process/check.php",{user:user , pass:pass}, function( da ) {
                        switch(da){
                            case "president":
                                window.alert("Bienvenue President");
                                document.location.href = "president";
                                break;
                            case "admin":
                                window.alert("Bienvenue Admin");
                                document.location.href = "administration";
                                break;
                            case "superadmin":
                                window.alert("Bienvenue Super Admin");
                                document.location.href = "superadmin";
                                break;
                            case "encadreur":
                                window.alert("Bienvenue Encadreur");
                                document.location.href = "encadreur";
                                break;
                            case "etudiant":
                                window.alert("Bienvenue Etudiant");
                                document.location.href = "etudiant";
                                break;
                            case "Incorrect password":
                                window.alert("Mot de passe erroné");
                                break;
                            case "Pseudo n'existe pas":
                            window.alert("Pseudo n'existe pas");
                            break;

                        }
                    
                });
                return false;
            });
        });

        //afficher formulaire de inscription on button click
        $("#afficherIns").click(function(){
            $(".show")
                .hide()
                .html($("#ins").html())
                .slideDown('slow');

            $(".container2").css('height',$(document).height()-70);
          
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#register").offset().top
    }, 2000);

    $("#afficherCnx1").click(function(){
            $(".show").html("");
            $(".show")
                .hide()
                .html($("#cnx").html())
                .slideDown('slow');

            $(".container2").css('height',$(document).height()-70);
          
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#login").offset().top
    }, 2000);
    $("#login").submit(function(){
                var user = $("#pseudo").val();
        var pass = $("#password").val();
        
                    $.post( "process/check.php",{user:user , pass:pass}, function( da ) {
                        switch(da){
                            case "admin":
                                window.alert("Bienvenue Admin");
                                document.location.href = "administration";
                                break;
                            case "encadreur":
                                window.alert("Bienvenue Encadreur");
                                document.location.href = "encadreur";
                                break;
                            case "etudiant":
                                window.alert("Bienvenue Etudiant");
                                document.location.href = "etudiant";
                                break;
                            case "Incorrect password":
                                window.alert("Mot de passe erroné");
                                break;
                            case "Username not Found":
                            window.alert("Pseudo erroné");
                            break;

                        }
                    
                });
                return false;
            }); 
    });
    //gerer les champs de PIN ca depend au type de compte
                $( "#type" ).change(function() {
            var ty = $("#type").val();
                if(ty =="Binome"){
                    $('#pin2').css('display', 'block');
                    $('#pin3').css('display', 'none');
                }else{
                    if(ty == "Trinome"){
                        $('#pin2').css('display', 'block');
                        $('#pin3').css('display', 'block');
                    }else{
                        if(ty=="Monome"){
                            $('#pin2').css('display', 'none');
                            $('#pin3').css('display', 'none');
                        }
                    }
                }
            });
  
        //user detection
        $("#pin").change(function(){
            var pin = $("#pin").val();
            var departement = $("#departement").val();
            $.post( "process/getUser.php", {pin:pin,departement:departement}, function( data ) {
                $("#user").val(data);
            });
        });
        $("#pin_2").change(function(){
            var pin = $("#pin").val();
            var pin2 = $("#pin_2").val();
            var departement = $("#departement").val();
            $.post( "process/getUser.php", {pin:pin,pin2:pin2,departement:departement}, function( data ) {
                $("#user").val(data);
            });
        });
        $("#pin_3").change(function(){
            var pin = $("#pin").val();
            var pin2 = $("#pin_2").val();
            var pin3 = $("#pin_3").val();
            var departement = $("#departement").val();
            $.post( "process/getUser.php", {pin:pin,pin2:pin2,pin3:pin3,departement:departement}, function( data ) {
                $("#user").val(data);
            });
        });
       

       //ajax inscription

            $("#register").submit(function(){
                var ty = $("#type").val();
            var user = $("#user").val();
            var pass =  $("#pass").val();
            var passConfirm = $("#passConfirm").val();
            var pin = $("#pin").val();
            var pin2 = $('#pin_2').val();
            var pin3 = $('#pin_3').val();
            var departement = $("#departement").val();
            if(pass.valueOf() != passConfirm.valueOf()){
               window.alert("les mots de passes ne sont pas identique");
            }else{
                //check if pins have allready accounts ..
                $.post( "process/reg.php", {ty:ty,user:user,pass:pass,pin:pin,pin2:pin2,pin3:pin3,departement:departement}, function( data ) {
                    window.alert(data);
                    location.reload();
                    
            });
        }
        $(this).trigger("reset");
        return false;
            }); 



        });
        //retourner vers cnx
    
        
    </script>
    </body>
</html>