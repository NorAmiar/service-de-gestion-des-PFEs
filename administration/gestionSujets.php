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
        <script src="../static/js/selectize.min.js"  ></script>
<link rel="stylesheet" href="../static/css/selectize.bootstrap3.min.css"  />

     
    </head>
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body style="background-color:#e5ebf0;">
    <?php include("layouts/navbar.php"); ?>
        <br>
    
        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
            <div class="col-md-9 col-xs-12 " style="color:white;">
            <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#listeSujet" id="ListeDesSujets">Liste des sujets</a></li>
                    <li><a data-toggle="tab" href="#creeSujetManuelle" id="cretionManuelleDeSujets"> Création manuelle de sujet </a></li>
                </ul>
                <div class="tab-content">
                    <div id="listeSujet" class="tab-pane fade in active">
            <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="niveau">Niveau</th>
                <th id="titre">Titre</th>
                <th id="encadreurText">Encadreur</th>
                <th id="etat">Etat </th>
                <th id="etudiant">Etudiant(s)</th>
                <th id="nombreDeChoix">Nombre de choix</th>
                <th id="tauxDavancement">Taux d'Avancement</th>
                <th>Action</th>
                <th id="Action0">Action</th>
                <th id="Action1">Action</th>
                <th id="Action2">Action</th>
                <th id="Action3">Action</th>
                
               
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `sujet` WHERE `departement`=? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$_SESSION['departement']]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                  $json2 = $result;
                  $json2['contenu'] = addslashes($json2['contenu']);
                  $json2 = json_encode($json2,JSON_UNESCAPED_UNICODE);
                  //$json2 = addslashes($json2);
                  
        
        ?>



            <tr>
                <td><?php echo $result['niveau']; ?></td>
                <td>
                <a href="theme.php?id=<?php echo $result['id'];?>"> <?php echo $result['titre']; ?></a>    
               </td>
               <td><a href="encadreur.php?user=<?php echo $result['encadreur']; ?>"><?php echo $result['encadreur']; ?></a></td>
                <td><?php if ($result['valid']==0){
                    echo "Non validé";
                }else{
                    echo "Validé";
                } 
                
                ?></td>
                <td><?php  
                if($result['etat']==0){
                    echo "Non choisi";
                }else{
                    $query2 = "SELECT * FROM `compte_etudiants` WHERE `sujet`=? ";
                    $sql2 = $pdo->prepare($query2);
                    $sql2->execute([$result['titre']]);
                    
                    if($sql2->rowCount()==1){
                        $result2 = $sql2->fetch(PDO::FETCH_ASSOC);
                        ?> 
                        <a href="profile.php?user=<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?> </a>
                        <?php
                        
                    }
                }
                 ?></td>
                <td><?php echo $result['nb_choix']; ?></td>
                <td><?php echo $result['tauxAvancement'] . " %"; ?></td>
                <td>
                <?php 
                $query2 = "SELECT * FROM `fiche_suivi` WHERE `id_sujet`=? ";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$result['id']]);
                if($sql2->rowCount()>0){

                ?>
                <button class="btn btn-primary" data-id="<?php echo $result['id']?>" id="ficheSuiviModal">Fiche de suivi</button>
                <?php
                }else{
                    echo "Pas de fiches encore";
                }
                ?>
                </td>
                <td>
                <?php 
                    if($result['valid']==0){
                        
                ?>
                <button class="btn btn-primary" onclick='modifier(<?php echo $result["id"]; ?>)'>Modifier</button> 
                <?php  }else{
                        echo "Le sujet est validé par le présiden de CSD";
                    }?>
                <td>
                <?php 
                    if($result['etat']==1){
                        
                ?>
                <button class="btn"id="Liberer" onclick= 'liberer(<?php echo $result["id"]; ?>)'>Liberer</button>
              <?php 
                    }else{
                        echo "Le sujet n'est pas affecté";
                    }
              ?>
              </td>
              <td>
                <?php 
                    if($result['etat']==0 && $result['valid']==1){
                ?>
                <button class="btn" id="affecter" onclick='affecter(<?php echo $result["id"]; ?>,"<?php echo $result["niveau"]; ?>")' > Affecter</button>
              <?php 
                    }else{
                        echo "Le sujet est affecté ou n'est pas validé";
                    }
              ?>
              </td>
              
              <td><button class="btn" id="supprimer" onclick="delSujet(<?php echo $result['id'] ?>);" >Supprimer</button></td>
            </tr>
          <?php 
              }
            }
          ?>

        </tbody>
      
    </table>

        </div>
        </div>
        <div id="creeSujetManuelle" class="tab-pane fade">
            <div class="col-md-offset-3 col-md-6 col-xs-12">
            <form id="creeSujetAction" style="color: #000040;"> 
                <div class="form-group">
                <div class="form-group">
                            <label id="niveauS" for="niveau">Niveau :</label><br>
                            <input type="radio"  id="License" name="niveau" value="licence">
                            <label id="licenseS" for="License">License</label><br>
                            <input type="radio" id="Master" name="niveau" value="master">
                            <label id= "masterS" for="Master">Master</label><br>
                        </div>
                    <label id="titreS" for="titre">Titre :</label>
                    <input type="text" name="titre" id="titreL" placeholder="le titre de sujet" class="form-control"  required>
                </div>
                <div class="form-group">
                    <label id="encadreurS" for="encadreur">Encadreur : </label>
                    <select name="encadreur" id="encadreur" class="form-control" required>
                    </select>
                </div>
                <div class="form-group">
                    <label id="contenuS" for="contenu">Contenu :</label>
                    <textarea class="form-control"  id="contenu" required></textarea>
                </div>
                <div class="form-group">
                        <label id="motcléS" for="keywords">Mots clé :</label>
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Saisir les mots clé séparé par virgule ex : web,e-learning, ..." required>
                </div>
                 <div class="form-group">
                        <label id="environementS" for="env">Environement :</label>
                        <input type="text" class="form-control" name="env" id="env" placeholder="Saisir l'environement de travail" required>
                </div>
                <div class="form-group">
                        <label id="bibliographieS" for="bibliographie">Bibliographie :</label>
                        <textarea class="form-control"  id="bibliographie" required></textarea>
                </div>
                <div align="center"><button class="btn btn-primary" id="creer" >Créer</button></div>
            </form>
            </div>
        </div>
        </div>
            </div>

            
        </div>
        <div id="affecterModal" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
            <span onclick="document.getElementById('affecterModal').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>
                <div class="container-fluid">
                    <br><br>
            
                    <center><h1 id="affecterLeSujet">Affecter le sujet </h1></center>    
                  
                    <form id="affecterAction">
                    <input type="hidden" name="idSujet" id="idSujet">
                        <div class="form-group">
                            <label for="etudiant"id="compteLabel">
                                Compte : 
                            </label>
                            <select name="compte" id="compte" class="form-control"  required>
                               
                            </select>
                           
                        </div>
                        <center><button type="submit" class="btn" id="affect">AFFECTER</button></center>
                    </form>
                </div>
            </div>
        </div>
        </div>
        




        <div id="modifierModal" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
            <span onclick="document.getElementById('modifierModal').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>
                <div class="container-fluid">
                    <br><br>
            
                    <center><h1>Modifier le sujet </h1></center>    


        <form id="modifierSujet" style="color: #000040;"> 
                <div class="form-group">
                <div class="form-group">
                <input type="hidden" name="id" id="idS">
                            <label id="niveauSm" for="niveau">Niveau :</label><br>
                            <input type="radio"  id="License" name="niveaum" value="licence">
                            <label id="licenseSm" for="License">License</label><br>
                            <input type="radio" id="Master" name="niveaum" value="master">
                            <label id= "masterSm" for="Master">Master</label><br>
                        </div>
                    <label id="titreS" for="titre">Titre :</label>
                    <input type="text" name="titrem" id="titreLm" placeholder="le titre de sujet" class="form-control"  required>
                </div>
                <div class="form-group">
                    <label id="encadreurSm" for="encadreur">Encadreur : </label>
                    <select name="encadreurm" id="encadreurm" class="form-control" required>
                    </select>
                </div>
                <div class="form-group">
                    <label id="contenuSm" for="contenu">Contenu :</label>
                    <textarea class="form-control"  id="contenum" required></textarea>
                </div>
                <div class="form-group">
                        <label id="motcléSm" for="keywords">Mots clé :</label>
                        <input type="text" class="form-control" name="keywordsm" id="keywordsm" placeholder="Saisir les mots clé séparé par virgule ex : web,e-learning, ..." required>
                </div>
                 <div class="form-group">
                        <label id="environementSm" for="env">Environement :</label>
                        <input type="text" class="form-control" name="envm" id="envm" placeholder="Saisir l'environement de travail" required>
                </div>
                <div class="form-group">
                        <label id="bibliographieSm" for="bibliographie">Bibliographie :</label>
                        <textarea class="form-control"  id="bibliographiem" required></textarea>
                </div>
                <div align="center"><button class="btn btn-primary" tye="submit" >Modifier</button></div>
            </form>
            </div>
            </div>
        </div>
        </div>



        <div id="ficheSuiviModal1" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
            <span onclick="document.getElementById('ficheSuiviModal1').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>
                <div class="container-fluid">
                    <br><br>
            
                    <center><h1>Fiches des suivi   </h1></center>    
            <div class="container-fluid">
            <ul class="list-group" id="listeFiches">
                
            </ul>
            </div>

     
            </div>
            </div>
        </div>
        </div>

        <script>
        headers={"content-type":["application/json"]}
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
            $.MultiLanguage("gestionSujets.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("gestionSujets.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("gestionSujets.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
        x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('gestionSujets.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('gestionSujets.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('gestionSujets.json','ar');
       }
    $('#example').DataTable();
    $.post("process/getEncadreur.php",function(data){
        data = JSON.parse(data);
        for(i=0;i<data.length;i++){
            var option = document.createElement("option");
            option.text = data[i];
            option.value = data[i];
            var select = document.getElementById("encadreur");
            select.appendChild(option);
        }
        $("#encadreur").selectize({
        sortField: 'text'
    });
    for(i=0;i<data.length;i++){
            var option = document.createElement("option");
            option.text = data[i];
            option.value = data[i];
            var select = document.getElementById("encadreurm");
            select.appendChild(option);
        }
        $("#encadreurm").selectize({
        sortField: 'text'
    });
} );
    });

    $("#ficheSuiviModal").click(function(){
        id = $(this).attr('data-id');
        $("#ficheSuiviModal1").show();
        $.post("process/getFiches.php",{id:id},function(data){
            data = JSON.parse(data);
            ul = $("#listeFiches");
            for(i=0;i<data.length;i++){

            nb = i+1;
            ul.append('<li class="list-group-item"><a href="../ficheSuivi.php?id='+ data[i] +'">Fiche '+nb+'  </a></li>');
        }
        });
    });
