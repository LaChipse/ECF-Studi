<?php

    session_start();

    function postgres_to_php_array($postgresArray){
        $postgresStr = trim($postgresArray,"{}");
        $elmts = explode(",",$postgresStr);
        return $elmts;   
    }
        
    function php_to_postgres_array( $phpArray){
        return "{".join(",",$phpArray)."}";
    }

    if(isset($_SESSION['error'])) unset($_SESSION['error']);

    require_once('../model/Formation.php');
    $formationModel = new FormationModel();


    $row_count = $formationModel->countVar();
    $count = $row_count['count'];

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $per_page  = 10;
    $offset = ($page - 1) * $per_page;

    $total_pages = ceil($count / $per_page);


    if(isset($_POST['search']) && ($_POST['search'] != "")){
        $formations = $formationModel->findName($_POST['search'],$per_page, $offset);
    } else {
        $formations = $formationModel->findAll($per_page, $offset);
    }


    if(isset($_SESSION['role']) && ($_SESSION['role'] == 'apprenant')) {

        require_once('../model/Apprenant.php');
        $apprenantModel = new ApprenantModel();
        $apprenants = $apprenantModel -> findBy(array('userid' => $_SESSION['id']));

        require_once('../model/Cours.php');
        $coursModel = new CoursModel();
        $coursLessonId = array();

        foreach ($apprenants as $apprs)
        {
            $apprenantId = $apprs['id'];
        }

        $apprenant = $apprenantModel -> find($apprenantId);
        $formSuiviApprenant = postgres_to_php_array($apprenant['formsuivi']);


        if(isset($_POST['trieForm'])) {

            if (strval($_POST['trieForm']) == 'progression') {
                foreach ($formSuiviApprenant as &$value) {
                    $formation = $formationModel->find(intval($value));

                    if (!$formation) {
                        $formations = array();
                    } else {
                        $formations = array();
                        array_push($formations, $formation);
                    }
                    
                }
            } elseif (strval($_POST['trieForm']) == 'terminer') {
                $formTermApprenant = postgres_to_php_array($apprenant['formterm']);
                foreach ($formTermApprenant as &$value) {
                    $formation = $formationModel->find(intval($value));
                    if (!$formation) {
                        $formations = array();
                    } else {
                        $formations = array();
                        array_push($formations, $formation);
                    }
                }
            }elseif (strval($_POST['trieForm']) == 'allForm') {
                $formations = $formationModel->findAll($per_page, $offset);
                }
            }


        if(($apprenant['formterm'] != NULL) || ($apprenant['formterm'] != '{}')) {

            $formTermApprenant = postgres_to_php_array($apprenant['formterm']);
            $apprCoursTermArray = postgres_to_php_array($apprenant['coursterm']);

            foreach ($formTermApprenant as $idForm) {
                $coursLesson = $coursModel -> findBy(array('formid' => intval($idForm)));

                foreach ($coursLesson as $valueCours) {
                    array_push($coursLessonId, strval($valueCours['id']));
                }

                if (array_intersect($coursLessonId, $apprCoursTermArray) != $coursLessonId) {

                    $formTermApprenant = array_diff($formTermApprenant, array($idForm));
                    $formTermApprenant = php_to_postgres_array($formTermApprenant);

                    $apprenantModel->formterm = $formTermApprenant;

                    if(!in_array(intval($idForm), $formSuiviApprenant)){

                        if(($apprenant['formsuivi'] == NULL) || ($apprenant['formsuivi'] == '{}')) 
                        {
                            $apprenantModel->formsuivi = "{" . $idForm . "}";

                        } else 
                        {   
                            array_push($formSuiviApprenant, $idForm);
                            $formSuiviApprenant = php_to_postgres_array($formSuiviApprenant);
                            $apprenantModel->formsuivi = $formSuiviApprenant;

                            $formSuiviApprenant = postgres_to_php_array($formSuiviApprenant);
                        }

                        $apprenantModel->update($apprenantId, $apprenantModel);
                    }
                }
            }
        }

        require_once('../view/homeView.php');

    } else {

        require_once('../view/homeView.php');
    };

    