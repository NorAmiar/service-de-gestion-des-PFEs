<?php 
include("../config/db.php");
?>

<!DOCTYPE html>
<html>
    <?php include("layouts/head.php"); ?>
    <body>
    <?php include("layouts/navbar.php"); ?>


        <div class="container-fluid">
        
        <div class="col-md-3 col-xs-12 ">
        <div class="row well">
        <?php include("layouts/profileTicket.php"); ?>
        </div>
        <?php include("layouts/sidebar.php"); ?>
        </div>
           
            <div class="col-md-9 col-xs-12">
                <div class="container-fluid ">
                <div class="row well">
                    <div align="center">
                        <h2> <b id="bienvenueDansVotreEspaceE"> Bienvenue Dans Votre Espace</b></h2>
                        <?php 
                            $query = "SELECT * FROM `etudiant` WHERE `id_compte`=?";
                            $sql = $pdo->prepare($query);
                            $sql->execute([$_SESSION['id']]);
                            if($sql->rowCount()>0){
                          
                                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <h4><b id="moyenneDe">Moyenne de </b><b><?php echo $result['nom']; ?> : </b><?php echo $result['moyenne_e']; ?></h4>
                       <?php 
                                }
                            }
                       ?>
                    </div>
                    <?php  
                   
                        if(!empty($_SESSION['theme'])){
                            $theme = $_SESSION['theme'];
                            $query = "SELECT * FROM `sujet` WHERE `titre`=?";
                            $sql = $pdo->prepare($query);
                            $sql->execute([$theme]);
                            $result = $sql->fetch(PDO::FETCH_ASSOC);
                            $keywords = $result['keywords'];
                            $keywords = explode(",",$keywords);
                            ?>
                             <h4><b id="themesAvecMotClé">Themes Avec mot clé  <?php echo $keywords[0]; ?> : </b></h4>
                                <ul>
                                <?php 
                                    $query1 = "SELECT * FROM `sujet` WHERE NOT `titre`=?";
                                    $sql1 = $pdo->prepare($query1);
                                    $sql1->execute([$theme]);

                                    if($sql1->rowCount()>0){
                                        while($result1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                                            $testKeywords = $result1['keywords'];
                                            $testKeywords = explode(",",$testKeywords);
                                            if(in_array($keywords[0],$testKeywords)){

                                           
                                  
                                ?>
                                    <li><a href="theme.php?id=<?php echo $result1['id'];?>"> <?php echo $result1['titre']; ?></a>    </li>
                                  <?php
                                   }
                                        }
                                    }
                                  ?>
                                </ul>
                                    <?php if(sizeof($keywords)>1){

                                     ?>
                                <h4><b id="themesAvecMotCléE">Themes Avec mot clé  <?php echo $keywords[1]; ?> : </b></h4>
                                <ul>
                                <?php 
                                    $query1 = "SELECT * FROM `sujet` WHERE NOT `titre`=?";
                                    $sql1 = $pdo->prepare($query1);
                                    $sql1->execute([$theme]);

                                    if($sql1->rowCount()>0){
                                        while($result1 = $sql1->fetch(PDO::FETCH_ASSOC)){
                                            $testKeywords = $result1['keywords'];
                                            $testKeywords = explode(",",$testKeywords);
                                            if(in_array($keywords[1],$testKeywords)){

                                           
                                  
                                ?>
                                    <li><a href="theme.php?id=<?php echo $result1['id'];?>"> <?php echo $result1['titre']; ?></a>    </li>
                                  <?php
                                   }
                                        }
                                    }
                                  ?>
                                </ul>
                              
                            
                            <?php
                            }
                        }
                    ?>
                   
                </div>
             
                
            </div>
            </div>
            <script> 
   // gestion de button de la langue 
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
            $.MultiLanguage("index.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("index.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("index.json","ar");
        });
   </script>
    </body>
    </html>