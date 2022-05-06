<?php
namespace src\classes\base;

/**
 * Classe d'aide � l'�criture des DAOs
 * pour le projet web de la premi�re ann�e g�nie informatique
 * Cette classe est �crite dans un cadre p�dagogique
 *
 * === G�nie Informatique 1 ===
 *
 * @author Tarik BOUDAA
 *        
 */
class GenericDaoImpl
{

    /**
     * Nom de la table sur la quelle seront execut�es les op�rations
     */
    private $tableName;

    /**
     * Nom de la classe entit� sur laquelle seront execut�es les op�rations
     */
    private $className;

    /**
     * identifiant de l'entit� � manipuler
     */
    private $entityId;

    /**
     * encapsule en connexion � la base de donn�es
     */
    private $connection;

    /**
     * Objet de reflexion permettant d'acc�der dynamiquement aux propri�t�s et m�thodes d'une classe
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

        // Creation d'un objet de connexion � la base de donn�es
        $dabaBase = new DatabaseConnection(Config::host, Config::port, Config::database, Config::user, Config::password);
       
        
        
        $this->connection = $dabaBase->getPdo();

        // Cr�ation d'un obejet de r�flexion pour la classe manipul�e par ce DAO
        $this->reflection = new \ReflectionClass($this->className);
    }

    /**
     * Permet d'executer une insertion d'une entit� en base de donn�es
     *
     * @param $entity :
     *            instance de l'entit� � sauvegarder dans la base de donn�es
     */
    public function save($entity)
    {

        // Construction de l'instruction insert into
        $query = "INSERT INTO " . strtolower($this->tableName) . " (";

        // On obtient par r�flexion la liste des noms des attributs de
        // l'entit� pass�e en param�tre
        $fields = $this->getFields();

        // On parcourt la liste des attributs
        // Ici on suppose que les colonnes de la table et les noms des attributs sont
        // les m�mes. Si on ne respecte pas cette convenion cette classe ne va pas fonctionner
        for ($i = 0; $i < count($fields); $i ++) {
            // S'il ne s'agit pas de l'attribut cl� primaire
            // (car on suppose que cette cl� est autoincr�ment� et g�n�r�e par le GGBD)
            if ($fields[$i] != $this->getIdField()) {
                
                $query = $query . $fields[$i];

                // S'il ne s'agit pas du dernier �l�ment alors ajouter virgule
                if ($i < count($fields) - 1) {
                    $query = $query . ", ";
                }
            }
        }

        // On continue la construction de l'ordre Insert
        $query = $query . ") VALUES (";

        // On parcourt la liste des attributs
        for ($i = 0; $i < count($fields); $i ++) {
            // S'il ne s'agit pas de l'attribut cl� primaire
            if ($fields[$i] != $this->getIdField()) {
                // On ajoute les noms des param�tres sous form ":nom_attribut"
                $query = $query . ":" . $fields[$i];
                // S'il ne s'agit pas du dernier �l�ment alors ajouter virgule
                if ($i < sizeof($fields) - 1) {
                    $query = $query . ", ";
                }
            }
        }
        $query = $query . ");";

        $values = [];
        for ($i = 0; $i < count($fields); $i ++) {

            if ($fields[$i] != $this->getIdField()) {

                // Pour chaque attribut on d�duit le nom du getter associ�.
                // il est de forme get+nom de l'attribut, avec le premi�re caract�re en majiscule
                $getterMethodName = 'get' . ucfirst($fields[$i]);
                // On appel les getters par r�flexion.

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

            // Pour chaque attribut on d�duit le nom du getter associ�.
            // il est de forme get+nom de l'attribut, avec le premi�re caract�re en majiscule
            $getterMethodName = 'get' . ucfirst($fields[$i]);
            // On appel les getters par r�flexion.
            $values[$fields[$i]] = $this->callMethod($getterMethodName, $entity);
        }

        $this->connection->prepare($query)->execute($values);
    }

    /**
     * Permet de retrouver toutes les entit�s de la base de donn�es
     *
     * @return array : un tableau des entit�s
     */
    public function getAll()
    {
        // Construit la requete SELECT
        $query = "SELECT * FROM " . strtolower($this->tableName) . ";";

        // Il s'agit d'une requ�te param�tr�e
        $stmt = $this->connection->prepare($query);

        // On execute la requ�te
        if ($stmt->execute()) {
            $result = [];

            // r�cup�re les enregistrement retrouv�s de la base de donn�es
            // puis on copie les donn�es aux objets
            while ($row = $stmt->fetch()) {
                $result[] = $this->mapToEntity($row);
            }
            return $result;
        }
        return [];
    }

    /**
     * Permet de retrouver une entit� par sa cl� primaire
     *
     * @param
     *            $id
     * @return object|NULL
     */
    public function getById($id)
    {

        // On construit la requ�te
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE " . $this->getIdField() . " = :id;";
        $stmt = $this->connection->prepare($query);
        // On indique la valeur du param�tre :id
        $stmt->bindParam(':id', $id);

        // On execute la requete et on copie le r�sultat vers un objet entit�
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                return $this->mapToEntity($row);
            }
        }
        return null;
    }

    /**
     * Permet de retrouver une entit� par la valeur d'une colonne
     *
     * @param
     *            $id
     * @return object|NULL
     */
    public function getByColumnValue($col, $val)
    {

        // On construit la requ�te
        $query = "SELECT * FROM " . strtolower($this->tableName) . " WHERE $col = :val";
        $stmt = $this->connection->prepare($query);
        // On indique la valeur du param�tre :id
        $stmt->bindParam(':val', $val);

        // On execute la requete et on copie le r�sultat vers un objet entit�
        $data = array();
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                $data[] = $this->mapToEntity($row);
            }
        }
        return $data;
    }

    /**
     * Permet de retrouver des entit�s en utilisant plusieurs crit�res
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

        // On construit la requ�te
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

        // On execute la requete et on copie le r�sultat vers un objet entit�
        if ($stmt->execute($values)) {
            while ($row = $stmt->fetch()) {
                $results[] = $this->mapToEntity($row);
            }
        }
        return $results;
    }

    /**
     * Permet de retrouver des entit�s en utilisant plusieurs crit�res
     *
     * @param
     *            $criterias
     * @return object[]
     */
    public function findByCreteria($criterias, $operators = [])
    {

        // On construit la requ�te
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

        // On execute la requete et on copie le r�sultat vers un objet entit�
        if ($stmt->execute($values)) {
            while ($row = $stmt->fetch()) {
                $results[] = $this->mapToEntity($row);
            }
        }
        return $results;
    }

    /**
     * Permet de supprimer une ligne dans la base de donn�es dont l'id est pass� en pram�tre
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
     * Permet d'appeler d'une fa�on dynamique une m�thode
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
     * Copie les donn�es d'une ligne de r�sultat vers un objet
     * (Elle effectue le mapping entre les lignes d'un r�sultat d'execution d'une
     * requ�te SQL et les objets)
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
            // On appel les setters pour copier les donn�es vers les objets
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
