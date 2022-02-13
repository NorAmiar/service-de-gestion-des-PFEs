<?php 
session_start();
?>
<div align="center">
                        <b>Dr <?php echo ucfirst($_SESSION['nom']) . " " . ucfirst($_SESSION['prenom']); ?></b> <br>
                        <img src="../static/images/user.png" width="60%" height="200px" alt="<?php echo ucfirst($_SESSION['nom']) . " " . ucfirst($_SESSION['prenom']); ?>">
                        <br>
                        <br>
                        <a href="encadreur.php?user=<?php echo $_SESSION['user']; ?>"> <button class="btn btn-primary">Mon Profile</button></a>
          
                
                </div>