<?php
require_once('../model/Model.php');

class ApprenantModel extends Model
{
    protected $id;
    protected $formSuivi;
    protected $formTerm;
    protected $coursTerm;
    protected $userId;

    public function __construct()
    {
        $this->table = 'apprenant';
    }

    /**
    * Obtenir la valeur d'un parametres
    */ 
    public function __get($property)
    {
        return $this->$property;
    }

    /**
    * Définir la valeur d'un parametres
    */ 
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

}