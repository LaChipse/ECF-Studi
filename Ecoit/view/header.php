<?php 
    if(!isset($_SESSION)) session_start();
?>
<header style="height: 100px">

    <nav class="p-3 navbar navbar-expand-md">

        <a class="navbar-brand" href="../index.php">
            <img src="../asset/images/logo.png" alt="" width="50" height="50">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav">
                
                <!-- Affichage de la navigation suivant la connexion ou le rôle du visiteur -->
            <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE) { ?>

                <li class="nav-item"><a href="../controller/inscription.php?role=apprenant" class="nav-link px-2">Devenir apprenant</a></li>
                <li class="nav-item"><a href="../controller/inscription.php?role=instructeur" class="nav-link px-2">Devenir instructeur</a></li>
            <?php 
            } elseif (isset($_SESSION['user']) && $_SESSION['user'] == TRUE) { 
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            ?>
                <li class="nav-item"><a href="../controller/candidature.php" class="nav-link px-2">Gérer les candidatures</a></li>
            <?php 
                } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'instructeur') {
                    require_once('../model/Instructeur.php');
                    $instructeurModel = new InstructeurModel(); 
                    $instructeur = $instructeurModel->find($_SESSION['id']);
            ?>
                <li class="nav-item" style="margin-right: 20px"><img src="<?php echo $instructeur['photoprofil'] ?>" class="profile-image rounded-circle" width="50" height="50"></li>
                <li class="nav-item"><a href="../controller/manageFormation.php?id=<?php echo $_SESSION['id'] ?>" class="nav-link px-2">Gérer mes formations</a></li>
            <?php
                }
            } 
            ?>
            </ul>

            <div class="text-end"">
            <?php if (!isset($_SESSION['user']) || $_SESSION['user'] == FALSE) { ?>
                <a href="../controller/login.php" class= text-decoration-none">
                    <button type="button" class="btn  me-2">Login</button>
                </a>
            <?php } else { ?>
                <a href="../controller/logout.php" class= text-decoration-none">
                    <button type="button" class="btn me-2">Log-Out</button>
                </a>
            <?php } ?>
            </div>
        </div>
    </nav>
</header>