<?php

session_start();

try {
    // verifie si formulaire a été submit
    if(!empty($_POST)) {

        require_once('../model/Cours.php');
        $coursModel = new CoursModel();

        $coursModel->titre = $_POST["titre"];
        $coursModel->description = $_POST["description"];

            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["video"]) && $_FILES["video"]["error"] == 0){
                $allowed = array("mp4" => "video/mp4", "webm" => "video/mp4", "ogg" => "video/ogg",);
                $filename = str_replace(' ', '_', $_FILES["video"]["name"]);
                $filetype = $_FILES["video"]["type"];
                $filesize = $_FILES["video"]["size"];
            
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) {
                    $_SESSION['error'] = 'Extension du fichier non autorisé';
                    header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
                    die();
                }
            
                // Vérifie la taille du fichier - 100Mo maximum
                $maxsize = 100 * 1024 * 1024;
                if($filesize > $maxsize) {
                    $_SESSION['error'] = 'La taille du fichier est supérieure à la limite autorisée.';
                    header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
                    die();
                }
            
            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){
                    // Vérifie si le fichier existe avant de le télécharger.
                    if(file_exists("../asset/dl/videos/" . $filename)){
                        $_SESSION['error'] = 'Le nom du fichier existe deja. Veuillez renommer votre fichier';
                        header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
                        die();
                    } else {
                        move_uploaded_file($_FILES["video"]["tmp_name"], "../asset/dl/videos/" . $filename);
                        var_dump("Votre fichier a été téléchargé avec succès.");
                    } 
                } else {
                    $_SESSION['error'] = 'Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.';
                    header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
                    die();
                }
            } else {
                echo "Error: " . $_FILES["video"]["error"];
                header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
                die();
            }
            
        $coursModel->video = "../asset/dl/videos/" . $filename;
        $coursModel->sectionid = $_POST["sectionid"];
        $coursModel->formid = $_GET['formation'];
        $coursModel->create($coursModel);

        if(isset($_SESSION['error'])) unset($_SESSION['error']);
        
        header("Location: ../controller/manageFormation.php?id=$_GET[id]");
    }
    else 
    {
        header("Location: ../view/addLessonView.php?id=$_GET[id]&formation=$_GET[formation]");
    }
} catch (PDOException $e) {
    die('echec : '.$e->getMessage());
}