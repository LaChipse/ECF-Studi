<?php

session_start();

// verifie si formulaire a été submit
try { 
    if(!empty($_POST)) {

        require_once('../model/Users.php');
        $userModel = new UserModel();
        $usersAll = $userModel -> findAll();

        $userModel->nom = $_POST["nom"];
        $userModel->prenom = $_POST["prenom"];

        // verifie si l'email envoyé est unique sinon envoie erreur
        foreach ($usersAll as $value) {
            if(strval($value['mail']) == strval($_POST["mail"] )) {
                $_SESSION['error'] = "Email déjà existante.";
                header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                die();
            } else {
                $userModel->mail = $_POST["mail"];
            }
        }
        
        $userModel->password = md5($_POST["password"]);
        $userModel->datecreated = date("Y-m-d");
        $userModel->role = $_GET['role'];
        $id = $userModel->create($userModel);

        // verifie le rôle du visiteur grâce aux bouton cliqué
        if (strval($_GET['role']) === "instructeur") {
            require_once('../model/Instructeur.php');
            $dataModel = new InstructeurModel();

            
            // Vérifie si le fichier a été uploadé sans erreur.
            if(isset($_FILES["photoprofil"]) && $_FILES["photoprofil"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = str_replace(' ', '_', $_FILES["photoprofil"]["name"]);
                $filetype = $_FILES["photoprofil"]["type"];
                $filesize = $_FILES["photoprofil"]["size"];
            
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) {
                    $_SESSION['error'] = "Veuillez sélectionner un format de fichier valide.";
                    header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                    die();
                }
            
                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) {
                    $_SESSION['error'] = "Taille du fichier trop grande.";
                    header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                    die();
                }
            
                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)){
                    // Vérifie si le fichier existe avant de le télécharger.
                    if(file_exists("../asset/dl/img/profil/" . $filename)) {
                        $_SESSION['error'] = "Nom du fichier existe déjà. Veuillez le renommer.";
                        header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                        die();
                    } else {
                        move_uploaded_file($_FILES["photoprofil"]["tmp_name"], "../asset/dl/img/profil/" . $filename);
                        $_SESSION['file'] = TRUE;
                    } 
                } else {
                    $_SESSION['error'] = "Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
                    header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                    die();
                }
            } else {
                echo "Error: " . $_FILES["photoprofil"]["error"];
                header("Location: ../view/inscriptionView.php?role=$_GET[role]");
                die();
            }
            
            $dataModel->photoprofil = "../asset/dl/img/profil/" . $filename;
            $dataModel->specialites = $_POST["specialites"];
            $dataModel->validation = "En attente";
            $dataModel->userid = $id["id"];

        } elseif (strval($_GET['role']) === "apprenant") {
            require_once('../model/Apprenant.php');
            $dataModel = new ApprenantModel();

            $dataModel->pseudo = $_POST["pseudo"];
            $dataModel->userid = $id["id"];
        }

        $dataModel->create($dataModel);
        header("Location: ../controller/login.php");
    }
    else 
    {
        header("Location: ../view/inscriptionView.php?role=$_GET[role]");
    }
} catch (PDOException $e) {
    die('echec : '.$e->getMessage());
}
    