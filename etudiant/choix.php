<?php  
    include("../config/db.php");
?>
<html>
<?php include("layouts/head.php"); ?>
<body>
    <?php include("layouts/navbar.php") ?>
    <div class="container-fluid">
    <div class="col-md-3 col-xs-12 ">
        <div class="row well">
        <?php include("layouts/profileTicket.php"); ?>
        </div>
        <?php include("layouts/sidebar.php"); ?>
        </div>
           
    <div class="col-md-9 col-xs-12 ">
        <div class="container-fluid">
            <h2><b id="listeDesChoix" >Liste Des Choix : </b></h2>
            <?php 
                $query = "SELECT * FROM `departement` WHERE `nom`=?";
                $sql = $pdo->prepare($query);
                $sql->execute([$_SESSION['departement']]);
                if($sql->rowCount()==1){
                    $result = $sql->fetch(PDO::FETCH_ASSOC);
                    if($result['choixSujet']==1){
            ?>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="idC">ID</th>
                <th id="sujetC">Sujet</th>
                <th id="dateDeChoixC">Date De Choix</th>
                <th id="reponseC">Reponse</th>
                <th id="actionC">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php 
            $query = "SELECT * FROM `choix` WHERE `departement`=? AND `user`=? ORDER BY `priority` ASC";
            $sql = $pdo->prepare($query);
            $sql->execute([$_SESSION['departement'],$_SESSION['user']]);
            if($sql->rowCount()>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    $query2 = "SELECT * FROM `sujet` WHERE `titre`=? ";
                    $sql2 = $pdo->prepare($query2);
                    $sql2->execute([$result['sujet']]);
                    $result2 = $sql2->fetch(PDO::FETCH_ASSOC);
                    
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><a href="theme.php?id=<?php echo $result2['id']; ?>"><?php echo $result['sujet']; ?></a></td>
                <td><?php echo $result['dateChoix']; ?></td>
                <td><?php  
                    if($result['etat']==0){
                        echo "Pas de Reponse";
                    }else{
                        echo "Confirmé par l'encadreur";
                    }
                ?></td>
                <td><?php  
                    if($result['etat']==1){
                        ?>
                        <button onclick="confirmer(<?php echo $result['id']; ?>)" id="confirmerC">Confirmer</button>
                        <?php
                    }
                ?></td>
              
            </tr>
            <?php 

                    }
                }
            ?>
 
        </tbody>
    </table>

        </div>
        <?php 
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
} );
$("#fr").click(function(){
            $.MultiLanguage("choix.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("choix.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("choix.json","ar");
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