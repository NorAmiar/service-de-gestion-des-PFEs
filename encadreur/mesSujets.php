<?php 
    include("../config/db.php");
 
?>
<html>
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
            <h2><b id="listeDesChoixS">Liste Des Choix : </b></h2>
            <br><br>
            <?php 
                $query = "SELECT * FROM `departement` WHERE `nom`=?";
                $sql = $pdo->prepare($query);
                $sql->execute([$_SESSION['departement']]);
                if($sql->rowCount()==1){
                    $result = $sql->fetch(PDO::FETCH_ASSOC);
                    if($result['choixSujet']==1){
                        if($result['affectationAuto']==0){
                            
            ?>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="pseudoS">Pseudo</th>
                <th id="sujetS">Sujet</th>
                <th id="prioritéS">Priorité </th>
                <th id="dateDeChoixS">Date de choix</th>
                <th id="moyenneDetudiantS">Moyenne d'etudiant(s)</th>
                <th id="action">Action</th>
                
               
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $sujets = [];
          $query2 = "SELECT * FROM `sujet` WHERE `encadreur` = ? AND `departement` = ?";
          $sql2 = $pdo->prepare($query2);
          $sql2->execute([$user,$_SESSION['departement']]);
          if($sql2->rowCount()>0){
              
            while($result2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                    array_push($sujets,$result2['titre']);
                }
                $in  = str_repeat('?,', count($sujets) - 1) . '?';
                $query = "SELECT * FROM `choix` WHERE `sujet` IN($in) AND `departement` = ?";
                $sql = $pdo->prepare($query);
                $inputs = $sujets;
                array_push($inputs,$_SESSION['departement']);
                $sql->execute($inputs);
                
                if($sql->rowCount()>0){
                    
                    while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                      $query3 = "SELECT * FROM `sujet` WHERE `titre` = ? AND `departement` = ?";
                      $sql3 = $pdo->prepare($query3);
                      $sql3->execute([$result['sujet'],$_SESSION['departement']]);
                      $result3 = $sql3->fetch(PDO::FETCH_ASSOC);


            
          
        ?>



            <tr>
                <td> <a href="profile.php?user=<?php echo $result['user'];?>"><?php echo $result['user'];?></a>     </td>
                <td>
                <a href="theme.php?id=<?php echo $result3['id'];?>"> <?php echo $result['sujet']; ?></a>    
               </td>
                <td><?php echo $result['priority']+1; ?></td>
                <td><?php echo $result['dateChoix'];  ?> </td>
                <td><?php echo $result['moyenne_compte']; ?></td>
                <td>
                <?php  
                if($result['etat']==0){
                    
                ?>
                <button class="btn btn-primary" onclick="confirmer(<?php echo $result['id']; ?>)" id="confirmerS" >Confirmer</button>
                <?php 
                }else{
                    echo "En attente de confirmation d'etudiant";
                }
                
                ?>
                </td>
              
            </tr>
          <?php 
              }
            }
        }
          ?>

        </tbody>
      
    </table>

        </div>
        <?php 

                }else{
                    echo "L'affectation sera faite automatiquement par le systeme";
                }
                    }else{
                        echo "Session de choix des sujets est fermé";
                    }
                }
        ?>
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
            $.MultiLanguage('mesSujets.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('mesSujets.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('mesSujets.json','ar');
       }
        } );
        $("#fr").click(function(){
            $.MultiLanguage("mesSujets.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("mesSujets.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("mesSujets.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
function confirmer(id){
   
    $.post("process/confirmChoix.php",{id:id},function(data){
        window.alert(data);
        location.reload();
    });
    
}
</script>
</body>
</html>