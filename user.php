<?php

class Usuario
{
    private $user;
    private $name;
    private $lastname;
    private $cod_user;
    private $company_code;

    public function __construct($user, $name, $lastname, $cod_user, $company_code)
    {
        $this->user = $user;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->cod_user = $cod_user;
        $this->company_code = $company_code;
    }

    // Getters
    public function getUser()
    {
        return $this->user;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getCodUser()
    {
        return $this->cod_user;
    }

    public function getCompanyCode()
    {
        return $this->company_code;
    }

    // Setters
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setCodUser($cod_user)
    {
        $this->cod_user = $cod_user;
    }

    public function setCompanyCode($company_code)
    {
        $this->company_code = $company_code;
    }
}
