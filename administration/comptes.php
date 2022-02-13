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
        <script src="../static/js/bar2.js"></script>
    
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
                    $query = "SELECT * FROM `etudiant` WHERE `departement`=?";
                    $sql = $pdo->prepare($query);
                    $sql->execute([$_SESSION['departement']]);
                    $nombreEtudiants = $sql->rowCount();
                    $query = "SELECT * FROM `etudiant` WHERE `departement`=? AND `id_compte` <> ?";
                    $sql = $pdo->prepare($query);
                    $sql->execute([$_SESSION['departement'],""]);
                    $avecCompte = $sql->rowCount();
                    $sansCompte = $nombreEtudiants - $avecCompte;

                    $query = "SELECT * FROM `compte_etudiants` WHERE `sujet` <> ? AND `departement`=?";
                    $sql = $pdo->prepare($query);
                    $sql->execute(["",$_SESSION['departement']]);
                    $avecSujet = 0;
                    if($sql->rowCount()>0){
                        while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                            if($result['typeC']=="Monome"){
                                $avecSujet++;
                            }else{
                                if($result['typeC']=="Binome"){
                                    $avecSujet+=2;
                                }else{
                                    if($result['typeC']=="Trinome"){
                                        $avecSujet+=3;
                                    }
                                }
                            }
                        }
                    }
                    $sansSujet = $nombreEtudiants - $avecSujet

                ?>
                <div class="chart-container col-md-6">
                <canvas id="myChart4"></canvas>
                <br>
                <center><b id="nombreTotalDesEtudiantsS">Nombre total des etudiants : <?php echo $nombreEtudiants ?></b></center>

            </div>
            <input type="hidden" id="sansCompte" value="<?php echo $sansCompte; ?>">
            <input type="hidden" id="avecCompte" value="<?php echo $avecCompte; ?>">

            <input type="hidden" id="avecSujet" value="<?php echo $avecSujet; ?>">
            <input type="hidden" id="sansSujet" value="<?php echo $sansSujet; ?>">
            
            <div class="chart-container col-md-6">
                <canvas id="myChart5"></canvas>
                <br>
                <center><b id="nombreTotalDesEtudiansA">Nombre total des etudiants : <?php echo $nombreEtudiants ?></b></center>
            </div>
            
            </div>
            <br><br>
            <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#etudiantAvecCompte" id="EtudiantsAvecCompte">Etudiants avec Compte</a></li>
                    <li><a data-toggle="tab" href="#etudiantSansCompte" id="etudiantsSansCompte">Etudiants sans Compte</a></li>
                    <li><a data-toggle="tab" href="#etudiantAvecSujet" id="comptesAvecSujets">Comptes avec Sujet</a></li>
                    <li><a data-toggle="tab" href="#etudiantSansSujet" id="comptesSansSujet">Comptes sans Sujet</a></li>
                    
                </ul>
                <div class="tab-content">
                    <div id="etudiantAvecCompte" class="tab-pane fade in active">
                    <div class="table-responsive ">
                 <table id="example" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="matricule">Matricule</th>
                    <th id="nom">Nom</th>
                    <th id="prenom">Prénom</th>
                    <th id="email">email</th>
                    <th id="moyenne">Moyenne</th>
                    <th id="niveau">Niveau</th>
                    <th id="pin">PIN</th>
                  
                 

            
                </tr>
        </thead>
        <tbody>

        <?php 
          $departement = $_SESSION['departement'];
          $query = "SELECT * FROM `etudiant` WHERE `departement`=? AND `id_compte` <> ?";
          $sql = $pdo->prepare($query);
          $sql->execute([$departement,""]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['matricule'];?> </td>
                <td><?php echo $result['nom']; ?></td>
                <td><?php echo $result['prenom']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['moyenne_e']; ?></td>
                <td><?php echo $result['niveau']; ?></td>
                <td><?php echo $result['pin']; ?></td>
               
            </tr>
            <?php   
                    }
                }
        ?>
        
        </tbody>
  
    </table>
        </div>
                    </div>
                    <div id="etudiantSansCompte" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example2" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="matriculeSC">Matricule</th>
                    <th id="nomSC">Nom</th>
                    <th id="prenomSC">Prénom</th>
                    <th id="emailSC">email</th>
                    <th id="moyenneSC">Moyenne</th>
                    <th id="niveauSC">Niveau</th>
                    <th id="pinSC">PIN</th>
                  
                 

            
                </tr>
        </thead>
        <tbody>

        <?php 
          $departement = $_SESSION['departement'];
          $query = "SELECT * FROM `etudiant` WHERE 1 EXCEPT SELECT * FROM etudiant WHERE id_compte <> ''";
          $sql = $pdo->prepare($query);
          $sql->execute([$departement,""]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['matricule'];?> </td>
                <td><?php echo $result['nom']; ?></td>
                <td><?php echo $result['prenom']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['moyenne_e']; ?></td>
                <td><?php echo $result['niveau']; ?></td>
                <td><?php echo $result['pin']; ?></td>
               
            </tr>
            <?php   
                    }
                }
        ?>
        
        </tbody>
  
    </table>
        </div>
                    </div>
                    <div id="etudiantAvecSujet" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example3" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="idAV">ID</th>
                    <th id="PseudoAV">Pseudo</th>
                    <th id="sujetAV">Sujet</th>
                    <th id="moyenneAV">Moyenne</th>
                    <th id="niveauAV">Niveau</th>
                    <th id="typeDeComptesAV">Type De Compte</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
            $query = "SELECT * FROM `compte_etudiants` WHERE `departement`=? AND sujet <> ?";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement,""]);
            
            if($sql->rowCount()>0){
                
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                   $json = json_encode($result);
                    
        ?>
            <tr>
                <td><?php echo $result['idCompte'];?> </td>
                <td><a href="profile.php?user=<?php echo $result['user']; ?>"><?php echo $result['user']; ?></a> </td>
                <td><?php echo $result['sujet']; ?></td>
                <td><?php echo $result['moyenne_compte']; ?></td>
                <td><?php echo $result['niveau']; ?></td>
                <td><?php echo $result['typeC'] ?></td>
               
            </tr>
        <?php 
        
    }
}
        ?>
        </tbody>
       
    </table>

        </div>
                    </div>
                    <div id="etudiantSansSujet" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example4" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="idSS">ID</th>
                    <th id="PseudoSS">Pseudo</th>
                    <th id="moyenneSS">Moyenne</th>
                    <th id="niveauSS">Niveau</th>
                    <th id="typeDeComptesSS">Type De Compte</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
            $departement = $_SESSION['departement'];
            $query = "SELECT * FROM `compte_etudiants` WHERE `departement`=? AND sujet = ?";
            $sql = $pdo->prepare($query);
            $sql->execute([$departement,""]);
            
            if($sql->rowCount()>0){
                
                while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                   $json = json_encode($result);
                    
        ?>
            <tr>
                <td><?php echo $result['idCompte'];?> </td>
                <td><a href="profile.php?user=<?php echo $result['user']; ?>"><?php echo $result['user']; ?></a> </td>
                <td><?php echo $result['moyenne_compte']; ?></td>
                <td><?php echo $result['niveau']; ?></td>
                <td><?php echo $result['typeC'] ?></td>
                
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
            $.MultiLanguage("comptes.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("comptes.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("comptes.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example').DataTable();
    $('#example2').DataTable();
    $('#example3').DataTable();
    $('#example4').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('comptes.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('comptes.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('comptes.json','ar');
       }
} );
var sansCompte = $("#sansCompte").val();
var avecCompte = $("#avecCompte").val();
var sansSujet = $("#sansSujet").val();
var avecSujet = $("#avecSujet").val();
i = [sansCompte,avecCompte];
f = [sansSujet,avecSujet]; 
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