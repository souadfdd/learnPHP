<?php
namespace src\classes\bo;

class Adresse
{

    private $idVille;

    private $ville;

    private $rue;
    
    private $idUser;
    /**
     * @return mixed
     */
    public function getIdVille()
    {
        return $this->idVille;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @return mixed
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idVille
     */
    public function setIdVille($idVille)
    {
        $this->idVille = $idVille;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @param mixed $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    
    

    
}