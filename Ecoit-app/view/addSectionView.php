<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require_once('../view/head.php');
    ?>
        
    <body style="height: 100vh">

        <?php
        require_once('../view/header.php');
        ?>
        
        <main class="container form-signin col-sm-8 col-lg-5 mt-5" style="margin: auto">

        <form class="mt-5" style="margin: auto" action="../controller/addSection.php?id=<?php echo $_GET['id']?>&formation=<?php echo $_GET['formation']?>" method="post">
        <h1 class="mb-5 fw-normal text-center">Ajout section</h1>

            <div class="mb-3 sectionInput">
                <label for="titre" class="form-label">Titre de la section</label>
                <input type="text" name="titre" class="form-control mb-4" id="titre" required>
            </div>

            <div>
                <a href="#" class="btn  addSection mb-4">Ajouter section supplementaire</a>
            </div>

            <div>
                <button type="submit" class="btn">Envoyer</button>
            </div>
        </form>

    </main>
    <script type="text/javascript" src="../asset/js/addSection.js"> 
    </script> 
    </body>
</html>