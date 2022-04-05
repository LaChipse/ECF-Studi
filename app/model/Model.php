<?php

require_once('../model/Db.php');

class Model extends Db
{
    // Table de la base de données
    protected $table;

    // Instance de connexion
    private $db;

	/**
	* Méthode qui exécutera les requêtes
	* @param string $postgresql Requête SQL à exécuter
	* @param array $attributes Attributs à ajouter à la requête 
	* @return PDOStatement|false 
	*/
	public function requete(string $postgresql, array $attributs = null)
	{
    	// On récupère l'instance de Db
		$this->db = Db::getInstance();

    	// On vérifie si on a des attributs
		if($attributs !== null) {
        	// Requête préparée
			$query = $this->db->prepare($postgresql);
			$query->execute($attributs);
			return $query;
		}else{
        	// Requête simple
			return $this->db->query($postgresql);
		}
	}


	/**
	* Sélection de tous les enregistrements d'une table
	* @return array Tableau des enregistrements trouvés
	*/
	public function findAll(int $limit, int $offset )
	{
		if(($limit == 0) and ($offset == 0)) {
			$query = $this->requete("SELECT * FROM $this->table");
			return $query->fetchAll();
		} else {
    	$query = $this->requete("SELECT * FROM $this->table limit $limit OFFSET $offset");
		return $query->fetchAll();
		}
	}

	/**
	* Sélection d'un enregistrement suivant son id
	* @param int $id id de l'enregistrement
	* @return array Tableau contenant l'enregistrement trouvé
	*/
	public function find(int $id)
	{
    	// On exécute la requête
    	return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
	}


	/**
	* Sélection de plusieurs enregistrements suivant un tableau de critères
	* @param array $criteres Tableau de critères
	* @return array Tableau des enregistrements trouvés
	*/
	public function findBy(array $criteres)
	{
		$champs = [];
		$valeurs = [];

    	// On boucle pour "éclater le tableau"
		foreach($criteres as $champ => $valeur){
			$champs[] = "$champ = ?";
			$valeurs[]= $valeur;
		}

    	// On transforme le tableau en chaîne de caractères séparée par des AND
		$liste_champs = implode(' AND ', $champs);

    	// On exécute la requête
    	$query = $this->requete("SELECT * FROM {$this->table} WHERE $liste_champs", $valeurs);
		return $query->fetchAll();
	}

	public function countVar()
	{
		return $this->requete("SELECT count(*) FROM {$this->table}")->fetch();
	}

	/**
	* Insertion d'un enregistrement suivant un tableau de données
	* @param Model $model Objet à créer
	* @return bool
	*/
	public function create(Model $model)
	{
		$champs = [];
		$inter = [];
		$valeurs = [];

    	// On boucle pour éclater le tableau
		foreach($model as $champ => $valeur){
        	// INSERT INTO tables (titre, description, actif) VALUES (?, ?, ?)
			if($valeur !== null && $champ != 'db' && $champ != 'table'){
				$champs[] = $champ;
				$inter[] = "?";
				$valeurs[] = $valeur;
			}
		}

    	// On transforme le tableau "champs" en une chaine de caractères
		$liste_champs = implode(', ', $champs);
		$liste_inter = implode(', ', $inter);

		// On exécute la requête
		return $this->requete('INSERT INTO '.$this->table.' ('. $liste_champs.')VALUES('.$liste_inter.')', $valeurs);
	}


	/**
	* Mise à jour d'un enregistrement suivant un tableau de données
	* @param int $id id de l'enregistrement à modifier
	* @param Model $model Objet à modifier
	* @return bool
	*/
	public function update(int $id, Model $model)
	{
		$champs = [];
		$valeurs = [];

    	// On boucle pour éclater le tableau
		foreach($model as $champ => $valeur){
			// UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
			if($valeur !== null && $champ != 'db' && $champ != 'table'){
				$champs[] = "$champ = ?";
				$valeurs[] = $valeur;
			}
		}
		$valeurs[] = $id;

    	// On transforme le tableau "champs" en une chaine de caractères
		$liste_champs = implode(', ', $champs);

		// On exécute la requête
		return $this->requete('UPDATE '.$this->table.' SET '. $liste_champs.' WHERE id = ?', $valeurs);
	}


	/**
	* Suppression d'un enregistrement
	* @param int $id id de l'enregistrement à supprimer
	* @return bool 
	*/
	public function delete(int $id) {
		return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
	}	
}
