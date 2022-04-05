<?php
require_once('../model/Model.php');

class UserModel extends Model
{
    protected $id;
    protected $nom;
    protected $prenom;
    protected $mail;
    protected $password;
    protected $role;

    public function __construct()
    {
        $this->table = 'users';
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