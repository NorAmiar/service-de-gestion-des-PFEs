<?php 
    include("../config/db.php");
?>

<html>
<?php include("layouts/head.php"); ?>
<body>
    <?php include("layouts/navbar.php") ?>
    <div class="container-fluid">
    <div class="col-md-3 col-xs-12 ">
        <div class="row well">
        <?php include("layouts/profileTicket.php"); ?>
        </div>
        <?php include("layouts/sidebar.php"); ?>
        </div>
           
    <div class="col-md-9 col-xs-12 ">
        <div class="container-fluid">
            <h2><b id="messegerieM">Messagerie : </b></h2>
           
            <br>
            <center><button onclick="sendMessage();" class="btn btn-large" id="envoyerUnMessageM">Envoyer un message</button></center>
            <br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="idM">ID</th>
                <th id="expiditeurM">Expiditeur</th>
                <th id="recepteurM">Recepteur</th>
                <th id="dateM">Date</th>
                <th id="objetM">Objet</th>
                <th id="EtatM">Etat</th>
                <th id="dateDeVueM">Date de Vue</th>
                <th id="actionM">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `messagerie` WHERE `expiditeur`=? AND natureExp=?";
          $sql = $pdo->prepare($query);
          $sql->execute([$user,"etudiant"]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
            
        
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['expiditeur']; ?></td>
                <td><a href="profile.php?user=<?php echo $result['recepteur']; ?>"><?php echo $result['recepteur']; ?></a></td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['objet']; ?></td>
                <td><?php  if($result['statut']==1){
                    echo "Vu";
                }else{
                    echo "Non Vu";
                } ?></td>
                <td><?php echo $result['date_vue']; ?></td>
                <td><button><a href="msg.php?id=<?php echo $result['id']; ?>" id="consulterM">Consulter</a></button></td>
              
            </tr>
            <?php 
                }
            }
             ?>
              <?php 
         
          $query2 = "SELECT * FROM `messagerie` WHERE `recepteur`=? AND natureRec=?";
          $sql2 = $pdo->prepare($query2);
          $sql2->execute([$user,"etudiant"]);
          
          if($sql2->rowCount()>0){
              
              while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
            
        
        ?>
            <tr>
                <td><?php echo $result2['id']; ?></td>
                <td><a href="profile.php?user=<?php echo $result2['expiditeur']; ?>"><?php echo $result2['expiditeur']; ?></a></td>
                <td><?php echo $result2['recepteur']; ?></td>
                <td><?php echo $result2['date']; ?></td>
                <td><?php echo $result2['objet']; ?></td>
                <td><?php  if($result2['statut']==1){
                    echo "Vu";
                }else{
                    echo "Non Vu";
                } ?></td>
                <td><?php echo $result2['date_vue']; ?></td>
                <td><button><a href="msg.php?id=<?php echo $result2['id']; ?>" id="consulterMM">Consulter</a></button></td>
              
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
 

    </div>


    <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onClick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4> <div align="center">
          <p id="envoyerUnMessageM1">&nbsp; Envoyer Un Message</p>
         
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form autocomplete="off" id="sendMessage">
            <div class="form-group">
                    <label for="role" id="roleDeRecepteurM">Role de recepteur : </label>
                    <select name="role" id="role"  class="form-control" required>
                        <option value="encadreur" id="encadreurM">Encadreur</option>
                        <option value="etudiant" id="etudiantM">Etudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recepteur" id="recepteurMM">Recepteur : </label>
                    <select name="recepteur" id="recepteur" class="form-control" placeholder="Saisir pseudo" required>
                <option value=""></option>
                    </select>
                   </div>
                <div class="form-group">
                    <label for="objet" id="objetM1">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageMM">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
           
                <center><button class="btn btn-primary" id="EnvoyezM">Envoyez</button></center>
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
    $(document).ready(function() {
    $('#example').DataTable();
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

    $("#fr").click(function(){
            $.MultiLanguage("messagerie.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("messagerie.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("messagerie.json","ar");
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
</html>