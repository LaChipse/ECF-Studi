<?php
require_once('../model/Model.php');

class SectionModel extends Model
{
    protected $id;
    protected $titre;
    protected $formId;

    public function __construct()
    {
        $this->table = 'section';
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