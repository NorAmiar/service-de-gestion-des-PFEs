<?php 
session_start();
    include("../config/db.php");
    $id= "";
 if(!empty($_GET['id']))
 {
    $id = $_GET['id'];
 }
?>
<html>
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
    <div class="col-md-9 col-xs-12 ">
        <div class="container-fluid">
            <?php  
                $query = "SELECT * FROM `sujet` WHERE `id`=?";
                $sql= $pdo->prepare($query);
                $sql->execute([$id]);
                $result = $sql->fetch(PDO::FETCH_ASSOC);
            ?>
        <center><h1><?php echo $result['titre'] ?></h1></center>
        <p><b id="encadreur ">Encadreur : <a href="encadreur.php?user=<?php echo $result['encadreur'];?>"><?php echo $result['encadreur'];?></a>  </b> </p>  
        <p><b id="descreption">Descreption : </b></p><br><center> <p><?php echo $result['contenu'];?></p></center>
        <p><b id="keyword">Keywords : </b><?php echo $result['keywords'];?></p>
        <p><b id="environement">Environement : </b><?php echo $result['environement'];?></p>
        <p><b id="bibliographie">Bibliographie : </b><?php echo $result['bibliographie'];?></p>
        <?php  if($result['valid']==0){
            ?>
            <p><b id="LeThemeNestPasEncoreValidé">Le theme n'est pas encore validé</b></p>
            <?php
        }else{
            if($result['valid']==1 && $result['etat']==1){
                $titre = $result['titre'];
                $query2 = "SELECT * FROM `compte_etudiants` WHERE `sujet`=?";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$titre]);
                $result2 = $sql2->fetch(PDO::FETCH_ASSOC);

                
                ?> 
                
                 <p><b id="etudiants">Etudiant(s) : </b><a href="profile.php?user=<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?></a></p>
                <p><b id="TauxDavancement">Taux d'avancement :</b> <?php echo $result['tauxAvancement']; ?> </p>
                 <?php 
            }else{
                if($result['valid']==1 && $result['etat']==0){
                    ?> 
                    <p><b id="LeThemeNestEncoreAffecte">Le theme n'est pas encore affecté</b></p>
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


</body>
<?php 
     }else{
         
    
    ?>
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
    window.alert("Something Wrong .. ? ");
    document.location.href = "../index.php";
</script>
        <?php 
        
     }
        ?>
</html>