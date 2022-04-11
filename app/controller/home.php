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

    if(isset($_SESSION['role']) && ($_SESSION['role'] == 'apprenant')) {

        require_once('../model/Apprenant.php');
        $apprenantModel = new ApprenantModel();
        $apprenants = $apprenantModel -> findBy(array('userid' => $_SESSION['id']));

        foreach ($apprenants as $apprs)
        {
            $apprenantId = $apprs['id'];
        }

        $apprenant = $apprenantModel -> find($apprenantId);
    
        if($apprenant['formsuivi'] != NULL) {
            $formSuiviApprenant = postgres_to_php_array($apprenant['formsuivi']);
            
        }
    };

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

    $formations = $formationModel->findAll($per_page, $offset);

    require('../view/homeView.php');