<?php

    require_once('../model/Users.php');
    $userModel = new UserModel();

    session_start();

    try {

        $mail = $_POST['mail'];
        $mdp = $_POST['password'];

        $user = $userModel->findBy(array('mail' => $mail, 'password' => md5($mdp)));

        // verifie si on a trouver une correspondance entre mail et password
        if ( count($user) > 0) {

            // verifie le role du visiteur qui va se connecter
            foreach ($user as $row) {

                if($row['role'] == 'admin') {
                    $_SESSION['role'] = 'admin';
                    $_SESSION['user'] = TRUE;
                    $_SESSION['id'] = $row["id"];
                    header("Location: ../controller/home.php?id=$row[id]");

                } elseif ($row['role'] == 'apprenant') {
                    $_SESSION['role'] = 'apprenant';
                    $_SESSION['user'] = TRUE;
                    $_SESSION['id'] = $row["id"];
                    header("Location: ../controller/home.php?id=$row[id]");

                } elseif ($row['role'] == 'instructeur') {

                    require_once('../model/Instructeur.php');
                    $instructeurModel = new InstructeurModel();
                    $instructeur = $instructeurModel->findBy(array('userid' => $row['id']));

                    if ( count($instructeur) > 0) {

                        // si instructeur alors on verifie la validitée de sa candidature
                        foreach ($instructeur as $row) {

                            if($row['validation'] == 'validée') {

                                $_SESSION['role'] = 'instructeur';
                                $_SESSION['user'] = TRUE;
                                $_SESSION['id'] = $row["id"];
                                header("Location: ../controller/home.php?id=$row[id]");

                            } else {
                                $_SESSION['user'] = FALSE;
                                $_SESSION['validate'] = FALSE;
                                header("Location: ../controller/login.php");
                            }
                        }
                    }
                }
            }

                
        } else {
            $_SESSION['user'] = FALSE;
            header("Location: ../controller/login.php");
        }

    } catch (PDOException $e) {
        die('echec : '.$e->getMessage());
    }