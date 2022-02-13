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
        <script src="../static/js/datatables.min.js"></script>
        <script src="../static/js/multi.min.js" ></script>
        <script src="../static/js/bootstrap.min.js"></script>
        <script src="../static/js/autocomplete.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    
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
            <h2 id="messagerie">Messagerie </h2>
            <br>
            <center><button onclick="sendMessage();" class="btn btn-large" id="EnvoyerUnMessageM">Envoyer un message</button></center>
            <br>
            <div class="table-responsive ">
                 <table id="example" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="idM">ID</th>
                    <th id="expiditeurM">Expiditeur</th>
                    <th id="nnatureExpiditeurM">Nature Expiditeur</th>
                    <th id="recepteurM">Recepteur</th>
                    <th id="natureRecepteurM">Nature Recepteur</th>
                    <th id="dateM">Date</th>
                    <th id="statutM">Statut</th>
                    <th id="adateDeVueM">Date de vue</th>
                    <th id="actionM">Action</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
          $departement = $_SESSION['departement'];
          $query = "SELECT * FROM `messagerie` WHERE `departement`=? AND `natureExp`=? OR `natureRec`=?";
          $sql = $pdo->prepare($query);
          $sql->execute([$departement,"admin","admin"]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['id'];?> </td>
                <td><?php echo $result['expiditeur']; ?></td>
                <td><?php echo $result['natureExp']; ?></td>
                <td><?php echo $result['recepteur']; ?></td>
                <td><?php echo $result['natureRec']; ?></td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['statut']; ?></td>
                <td><?php echo $result['date_vue']; ?></td>
                <td><button ><a href="msg.php?id=<?php echo $result['id']; ?>" id="consulterM">Consulter</a></button></td>
            </tr>
            <?php   
                    }
                }
        ?>
        </tbody>
       
    </table>

        </div>
            </div>

            
        </div>




        <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p>&nbsp;</p id="envoyerUnMessageMM">
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form autocomplete="off" id="sendMessage">
            <div class="form-group">
                    <label for="role" id="roleDeRecepteurMM">Role de recepteur : </label>
                    <select name="role" id="role"  class="form-control" required>
                        <option value="encadreur" id="encadreurM">Encadreur</option>
                        <option value="etudiant" id="etudiantM">Etudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recepteur" id="recepteurMM" >Recepteur : </label>
                    <select name="recepteur" id="recepteur" class="form-control" placeholder="Saisir pseudo" required>
                <option value=""></option>
                    </select>
                   </div>
                <div class="form-group">
                    <label for="objet" id="objetM">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageM">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
           
                <center><button class="btn btn-primary" id="envoyerM">Envoyez</button></center>
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
            $.MultiLanguage("messagerie.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("messagerie.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("messagerie.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('messagerie.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('messagerie.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('messagerie.json','ar');
       }
   
} );
$("#sendMessage").submit(function(){
        var objet = $("#objet").val();
        var contenu = $("#msg").val();
        const type = $("#role").val();
        var recepteur = $("#recepteur").val();
     
        $.post("process/sendMessage.php",{objet:objet,recepteur:recepteur,contenu:contenu,type:type},function(data){
             window.alert(data);
    });
        return false;
    });


    function sendMessage(){
        $("#id01").css('display','block');
        $.post("process/autoRec.php",function(result){
      var data  = JSON.parse(result);
      var n= data.length;
     
      for(var i =0 ; i<n;i++){
          optionText = data[i];
          optionValue = data[i];
          $("#recepteur").append(`<option value="${optionValue}"> ${optionText} </option>`);
      }
      $("#recepteur").selectize({
        sortField: 'text'
    });
 
  });
       
        
       
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

