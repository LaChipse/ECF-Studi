<?php

    require_once('../model/Formation.php');
    $formationModel = new FormationModel();

    $formation = $formationModel -> findBy(array('intid' => $_GET['id']));

    require_once('../model/Section.php');
    $sectionModel = new SectionModel();

    require_once('../model/Cours.php');
    $coursModel = new CoursModel();

    require_once('../view/manageFormationView.php');


    

    