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
            <h2><b id="listeDesRendezVousRV">Liste Des Rendez-Vous : </b></h2>
            <br><br>
            <center>
            <?php 
                 if(!empty($_SESSION['theme'])){
                     ?>
                     <button class="btn btn-large" onclick="newRDV();" id="demanderUnRendezVousRV">Demander Un Rendez Vous</button>
                     <?php

                 }
            ?>
            
            </center>
            <br><br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
       
            <tr>
                <th id="idRV">ID</th>
                <th id="dateRV">Date</th>
                <th id="heureRV">Heure</th>
                <th id="EtatRV">Etat</th>
                <th id="actionRV1">Action</th>
                <th id="actionRV2">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php  
            $query = "SELECT * FROM `rdv` WHERE `departement`=? AND `compte_etudiant`=? ";
            $sql = $pdo->prepare($query);
            $sql->execute([$_SESSION['departement'],$_SESSION['user']]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['time']; ?></td>
                <td><?php 
                    if($result['statut']==1){
                        echo "Validé";
                    }else{
                        if($result['validEncadreur']==1 && $result['validEtudiant']==1){
                            echo "Fixé";
                        }else{
                            echo "Non Fixé";
                        }
                    }
                ?></td>
                 <td>
            <?php 
                if($result['validEtudiant']==0){
                    ?>
                    <button onclick="confirmRDV(<?php echo $result['id']; ?>);" id="ConfirmerRV">Confirmer</button>
                    <?php
                }else{
                    echo "Aucune action disponible";
                }
            ?>
            </td>
            <td>
            <?php 
                if($result['validEncadreur']==1 && $result['validEtudiant']==1){
                    echo "Le rendez vous est déja fixé";
                }else{
                    $jsonResult = json_encode($result, JSON_UNESCAPED_UNICODE);
                    ?>
                    
                    <button onclick='modifier(<?php echo $jsonResult;?>);' id="modifierRV" >Modifier</button>
                    <?php
               
                   
                }
            ?>
            </td>
           
              
            </tr>
        <?php 

            }
        }
        ?>

        </tbody>
 
        </tfoot>
    </table>

        </div>
                </div>

    </div>
 

    </div>


  <!--   MODAL -->
  <div id="editRDV" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('editRDV').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>

    <h1 align="center" style="color:#4fbfa8;" id="modifierRendezVousRV">MODIFIER Rendez Vous</h1>
        <form id="edit_click" >
        <div class="form-group">
                <label for="id" id="idRV">id :</label>
                <input class="form-control" type="text" name="id" id="id" readonly> 
            </div>
        <div class="form-group">
          
                <label for="date" id="dateRV1">Date :</label>
                <?php $today = date("Y-m-d"); ?>
                    <input type="text" name="date" id="date" min="<?php echo $today; ?>" class="form-control" required> 
            </div>
            <div class="form-group">
                    <label for="heure" id="heureRV1">Heure : </label>
                    <input type="time" id="heure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieuRV1">Lieu : </label>
                    <input type="text" name="lieu" id="lieu" class="form-control" required>
                </div>
                
       
            <div align="center">            
                <button class="btn btn-large" id="modifierRV1" >Modifier</button>
                </div>
            </form>
        
        
      </div>
    </div>
  </div>



  <div id="demandeRDV" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('demandeRDV').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>

    <h1 align="center" style="color:#4fbfa8;" id="demanderUnRenderVousRV1">Demander Un Rendez Vous</h1>
        <form id="demande_click" >
       
        <div class="form-group">
                <label for="date" id="dateRV2">Date :</label>
                <?php $today = date("Y-m-d"); ?>
                    <input type="date" name="date" id="newDate" min="<?php echo $today; ?>" class="form-control" required> 
            </div>
            <div class="form-group">
                    <label for="heure" id="heureRV2">Heure : </label>
                    <input type="time" id="newHeure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieuRV">Lieu : </label>
                    <input type="text" name="lieu" id="newLieu" class="form-control" required>
                </div>
                
       
            <div align="center">            
                <button class="btn btn-large" id="demanderRV" >Demander</button>
                </div>
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
            $.MultiLanguage("rdv.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("rdv.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("rdv.json","ar");
        });
    $(document).ready(function() {
    $('#example').DataTable();
} );
function newRDV(){
    $("#demandeRDV").css('display','block');
}
$("#demande_click").submit(function(){
    var date = $("#newDate").val();
    var heure = $("#newHeure").val();
    var lieu = $("#newLieu").val();
    $.post("process/submitRDV.php",{date:date,heure:heure,lieu:lieu},function(data){
        window.alert(data);

    location.reload();
    });
    return false;
});
function modifier(toedit){
    var obj = JSON.stringify(toedit);
    obj = JSON.parse(obj);
    $("#editRDV").css('display','block');
    $("#id").val(obj.id);
    $("#date").val(obj.date);
    $("#heure").val(obj.time);
    $("#lieu").val(obj.lieu);
    
}
$("#edit_click").submit(function(){
    var id = $("#id").val();
    var date = $("#date").val();
    var heure = $("#heure").val();
    var lieu = $("#lieu").val();
    $.post("process/editRDV.php",{id:id,date:date,heure:heure,lieu:lieu},function(data){
        window.alert(data);
        $(this).trigger("reset");
         location.reload();
    });

    
    return false;
});
function confirmRDV(id){
    $.post("process/confirmRDV.php",{id:id},function(data){
        window.alert(data);

    location.reload();
    });

}
</script>
</body>
</html>