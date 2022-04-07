<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100vh">

        <?php
        require('../view/header.php');
        ?>
        
        <main class="container form-signin h-75 col-lg-5 mt-5" style="margin: auto">

        <form enctype="multipart/form-data" class="mt-5" style="margin: auto" action="../controller/inscription.php?role=<?php echo $_GET["role"]?>" method="post">
        <h1 class="mb-5 fw-normal text-center">Inscription</h1>

            <div class="mb-3 d-flex justify-content-between">
                <div class="mr-2" style="width: 48%">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" id="nom" required>
                </div>
                <div class="ml-2" style="width: 48%">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" name="prenom" class="form-control" id="prenom" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="email" name="mail" class="form-control" id="mail" required>
            </div>
        <?php if($_GET["role"] == "apprenant") 
        {
        ?>
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" required></input>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="text" name="password" class="form-control" id="password" required>
            </div>

        <?php
        } elseif($_GET["role"] == "instructeur") {
        ?>

            <div class="mb-3">
                <label for="photoprofil" class="form-label">Photo de profil</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <input class="form-control" type="file" name="photoprofil" id="photoprofil" required>
            </div>
            <div class="mb-3">
                <label for="specialites" class="form-label">Spécialités</label>
                <textarea class="form-control" name="specialites" id="specialite" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="text" name="password" class="form-control" id="password" required>
            </div>
        <?php 
        }
        ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </main>
    </body>
</html>