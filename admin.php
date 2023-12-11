<?php

class Administrador
{
    private $user;
    private $name;
    private $lastname;
    private $cod_admin;
    private $position;

    public function __construct($user, $name, $lastname, $cod_admin, $position)
    {
        $this->user = $user;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->cod_admin = $cod_admin;
        $this->position = $position;
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

    public function getCodAdmin()
    {
        return $this->cod_admin;
    }

    public function getPosition()
    {
        return $this->position;
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

    public function setCodAdmin($cod_admin)
    {
        $this->cod_admin = $cod_admin;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }
}
