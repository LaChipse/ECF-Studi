<?php
require_once('../model/Model.php');

class QuizModel extends Model
{
    protected $id;
    protected $question;
    protected $repFausse;
    protected $repVraie;
    protected $sectionId;

    public function __construct()
    {
        $this->table = 'quiz';
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