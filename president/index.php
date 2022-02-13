<?php 
include("../config/db.php");
session_start();
if(isset($_SESSION['role']) && $_SESSION['role']=="president"){
 ?>
<!DOCTYPE html>
<html>
    <?  include("layouts/head.php"); ?>

    <body>
        <!-- load navbar layout -->
            <?php include("layouts/navbar.php"); ?>
        <br>

        
                <div class="container-fluid ">
                <div class="col-md-3 col-xs-12">
            <div class="row well">
              <!-- load profile ticket : name email number .. ect -->
            <?php include("layouts/profileTicket.php"); ?>
            </div>
        
              
              
               
        </div>
        
          
            <div class="col-md-9 col-xs-12">
            <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Niveau</th>
                <th>Titre</th>
                <th>Encadreur</th>
                <th>Etat </th>
                <th>Action</th>
                <th>Action</th>
                
               
        
            </tr>
        </thead>
        <tbody>
        <?php 
          $query = "SELECT * FROM `sujet` WHERE `departement`=? ";
          $sql = $pdo->prepare($query);
          $sql->execute([$_SESSION['departement']]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                  $json2 = $result;
                  $json2['contenu'] = addslashes($json2['contenu']);
                  $json2 = json_encode($json2,JSON_UNESCAPED_UNICODE);
                  //$json2 = addslashes($json2);
                  
        
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
               
              
               <td><?php if ($result['valid']==0){
                    ?>
                    <button class="btn" onclick="validSujet(<?php echo $result['id'] ?>);" >Valider</button>
                    <?php
                }else{
                    echo "Sujet déja validé";
                } 
                
                ?></td>
              <td><button class="btn" onclick="delSujet(<?php echo $result['id'] ?>);" >Supprimer</button></td>
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
             
               
          
       
      
           
                   <!-- load sidebar Menu  -->
                    
                  
                    
              
       
          
                <script>
                function delSujet(id){
    var result = confirm("Are you sure you want to delete this ? ");
    if(result){
        $.post("process/delSujet.php",{id:id},function(data){
            window.alert(data);
            location.reload();
        });
    }
    
}
function validSujet(id){
   
        $.post("process/validSujet.php",{id:id},function(data){
            window.alert(data);
            location.reload();
        });
    
    
}
                    function getCookie(name) {
                            var value = "; " + document.cookie;
                            var parts = value.split("; " + name + "=");
                            if (parts.length == 2) return parts.pop().split(";").shift();
                            }
                   x = getCookie("lang");
                  
    $(document).ready(function(){
      
        if(x=="fr"){
            $.MultiLanguage('language.json','fr');
       }else if(x=="en"){
        $.MultiLanguage('language.json','en');
       }else if(x=="ar"){
        $.MultiLanguage('language.json','ar');
       }
    });
</script>
          
    </body>
    </html>
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