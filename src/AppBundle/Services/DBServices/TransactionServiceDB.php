<?php

namespace AppBundle\Services\DBServices;
use AppBundle\Exceptions\DataBaseErrorException;
use Exception;
use Doctrine\DBAL\LockMode;

class TransactionServiceDB extends EntityDB {
    public function __construct ($manager) {
        $dql["fields"] = array(
            "id",
            "user",
            "date",
            "amount",
            "fromCur",
            "toCur"
        );

        $dql["filters"] = array(
            "estado" => 1
        );

        parent::__construct($manager, 'Transactions', $dql);
    }

    public function getBalance($id) {
        $sql = 'select ifnull(sum(amount), 0.00) as su from transactions where user = ' . $id;

        $em   = $this->manager;
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        return $res[0]["su"];
    }
}