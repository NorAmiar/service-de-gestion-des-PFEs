<?php 
    session_start();
   //titre de page 
    $title = "ESPACE ADMIN";
?>

<!DOCTYPE html>
<html>
<!--  importation partie head -->
<?php include("layouts/head.php"); ?>

    <body>
    <?php 
        //si le visiteur est connecté et il s'agit d'un admin 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <?php 
    //import de la barre de navigation 
    include("layouts/navbar.php"); ?>
    <br>
    <div class="container-fluid">
    <?php 
    //import de menu lateral sidebar
    include("layouts/sidebar.php"); ?>
        
        <div class="col-md-9 col-xs-12">
       
        <!--  contenu de la page carte admin -->
            <div class="well" >
                <div align="center">
                  <b><span class="glyphicon glyphicon-user"></span> </b>  <b id="admin">Administrateur</b>

                    <br><br>
                    <p><b id="dep">Departement : </b> <?php echo $_SESSION['departement']; ?> </p>
                    <p><b id="date" > Date :</b> <?php echo date("d/m/Y"); ?></p>
                    <p><b id="heure">Heure :</b> <?php echo date("H:i"); ?> </p>
                    <a class="btn " id="settings" href="settings.php">Paramètres</a> 
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
            $.MultiLanguage('index.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('index.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('index.json','ar');
       }
    });

   // gestion de button de la langue 
          $("#fr").click(function(){
            $.MultiLanguage("index.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("index.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("index.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
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
   