$("#creeSujetAction").submit(function(){
    titre = $("#titreL").val();
    encadreur = $("#encadreur").val();
    contenu = $("#contenu").val();
    keywords = $("#keywords").val();
    env = $("#env").val();
    niveau = $( "input[name='niveau']:checked","#creeSujetAction" ).val();
    bibliographie = $("#bibliographie").val();
    $.post("process/addSujet.php",{niveau:niveau,titre:titre,encadreur:encadreur,contenu:contenu,keywords:keywords,env:env,bibliographie:bibliographie},function(data){
        window.alert(data);
        location.reload();
    });
    return false;
});
$("#affect").click(function(){
    id = $("#idSujet").val();
    compte = $("#compte").val();
    $.post("process/affecterAction.php",{id:id,compte:compte},function(data){
       // window.alert(data);
        location.reload();
    });
});
function modifier(id){
    $("#modifierModal").show();
    $.post("process/recupererSujet.php",{id:id},function(data){
        obj = JSON.parse(data);
        $("#idS").val(obj.id);
        $("input[name=niveaum][value=" + obj.niveau + "]").attr('checked', 'checked');
        $("#titreLm").val(obj.titre);
        $("#encadreurm").val(obj.encadreur);
        $("#contenum").val(obj.contenu);
        $("#keywordsm").val(obj.keywords);
        $("#envm").val(obj.environement);
        $("#bibliographiem").val(obj.bibliographie);
    });
}
$("#modifierSujet").submit(function(){
        id = $("#idS").val();
        niv = $("input[name=niveaum]").val();
        titre = $("#titreLm").val();
        encadreur = $("#encadreurm").val();
        contenu = $("#contenum").val();
        keywords = $("#keywordsm").val();
        env = $("#envm").val();
        bib = $("#bibliographiem").val();
        $.post("process/editSujet.php",{id:id,niv:niv,titre:titre,encadreur:encadreur,contenu:contenu,keywords:keywords,env:env,bib:bib},function(data){
            window.alert(data);
            location.reload();
        });
    return false;
});
function affecter(id,niveau){
    $("#idSujet").val(id);
    $("#affecterModal").show();
    $.post("process/affecterSearch.php",{niveau:niveau},function(data){
        data = JSON.parse(data);
        for(i=0;i<data.length;i++){
            var option = document.createElement("option");
            option.text = data[i].user;
            option.value = data[i].user;
            var select = document.getElementById("compte");
            select.appendChild(option);
        }
        $("#compte").selectize({
        sortField: 'text'
    });
    });
}
function liberer(id){
    var result = confirm("Are you sure you want to free this ? ");
       if(result){
        $.post("process/libererSujet.php",{id:id},function(data){
                    window.alert(data);
                    location.reload();
                });
       }
               
        }

function delSujet(id){
    var result = confirm("Are you sure you want to delete this ? ");
    if(result){
        $.post("process/delSujet.php",{id:id},function(data){
            window.alert(data);
            location.reload();
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