<?php
    include("../config/db.php");
    session_start();
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
        <script src="../static/js/multi.min.js" ></script>
        <script src="../static/js/bootstrap.min.js"></script>
        <script src="../static/js/affectation.js"></script>
    </head>

    <body style="background-color:#e5ebf0;">
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <?php include("layouts/navbar.php"); ?>
    <div class="container-fluid">
    <?php include("layouts/sidebar.php"); ?>
    <?php 
    $info="";
        $query = "SELECT * FROM `administration` WHERE `username`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['user']]);
        if($sql->rowCount()==1){
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            $info = $result['email'];
        }
    ?>
        <input type="hidden" name="info" id="info" value="<?php echo $info; ?>">
        <div class="col-md-9 col-xs-12">

        
        <?php 
            $query = "SELECT * FROM `departement` WHERE `nom`=?";
            $sql = $pdo->prepare($query);
            $sql->execute([$_SESSION['departement']]);
            if($sql->rowCount()==1){
                $result = $sql->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" id="editProfileText" href="#profileEditForm">Modifier Profile</a></li>
                    <li><a data-toggle="tab" id="generalSettingsText" href="#generalSettings"> Parametres Generale  </a></li>
                </ul>
                <div class="tab-content">
                    <div id="profileEditForm" class="tab-pane fade in active">
                        <br><br>
                        <div class="col-md-4 col-md-offset-4">
                        <form id="profileEdit">
                            <div class="form-group">
                                <label for="email" id="emailText">Email :</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="exemple@exemple.com" required> 
                            </div>
                            <div class="form-group">
                                <label for="mdp" id="mdpText">Ancien mot de passe :</label>
                                <input type="password" placeholder="ancien mot de passe"  minlength="8" name="oldPassword" id="oldPassword" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="mdp" id="nvmdpText">Nouveau mot de passe :</label>
                                <input type="password" placeholder="min 8 char" minlength="8" name="password" id="password" class="form-control" required>
                            </div>
                            <center>
                            <button class="btn" id="modifierText" type="submit">Modifier</button>
                            </center>
                        </form>
                        </div>
                    </div>
                    <div id="generalSettings" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example2" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="nomE">Label</th>
                    <th id="prénomE">Action</th>
                    <th id="emailE">Action</th>
                    <th id="pseudoE">Action</th>
            
                </tr>
        </thead>
        <tbody>
        <tr>
        <td><p><b id="typeAffectationText" >Type d'affectation : </b></td>
        <td> <?php 
                            if($result['affectationAuto']==1)
                            {
                                echo "Automatique";
                             
                            }else{
                                echo "Manuel";
                            }
                            ?> </p></td>
        <td><?php 
                            if($result['affectationAuto']==1)
                            { ?>
                            <button class="btn" id="affecter">Affecter</button>
                            <?php
                            }else{
                                ?>
                                <button class="btn" id="affectationAuto">Automatique</button>
                                <?php
                                } 
                                ?>
                            </td>
                            <td>
                            <?php 
                            if($result['affectationAuto']==1)
                            { ?>
                            <button class="btn" id="affectationManuel">Manuel</button>
                            <?php
                                } 
                                ?>
                            </td>
        </tr>

        <tr>
        <td>  <p><b id="moyenneDesComptesText" >Moyenne des comptes </b>
                           </td>
        <td> <?php 
                            if($result['moy']==1)
                            {
                                echo "Maximum";
                               
                            }else{
                                echo "Moyenne";
                                
                            }
                            ?></td>
        <td> <?php 
                            if($result['moy']==1)
                            {
                              
                                ?>
                                    <button class="btn" id="moy">Moyenne</button>
                                <?php
                            }else{
                              
                                ?>
                                    <button class="btn" id="max">Maximum</button>
                                <?php
                            }
                            ?></td>
        <td></td>
        </tr>



        <tr>
        <td> <p><b id="sessionDepotText">Session de dépot de sujets : </b></td>
        <td> <?php 
                            if($result['depotSujet']==1)
                            {
                                echo "En cours";
                            }else{
                                echo "Fermé";
                            }
                                ?></td>
        <td><?php 
                            if($result['depotSujet']==1)
                            { ?>
                                <button class="btn" id="fermerDepot">Fermer</button>
                                <?php }else{ ?>
                                <button class="btn" id="ouvrirDepot">Ouvrir</button>
                                <?php    }
                                ?></td>
        <td></td>
        </tr>
        <tr>
        <td>   <p><b id="sessionChoixText">Session de choix des sujets : </b></td>
        <td>  <?php 
                                if($result['choixSujet']==1){
                                    echo "En cours";
                                  
                                }else{
                                    echo "Fermé";
                                   
                                }
                            ?> </td>
        <td>  <?php 
                                if($result['choixSujet']==1){
                                   
                                    ?>
                                    <button class="btn" id="fermerChoix">Fermer</button>
                                    <?php
                                }else{
                                   
                                    ?>
                                    <button class="btn" id="ouvrirChoix" >Ouvrir</button>
                                    <?php
                                }
                            ?> </td>
        <td></td>
        </tr>
        <tr>
        <td>  <p><b id="sessionRemplissageText" >Session de remplissage des fiches de suivi : </b>
                           </td>
        <td> <?php 
                            if($result['ficheSuivi']==1)
                            {
                                echo "En cours";
                               
                            }else{
                                echo "Fermé";
                                
                            }
                            ?></td>
        <td> <?php 
                            if($result['ficheSuivi']==1)
                            {
                              
                                ?>
                                    <button class="btn" id="fermerSuivi">Fermer</button>
                                <?php
                            }else{
                              
                                ?>
                                    <button class="btn" id="ouvrirSuivi">Ouvrir</button>
                                <?php
                            }
                            ?></td>
        <td></td>
        </tr>
        <tr>
        <td><p><b>Limiter les nombres des choix : </b></p></td>
        <td><input type="number" id="nbChoixMax" class="form-control" min="0"></td>
        <td><button class="btn" id="limiterSujets">Limiter </button></td>
        <td></td>
        </tr>
        </tbody>
        </table>
        </div>
                        
                           
                              
                          
                         
                          
                </div>
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
            $.MultiLanguage('settings.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('settings.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('settings.json','ar');
       }
    });
        $("#limiterSujets").click(function(){
            var nb = $("#nbChoixMax").val();
            $.post("process/changeNbChoix.php",{nb:nb},function(data){
                    window.alert(data);
                    location.reload();
                });
        });
            $("#fr").click(function(){
            $.MultiLanguage("settings.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("settings.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("settings.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
            $(document).ready(function(){
                $("#email").val($("#info").val());
            });
            $("#profileEdit").submit(function(data){
                email = $("#email").val();
                password = $("#password").val();
                oldPassword = $("#oldPassword").val(); 
                $.post("process/editProfile.php",{email:email,password:password,oldPassword:oldPassword},function(data){
                    window.alert(data);
                    location.reload();
                });
                return false;
            });
            $("#affecter").click(function(){
                affect_click();
            });
            $("#affectationAuto").click(function(){
                option = "affectationAuto";
                etat = 1;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#affectationManuel").click(function(){
                option = "affectationAuto";
                etat = 0;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#fermerDepot").click(function(){
                option = "depotSujet";
                etat = 0;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#ouvrirDepot").click(function(){
                option = "depotSujet";
                etat = 1;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#ouvrirChoix").click(function(){
                option = "choixSujet";
                etat = 1;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#fermerChoix").click(function(){
                option = "choixSujet";
                etat = 0;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#ouvrirSuivi").click(function(){
                option = "ficheSuivi";
                etat = 1;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
            });
            $("#fermerSuivi").click(function(){
                option = "ficheSuivi";
                etat = 0;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
                
            });
            $("#moy").click(function(){
                option = "moy";
                etat = 0;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
                
            });
            $("#max").click(function(){
                option = "moy";
                etat = 1;
                $.post("process/changerOption.php",{option:option,etat:etat},function(data){
                    window.alert(data);
                    location.reload();
                });
                
            });
        </script>



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
   
        </body>
    </html>
   