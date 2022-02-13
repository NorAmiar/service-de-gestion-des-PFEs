<html>
<?php include("../config/db.php"); ?>
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
            <h2><b id="listeDesMessagesMS">Liste Des messages : </b></h2>
            <br>
            <center><button onclick="sendMessage();" class="btn btn-large" id="envoyerUnMessageMS">Envoyer un message</button></center>
            <br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="idMS">ID</th>
                <th id="expiditeurMS">Expiditeur</th>
                <th id="recepteurMS">Recepteur</th>
                <th id="dateMS">Date</th>
                <th id="objetMS">Objet</th>
                <th id="etatMs">Etat</th>
                <th id="dateDeVueMS">Date de Vue</th>
                <th id="actionMS">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `messagerie` WHERE `expiditeur`=? AND natureExp=?";
          $sql = $pdo->prepare($query);
          $sql->execute([$user,"encadreur"]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
            
        
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['expiditeur']; ?></td>
                <td>
                <?php 
                    if($result['natureRec']=="admin"){
                        echo $result['recepteur'];
                    }else{
                        
                ?>
                <a href="profile.php?user=<?php echo $result['recepteur']; ?>"><?php echo $result['recepteur']; ?></a>
                <?php 
                    }
                ?>
                </td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['objet']; ?></td>
                <td><?php  if($result['statut']==1){
                    echo "Vu";
                }else{
                    echo "Non Vu";
                } ?></td>
                <td><?php echo $result['date_vue']; ?></td>
                <td><button><a href="msg.php?id=<?php echo $result['id']; ?>" id="consulterMS">Consulter</a></button></td>
              
            </tr>
            <?php 
                }
            }
             ?>
              <?php 
         
          $query2 = "SELECT * FROM `messagerie` WHERE `recepteur`=? AND natureRec=?";
          $sql2 = $pdo->prepare($query2);
          $sql2->execute([$user,"encadreur"]);
          
          if($sql2->rowCount()>0){
              
              while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
            
        
        ?>
            <tr>
                <td><?php echo $result2['id']; ?></td>
                <td>
                <?php 
                    if($result2['natureExp']=="admin"){
                        echo $result2['expiditeur'];
                    }else{
                        
                ?>
                <a href="profile.php?user=<?php echo $result2['expiditeur']; ?>"><?php echo $result2['expiditeur']; ?></a>
                <?php 

}
                ?>
                </td>
                <td><?php echo $result2['recepteur']; ?></td>
                <td><?php echo $result2['date']; ?></td>
                <td><?php echo $result2['objet']; ?></td>
                <td><?php  if($result2['statut']==1){
                    echo "Vu";
                }else{
                    echo "Non Vu";
                } ?></td>
                <td><?php echo $result2['date_vue']; ?></td>
                <td><a class="btn btn-custom" href="msg.php?id=<?php echo $result2['id']; ?>" id="consulterMS1">Consulter</a></td>
              
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
          <p>&nbsp;</p id="envoyerUnMessageMS1">
          Envoyer Un Message
          <p>&nbsp;</p>
        </div></h4>
      </header>
     
    <div class="container-fluid">

            <form autocomplete="off" id="sendMessage">
            <div class="form-group">
                    <label for="role" id="roleDeRecepteurMS">Role de recepteur : </label>
                    <select name="role" id="role"  class="form-control" required>
                        <option value="encadreur" id="encadreurMS">Encadreur</option>
                        <option value="etudiant" id="etudiantMS">Etudiant</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recepteur" id="recepteurMS1">Recepteur : </label>
                    <select name="recepteur" id="recepteur" class="form-control" placeholder="Saisir pseudo" required>
                <option value=""></option>
                    </select>
                   </div>
                <div class="form-group">
                    <label for="objet" id="objetMS1">Objet : </label>
                    <input type="text" class="form-control" id="objet" name="objet" placeholder="Saisir l'objet" required>
                </div>
                <div class="form-group">
                    <label for="msg" id="messageMS1">Message : </label>
                    <textarea name="msg" id="msg" cols="30" rows="10" class="form-control" required></textarea>
                </div>
           
                <center><button class="btn btn-primary" id="envoyerMS1">Envoyez</button></center>
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
             location.reload();
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
</html>