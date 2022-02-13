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
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="../static/js/bar3.js"></script>
    
        <link rel="stylesheet" href="../static/css/datatables.min.css">
     
    </head>
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body style="background-color:#e5ebf0;">
    <?php include("layouts/navbar.php"); ?>
        <br>

        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
        <div class="col-md-9 col-xs-12" >
                <div class="row">
                <?php 
                    $query = "SELECT * FROM `encadreur` WHERE `departement`=?";
                    $sql = $pdo->prepare($query);
                    $sql->execute([$_SESSION['departement']]);
                    $nombreEncadreur = $sql->rowCount();
                    //nb encadreurs license
                    $query = "SELECT COUNT(niveau),encadreur FROM sujet WHERE niveau = ? AND departement = ? GROUP BY encadreur";
                    $sql = $pdo->prepare($query);
                    $sql->execute(["license",$_SESSION['departement']]);
                    $nbLicense = $sql->rowCount();
                    //nb encadreur master
                    $query="SELECT COUNT(niveau),encadreur FROM sujet WHERE niveau = ? AND departement = ? GROUP BY encadreur";
                    $sql = $pdo->prepare($query);
                    $sql->execute(["master",$_SESSION['departement']]);
                    $nbMaster = $sql->rowCount();
                    //nb encadreur avc suj
                    $query = "SELECT COUNT(niveau),encadreur FROM sujet WHERE departement=? GROUP BY encadreur";
                    $sql = $pdo->prepare($query);
                    $sql->execute([$_SESSION['departement']]);
                    $proposeSujet = $sql->rowCount();
                    $sansPropositionSujet = $nombreEncadreur - $proposeSujet;
                ?>
                <div class="chart-container col-md-6">
                <canvas id="myChart"></canvas>
                <br>
                <center><b id="nombreTotalDesEncadreursInscrit">Nombre total des encadreurs inscrit : <?php echo $nombreEncadreur ?></b></center>

            </div>
            <input type="hidden" id="proposeSujet" value="<?php echo $proposeSujet; ?>">
            <input type="hidden" id="sansPropositionSujet" value="<?php echo $sansPropositionSujet; ?>">
            
            <div class="chart-container col-md-6">
                <canvas id="myChart2"></canvas>
                <br>
                <center><b id="nombreDesEncadreursQuiOntProposéDesSujets">Nombre des encadreurs qui ont proposé des sujets : <?php echo $proposeSujet ?></b></center>
            </div>
            <input type="hidden" id="nbLicense" value="<?php echo $nbLicense; ?>">
            <input type="hidden" id="nbMaster" value="<?php echo $nbMaster; ?>">
            
            
            </div>
            <br><br>
            <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#encadreursList" id="listeEncadreurs">Liste des encadreurs</a></li>
                    <li><a data-toggle="tab" href="#encadreursSansS" id="encadreursSansSujet">Liste des encadreurs sans sujets</a></li>
                    
                </ul>
                <div class="tab-content">
                    <div id="encadreursList" class="tab-pane fade in active">
                <div class="table-responsive ">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                    <tr>
                        <th id="nom">Nom</th>
                        <th id="Prénom">Prénom</th>
                        <th id="email">Email</th>
                        <th id="Pseudo">Pseudo</th>
                        <th id="grade">Grade</th>
                        <th id="ThemeLicence">Theme License</th>
                        <th id="themeMaster">Theme Master</th>
                
                    </tr>
            </thead>
            <tbody>
            <?php 
                $departement = $_SESSION['departement'];
                $query = "SELECT * FROM `encadreur` WHERE `departement`=? ";
                $sql = $pdo->prepare($query);
                $sql->execute([$departement]);
                
                if($sql->rowCount()>0){
                    
                    while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                        $query2 = "SELECT * FROM sujet WHERE niveau = ? AND departement = ? AND encadreur = ? ";
                        $sql2 = $pdo->prepare($query2);
                        $sql2->execute(["license",$_SESSION['departement'],$result['username']]);
                        $license = $sql2->rowCount();
                        $query3 = "SELECT * FROM sujet WHERE niveau = ? AND departement = ? AND encadreur = ? ";
                        $sql3 = $pdo->prepare($query3);
                        $sql3->execute(["master",$_SESSION['departement'],$result['username']]);
                        $master = $sql3->rowCount();
                        
            ?>
                <tr>
                    <td><?php echo $result['nom']; ?></td>
                    <td><?php echo $result['prenom']; ?></td>
                    <td><?php echo $result['email']; ?></td>
                    <td><a href="encadreur.php?user=<?php echo $result['username']; ?>"><?php echo $result['username']; ?></a>    </td>
                    <td><?php echo $result['grade']; ?></td>
                    <td><?php echo $license; ?></td>
                    <td><?php echo $master; ?></td>
                
                </tr>
            <?php 
            
        }
    }
            ?>
            </tbody>
        
        </table>

            </div>
            </div>
            <div id="encadreursSansS" class="tab-pane fade">
            <div class="table-responsive ">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                    <tr>
                        <th id="nom2">Nom</th>
                        <th id="Prénom2">Prénom</th>
                        <th id="email2">Email</th>
                        <th id="Pseudo2">Pseudo</th>
                        <th id="grade2">Grade</th>
                        <th id="ThemeLicence2">Theme License</th>
                        <th id="themeMaster2">Theme Master</th>
                
                    </tr>
            </thead>
            <tbody>
            <?php 
                $departement = $_SESSION['departement'];
                $query = "SELECT * FROM `encadreur` WHERE `departement`=? ";
                $sql = $pdo->prepare($query);
                $sql->execute([$departement]);
                
                if($sql->rowCount()>0){
                    
                    while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                        $query2 = "SELECT * FROM sujet WHERE niveau = ? AND departement = ? AND encadreur = ? ";
                        $sql2 = $pdo->prepare($query2);
                        $sql2->execute(["license",$_SESSION['departement'],$result['username']]);
                        $license = $sql2->rowCount();
                        $query3 = "SELECT * FROM sujet WHERE niveau = ? AND departement = ? AND encadreur = ? ";
                        $sql3 = $pdo->prepare($query3);
                        $sql3->execute(["master",$_SESSION['departement'],$result['username']]);
                        $master = $sql3->rowCount();
                        if($master ==0 && $license ==0){

                        
                        
            ?>
                <tr>
                    <td><?php echo $result['nom']; ?></td>
                    <td><?php echo $result['prenom']; ?></td>
                    <td><?php echo $result['email']; ?></td>
                    <td><a href="encadreur.php?user=<?php echo $result['username']; ?>"><?php echo $result['username']; ?></a>    </td>
                    <td><?php echo $result['grade']; ?></td>
                    <td><?php echo $license; ?></td>
                    <td><?php echo $master; ?></td>
                
                </tr>
            <?php 
            }
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


               $("#fr").click(function(){
            $.MultiLanguage("encadreurStats.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("encadreurStats.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("encadreurStats.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('encadreurStats.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('encadreurStats.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('encadreurStats.json','ar');
       }
} );
var proposeSujet = $("#proposeSujet").val();
var sansPropositionSujet = $("#sansPropositionSujet").val();
var nbLicense = $("#nbLicense").val();
var nbMaster = $("#nbMaster").val();
x = [proposeSujet,sansPropositionSujet];
y = [nbLicense,nbMaster]; 
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