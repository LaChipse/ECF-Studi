<?php

require_once("../config.php");

class Db extends PDO
{
    // Instance unique de la classe
    private static $_instance = null;

    // Informations de connexion
    private const DBHOST = HOST;
    private const DBUSER = USER;
    private const DBPORT = PORT;
    private const DBPASS = PASS;
    private const DBNAME = NAME;

    private function __construct()
    {
        // DSN de connexion
        $_dsn = 'pgsql:dbname='. self::DBNAME . ';host=' . self::DBHOST . ';port=' .self::DBPORT;

        // On appelle le constructeur de la classe PDO
        try{
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }


    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance = new Db();
        }
        return self::$_instance;
    }
}