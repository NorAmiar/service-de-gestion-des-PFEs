<?php 
    include("../config/db.php");
    

?>
<!DOCTYPE html>
<html>
  <?php include("layouts/head.php"); ?>
    <body>
        <!-- load navbar layout -->
            <?php include("layouts/navbar.php"); ?>
       

        <div class="container-fluid">
        
            
        <div class="col-md-3 col-xs-12">
                <!-- load profile ticket : name email number .. ect -->
                <div class="row well">
                <?php include("layouts/profileTicket.php"); ?>
                </div>
                     <!-- load sidebar Menu  -->
                    
                     <?php include("layouts/sidebar.php"); ?>
        </div>
        
          
            <div class="col-md-9 col-xs-12">
                <div class="container-fluid ">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#deposerSujet0" id="déposerUnSujetDS">Déposer un Sujet</a></li>
                    <li><a data-toggle="tab" href="#mesSujets" id="mesSujetsDS">Mes sujets</a></li>
                    <li><a data-toggle="tab" href="#toutSujets" id="tousLesSujetsDS">Tout les sujets</a></li>
                    
                </ul>
                <div class="tab-content">
        <div id="deposerSujet0" class="tab-pane fade in active">
            <h3 id="déposerUnSujetDS1">Déposer un sujet</h3>
            <?php 
            $query = "SELECT * FROM `departement` WHERE `nom`=?";
            $sql = $pdo->prepare($query);
            $sql->execute([$_SESSION['departement']]);
            if($sql->rowCount()==1){
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                if($result['depotSujet']==1){

            ?>
            <form id="deposerSujet"  >
                    <div class="form-group">
                            <label for="niveau" id="niveauDS1">Niveau :</label><br>
                            <input type="radio"  id="License" name="niveau" value="license">
                            <label for="License" id="licenseDS">License</label><br>
                            <input type="radio" id="Master" name="niveau" value="master">
                            <label for="Master" id="masterDS">Master</label><br>
                        </div>
                        <div class="form-group">
                            <label for="titre" id="titreDS">Titre :</label>
                            <input type="text" class="form-control" name="titre" id="titre" placeholder="Saisir le titre de theme" required>
                            <div id="titleError" style="display:none;">
                            <br>
                            <div  class="alert alert-danger" id="errorMessage" >  </div></div>
                        </div>
                        <div class="form-group">
                            <label for="contenu" id="contenuDS">Contenu :</label>
                            <textarea class="form-control"  id="contenu" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords"  id="motsCléDS">Mots clé :</label>
                            <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Saisir les mots clé séparé par virgule ex : web,e-learning, ..." required>
                        </div>
                        <div class="form-group">
                            <label for="env" id="environementDS">Environement :</label>
                            <input type="text" class="form-control" name="env" id="env" placeholder="Saisir l'environement de travail" required>
                        </div>
                        <div class="form-group">
                            <label for="bibliographie" id="bibliographieDS">Bibliographie :</label>
                            <textarea class="form-control"  id="bibliographie" required></textarea>
                        </div>
                        <div align="center"><button class="btn btn-primary" id="déposerDS" >Déposer</button></div>
                    </form>
                    <?php 
                    }else{
                        echo "Session de dépot des sujets est fermé";
                    }
                }
                    ?>
                
            </div>
        <div id="mesSujets" class="tab-pane fade">
        <div class="container-fluid" >
            <h2><b id="listeDeMesSujetsDS">Liste De Mes Sujets : </b></h2>
            <br><br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="niveauDS2">Niveau</th>
                <th id="titreDS1">Titre</th>
                <th id="etatDS">Etat </th>
                <th id="etudiantDS">Etudiant(s)</th>
                <th id="nombreDeChoixDS">Nombre de choix</th>
                
               
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `sujet` WHERE `encadreur`=? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$user]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['niveau']; ?></td>
                <td>
                <a href="theme.php?id=<?php echo $result['id'];?>"> <?php echo $result['titre']; ?></a>    
               </td>
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
            <div id="toutSujets" class="tab-pane fade ">
                <h2><b id="toutLesSujetsDS">Tout les sujets</b></h2>
                <br><br>
                <div class="table-responsive">
        <table id="example2" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="niveauDS">Niveau</th>
                <th id="titreDS2">Titre</th>
                <th id="encadreurDS">Encadreur</th>
                <th id="etatDS1">Etat </th>
                <th id="etudiantDS1">Etudiant(s)</th>
                <th id="nombreDeChoixDS1">Nombre de choix</th>
                
               
        
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
            $.MultiLanguage("deposerSujet.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("deposerSujet.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("deposerSujet.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
                  $(document).ready(function() {
                    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('deposerSujet.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('deposerSujet.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('deposerSujet.json','ar');
       }
                    $('#example').DataTable();
                    $('#example2').DataTable();
                        } );

                var valid = true;
               

                                        function checkTitle(x,callback)
                        {
                           
                            $.post( "process/check.php",{title:x}, function( data ) {
                               
                                    callback(data);
                            });
                             


                        }

    
                    function check(){
                        if(!valid){
                            //show error
                            $("#titleError").css('display','block');
                            $("#errorMessage").html("changer le titre , deja utilisé");
                        }else{
                            //unshow the error
                            $("#titleError").css('display','none');
                            $("#errorMessage").html("");
                            
                        }
                    }
                    
                    $("#titre").change(function(){
                        var x = $(this).val();
                        checkTitle(x,function(d){
                            if(d == "true"){
                            valid = true;
                        }else{
                            valid = false;
                        }
                       check();
                        });
                        
                      
                    });
                    $("#deposerSujet").submit(function(){
                        var niveau = $("input[name='niveau']:checked").val();
                        var titre = $("#titre").val();
                        var contenu = $("#contenu").val();
                        var env = $("#env").val();
                        var bib = $("#bibliographie").val();
                        var keywords = $("#keywords").val();
                        checkTitle(titre,function(d){
                          
                            if(d == "true"){
                            valid = true;
                             //post data
                             $.post( "process/deposer.php",{niveau:niveau,titre:titre,contenu:contenu,env:env,bib:bib,keywords:keywords}, function( data ) {
                                window.alert(data);
                                location.reload();
                               
                                });

                        }else{
                            valid = false;
                            window.alert("Le titre est déja utilisé");
                        }
                       check();
                        });
                     
                            
                        
                        return false;

                    });

            
                  

   
</script>
          
    </body>
    </html>