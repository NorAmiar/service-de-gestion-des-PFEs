<?php 
    include("../config/db.php");
    $id="";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
 
?>

<!DOCTYPE html>
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
                <center><h2 id="DetailDeMessage">Détail de message</h2></center>
                <?php   
                
                   $departement = $_SESSION['departement'];
                    $query = "SELECT * FROM `messagerie` WHERE `id`=?";
                    $sql = $pdo->prepare($query);
                    $sql->execute([$id]);
                    if($sql->rowCount()==1){
                        $result = $sql->fetch(PDO::FETCH_ASSOC);
                       
                        if($result['recepteur']==$_SESSION['user']){
                            $now = date("Y-m-d H:i:s");
                            $query1 = "UPDATE `messagerie` SET `statut`=?,`date_vue`=? WHERE `id`=?  AND `departement`=?";
                            $sql1 = $pdo->prepare($query1);
                            $sql1->execute([1,$now,$id,$departement]);
                        }
                        ?>
                        <p><b id="expiditeur">Expiditeur : </b><?php echo $result['expiditeur']; ?></p>
                        <p><b id="role">Role : </b><?php echo $result['natureExp']; ?></p>
                        <p><b id="recepteur">Recepteur : </b><?php echo $result['recepteur']; ?></p>
                        <p><b id="rol">Role : </b><?php echo $result['natureRec']; ?></p>
                        <p><b id="date">Date : </b><?php echo $result['date']; ?></p>
                        <p><b id="objet">Objet : </b><?php echo $result['objet']; ?></p>
                        <p><b id="contenu"> Contenu : </b><?php echo $result['contenu']; ?></p>
                        <p><b id="etat">Etat : </b><?php if($result['statut']==0){
                            echo "Non vue";
                        }else{
                            if($result['statut']==1){
                                echo "Vue";
                            }
                        } ?></p>
                        <p><b id="DateDeVue"> Date de vue : </b><?php echo $result['date_vue']; ?></p>
                        
                        
                        <?php
                    }
                ?>
            
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
            $.MultiLanguage("msg.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("msg.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("msg.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('msg.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('msg.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('msg.json','ar');
       }
} );
</script>
    </body>
    </html>