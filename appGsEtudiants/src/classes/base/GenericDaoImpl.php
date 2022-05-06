<?php
namespace src\classes\base;

/**
 * Classe d'aide à l'écriture des DAOs
 * pour le projet web de la première année génie informatique
 * Cette classe est écrite dans un cadre pédagogique
 *
 * === Génie Informatique 1 ===
 *
 * @author Tarik BOUDAA
 *        
 */
class GenericDaoImpl
{

    /**
     * Nom de la table sur la quelle seront executées les opérations
     */
    private $tableName;

    /**
     * Nom de la classe entité sur laquelle seront executées les opérations
     */
    private $className;

    /**
     * identifiant de l'entité à manipuler
     */
    private $entityId;

    /**
     * encapsule en connexion à la base de données
     */
    private $connection;

    /**
     * Objet de reflexion permettant d'accéder dynamiquement aux propriétés et méthodes d'une classe
     */
    private $reflection;

    /**
     * Constructeur
     *
     * @param
     *            $tableName
     * @param
     *            $className
     * @param
     *            $id
     */
    public function __construct($tableName, $className = null, $id = null)
    {
        //initialiser le nom de la table
        $this->tableName = $tableName;
        
        
        if ($className == null) {
            
            $this->className = $tableName;
        } else {
            $this->className = $className;
        }

        if ($id == null) {
            $this->entityId = "id";
        } else {
            $this->entityId = $id;
        }

        // Creation d'un objet de connexion à la base de données
        $dabaBase = new DatabaseConnection(Config::host, Config::port, Config::database, Config::user, Config::password);
       
        
        
        $this->connection = $dabaBase->getPdo();

        // Création d'un obejet de réflexion pour la classe manipulée par ce DAO
        $this->reflection = new \ReflectionClass($this->className);
    }

    /**
     * Permet d'executer une insertion d'une entité en base de données
     *
     * @param $entity :
     *            instance de l'entité à sauvegarder dans la base de données
     */
    public function save($entity)
    {

        // Construction de l'instruction insert into
        $query = "INSERT INTO " . strtolower($this->tableName) . " (";

        // On obtient par réflexion la liste des noms des attributs de
        // l'entité passée en paramètre
        $fields = $this->getFields();

        // On parcourt la liste des attributs
        // Ici on suppose que les colonnes de la table et les noms des attributs sont
        // les mêmes. Si on ne respecte pas cette convenion cette classe ne va pas fonctionner
        for ($i = 0; $i < count($fields); $i ++) {
            // S'il ne s'agit pas de l'attribut clé primaire
            // (car on suppose que cette clé est autoincrémenté et générée par le GGBD)
            if ($fields[$i] != $this->getIdField()) {
                
                $query = $query . $fields[$i];

                // S'il ne s'agit pas du dernier élément alors ajouter virgule
                if ($i < count($fields) - 1) {
                    $query = $query . ", ";
                }
            }
        }

        // On continue la construction de l'ordre Insert
        $query = $query . ") VALUES (";

        // On parcourt la liste des attributs
        for ($i = 0; $i < count($fields); $i ++) {
            // S'il ne s'agit pas de l'attribut clé primaire
            if ($fields[$i] != $this->getIdField()) {
                // On ajoute les noms des paramètres sous form ":nom_attribut"
                $query = $query . ":" . $fields[$i];
                // S'il ne s'agit pas du dernier élément alors ajouter virgule
                if ($i < sizeof($fields) - 1) {
                    $query = $query . ", ";
                }
            }
        }
        $query = $query . ");";

        $values = [];
        for ($i = 0; $i < count($fields); $i ++) {

            if ($fields[$i] != $this->getIdField()) {

                // Pour chaque attribut on déduit le nom du getter associé.
                // il est de forme get+nom de l'attribut, avec le première caractère en majiscule
                $getterMethodName = 'get' . ucfirst($fields[$i]);
                // On appel les getters par réflexion.

                $values[$fields[$i]] = $this->callMethod($getterMethodName, $entity);
            }
        }

        // On execute la requete
        $this->connection->prepare($query)->execute($values);
        $lastId = $this->connection->lastInsertId();
        $setIdMethod = 'set' . ucfirst($this->getIdField());
        $this->callMethod($setIdMethod, $entity, $lastId);

        return $lastId;
    }

    public function update($entity)
    {

        // Construction de l'instruction insert UPDATE
        $query = "UPDATE " . strtolower($this->className) . " SET ";
        $fields = $this->getFields();
        for ($i = 0; $i < count($fields); $i ++) {
            if ($fields[$i] != $this->getIdField()) {
                $query = $query . $fields[$i] . "=:" . $fields[$i];
                if ($i < count($fields) - 1) {
                    $query = $query . ", ";
                }
            }
        }
        $query = $query . " WHERE " . $this->getIdField() . " = :" . $this->getIdField() . " ;";
        echo $query;
        $values = [];
        for ($i = 0; $i < count($fields); $i ++) {

            // Pour chaque attribut on déduit le nom du getter associé.
            // il est de forme get+nom de l'attribut, avec le première caractère en majiscule
            $getterMethodName = 'get' . ucfirst($fields[$i]);
            // On appel les getters par réflexion.
            $values[$fields[$i]] = $this->callMethod($getterMethodName, $entity);
        }

        $this->connection->prepare($query)->execute($values);
    }

