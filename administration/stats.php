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
    </head>
    <?php 
    session_start();
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body>
    <?php include("layouts/navbar.php"); ?>
        <br>



        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
        <div class="col-md-9 col-xs-12">
            <h1><b id="statistiques">Statistiques </b></h1>
            <br>
            <div class="container">
            <ul class="nav nav-pills nav-stacked">
                <a href="sujets.php"><li style="font-size:35px;"><span class="glyphicon glyphicon-list-alt" ></span> <b  id="sujets" > Sujets</b></li></a>
                <a href="encadreurStats.php"><li  style="font-size:35px;"><span class="glyphicon glyphicon-briefcase" ></span><b id="encadreurs">  Encadreurs</b></li></a>
                <a href="comptes.php"><li  style="font-size:35px;"><span class="glyphicon glyphicon-user" ></span> <b id="comptes">  Comptes</b></li></a>
                </ul>
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
            $.MultiLanguage("stats.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("stats.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("stats.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
        $(document).ready(function(){
            x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('stats.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('stats.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('stats.json','ar');
       }
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