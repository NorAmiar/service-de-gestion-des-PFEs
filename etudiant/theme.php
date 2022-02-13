<?php 
    include("../config/db.php");
    if(isset($_GET['id']) && $_GET['id']>=0){
        
 $id = $_GET['id'];
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
            <?php  
                $query = "SELECT * FROM `sujet` WHERE `id`=?";
                $sql= $pdo->prepare($query);
                $sql->execute([$id]);
                if($sql->rowCount()==1){
                    
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                $etat = $result['etat'];
                $encadreur = $result['encadreur'];
            ?>
        <center><h1><?php echo $result['titre'] ?></h1></center>
        <p><b id="encadreurTm" >Encadreur : <a href="encadreur.php?user=<?php echo $result['encadreur'];?>" "><?php echo $result['encadreur'];?></a>  </b> </p>  
        <p><b id="DescreptionTm">Descreption : </b></p><br><center> <p><?php echo $result['contenu'];?></p></center>
        <p><b id="keywordsTm">Keywords : </b><?php echo $result['keywords'];?></p>
        <p><b id="environementTm">Environement : </b><?php echo $result['environement'];?></p>
        <p><b id="bibliographieTm">Bibliographie : </b><?php echo $result['bibliographie'];?></p>
        <?php  if($result['valid']==0){
            ?>
            <p><b id="leThemeNestPasEncoreValidé" >Le theme n'est pas encore validé </b></p>
            <?php
        }else{
            if($result['valid']==1 && $result['etat']==1){
                $titre = $result['titre'];
                $query2 = "SELECT * FROM `compte_etudiants` WHERE `sujet`=?";
                $sql2 = $pdo->prepare($query2);
                $sql2->execute([$titre]);
                $result2 = $sql2->fetch(PDO::FETCH_ASSOC);

                
                ?> 
                
                 <p><b id="etuduantTm">Etudiant(s) : </b><a href="profile.php?user=<?php echo $result2['user']; ?>"><?php echo $result2['user']; ?></a></p>
                <p><b id="tauxDavancementTm">Taux d'avancement :</b> <?php echo $result['tauxAvancement']; ?> </p>
                 <?php 
            }else{
                if($result['valid']==1 && $result['etat']==0){
                    ?> 
                    <p><b id="leThemeNestPasEncoreAffecté">Le theme n'est pas encore affecté</b></p>
                    <p><b id="nombreDeFoisChoisi">Nombre de fois choisi : </b> <?php echo $result['nb_choix']; ?> </p>
                    <?php
                }
            }
        } ?>
        <center>
        <a href="../ficheSujet.php?id=<?php echo $id;?>" class="btn btn-primary">Fiche de sujet PDF</a>
        </center>
        <br><br><br>
        <?php  
        
    }else{
        echo "Sujet not found";
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

          $("#fr").click(function(){
            $.MultiLanguage("theme.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("theme.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("theme.json","ar");
        });
</script>
</body>
</html>
<?php 


}
?>