    /**
     * Permet de retrouver toutes les entités de la base de données
     *
     * @return array : un tableau des entités
     */
    public function getAll()
    {
        // Construit la requete SELECT
        $query = "SELECT * FROM " . strtolower($this->tableName) . ";";

        // Il s'agit d'une requête paramétrée
        $stmt = $this->connection->prepare($query);

        // On execute la requête
        if ($stmt->execute()) {
            $result = [];

            // récupère les enregistrement retrouvés de la base de données
            // puis on copie les données aux objets
            while ($row = $stmt->fetch()) {
                $result[] = $this->mapToEntity($row);
            }
            return $result;
        }
        return [];
    }

    /**
     * Permet de retrouver une entité par sa clé primaire
     *
     * @param
     *            $id
     * @return object|NULL
     */
    public function getById($id)
    {

        // On construit la requête
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE " . $this->getIdField() . " = :id;";
        $stmt = $this->connection->prepare($query);
        // On indique la valeur du paramètre :id
        $stmt->bindParam(':id', $id);

        // On execute la requete et on copie le résultat vers un objet entité
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                return $this->mapToEntity($row);
            }
        }
        return null;
    }

    /**
     * Permet de retrouver une entité par la valeur d'une colonne
     *
     * @param
     *            $id
     * @return object|NULL
     */
    public function getByColumnValue($col, $val)
    {

        // On construit la requête
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE $col = :val";
        $stmt = $this->connection->prepare($query);
        // On indique la valeur du paramètre :id
        $stmt->bindParam(':val', $val);

        // On execute la requete et on copie le résultat vers un objet entité
        $data = array();
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                $data[] = $this->mapToEntity($row);
            }
        }
        return $data;
    }

    /**
     * Permet de retrouver des entités en utilisant plusieurs critères
     *
     * @param
     *            $criterias
     * @return object[]
     */
    public function findByEqualCreterias($criterias, $operator = null)
    {
        if ($operator == null) {
            $operator = 'AND';
        }

        // On construit la requête
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE ";
        $values = [];

        $i = 0;
        foreach ($criterias as $key => $val) {
            $query .= "$key=:$key";

            $values[$key] = $val;

            if ($i < count($criterias) - 1) {
                $query = $query . "  " . $operator . " ";
            }

            $i ++;
        }
        echo $query;
        $stmt = $this->connection->prepare($query);

        $results = [];

        // On execute la requete et on copie le résultat vers un objet entité
        if ($stmt->execute($values)) {
            while ($row = $stmt->fetch()) {
                $results[] = $this->mapToEntity($row);
            }
        }
        return $results;
    }

    /**
     * Permet de retrouver des entités en utilisant plusieurs critères
     *
     * @param
     *            $criterias
     * @return object[]
     */
    public function findByCreteria($criterias, $operators = [])
    {

        // On construit la requête
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE ";
        $values = [];

        $i = 0;
        foreach ($criterias as $crt) {

            $query .= $crt->getKey() . $crt->getSymbol() . ":" . $crt->getKey();
            if ($i < count($operators)) {
                $query = $query . " " . $operators[$i] . " ";
            }

            $values[$crt->getKey()] = $crt->getValue();

            $i ++;
        }
        $stmt = $this->connection->prepare($query);

        $results = [];

        // On execute la requete et on copie le résultat vers un objet entité
        if ($stmt->execute($values)) {
            while ($row = $stmt->fetch()) {
                $results[] = $this->mapToEntity($row);
            }
        }
        return $results;
    }

    /**
     * Permet de supprimer une ligne dans la base de données dont l'id est passé en pramètre
     *
     * @param
     *            $id
     */
    public function remove($id)
    {
        $query = "DELETE FROM " . strtolower($this->className) . " WHERE " . $this->getIdField() . " = ?;";
        $values = [
            $id
        ];

        $this->connection->prepare($query)->execute($values);
    }

    /**
     * Retourne la liste des attributs d'une classe
     *
     * @return array
     */
    private function getFields()
    {
        $properties = $this->reflection->getProperties(\ReflectionProperty::IS_PRIVATE);
        
        $fields = [];
        
        foreach ($properties as $prop) {

            array_push($fields, $prop->getName());
        }
        return $fields;
    }

    /**
     * Permet d'appeler d'une façon dynamique une méthode
     */
    private function callMethod($methodName, $class, $arg = null)
    {
        if ($arg == null) {
            return call_user_func_array(array(
                $class,
                $methodName
            ), array());
        } else {
     
            return call_user_func_array(array(
                $class,
                $methodName
            ), array(
                $arg
            ));
        }
    }

    /**
     * Copie les données d'une ligne de résultat vers un objet
     * (Elle effectue le mapping entre les lignes d'un résultat d'execution d'une
     * requête SQL et les objets)
     *
     * @param
     *            $row
     * @return
     */
    private function mapToEntity($row)
    {
        $fields = $this->getFields();

        // On construit dynamiquement une instance
        $entity = $this->reflection->newInstanceArgs();
        for ($i = 0; $i < count($fields); $i ++) {
            // On appel les setters pour copier les données vers les objets
            $setterMethodName = 'set' . ucfirst($fields[$i]);
            $this->callMethod($setterMethodName, $entity, $row[$fields[$i]]);
        }

        return $entity;
    }

    private function getIdField()
    {
        return $this->entityId;
    }
}

class Etudiant
{
}
