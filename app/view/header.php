<?php 
    session_start();
?>
<header class="p-3 bg-dark text-white">
    <div class="container h-75">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <a class="navbar-brand" href="../index.php">
                <img src="../asset/images/logo.png" alt="" width="30" height="30">
            </a>
            
            <ul class="nav col-auto me-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../index.php" class="nav-link px-2 text-white">Home</a></li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user'] == TRUE) { ?>
                <li><a href="../controller/adminData.php" class="nav-link px-2 text-white">Gérer les données</a></li>
            <?php } ?>
            </ul>

            <form class="form-inline d-flex">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-primary my-sm-0" type="submit">Search</button>
            </form>
            

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