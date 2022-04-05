<?php

class Db extends PDO
{
    // Instance unique de la classe
    private static $_instance = null;

    // Informations de connexion
    private const DBHOST = 'localhost';
    private const DBUSER = 'postgres';
    private const DBPORT = '5432;';
    private const DBPASS = 'Mickey3d!';
    private const DBNAME = 'EcoIT';

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