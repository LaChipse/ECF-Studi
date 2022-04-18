<?php
require_once('../model/Model.php');

class CoursModel extends Model
{
    protected $id;
    protected $titre;
    protected $video;
    protected $description;
    protected $sectionId;
    protected $formId;

    public function __construct()
    {
        $this->table = 'cours';
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