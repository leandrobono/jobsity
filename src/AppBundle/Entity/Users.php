<?php

namespace AppBundle\Entity;

/**
 * Users
 */
class Users
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $currency;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Get id
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $id
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this->password;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Users
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}

