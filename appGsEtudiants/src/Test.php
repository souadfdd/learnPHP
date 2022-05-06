<?php

use src\classes\base\GenericDaoImpl;
use src\classes\dao\UserDao;
use src\classes\bo\User;
use src\classes\bo\Adresse;

include_once 'autoload.php';

$user = new User();
$user->setNom("Souad");
$user->setPassword("123456");
$user->setLogin("souadlogin");


$daoUser = new UserDao();
$idUser = $daoUser->save($user);


$adresse = new Adresse();
$adresse->setRue("50");
$adresse->setVille("Al Hoceima");
$adresse->setIdUser($idUser);

$adresseDao = new GenericDaoImpl("Adresse","src\classes\bo\Adresse","idVille");
$adresseDao->save($adresse);


//On r�cup�re la liste des Personnes
$allUser= $daoUser->getAll();

foreach ($allUser as $it) {
    
    echo "Nom = ". $it->getNom() ." ".$it->getNom(), '<br>';
    
    
    $adresses = $adresseDao->getByColumnValue("idUser",$it->getId());
    foreach($adresses as $ad){
        echo  $ad->getRue() ,'<br>';
    }
    
    echo '<hr>';
}

