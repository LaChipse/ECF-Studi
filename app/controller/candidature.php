<?php

require('../model/Instructeur.php');


$instructeurModel = new InstructeurModel();

if($_GET['valid']) {
    if(strval($_GET['valid']) === 'right') {

        $instructeurModel->validation = 'validée';
        $instructeurModel->update($_GET['id'], $instructeurModel);

    } elseif (strval($_GET['valid']) === 'wrong') {

        $instructeurModel->validation = 'refusée';
        $instructeurModel->update($_GET['id'], $instructeurModel);
    }
}

header("Location: ../view/candidatureView.php");