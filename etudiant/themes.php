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
        <div class="container-fluid ">
            <h2><b id="listeDesThemes">Liste Des Themes : </b></h2>
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
                <th id="idt">ID</th>
                <th id="titret">Titre</th>
                <th id="encadreurt">Encadreur</th>
                <th id="nombreDeSelectiont">Nombre de selection</th>
                <th id="actiont">Action</th>
        
            </tr>
        </thead>
        <tbody>
        <?php 
        $niveau=$_SESSION['niveau'];
            $query = "SELECT * FROM `sujet` WHERE `etat`=? AND `valid`=? AND `departement`=? AND `niveau`=?";
            $sql = $pdo->prepare($query);
            $sql->execute([0,1,$_SESSION['departement'],$niveau]);

            if($sql->rowCount()>0){
                while($result= $sql->fetch(PDO::FETCH_ASSOC)){

           
        ?>
            <tr>
                <td><?php echo $result['id']; ?></td>
                <td><a href="theme.php?id=<?php echo $result['id']; ?>"><?php echo $result['titre']; ?></a></td>
                <td><a href="encadreur.php?user=<?php echo $result['encadreur']; ?>"><?php echo $result['encadreur']; ?></a></td>
                <td><?php echo $result['nb_choix']; ?></td>
                <?php $titre = addslashes($result["titre"]); ?>
                <td><button class="btn btn-primary" onclick="choisir('<?php echo $titre; ?>')" id="choisirt">Choisir</button></td>
              
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


          $("#fr").click(function(){
            $.MultiLanguage("themes.json","fr");
        });
        $("#eng").click(function(){
            $.MultiLanguage("themes.json","en");
        });
        $("#ar").click(function(){
            $.MultiLanguage("themes.json","ar");
        });
    $(document).ready(function() {
    $('#example').DataTable();
} );

    function choisir(titre){
        $.post("process/choisir.php",{titre:titre},function(data){
            window.alert(data);
            location.reload();
        });
    }




</script>
</body>
</html>