<?php

session_start();

try { 
    if(!empty($_POST)) {

        if(isset($_SESSION['error'])) unset($_SESSION['error']);

        require_once('../model/Formation.php');
        $formationModel = new FormationModel();

        $formationModel->titre = $_POST["titre"];
        $formationModel->description = $_POST["description"];

            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = str_replace(' ', '_', $_FILES["image"]["name"]);
                $filetype = $_FILES["image"]["type"];
                $filesize = $_FILES["image"]["size"];
            
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) {
                    $_SESSION['error'] = 'Extension du fichier non autorisé';
                    header("Location: ../view/addFormationView.php");
                }
            
                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) {
                    $_SESSION['error'] = 'La taille du fichier est supérieure à la limite autorisée.';
                    header("Location: ../view/addFormationView.php");
                }
            
                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)) {
                    // Vérifie si le fichier existe avant de le télécharger.
                    if(file_exists("../asset/dl/img/formation/" . $filename)){
                        $_SESSION['error'] = 'Le nom du fichier existe deja. Veuillez renommer votre fichier';
                        header("Location: ../view/addFormationView.php");
                    } else {
                        move_uploaded_file($_FILES["image"]["tmp_name"], "../asset/dl/img/formation/" . $filename);
                        echo "Votre fichier a été téléchargé avec succès.";
                    } 
                } else {
                    $_SESSION['error'] = 'Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.';
                    header("Location: ../view/addFormationView.php");
                }
            } else {
                echo "Error: " . $_FILES["image"]["error"];
                header("Location: ../view/addFormationView.php");
            }
            
        $formationModel->image = "../asset/dl/img/formation/" . $filename;
        $formationModel->intid = $_GET['id'];
        $formationModel->datecreated = date('Y-m-d');
        $formationModel->create($formationModel);

        if(isset($_SESSION['error'])) unset($_SESSION['error']);
        
        header("Location: ../controller/manageFormation.php?id=$_GET[id]");
    }
    else 
    {
        header("Location: ../view/addFormationView.php");
    }
} catch (PDOException $e) {
    die('echec : '.$e->getMessage());
}