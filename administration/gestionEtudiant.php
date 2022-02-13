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
    
        <link rel="stylesheet" href="../static/css/datatables.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

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
           <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" id="importEtudText" href="#importEtud">Importation Etudiants</a></li>
                    <li><a data-toggle="tab" id="listeEtudText" href="#listeEtud"> Liste des Etudiants </a></li>
                    <li><a data-toggle="tab" id="gestionCompteText" href="#gestionCompte">Gestion des Comptes</a></li>
                    <li><a data-toggle="tab" id="creationCompteText" href="#creationCompte">Creation manuelle des comptes</a></li>
                </ul>
                <div class="tab-content">
                    <div id="importEtud" class="tab-pane fade in active">
                        <form class="form-horizontal" action="process/import.php" method="POST" id="import" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Form Name -->
                                <legend> <b id="importerLegendText" >  Importer la liste des etudiants</b></legend>
                                <!-- File Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" id="choixFichier" for="filebutton">Choisir un fichier</label>
                                    <div class="col-md-4">
                                        <input type="file" accept=".csv" name="file" id="file" class="input-large" required>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="form-group">
                                
                                        <div align="center">
                                                <button class="btn" id="importButton" style="width:30%;">Importer</button>
                                                </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div id="listeEtud" class="tab-pane fade">
                        <div class="table-responsive ">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th id="matriculeTh">Matricule</th>
                                        <th id="nomTh">Nom</th>
                                        <th id="prenomTh">Prénom</th>
                                        <th id="emailTh">email</th>
                                        <th id="moyenneTh">Moyenne</th>
                                        <th id="niveauTh">Niveau</th>
                                        <th id="pinTh">PIN</th>
                                        <th id="actionTh">Action</th>
                                        <th id="actionTh2">Action</th>
                                    
                                    
 
                                
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                    $departement = $_SESSION['departement'];
                                    $query = "SELECT * FROM `etudiant` WHERE `departement`=? ";
                                    $sql = $pdo->prepare($query);
                                    $sql->execute([$departement]);
                                    
                                    if($sql->rowCount()>0){
                                        
                                        while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                                            $json = json_encode($result);
                                    
                                    ?>



                                    <tr>
                                        <td><?php echo $result['matricule'];?> </td>
                                        <td><?php echo $result['nom']; ?></td>
                                        <td><?php echo $result['prenom']; ?></td>
                                        <td><?php echo $result['email']; ?></td>
                                        <td><?php echo $result['moyenne_e']; ?></td>
                                        <td><?php echo $result['niveau']; ?></td>
                                        <td><?php echo $result['pin']; ?></td>
                                        <td><button onclick='editEtud(<?php echo $json; ?>);' class="btn" id="modifButton"> Modifier</button></td>
                                        <td><button onclick="del(<?php echo $result['matricule']; ?>);" class="btn" id="supprimButton" >Supprimer</button></td>
                                    
                                     
                                    </tr>
                                    <?php   
                                            }
                                        }
                                    ?>
                            
                                 </tbody>
                    
                            </table> 
                                <center>
                                    <button onclick="exportTableToCSV('ListeDesEtudiants.csv')" class="btn" id="exportButton" style="width:30%;">Export</button>
                                </center>
                        </div>
                    </div>
                    <div id="gestionCompte" class="tab-pane fade">
                    <div class="table-responsive" id="pdfExportDiv">
                 <table id="example2" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="idTh">ID</th>
                    <th id="pseudoTH">Pseudo</th>
                    <th id="sujetTh">Sujet</th>
                    <th id="moyenneTh2">Moyenne</th>
                    <th id="niveauTH2">Niveau</th>
                    <th id="typeTh">Type De Compte</th>
                    <th id="actionTh3">Action</th>
                    <th id="actionTh4">Action</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
            $departement = $_SESSION['departement'];
            $query = "SELECT * FROM `compte_etudiants` WHERE `departement`=? ";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement]);
            
            if($sql->rowCount()>0){
                
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                   
                    
        ?>
            <tr>
                <td><?php echo $result['idCompte'];?> </td>
                <td><a href="profile.php?user=<?php echo $result['user']; ?>"><?php echo $result['user']; ?></a> </td>
                <td><?php echo $result['sujet']; ?></td>
                <td><?php echo $result['moyenne_compte']; ?></td>
                <td><?php echo $result['niveau']; ?></td>
                <td><?php echo $result['typeC'] ?></td>
                <?php 
                 unset($result["sujet"]);
                 $json2 = json_encode($result);
                ?>
                <td><button class="btn" onclick='editCompte(<?php echo $json2; ?>);' style="width:100% !important;">Modifier</button></td>
                <td><button onclick='delCompte(<?php echo $result["idCompte"]; ?>);' class="btn" id="suppButton" style="width:100% !important;">Supprimer</button></td>
               
            </tr>
        <?php 
        
    }
}
        ?>
        </tbody>
       
    </table>
    </div>
    <center>
                                    <button onclick="createPDF()" class="btn" id="exportButton2" style="width:30%;">Export</button>
                                </center>
      
                    </div>
                    <div id="creationCompte" class="tab-pane fade">
                        <div class="col-md-4">
                            <form id="createAcc">
                            <center><h4 id="form1Title">Creation manuelle d'un compte étudiant</h4></center>
                                <div class="form-group">
                                    <label for="pseudo" id="pseudoLabel">Pseudo : </label>
                                    <input type="text" class="form-control" name="pseudo" id="pseudo" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" id="passwordLabel">Mot de passe : </label>
                                    <input type="password" class="form-control" name="password" id="password" minlength="8" required>
                                </div>
                                <div class="form-group">
                                    <label for="type" id="typeLabel">Type de compte : </label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="Monome"id="monome">Monome</option>
                                        <option value="Binome" id="binome">Binome</option>
                                        <option value="Trinome" id="trinome">Trinome</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                <div class="row">
                                    <div class="col-md-9">
                                    <select name="etud" id="etudiantMat" class="form-control" placeholder="Choisir l'etudiant et cliquer ajouter" required>
                                        <option value=""></option>
                                    </select>
                                    </div>
                                    <div class="col-md-3"> 
                                    <button id="addEtud" type="button" class="btn">Ajouter</button>
                                    </div>
                                </div>
                                </div>

                                <div class="form-group">
                                    <ul id="list">

                                    </ul>
                                </div>
                                <center><button id="formButton1" class="btn">Creer</button></center>
                            </form>
                        </div>
                        <div class="col-md-offset-2 col-md-4">
                            <form id="addToEtudList">
                            <center><h4 id="form2Title">Ajout manuelle d'un étudiant a la base</h4></center>
                                <div class="form-group">
                                    <label for="mat" id="matLabel">Matricule : </label>
                                    <input type="number" class="form-control" name="mat" id="mat" max="99999999" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom" id="nomLabel">Nom : </label>
                                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Saisir le nom" required>
                                </div>
                                <div class="form-group">
                                    <label for="prenom" id="prenomLabel">Prénom : </label>
                                    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Saisir le prénom" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" id="emailLabel">Email : </label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="exemple@exemple.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="moyenne" id="moyenneLabel">Moyenne : </label>
                                    <input type="number" name="moyenne" id="moyenne" value="0" min="0" max="20" class="form-control" step=".01" required>
                                </div>
                                <div clas="form-group">
                                    <label for="pin" id="pinLabel">Code PIN : </label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="number" name="pin" class="form-control" id="pin" min="1111" max="9999" required>
                                            </div>
                                            <div class="col-md-4">
                                                <center> 
                                                    <button type="button" onclick="generer();" id="form2Button1" class="btn">Génerer</button>
                                                </center>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" onclick="verifierPin();" id="form2Button2" class="btn">Vérifier s'il existe</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="alert alert-danger" id="pinExist" style="display:none;">
                                            <strong>PIN exist deja!</strong> Veuillez generer un autre code PIN s'il vous plait .
                                        </div>
                                        <div class="alert alert-success" id="pinValide" style="display:none;">
                                            <strong>PIN Valide</strong> Completer l'ajout .
                                        </div>
                                </div>
                                <div class="form-group">
                                <label for="niveau" id="niveauLabel">Niveau :</label><br>
                                    <input type="radio"  id="Licence" name="niveau" value="licence" checked>
                                    <label for="License" id="licenseLabel">Licence</label> &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="Master" name="niveau" value="master" >
                                    <label for="Master" id="masterLabel">Master</label><br>
                                </div>
                                <center><button type=submit class="btn" id="form2Button3">Ajouter</button></center>
                            </form>
                        </div>
                    </div>
                </div>
               
