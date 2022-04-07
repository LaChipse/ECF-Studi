<?php 
    session_start();
?>
<header class="p-3 text-white">
    <div class="container h-75">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <a class="navbar-brand" href="../index.php">
                <img src="../asset/images/logo.png" alt="" width="50" height="50">
            </a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'instructeur') { 
                require('../model/Instructeur.php');
                $instructeurModel = new InstructeurModel(); 
                $instructeur = $instructeurModel->find($_GET["id"]); ?>
            
            <?php } ?>
            
            <ul class="nav col-auto me-auto mb-2 justify-content-center mb-md-0">
                <li style="margin-right: 20px"><img src="<?php echo $instructeur['photoprofil'] ?>" class="profile-image rounded-circle" width="50" height="50"></li>
                <li><a href="../controller/formations.php" class="nav-link px-2 text-white">Les formations</a></li>
            <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE) { ?>
                
                <li><a href="../controller/inscription.php?role=apprenant" class="nav-link px-2 text-white">Devenir apprenant</a></li>
                <li><a href="../controller/inscription.php?role=instructeur" class="nav-link px-2 text-white">Devenir instructeur</a></li>
            <?php 
            }
            if (isset($_SESSION['user']) && $_SESSION['user'] == TRUE) { 
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            ?>
                <li><a href="../controller/candidature.php?valid=attente" class="nav-link px-2 text-white">Gérer les candidatures</a></li>
            <?php 
                } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'instructeur') {
            ?>
                <li><a href="../controller/manageFormation" class="nav-link px-2 text-white">Gérer mes formations</a></li>
            <?php
                }
            } 
            ?>
            </ul>

            <div class="text-end" style="margin-left: 20px">
            <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE) { ?>
                <a href="../controller/login.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <button type="button" class="btn btn-primary me-2">Login</button>
                </a>
            <?php } else { ?>
                <a href="../controller/logout.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <button type="button" class="btn btn-danger me-2">Log-Out</button>
                </a>
            <?php } ?>
            </div>
        </div>
    </div>
</header>