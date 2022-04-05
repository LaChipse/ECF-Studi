<?php
require_once('../model/Model.php');

class InstructeurModel extends Model
{
    protected $id;
    protected $titre;
    protected $image;
    protected $description;
    protected $instId;

    public function __construct()
    {
        $this->table = 'instructeur';
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