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
            <h2><b id="listeDesRendezVousRD">Liste Des Rendez Vous : </b></h2>
            <br><br>
            <center>
            <button class="btn btn-large" onclick="newRDV();" id="demanderUnRdvRD">Demander un Rendez Vous</button>
            </center>
            <br><br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="idRD">ID</th>
                <th id="etudiantRD">Etudiant(s)</th>
                <th id="dateRD">Date</th>
                <th id="heureRD">Heure</th>
                <th id="lieuRD">Lieu</th>
                <th id="etatRD">Etat</th>
                <th id="actionRD1">Action</th>
                <th id="actionRD2">Action</th>
                <th id="actionRD3">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `rdv` WHERE `encadreur`=?";
          $sql = $pdo->prepare($query);
          $sql->execute([$user]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
            
        
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td>
                <a href="profile.php?user=<?php echo $result['compte_etudiant']; ?>"><?php echo $result['compte_etudiant']; ?> </a>
                </td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['time']; ?></td>
                <td><?php echo $result['lieu']; ?></td>
                <td>
                <?php
                    if($result['statut']==1){
                        echo "Validé";
                    }else{
                        if($result['validEncadreur']==1 && $result['validEtudiant']==1 ){
                            echo "Fixé";
                        }else{
                            echo "Non Fixé";
                        }
                    }
                 ?>
                </td>
                <td>
                <?php
                    if($result['validEncadreur']==1 && $result['validEtudiant']==1 && $result['statut']==0){
                        ?>
                        <button class="btn btn-primary" onclick="validerRDV(<?php echo $result['id']; ?>);" id="validerRD" >Valider</button>
                        <?
                    }else{
                        if($result['validEncadreur']==0){
                            ?>
                            <button class="btn btn-primary" onclick="confirmRDV(<?php echo $result['id']; ?>);" id="confirerRD">Confirmer</button>
                            <?php
                        }else{
                            if($result['statut']==1){
                                echo "Le Rendez vous est déja validé";
                            }else{
                                echo "En attente de confirmation d'etudiant";    
                            }
                        
                        }
                    }
                    
                 ?>
                
                </td>

              
                <td>
                <?php
                   
                   if($result['validEncadreur']==1 && $result['validEtudiant']==1){
                    if($result['statut']==1){
                        echo "Le Rendez vous est déja validé";
                    }else{
                        echo "Le rendez vous est deja fixé";  
                    }
                   
                }else{
                    $jsonResult = json_encode($result, JSON_UNESCAPED_UNICODE);
                       ?>
                       <button class="btn btn-primary" onclick='modifier(<?php echo $jsonResult;?>);'id="modifierRD" >Modifier</button>
                       <?php
                  
                       
                   }
               
            ?>
                
                
                </td>
              <td>
              <?php 
                if($result['statut']==0){
                    
              ?>
              <button class="btn btn-primary" onclick="annullerRDV(<?php echo $result['id']; ?>);" id="annulerRD" >Annuler</button>
              <?php 
                    }else{
                        echo "Le Rendez vous est déja validé";
                    }
              ?>
              </td>
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
    <!--   MODAL -->
<div id="editRDV" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('editRDV').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>

    <h1 align="center" style="color:#4fbfa8;" id="modifierRendezVousRD">MODIFIER Rendez Vous</h1>
        <form id="edit_click" >
        <div class="form-group">
                <input class="form-control" type="hidden" name="id" id="id" > 
            </div>
        <div class="form-group">
          
                <label for="date" id="dateRD1">Date :</label>
                <?php $today = date("Y-m-d"); ?>
                    <input type="date" name="date" id="date" min="<?php echo $today; ?>" class="form-control" required> 
            </div>
            <div class="form-group">
                    <label for="heure" id="heureRD1">Heure : </label>
                    <input type="time" id="heure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieuRD1">Lieu : </label>
                    <input type="text" name="lieu" id="lieu" class="form-control" required>
                </div>
                
       
            <div align="center">            
                <button class="btn btn-large"id="modifierRD1" >Modifier</button>
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

    <h1 align="center" style="color:#4fbfa8;" id="demanderUnRendezVousRD">Demander Un Rendez Vous</h1>
        <form id="demande_click" >
        <div class="form-group">
            <label for="recepteur" id="recepteurRD">Recepteur : </label>
            <select name="recepteur" id="recepteur" class="form-control" required>
            <?php  
            $sujets = [];
            $query = "SELECT * FROM `sujet` WHERE `encadreur` = ? AND `departement` = ?";
            $sql = $pdo->prepare($query);
            $sql->execute([$_SESSION['user'],$_SESSION['departement']]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    array_push($sujets,$result['titre']);
                }
                 $in  = str_repeat('?,', count($sujets) -1 ) . '?';
            $query2 = "SELECT * FROM `choix` WHERE `sujet` IN ($in) AND `departement` = ?" ;
            $sql2 = $pdo->prepare($query2);
            $inputs = $sujets;
            array_push($inputs,$_SESSION['departement']);
            
            $sql2->execute($inputs);
            if($sql2->rowCount()>0){
                ?>
                 <optgroup label="Les étudiants qui ont choisi un de mes themes">
                <?php
                while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <option value="<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?></option>
                    <?php
                }
                ?>
                 </optgroup>
                <?php
                }

            $query3 = "SELECT * FROM `compte_etudiants` WHERE `sujet` IN($in) AND `departement` = ?"; 
            $sql3 = $pdo->prepare($query3);
            $sql3->execute($inputs);
            if($sql3->rowCount()>0){
                ?>
                 <optgroup label="Mes étudiants encadrer">
                <?php
                while($result3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                    ?> 
                    <option value="<?php echo $result3['user']; ?>"><?php echo $result3['user']; ?></option>
                    <?php
                }
                ?>
                </optgroup>
                <?php
            }   
            }
            ?>
            </select>
        </div>
        <div class="form-group">
                <label for="date" id="dateRD2">Date :</label>
                <?php $today = date("Y-m-d"); ?>
                    <input type="date" name="date" id="newDate" min="<?php echo $today; ?>" class="form-control" required> 
            </div>
            <div class="form-group">
                    <label for="heure" id="heureRD2">Heure : </label>
                    <input type="time" id="newHeure" name="heure" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lieu" id="lieuRD2">Lieu : </label>
                    <input type="text" name="lieu" id="newLieu" class="form-control" required>
                </div>
                
       
            <div align="center">            
                <button class="btn btn-large" id="demanderRD">Demander</button>
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


    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('mesRdv.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('mesRdv.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('mesRdv.json','ar');
       }
} );
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

$("#demande_click").submit(function(){
    var recepteur = $("#recepteur").val();
    var date = $("#newDate").val();
    var heure = $("#newHeure").val();
    var lieu = $("#newLieu").val();
    $.post("process/submitRDV.php",{date:date,heure:heure,lieu:lieu,user:recepteur},function(data){
        window.alert(data);
        location.reload();
    });
    
    return false;
});


function validerRDV(id){
    $.post("process/validerRDV.php",{id:id},function(data){
        window.alert(data);
        location.reload();
    });
    
}
function confirmRDV(id){
    $.post("process/confirmRDV.php",{id:id},function(data){
        window.alert(data);
        location.reload();
    });
    

}
function annullerRDV(id){
    $.post("process/annulerRDV.php",{id:id},function(data){
        window.alert(data);
        location.reload();
    });
   
}
function newRDV(){
    $("#demandeRDV").css('display','block');
}
$("#fr").click(function(){
            $.MultiLanguage("mesRdv.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("mesRdv.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("mesRdv.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
</script>
</body>
</html>