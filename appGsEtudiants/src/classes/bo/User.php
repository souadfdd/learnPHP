<?php
namespace src\classes\bo;

class User
{

    private $id;

    private $nom;

    private $login;

    private $password;

 

    /**
     *
     * @return mixed
     */
    public function getIdAdresse()
    {
        return $this->idAdresse;
    }

    /**
     *
     * @param mixed $idAdresse
     */
    public function setIdAdresse($idAdresse)
    {
        $this->idAdresse = $idAdresse;
    }

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     *
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     *
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}