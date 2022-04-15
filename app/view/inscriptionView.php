<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require('../view/head.php');
    ?>
        
    <body style="height: 100vh">

        <?php
        require('../view/header.php');
        ?>
        
        <main class="container form-signin col-lg-5 mt-5" style="margin: auto">

        <form enctype="multipart/form-data" class="mt-5" style="margin: auto" action="../controller/inscription.php?role=<?php echo $_GET["role"]?>" method="post">
        <h1 class="mb-5 fw-normal text-center">Inscription</h1>

            <div class="mb-3 d-flex justify-content-between">
                <div class="mr-2" style="width: 48%">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" pattern="^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$" class="form-control" id="nom" required>
                    <small style="display:none; color: red" class="form-text validNom">Veuillez mettre un nom conforme (pas de chiffres ou caractéres spéciaux).</small>
                </div>
                <div class="ml-2" style="width: 48%">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" name="prenom" pattern="^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$" class="form-control" id="prenom" required>
                    <small style="display:none; color: red" class="form-text validPrenom">Veuillez mettre un nom conforme (pas de chiffres ou caractéres spéciaux).</small>
                </div>
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="email" name="mail" class="form-control" id="mail" required>
            </div>
            <!-- Controle le rôle pour changer de type de formulaire -->
        <?php if($_GET["role"] == "apprenant") 
        {
        ?>
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" required></input>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="text" name="password" pattern="^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$" id="password" class="form-control" required>
                <small class="form-text">Le mot de passe doit faire au moins 8 caractéres, un chiffre, une lettre minuscule et majuscule ainsi qu'un caractére spécial.</small>
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
                <input type="text" class="form-control" name="password" pattern="^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$" id="password" class="form-control" required>
                <small class="form-text">Le mot de passe doit faire au moins 8 caractéres, un chiffre, une lettre minuscule et majuscule ainsi qu'un caractére spécial.</small>
            </div>
        <?php 
        }
        ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <!-- Affichage des erreurs si il y en a eu -->
        <?php if (isset($_SESSION['error'])) { ?>
        <p class="errorMessage" style="color: red; font-size: 18px; margin-top: 15px"><?php echo $_SESSION['error']; 
        ?></p>
        <?php unset($_SESSION['error']); } ?>



    </main>
        <script>
            $( document ).ready(function() {

                $("#password").on('input', function(e) {

                    if (/^(?=.{6,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/.test(this.value)) {

                        $("small").css("color", "green")
                    } else {
                        $("small").css("color", "red")
                    }
                })

                $("#nom").on('input', function(e) {

                    if (/^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$/.test(this.value)) {

                        $(".validNom").css("display", "none")
                    } else {
                        $(".validNom").css("display", "block")
                    }
                })

                $("#prenom").on('input', function(e) {

                    if (/^[a-zA-Z \-,.ùüäàâéëêèïîôö]*$/.test(this.value)) {

                        $(".validPrenom").css("display", "none")
                    } else {
                        $(".validPrenom").css("color", "red")
                    }
                })
            })

        </script>
    </body>
</html>