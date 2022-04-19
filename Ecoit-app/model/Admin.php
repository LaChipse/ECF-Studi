<?php
require_once('../model/Model.php');

class AdminModel extends Model
{
    protected $id;
    protected $userId;

    public function __construct()
    {
        $this->table = 'administrateur';
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