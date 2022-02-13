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
        <script src="../static/js/bar.js"></script>
    
        <link rel="stylesheet" href="../static/css/datatables.min.css">
     
    </head>
    <?php 
       if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){
    
    ?>
    <body style="background-color:#e5ebf0;">
    <?php include("layouts/navbar.php"); ?>
        <br>
    <?php  
        $query = "SELECT * FROM `sujet` WHERE `departement`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement']]);
            $tauxAvancement = 0;
            $nombreSujets = $sql->rowCount();
            if($nombreSujets>0){
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                    $tauxAvancement= $tauxAvancement+$result['tauxAvancement'];
                }
                $tauxAvancement = $tauxAvancement/$nombreSujets;
            }
        $query = "SELECT * FROM `sujet` WHERE `departement`=? AND `valid`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement'],1]);
            
            $sujetValid = $sql->rowCount();
            $sujetNonValid = $nombreSujets - $sujetValid;
        $query = "SELECT * FROM `sujet` WHERE `departement`=? AND `etat`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement'],1]);
                
            $sujetChoisi = $sql->rowCount();
            $sujetNonChoisi = $sujetValid - $sujetChoisi;
        $query = "SELECT * FROM `sujet` WHERE `departement`=? AND `niveau`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement'],"license"]);
        $sujetLicense = $sql->rowCount();
        $query = "SELECT * FROM `sujet` WHERE `departement`=? AND `niveau`=?";
        $sql = $pdo->prepare($query);
        $sql->execute([$_SESSION['departement'],"master"]);
        $sujetMaster = $sql->rowCount();
            
    ?>

    <input type="hidden" id="sujetValid" value="<?php echo $sujetValid; ?>">
    <input type="hidden" id="sujetNonValid" value="<?php echo $sujetNonValid; ?>">
    
        <div class="container-fluid">
        <?php include("layouts/sidebar.php"); ?>
        <div class="col-md-9 col-xs-12" >
        <div class="row">
        
        <div class="chart-container col-md-4">
        <canvas id="myChart"></canvas>
        <br>
        <center><b id="nombreTotalDesSujets">Nombre total des sujets : <?php echo $nombreSujets ?></b></center>

     </div>
     <input type="hidden" id="sujetChoisi" value="<?php echo $sujetChoisi; ?>">
     <input type="hidden" id="sujetNonChoisi" value="<?php echo $sujetNonChoisi; ?>">
    
     <div class="chart-container col-md-4">
        <canvas id="myChart2"></canvas>
        <br>
        <center><b id="nombreDesSujetsValidé">Nombre des sujets validé : <?php echo $sujetValid ?></b></center>
     </div>
     <input type="hidden" id="sujetLicense" value="<?php echo $sujetLicense; ?>">
     <input type="hidden" id="sujetMaster" value="<?php echo $sujetMaster; ?>">
    
     <div class="chart-container col-md-4">
        <canvas id="myChart3"></canvas>
        <br>
        <center><b id="nombretotaldessujets">Nombre total des sujets : <?php echo $nombreSujets ?></b></center>
     </div>
     
     </div>
     <br>
        <div class="row">
           <center>
               <h2 id="tauxDavancementTotal">Taux d'avancement total : <?php echo $tauxAvancement . " %"; ?></h2>
            </center>Messagerie : 

            <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th id="niveau">Niveau</th>
                <th id="titre">Titre</th>
                <th id="encadreur">Encadreur</th>
                <th id="etat">Etat </th>
                <th id="Etudiant">Etudiant(s)</th>
                <th id="nombreDeChoix">Nombre de choix</th>
                <th id="tauxDavancement">Taux d'Avancement</th>
                
               
        
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
                  $json2 = json_encode($result, JSON_UNESCAPED_UNICODE)
        
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
            $.MultiLanguage("sujets.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("sujets.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("sujets.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
        function liberer(id){
                $.post("process/libererSujet.php",{id:id},function(data){
                    window.alert(data);
                    location.reload();
                });
        }
    $(document).ready(function() {
    $('#example').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('sujets.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('sujets.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('sujets.json','ar');
       }
} );
var sujetValid = $("#sujetValid").val();
var sujetNonValid = $("#sujetNonValid").val();
var sujetChoisi = $("#sujetChoisi").val();
var sujetNonChoisi = $("#sujetNonChoisi").val();
var sujetLicense = $("#sujetLicense").val();
var sujetMaster = $("#sujetMaster").val();
x = [sujetValid,sujetNonValid];
y = [sujetChoisi,sujetNonChoisi];
z = [sujetLicense,sujetMaster]; 
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