<br><br>
               


            </div>
     
            </div>

            <div id="editEtud" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('editEtud').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
            <div class="container-fluid">
            <br><br>
            <center><h3 id="modificationDetudiant">Modification d'étudiant </h3></center>
                <form id="editEtudAction">
                <input type="hidden" name="idE" id="idE">
                    <div class="form-group">
                        <label for="matriculeE" id="matriculeE1">
                            Matricule : 
                        </label>
                        <input type="number" class="form-control" max="99999999" name="matriculeE" id="matriculeE" required> 
                    </div>
                    <div class="form-group">
                        <label for="nomE" id="nomE1">
                            Nom : 
                        </label>
                        <input type="text" name="nomE" id="nomE" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="prenomE" id="prenomE1">
                            Prénom : 
                        </label>
                        <input type="text" name="prenomE" id="prenomE" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="emailE" id="emailE1">
                            Email : 
                        </label>
                        <input type="email" name="emailE" id="emailE" class="form-control" required>
                    </div>
                    <div class="form-group">
                            <label for="moyenneE" id="moyenneE1">Moyenne : </label>
                            <input type="number" name="moyenneE" id="moyenneE" value="0" min="0" max="20" class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                                <label for="niveau" id="niveauE">Niveau :</label><br>
                                    <input type="radio"  id="LicenseE" name="niveauE" value="licence" required>
                                    <label for="License" id="LicenseE">Licence</label> &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="MasterE" name="niveauE" value="master" required>
                                    <label for="Master"id ="MasterE">Master</label><br>
                    </div>
                    
                    <center><button class="btn btn-custom" id="modife" >Modifier</button></center>
                </form>
            </div>
      </div>
  </div>
