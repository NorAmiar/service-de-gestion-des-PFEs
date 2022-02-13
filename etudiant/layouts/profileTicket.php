<?php 
session_start();
?>
                <!-- <div class="row well"> -->
                    <div align="center">
                        <b><?php echo $_SESSION['user']; ?></b> <br>
                        <img src="../static/images/user.png" width="60%" height="200px" alt="img badji">
                        <br>
                        <br>
                        <a href="profile.php?user=<?php echo $_SESSION['user']; ?>"><button class="btn btn-primary">Mon Profile</button></a>
                <!--    </div> -->
                
                </div>
    