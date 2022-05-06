
<?php
 header('Content-Type: text/html; charset=utf-8');
function connect()
{
    $pdo = new PDO('mysql:host=localhost;dbname=miniproject;charset=utf8', 'root', '');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    return $pdo;
}
function sanitaze($var)
{
    //     $r = isset($var) ? htmlspecialchars(trim($var)) : "";
    $r=$var;
    if(isset($var)){
        $r=  trim($var);
        $r=  htmlspecialchars(trim($var));
        $r= stripslashes($r);
    }
    
    
    return $r;
}
function printcheckbox($key, $lab)
{
    $check = '
    <option   value="' . $key . '" "> ' . $lab . ' </option>';
    echo $check;
}
function getFillier()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from Filiere ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
function getNiveau()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from Niveau ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
function getModule()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from Module ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
function getCoordinateur()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from coordinateur,Utilisateur where coordinateur.idUtilisateur=Utilisateur.idUtilisateur ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
?>