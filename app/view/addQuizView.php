<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require_once('../view/head.php');
    ?>
        
    <body style="height: 100vh">

        <?php
        require_once('../model/Section.php');
        $sectionnModel = new SectionModel();
        $section = $sectionnModel -> findBy(array('formid' => $_GET['formation']));
        ?>
        
        <main class="container form-signin col-lg-5 mt-5" style="margin: auto">

        <form class="mt-5" style="margin: auto" action="../controller/addQuiz.php?id=<?php echo $_GET['id']?>&formation=<?php echo $_GET['formation']?>" method="post">
        <h1 class="mb-5 fw-normal text-center">Ajout quiz</h1>

            <div class="mb-3">
                <label for="sectionid" class="form-label">Section</label>
                <select name="sectionid" class="form-select" id="sectionid">
                    <option selected>Choisir la section</option>
                    <!-- Affichage de toutes les sections possibles -->
                <?php foreach($section as $row) {
                ?>
                    
                    <option value=<?php echo $row["id"] ?>><?php echo $row["titre"] ?></option>
                
                <?php
                }
                ?>
                </select>
            </div>

            <div class="mb-3 sectionInput">
                <label for="question" class="form-label">Question :</label>
                <input type="text" name="question" class="form-control mb-4" id="question" required>
            </div>

            <div>
                <button class="btn btn-success addRep mb-4">Ajouter une mauvaise réponse (max 3)</button>
            </div>

            <div class="mb-">
                <label for="bonne-rep" class="form-label">Réponse correct</label>
                <input type="text" name="bonne-rep" class="form-control mb-4" id="bonne-rep" required>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </main>
    <script type="text/javascript" src="../asset/js/addQuiz.js"> 
    </script> 
    </body>
</html>