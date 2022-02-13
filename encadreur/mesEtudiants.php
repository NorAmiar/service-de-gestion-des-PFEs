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
            <h2><b id="listeDesMesEtudiantsME">Liste De Mes Etudiants : </b></h2>
            <br><br>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="idME">ID</th>
                <th id="PseudoME">Pseudo</th>
                <th id="sujetME">Sujet</th>
                <th id="tauxAvancementME">Taux d'avancement</th>
                
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $user = $_SESSION['user'];
          $query = "SELECT * FROM `sujet` WHERE `encadreur`=? AND `etat`= ? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$user,1]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                $query2 = "SELECT * FROM `compte_etudiants` WHERE `sujet`=? ";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$result['titre']]);
                $result2 = $sql2->fetch(PDO::FETCH_ASSOC);
        
        ?>
            <tr>
                <td><?php echo $result2['idCompte']; ?></td>
                <td>
                <a href="profile.php?user=<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?> </a>
                </td>
                <td>
                <a href="theme.php?id=<?php echo $result['id'];?>"> <?php echo $result['titre']; ?></a>    
               </td>
                <td><?php echo $result['tauxAvancement']; ?> %</td>
              
              
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
            $.MultiLanguage('mesEtudiants.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('mesEtudiants.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('mesEtudiants.json','ar');
       }
} );
$("#fr").click(function(){
            $.MultiLanguage("mesEtudiants.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("mesEtudiants.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("mesEtudiants.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
</script>
</body>
</html>