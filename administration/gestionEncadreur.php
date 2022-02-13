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
        <script src="../static/js/multi.min.js" ></script>
        <script src="../static/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="../static/css/datatables.min.css">
        <script src="../static/js/datatables.min.js"></script>
    </head>
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body style="background-color:#e5ebf0;">
    <?php include("layouts/navbar.php"); ?>
        <br>

        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
            <div class="col-md-8 col-xs-12 " style=" /*background-color:#003c71; color:white;*/">
            <ul class="nav nav-tabs">
                    <li class="active" ><a data-toggle="tab" id="creerCompteEncadreur" href="#creeEncadreurTab ">Creer Compte Encadreur</a></li>
                    <li><a data-toggle="tab" id ="gestionDesComptesEncadreur" href="#gestionEncadreurTab"> Gestion des comptes encadreur </a></li>
                </ul>
                <div class="tab-content">
                    <div id="creeEncadreurTab" class="tab-pane fade in active">
                        <form id="addEncadreur" method="POST">
                            <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                    <label for="nom" id="nom1">Nom :</label>
                                    <input type="text" name="nom" id="nom" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="prenom" id="prenom1">Prenom :</label>
                                    <input type="text" name="prenom" id="prenom" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="pseudo" id="pseudo1">Pseudo :</label>
                                    <input type="text" name="pseudo" id="pseudo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="mdp" id="mdp1">Mot de passe :</label>
                                    <input type="password" name="mdp" minlength="8" id="mdp" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                    <label for="email" id="email1">Email :</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            
                            
                                <div class="form-group">
                                    <label for="number" id="number1">Numéro :</label>
                                    <input type="number" name="number" max="9999999999" id="number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="grade" id="grade1">Grade :</label>
                                    <select name="grade" class="form-control" id="grade">
                                        <option value="Maitre de conference classe A"id="maitreDeConferenceClasseA">Maitre de conference classe A</option>
                                        <option value="Maitre de conference classe B" id="maitreDeConferenceClasseB">Maitre de conference classe B</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="domaines" id="DomaineDeRecherhces">Domaines de recherches :</label>
                                    <input type="text" name="domaines" id="domaines" class="form-control" required>
                                </div>

                            </div> 
                                
                                
                            
                                <div align="center">
                                    <button class="btn btn-primary" id="creer" > Creer </button>
                                </div>
                            </form>
                        </div>
                    <div id="gestionEncadreurTab" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example2" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="nomE">Nom</th>
                    <th id="prénomE">Prénom</th>
                    <th id="emailE">Email</th>
                    <th id="pseudoE">Pseudo</th>
                    <th id="gradeE">Grade</th>
                    <th id="action1">Action</th>
                    <th id="action2">Action</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
            $departement = $_SESSION['departement'];
            $query = "SELECT * FROM `encadreur` WHERE `departement`=? ";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement]);
            
            if($sql->rowCount()>0){
                
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                   $json = json_encode($result);
                    
        ?>
            <tr>
                <td><?php echo $result['nom']; ?></td>
                <td><?php echo $result['prenom']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><a href="encadreur.php?user=<?php echo $result['username']; ?>"><?php echo $result['username']; ?></a>    </td>
                <td><?php echo $result['grade']; ?></td>
                <td><button onclick='delCompte(<?php echo $result["id"]; ?>);' class="btn" id="supprimer" style="width:100% !important;">Supprimer</button></td>
                <td><button onclick='editCompte(<?php echo $json ?>);' class="btn" id="modifier" style="width:100% !important;">Modifier</button></td>
              
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
                
                <br><br>
               
            </div>
          
        </div>



        <div id="editCompte" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('editCompte').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      
      <form id="editEncadreur" method="POST">
                <div class="container-fluid">
                <div class="form-group">
                        <input type="hidden" name="id" max="9999999999" id="idm" class="form-control" readonly>
                    </div>
                    </div>
                <div class="col-md-6 col-xs-12">
                <div class="form-group">
                        <label for="nom" id="nomm1">Nom :</label>
                        <input type="text" name="nom" id="nomm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom" id="prenomm1">Prenom :</label>
                        <input type="text" name="prenom" id="prenomm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pseudo" id="pseudom1">Pseudo :</label>
                        <input type="text" name="pseudo" id="pseudom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mdp" id="mdpm1">Mot de passe :</label>
                        <input type="password" name="mdp" minlength="8" id="mdpm" class="form-control" required>
                    </div>
                </div>
                  <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                        <label for="email" id="emailm1">Email :</label>
                        <input type="email" name="email" id="emailm" class="form-control" required>
                    </div>
                   
                  
                    <div class="form-group">
                        <label for="number" id="numberm1">Numéro :</label>
                        <input type="number" name="number" max="9999999999" id="numberm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="grade" id="gradem1">Grade :</label>
                        <select name="grade" class="form-control" id="gradem">
                            <option value="Maitre de conference classe A" id="maitreDeConferenceClasseAA" >Maitre de conference classe A</option>
                            <option value="Maitre de conference classe B" id="maitreDeConferenceClasseBB" >Maitre de conference classe B</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="domaines" id="DomainesDeRecherches">Domaines de recherches :</label>
                        <input type="text" name="domaines" id="domainesm" class="form-control" required>
                    </div>

                  </div> 
                    
                    
                   
                    <div align="center">
                        <button class="btn btn-primary" id="modifierm" > Modifier </button>
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
            $.MultiLanguage("gestionEncadreur.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("gestionEncadreur.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("gestionEncadreur.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example2').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('gestionEncadreur.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('gestionEncadreur.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('gestionEncadreur.json','ar');
       }
    
} );
     function editCompte(id){
            $("#editCompte").css('display','block');
            $("#idm").val(id['id']);
            $("#nomm").val(id['nom']);
            $("#prenomm").val(id['prenom']);
            $("#pseudom").val(id['username']);
            $("#emailm").val(id['email']);
            $("#numberm").val(id['number']);
            $("#gradem").val(id['grade']);
            $("#domainesm").val(id['domaine']);
            
        }
        function delCompte(mat){
            var result = confirm("Are you sure to delete?");
        if(result){
        // Delete logic goes here
        $.post( "process/delEncadreur.php",{mat:mat}, function( data ) {
            if(data=="done"){
                window.alert("encadreur supprimé");
                location.reload();
            }else{
                window.alert("eurreur");
            }
     });
        }
            
        }
      
        $("#editEncadreur").submit(function(){

                var id = $("#idm").val();
                var nom = $("#nomm").val();
                var prenom = $("#prenomm").val();
                var pseudo = $("#pseudom").val();
                var mdp = $("#mdpm").val();
                var email = $("#emailm").val();
                var number = $("#numberm").val();
                var grade = $("#gradem").val();
                var domaines = $("#domainesm").val();
                $.post( "process/editEncadreur.php", {id:id,nom:nom,prenom:prenom,pseudo:pseudo,mdp:mdp,email:email,number:number,grade:grade,domaines:domaines}, function( data ) {
                            if(data == "done"){
                               
                                window.alert("encadreur  est modifié");
                                location.reload();
                            }else{
                                window.alert("error");
                            }
                    });
                   
            return false;
        });  


     $("#addEncadreur").submit(function(){

        var matricule = $("#matricule").val();
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        var pseudo = $("#pseudo").val();
        var mdp = $("#mdp").val();
        var email = $("#email").val();
        var number = $("#number").val();
        var grade = $("#grade").val();
        var domaines = $("#domaines").val();
        $.post( "process/ajoutEncadreur.php", {matricule:matricule,nom:nom,prenom:prenom,pseudo:pseudo,mdp:mdp,email:email,number:number,grade:grade,domaines:domaines}, function( data ) {
                    if(data == "done"){
                        window.alert("Encadreur ajouté avec success");
                        location.reload();
                    }else{
                        window.alert(data);
                        window.alert("error");
                    }
            });
            $('#addEncadreur').trigger("reset");
            return false;
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