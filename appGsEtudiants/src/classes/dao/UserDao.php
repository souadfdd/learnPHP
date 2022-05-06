<?php
namespace src\classes\dao;


use src\classes\base\GenericDaoImpl;

class UserDao extends GenericDaoImpl
{
    
    public function __construct(){
        parent::__construct("User", "src\classes\bo\User");
    }
    
    
    
}