</div>


<div id="editEtudCompte" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('editEtudCompte').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
            <div class="container-fluid">
            <br><br>
            <center><h3 id="modificationCompteDesEtudiants">Modification compte étudiant </h3></center>
                <form id="editCompteAction">
                <input type="hidden" name="idCE" id="idCE">
                    <div class="form-group">
                        <label for="Pseudo" id="pseudoCE2">
                            Pseudo : 
                        </label>
                        <input type="text" name="pseudoE" id="pseudoCE" class="form-control" required>
                    </div>
                    <div class="form-group">
                            <label for="moyenneE"id="moyenneCE2">Moyenne : </label>
                            <input type="number" name="moyenneCE" id="moyenneCE" value="0" min="0" max="20" class="form-control" step=".01" required>
                    </div>
                    <div class="form-group">
                                <label for="niveau"id ="niveauCE2">Niveau :</label><br>
                                    <input type="radio"  id="LicenseCE" name="niveauCE" value="licence" required>
                                    <label for="License" id="LicenseCE2">License</label> &nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="MasterCE" name="niveauCE" value="master" required>
                                    <label for="Master" id="MasterCE2">Master</label><br>
                    </div>
                    <div class="form-group">
                                    <label for="type" id="typeCompteCE">Type de compte : </label>
                                    <select name="typeE" class="form-control" id="typeE">
                                        <option value="Monome" id="MonomeCE">Monome</option>
                                        <option value="Binome" id="BinomeCE">Binome</option>
                                        <option value="Trinome" id="trinomeCE">Trinome</option>
                                    </select>
                                </div>
                    <center><button type="submit" class="btn btn-primary" id="modifeCE">Modifier</button></center>
                </form>
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
            $.MultiLanguage("gestionEtudiant.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("gestionEtudiant.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("gestionEtudiant.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
           
    $(document).ready(function() {
    $('#example').DataTable();
    $('#example2').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('gestionEtudiant.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('gestionEtudiant.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('gestionEtudiant.json','ar');
       }
    manualAdd();
} );
function editCompte(info){
    $("#idCE").val(info.idCompte);
    $("#pseudoCE").val(info.user);
    $("#moyenneCE").val(info.moyenne_compte);
    $("input[name=niveauCE][value=" + info.niveau + "]").attr('checked', 'checked');
    $("#typeE").val(info.typeC);
    $("#editEtudCompte").show();
}
$("#editCompteAction").submit(function(){
    
    id= $("#idCE").val();
    pseudo = $("#pseudoCE").val();
    moyenne = $("#moyenneCE").val();
    niveau = $('input[name="niveauCE"]:checked').val();
    type = $("#typeE").val();
    $.post("process/editEtudCompte.php",{id:id,pseudo:pseudo,moyenne:moyenne,niveau:niveau,type:type},function(data){
       window.alert(data);
       location.reload();
    });
    return false;
});
function editEtud(info){
    $("#idE").val(info.id);
    $("#matriculeE").val(info.matricule);
    $("#nomE").val(info.nom);
    $("#prenomE").val(info.prenom);
    $("#emailE").val(info.email);
    $("#moyenneE").val(info.moyenne_e);
    $("input[name=niveauE][value=" + info.niveau + "]").attr('checked', 'checked');
    $("#editEtud").show();
}
$("#editEtudAction").submit(function(){
    id = $("#idE").val();
    mat = $("#matriculeE").val();
    nom = $("#nomE").val();
    prenom = $("#prenomE").val();
    email = $("#emailE").val();
    moyenne = $("#moyenneE").val();
    niveau = $('input[name="niveauE"]:checked').val();
    $.post("process/editEtud.php",{id:id,mat:mat,nom:nom,prenom:prenom,email:email,moyenne:moyenne,niveau:niveau},function(data){
        window.alert(data);
        location.reload();
    });
    return false;
});

$("#createAcc").submit(function(){
    nb=0;
    var type = $("#type").val();
    if(type=="Monome"){
        nb=1;
    }else{
        if(type=="Binome"){
            nb=2;
        }else{
            if(type=="Trinome"){
                nb=3;
            }
        }
    }
    var user = $("#pseudo").val();
    var password = $("#password").val();
    if(nb==etuds.length){
        $.post("process/manuelAcc.php",{user:user,password:password,type:type,etuds:etuds},function(data){
            window.alert(data);
            location.reload();
        });
    }else{
        window.alert("Nombre des étudiants ne corespend pas au type de compte");
    }
    return false;
});
$("#addToEtudList").submit(function(){
    var mat = $("#mat").val();
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();
    var email = $("#email").val();
    var moyenne = $("#moyenne").val();
    var pin = $("#pin").val();
    var niveau = $("input[name='niveau']:checked","#addToEtudList").val();
    verifierPin();
    if($("#pinValide").is(":visible")){

        $.post("process/addToEtudList.php",{mat:mat,nom:nom,prenom:prenom,email:email,moyenne:moyenne,pin:pin,niveau:niveau},function(data){
            window.alert(data);
            location.reload();
        });

        } else{

            window.alert("PIN exist deja! Veuillez generer un autre code PIN s'il vous plait . ");

        }
    return false;
});
function del(mat){
    var result = confirm("Are you sure to delete?");
    if(result){
        // Delete logic goes here
        $.post("process/delE.php",{mat:mat},function(data){
            window.alert(data);
            location.reload();
        });
    }
}
function verifierPin(){
    
    var pin = $("#pin").val();
    
    if(pin>999){
        $.post("process/verifierPin.php",{pin:pin},function(data){
            if(data=="exist"){
                $("#pinValide").hide();
                $("#pinExist").show();
            }else{
                $("#pinExist").hide();
                $("#pinValide").show();
            }
        });
    }
}
function generer(){
    var nb = Math.floor(Math.random() * 9000) + 999;
    $('#pin').val(nb);
}
function manualAdd(){
        $.post("process/manualEtud.php",function(result){
            if(result !=""){

            
      var data  = JSON.parse(result);
      var n= data.length;
     
      for(var i =0 ; i<n;i++){
          optionText = data[i][1];
          optionValue = data[i][0];
          $("#etudiantMat").append(`<option value="${optionValue}"> ${optionText} </option>`);
      }
      $("#etudiantMat").selectize({
        sortField: 'text'
    });
}
 
  });
       
        
       
    }
    $("#type").change(function(){
        $('#list').empty();
        etuds = [];
    });
    var etuds = [];
    $("#addEtud").click(function(){
        var type = $("#type").val();
        switch(type){
            case "Monome":
                //code block
                if(etuds.length==0)
                {
                etuds.push($("#etudiantMat").val());
                var n = etuds.length-1;
                $("#list").append('<li id="item'+n+'"><a href="#">'+$("#etudiantMat").text()+'</a> &nbsp;&nbsp; <button class="btn" type="button" onclick="deleteItem('+n+')" >Supprimer</button></li>');
                }else{
                    window.alert("Type monome vous pouvez juste ajouter 1 étudiant");
                }
                break;
            case "Binome":
                //code block
                if(etuds.length<2 && !etuds.includes($("#etudiantMat").val()))
                {
                etuds.push($("#etudiantMat").val());
                var n = etuds.length-1;
                $("#list").append('<li  id="item'+n+'"><a href="#">'+$("#etudiantMat").val()+'</a> &nbsp;&nbsp; <button class="btn" type="button" onclick="deleteItem('+n+')" >Supprimer</button></li>');
                }else{
                    window.alert("Type binome vous pouvez juste ajouter 2 étudiant ou verifier étudiant déja ajouté");
                }
                break;
            case "Trinome":
                //code block
                if(etuds.length<3 && !etuds.includes($("#etudiantMat").val()))
                {
                etuds.push($("#etudiantMat").val());
                var n = etuds.length-1;
                $("#list").append('<li  id="item'+n+'"><a href="#">'+$("#etudiantMat").val()+'</a> &nbsp;&nbsp; <button class="btn" type="button" onclick="deleteItem('+n+')" >Supprimer</button></li>');
                }else{
                    window.alert("Type trinome vous pouvez juste ajouter 3 étudiant ou verifier étudiant déja ajouté");
                }
                break;
        }
        
       });
       function createPDF(){
           var sTable = document.getElementById('pdfExportDiv').innerHTML;
          
           var style = "<style>";
           style = style + "table {width:100%;font:17px Calibri;}";
           style = style + "table,th,td {border: solid 1px #DDD;border-collapse:collaplse;";
           style = style + "padding: 2px 3px;text-align:center;}";
           style = style + "</style>";

            // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');

            win.document.write('<html><head>');
            win.document.write('<title>Liste des comptes</title>');   // <title> FOR PDF HEADER.
            win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
            win.document.write('</body></html>');

            win.document.close(); 	// CLOSE THE CURRENT WINDOW.

            win.print();    // PRINT THE CONTENTS.
       }
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
function deleteItem(id){
    var result = confirm("Are you sure to delete?");
    if(result){
        // Delete logic goes here
        $('#item'+id).remove();
    etuds.splice(id,1);
    }
    
}
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#example tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length-2; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
function delCompte(id){
    var result = confirm("Are you sure to delete?");
    if(result){
        // Delete logic goes here
        $.post( "process/delEtudiant.php",{id:id}, function( data ) {
            if(data=="done"){
                window.alert("Compte etudiants est supprimé avec success");
                location.reload();
            }else{
                window.alert("eurreur");
            }
     });
    }
            
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