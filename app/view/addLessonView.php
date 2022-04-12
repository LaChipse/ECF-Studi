<!DOCTYPE html>
<html style="height: 100%">

    <?php
        require_once('../view/head.php');
    ?>
        
    <body style="height: 100vh">

        <?php
        require_once('../view/header.php');

        require_once('../model/Section.php');

        $sectionnModel = new SectionModel();
        $section = $sectionnModel -> findBy(array('formid' => $_GET['formation']));
        ?>
        
        <main class="container form-signin col-lg-5 mt-5" style="margin: auto">

        <form enctype="multipart/form-data" class="mt-5" style="margin: auto" action="../controller/addLesson.php?id=<?php echo $_GET['id']?>&formation=<?php echo $_GET['formation']?>" method="post">
            <h1 class="mb-5 fw-normal text-center">Ajout lesson</h1>

            <div class="mb-3">
                <label for="sectionid" class="form-label">Section</label>
                <select name="sectionid" class="form-select" id="sectionid">
                    <option selected>Choisir la section</option>
                <?php foreach($section as $row) {
                ?>
                    
                    <option value=<?php echo $row["id"] ?>><?php echo $row["titre"] ?></option>
                
                <?php
                }
                ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="titre" class="form-label">Titre de la lesson</label>
                <input type="text" name="titre" class="form-control" id="titre" required>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Video d'explication de la lesson</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                <input class="form-control" type="file" name="video" id="video" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php if (isset($_SESSION['error'])) { ?>
            <p class="errorMessage" style="color: red; font-size: 18px; margin-top: 15px"><?php echo $_SESSION['error'];} ?></p>

    </main>
    </body>
</html>