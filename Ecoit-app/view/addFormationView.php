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

        <form enctype="multipart/form-data" class="mt-5" style="margin: auto" action="../controller/addFormation.php?id=<?php echo $_SESSION['id'] ?>" method="post">
        <h1 class="mb-5 fw-normal text-center">Ajout formation</h1>

            <div class="mb-3">
                <label for="titre" class="form-label">Titre de la formation</label>
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Illustration formation</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                <input class="form-control" type="file" name="image" id="image" required>
                <small class="form-text text-muted">Taille maximum du fichier 5 Mo.</small>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn">Envoyer</button>
        </form>

        <!-- Affichage erreur si il y en a eu -->
        <?php if(isset($_SESSION['error'])) { ?>
            <p class="msgError"><?php echo $_SESSION['error']; ?></p>

        <?php unset($_SESSION['error']); } ?>

    </main>
    </body>
</html>