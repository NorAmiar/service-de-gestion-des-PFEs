<?php 

include("../config/db.php");

?>
<html>
<?php include("layouts/head.php"); ?>
<body>
    <?php include("layouts/navbar.php") ?>
    <div class="container-fluid">

   
        <div class="container-fluid">
        <div class="col-md-3 col-xs-12 ">
            <div class="row well">
             <?php include("layouts/profileTicket.php"); ?>
            </div>
              <?php include("layouts/sidebar.php"); ?>
        </div>
           
            <div class="col-md-9 col-xs-12 ">
            <div class="container-fluid">
            <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#contactAdmin" id="contacterLadministrationC">Contacter l'administration</a></li>
                    <li><a data-toggle="tab" href="#contactAutre" id="contacterAutresC">Contacter autre</a></li>
                    
                </ul>
                <div class="tab-content">
                    <div id="contactAdmin" class="tab-pane fade in active">
                    <div class="card-body">
                        <form id="sendMessage">
                            <div class="form-group">
                                <label for="object" id="objetC">Objet :</label>
                                <input type="text" class="form-control" name="objetA" id="objet" placeholder="Objet de contact">

                            </div>
                            <div class="form-group">
                                <label for="message" id="messageC">Message :</label>
                                <textarea  class="form-control" name="messageA" id="message" placeholder="Message"></textarea>

                            </div>
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
                            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                            <center>
                            <button class="btn btn-large" id="EnvoyerC">Envoyer</button>
                            </center>
                        </form>
                    </div>
               
                    </div>
                    <div id="contactAutre" class="tab-pane fade">
                    <form autocomplete="off" id="sendMessage2">
            <div class="form-group">
                    <label for="role" id="roleDeRecepteurC">Role de recepteur : </label>
                    <select name="role" id="role2"  class="form-control" required>
                        <option value="encadreur" id="encadreurC">Encadreur</option>
                        <option value="etudiant" id="etudiantC">Etudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recepteur" id="recepteurCC">Recepteur : </label>
                    <select name="recepteur" id="recepteur2" class="form-control" placeholder="Saisir pseudo" required>
                <option value=""></option>
                    </select>
                   </div>
                <div class="form-group">
                    <label for="objet" id="objetCC">Objet : </label>
                    <input type="text" class="form-control" id="objet2" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageCC">Message : </label>
                    <textarea name="msg" id="msg2" cols="30" rows="10" class="form-control" required></textarea>
                </div>
           
                <center><button class="btn btn-primary" id="envoyerCC">Envoyez</button></center>
            </form>
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


        $("#fr").click(function(){
            $.MultiLanguage("contact.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("contact.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("contact.json","ar");
        });
     $("#sendMessage").submit(function(){
       var objet = $("#objet").val();
        var contenu = $("#message").val();
        const type = "admin";
        var recepteur = $("#user").val();
       $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
            window.alert(data);
    });
    $(this).trigger("reset");
    
        return false;
    });
    $("#sendMessage2").submit(function(){
        var objet = $("#objet2").val();
        var contenu = $("#msg2").val();
        const type = $("#role2").val();
        var recepteur = $("#recepteur2").val();
     
        $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
             window.alert(data);
    });
        return false;
    });

    $(document).ready(function(){
        sendMessage();
    });
    function sendMessage(){
        $.post("process/autoRec.php",function(result){
      var data  = JSON.parse(result);
      var n= data.length;
     
      for(var i =0 ; i<n;i++){
          optionText = data[i];
          optionValue = data[i];
          $("#recepteur2").append(`<option value="${optionValue}"> ${optionText} </option>`);
      }
      $("#recepteur2").selectize({
        sortField: 'text'
    });
 
  });
       
        
       
    }
</script>



</body>
</html>