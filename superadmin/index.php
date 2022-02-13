<?php 
include("../config/db.php");
session_start();

if(isset($_SESSION['role']) && $_SESSION['role']=="superadmin"){
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
            <div class="row">
            <center>
                <button class="btn btn-primary" id="addDep">Ajouter un département</button>
            </center>
            </div>
        </div>
            <div class="col-md-9 col-xs-12">
            <ul class="nav nav-tabs">
                    <li class="active" ><a data-toggle="tab" id="creerCompteEncadreur" href="#listeAdmin ">Liste des admins  </a></li>
                    <li><a data-toggle="tab" id ="gestionDesComptesEncadreur" href="#listePresident"> Liste des présidents </a></li>
                </ul>

                <div class="tab-content">
                    <div id="listeAdmin" class="tab-pane fade in active">
            <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>email</th>
                <th>departement</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
          $query = "SELECT * FROM `administration` WHERE ?";
          $sql = $pdo->prepare($query);
          $sql->execute([1]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                  $json2 = $result;
                 
                  $json2 = json_encode($json2,JSON_UNESCAPED_UNICODE);
                  //$json2 = addslashes($json2);
        ?>

            <tr>
                <td><?php echo $result['username']; ?></td>
                <td>
                <?php echo $result['email']; ?>
               </td>
               <td><?php echo $result['departement']; ?></td>
               <td>
                    <button onclick='modifier(<?php echo $result["id"]; ?>)' class="btn" >Modifier</button>
                  
                
               </td>
             </tr>
          <?php 
              }
            }
          ?>

        </tbody>
      
    </table>

        </div>
        </div>

        <div id="listePresident" class="tab-pane fade">
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>email</th>
                <th>departement</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
          $query = "SELECT * FROM `president` WHERE ?";
          $sql = $pdo->prepare($query);
          $sql->execute([1]);
          
          if($sql->rowCount()>0){
              
              while($result = $sql->fetch(PDO::FETCH_ASSOC)){
                  $json2 = $result;
                 
                  $json2 = json_encode($json2,JSON_UNESCAPED_UNICODE);
                  //$json2 = addslashes($json2);
                  
        
        ?>
            <tr>
                <td><?php echo $result['user']; ?></td>
                <td>
                <?php echo $result['email']; ?>
               </td>
               <td><?php echo $result['departement']; ?></td>
               <td>
                    <button onclick='modifierPres(<?php echo $result["id"]; ?>)' class="btn" >Modifier</button>
                  
                
               </td>
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
             
                   <!-- load sidebar Menu  -->
                    
                <!-- The Modal -->
 <div id="addDepModal" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('addDepModal').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="devTitle"> Ajouter un Département :</h1>
      <form action="#" id="addDepAction">
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Nom de département" name="nomDep" id="nomDep" required>
      </div>
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Pseudo administrateur" name="userAdmin" id="userAdmin" required>
      </div>
      <div class="form-group">
      <input type="password" class="form-control" placeholder="Mot de passe administrateur" name="passAdmin" id="passAdmin" required>
      </div>
      <div class="form-group">
      <input type="email" class="form-control" placeholder="Email administrateur" name="emailAdmin" id="emailAdmin" required>
      </div>
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Pseudo président" name="userPresident" id="userPresident" required>
      </div>
      <div class="form-group">
      <input type="password" class="form-control" placeholder="Mot de passe président" name="passPresident" id="passPresident" required>
      </div>
      <div class="form-group">
      <input type="email" class="form-control" placeholder="Email President" name="emailPresident" id="emailPresident" required>
      </div>
      <br>
      <center>
            <button class="btn btn-custom">
                Ajouter
            </button>
      </center>
      </form>
      <br><br>
       
      </div>
    </div>
  </div>
</div>   


    <!-- The Modal -->
    <div id="editAdmin" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('editAdmin').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="devTitle"> Modifier admin :</h1>
      <form action="#" id="editAdminAction">
      <input type="hidden" name="id" id="idAdmin">
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Pseudo administrateur" name="userAdmin" id="userAdminE" required>
      </div>
      <div class="form-group">
      <input type="password" class="form-control" placeholder="Mot de passe administrateur" name="passAdminE" id="passAdminE" required>
      </div>
      <div class="form-group">
      <input type="email" class="form-control" placeholder="Email administrateur" name="emailAdmin" id="emailAdminE" required>
      </div>
      <br>
      <center>
            <button class="btn btn-custom">
                Modifier
            </button>
      </center>
      </form>
      <br><br>
       
      </div>
    </div>
  </div>
</div>   
  <!-- The Modal -->
  <div id="editPresident" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('editPresident').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <div class="container-fluid" style="padding-top:3%;padding-bottom:3%;">
      <h1 id="devTitle"> Modifier president :</h1>
      <form action="#" id="editPresidentAction">
      <input type="hidden" name="id" id="idPresident">
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Pseudo administrateur" name="userPresidentE" id="userPresidentE" required>
      </div>
      <div class="form-group">
      <input type="password" class="form-control" placeholder="Mot de passe administrateur" name="passPresidentE" id="passPresidentE" required>
      </div>
      <div class="form-group">
      <input type="email" class="form-control" placeholder="Email administrateur" name="emailPresidentE" id="emailPresidentE" required>
      </div>
      <br>
      <center>
            <button class="btn btn-custom">
                Modifier
            </button>
      </center>
      </form>
      <br><br>
       
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
    $("#addDep").click(function(){
        $("#addDepModal").slideDown();
    });
    function modifierPres(id){
        $.post("process/recupererDataPrec.php",{id:id},function(data){
        data = JSON.parse(data);
        id = data[0].id;
        user = data[0].user;
        email = data[0].email;
        $("#idPresident").val(id);
        $("#userPresidentE").val(user);
        $("#emailPresidentE").val(email);
        $("#editPresident").slideDown();
       });
    }
    function modifier(id){
       $.post("process/recupererData.php",{id:id},function(data){
        data = JSON.parse(data);
        id = data[0].id;
        user = data[0].username;
        email = data[0].email;
        $("#idAdmin").val(id);
        $("#userAdminE").val(user);
        $("#emailAdminE").val(email);
        $("#editAdmin").slideDown();
       });
    }
    
    $("#editPresidentAction").submit(function(){
        id= $("#idPresident").val();
       email =  $("#emailPresidentE").val();
       user =  $("#userPresidentE").val();
        pass = $("#passPresidentE").val();
        $.post("process/editPresident.php",{id:id,email:email,user:user,pass:pass},function(data){
            window.alert(data);
            location.reload();
        });
        return false;
    });
    $("#editAdminAction").submit(function(){
        id= $("#idAdmin").val();
       email =  $("#emailAdminE").val();
       user =  $("#userAdminE").val();
        pass = $("#passAdminE").val();
        $.post("process/editAdmin.php",{id:id,email:email,user:user,pass:pass},function(data){
            window.alert(data);
            location.reload();
        });
        return false;
    });
    $("#addDepAction").submit(function(){
        nomDep = $("#nomDep").val();
        pseudoAdmin = $("#userAdmin").val();
        passAdmin = $("#passAdmin").val();
        emailAdmin = $("#emailAdmin").val();
        pseudoPresident = $("#userPresident").val();
        passPresident = $("#passPresident").val();
        emailPresident = $("#emailPresident").val();
        $.post("process/addDep.php",{emailAdmin:emailAdmin,emailPresident:emailPresident,nomDep:nomDep,pseudoAdmin:pseudoAdmin,passAdmin:passAdmin,pseudoPresident:pseudoPresident,passPresident:passPresident},function(data){
            window.alert(data);
            location.reload();
        });
        return false;
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