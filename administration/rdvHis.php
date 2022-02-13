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
            <div class="col-md-9 col-xs-12 " style="  color:white;">
            <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" id="histpriqueDesRdv" href="#rdvHis">Historique des RDV</a></li>
                    <li><a data-toggle="tab" id="historiqueDesMessages" href="#msgHis"> Historique des messages  </a></li>
                </ul>

                <div class="tab-content">
                    <div id="rdvHis" class="tab-pane fade in active">
                    <div class="table-responsive ">
                 <table id="example" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="id">ID</th>
                    <th id="encadreur">Encadreur</th>
                    <th id="Etudiant"> Etudiant(s)</th>
                    <th id="date">Date</th>
                    <th id="Heure">Heure</th>
                    <th id="lieu">Lieu</th>
                    <th id="statut">Statut</th>
                    

            
                </tr>
        </thead>
        <tbody>

        <?php 
          $departement = $_SESSION['departement'];
          $query = "SELECT * FROM `rdv` WHERE `departement`=? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$departement]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['id'];?> </td>
                <td><?php echo $result['encadreur']; ?></td>
                <td><?php echo $result['compte_etudiant']; ?></td>
                <td><?php echo $result['date']; ?></td>
                <td><?php echo $result['time']; ?></td>
                <td><?php echo $result['lieu']; ?></td>
                <td><?php if( $result['statut']){
                    echo " Validé";
                }else{
                    echo "Non validé";
                } ?></td>
            </tr>
            <?php   
                    }
                }
        ?>
        
        </tbody>
  
    </table>

        </div>
                    </div>
                    <div id="msgHis" class="tab-pane fade">
                    <div class="table-responsive ">
                 <table id="example2" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                <tr>
                    <th id="idm">ID</th>
                    <th id="expiditeurm">Expiditeur</th>
                    <th id="natureExpiditeurm">Nature Expiditeur</th>
                    <th id="recepteurm">Recepteur</th>
                    <th id="natureRecepteurm">Nature Recepteur</th>
                    <th id="datem">Date</th>
                    <th id="statutm">Statut</th>
                    <th id="dateDeVuem">Date de vue</th>
            
                </tr>
        </thead>
        <tbody>
        <?php 
          $departement = $_SESSION['departement'];
          $query = "SELECT * FROM `messagerie` WHERE `departement`=? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$departement]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
        
        ?>



            <tr>
                <td><?php echo $result['id'];?> </td>
                <td><?php echo $result['expiditeur']; ?></td>
                <td><?php echo $result['natureExp']; ?></td>
                <td><?php echo $result['recepteur']; ?></td>
                <td><?php echo $result['natureRec']; ?></td>
                <td><?php echo $result['date']; ?></td>
                <td><?php if( $result['statut']){
                    echo "Vue";
                }else{
                    echo "Non vue";
                } ?></td>
                <td><?php echo $result['date_vue']; ?></td>
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
            $.MultiLanguage("rdvHis.json","fr");
            eraseCookie("lang");
            setCookie("lang","fr",7);
        });
        $("#eng").click(function(){
            $.MultiLanguage("rdvHis.json","en");
            eraseCookie("lang");
            setCookie("lang","en",7);
        });
        $("#ar").click(function(){
            $.MultiLanguage("rdvHis.json","ar");
            eraseCookie("lang");
            setCookie("lang","ar",7);
        });
    $(document).ready(function() {
    $('#example').DataTable();
    $('#example2').DataTable();
    x = getCookie("lang");
        if(x=="fr"){
            $.MultiLanguage('rdvHis.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('rdvHis.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('rdvHis.json','ar');
       }
} );
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