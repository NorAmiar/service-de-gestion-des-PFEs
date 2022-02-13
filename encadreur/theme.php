<?php 
    include("../config/db.php");
 $id = $_GET['id'];
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
                $query = "SELECT * FROM `sujet` WHERE `id`=?";
                $sql= $pdo->prepare($query);
                $sql->execute([$id]);
                $result = $sql->fetch(PDO::FETCH_ASSOC);
            ?>
        <center><h1><?php echo $result['titre'] ?></h1></center>
        <p><b id="encadreur">Encadreur : <a href="encadreur.php?user=<?php echo $result['encadreur'];?>"><?php echo $result['encadreur'];?></a>  </b> </p>  
        <p><b id="descreption">Descreption : </b></p><br><center> <p><?php echo $result['contenu'];?></p></center>
        <p><b id="keywords">Keywords : </b><?php echo $result['keywords'];?></p>
        <p><b id="environement">Environement : </b><?php echo $result['environement'];?></p>
        <p><b id="bibliographie">Bibliographie : </b><?php echo $result['bibliographie'];?></p>
        <?php  if($result['valid']==0){
            ?>
            <p><b id="LeThemeNestPasencoreValidé">Le theme n'est pas encore validé</b></p>
            <?php
        }else{
            if($result['valid']==1 && $result['etat']==1){
                $titre = $result['titre'];
                $query2 = "SELECT * FROM `compte_etudiants` WHERE `sujet`=?";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$titre]);
                $result2 = $sql2->fetch(PDO::FETCH_ASSOC);

                
                ?> 
                
                 <p><b id="etudiant">Etudiant(s) : </b><a href="profile.php?user=<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?></a></p>
                <p><b id="TauxDavancement">Taux d'avancement :</b> <?php echo $result['tauxAvancement']; ?> </p>
                 <?php 
            }else{
                if($result['valid']==1 && $result['etat']==0){
                    ?> 
                    <p><b id="LeThemeNestPasEncoreAffecte">Le theme n'est pas encore affecté</b></p>
                    <p><b id="NombreDeFoisChoisi">Nombre de fois choisi : </b> <?php echo $result['nb_choix']; ?> </p>
                    <?php
                }
            }
        } ?>
    
    <center>
        <a href="../ficheSujet.php?id=<?php echo $id;?>" class="btn btn-primary">Fiche de sujet PDF</a>
        </center>
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
            $.MultiLanguage('theme.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('theme.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('theme.json','ar');
       }
    });

   // gestion de button de la langue 
          $("#fr").click(function(){
            $.MultiLanguage("theme.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("theme.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("theme.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
</script>
</body>
</html>