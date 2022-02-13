<html>
    <?php  
        include("../config/db.php");
     
    ?>
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
      
            <div class="col-md-offset-3 col-md-6 col-xs-12 well">
        

             
            <div class="card">
                <div class="card-header  text-white" style="padding:2% 2% 2% 2%;">
                    <div align="center">
                        <i class="fa fa-envelope"></i> &nbsp;<b id="contacterLadministrateurCN" >Contacter l'adminstrateur</b>
                    </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <form id="sendMessage">
                            <div class="form-group">
                                <label for="object" id="objetCN">Objet :</label>
                                <input type="text" class="form-control" name="objet" id="objet" placeholder="Objet de contact">

                            </div>
                            <div class="form-group">
                                <label for="message" id="messageCN">Message :</label>
                                <textarea  class="form-control" name="message" id="message" placeholder="Message"></textarea>
                            <?php 
                                $query = "SELECT * FROM `administration` WHERE `departement`=?";
                                $sql = $pdo->prepare($query);
                                $sql->execute([$_SESSION['departement']]);
                                $user = "";
                                if($sql->rowCount()==1){
                                    $result = $sql->fetch(PDO::FETCH_ASSOC);
                                    $user = $result['username'];
                                }
                            ?>
                            </div>
                            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                            <center>
                            <button class="btn btn-large" id="envoyerCN" >Envoyer</button>
                            </center>
                        </form>
                    </div>
               
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
            $.MultiLanguage('contact.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('contact.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('contact.json','ar');
       }
    });
       $("#fr").click(function(){
            $.MultiLanguage("contact.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("contact.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("contact.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
     $("#sendMessage").submit(function(){
       var objet = $("#objet").val();
        var contenu = $("#message").val();
        const type = "admin";
        var recepteur = $("#user").val();
       $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
            window.alert(data);

    $(this).trigger("reset");
    location.reload();
    });
        return false;
    });
</script>


</body>
</html>