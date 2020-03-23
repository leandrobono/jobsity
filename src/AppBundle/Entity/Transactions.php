<?php

namespace AppBundle\Entity;

/**
 * Users
 */
class Transactions
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $amount;

    private $fromCur;

    private $toCur;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $id
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Users
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this->date;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Users
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getFromCur()
    {
        return $this->fromCur;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Users
     */
    public function setFromCur($fromCur)
    {
        $this->fromCur = $fromCur;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getToCur()
    {
        return $this->toCur;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Users
     */
    public function setToCur($toCur)
    {
        $this->toCur = $toCur;

        return $this;
    }
}

