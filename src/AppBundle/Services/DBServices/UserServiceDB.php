<?php

namespace AppBundle\Services\DBServices;
use AppBundle\Exceptions\DataBaseErrorException;
use Exception;
use Doctrine\DBAL\LockMode;

class UserServiceDB extends EntityDB {
    public function __construct ($manager) {
        $dql["fields"] = array(
            "id",
            "username",
            "password",
            "currency"
        );

        $dql["filters"] = array(
            "estado" => 1
        );

        parent::__construct($manager, 'Users', $dql);
    }
    public function getEntityByUsername($username) {
        return $this->manager->getRepository("AppBundle:Users")->findOneBy(
            array('username' => $username)
        );
    }
}