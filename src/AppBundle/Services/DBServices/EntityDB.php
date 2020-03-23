<?php

namespace AppBundle\Services\DBServices;
use Doctrine\DBAL\LockMode;
use Exception;
use AppBundle\Exceptions\DataBaseErrorException;

abstract class EntityDB {
    protected $entityName;
    protected $manager;
    protected $getResultsDql;
    protected $_aliasEntityName;

    public function __construct($manager, $entityName, $dql) {
        $this->manager          = $manager;
        $this->entityName       = $entityName;
        $this->getResultsDql    = $dql;
        $this->_aliasEntityName = $entityName;
    }

    public function setDqlFilters($dql) {
        $this->getResultsDql["filters"] = $dql;
    }

    public function setDqlJoins($dql) {
        $this->getResultsDql["joins"] = $dql;
    }

    public function create ($entity) {
        $this->persistEntity($entity);
    }

    public function checkEntityExistsByUuid($uuid, $forUpdate = false) {
        try {
            $dql = "SELECT ".$this->_aliasEntityName."
                    FROM AppBundle:".ucfirst($this->entityName)." ".$this->_aliasEntityName."
                    WHERE ".$this->_aliasEntityName.".uuid = :uuid";

            $parameters = array();
            $parameters["uuid"] = $uuid;

            $query = $this->manager->createQuery($dql)->setParameters($parameters);
            if ($forUpdate) {
                $query->setLockMode(LockMode::PESSIMISTIC_WRITE);
            }
            return $query->getResult();
        } catch (Exception $e) {
            throw new DataBaseErrorException;
        }
    }

    public function delete($uuid) {
        try {
            $dql  = "DELETE FROM AppBundle:".$this->entityName." ".$this->_aliasEntityName;
            $dql .= " WHERE ".$this->_aliasEntityName.".uuid = :uuid";

            $parameters = array(
                'uuid' => $uuid
            );

            $query = $this->manager->createQuery($dql)->setParameters($parameters);
            return $query->execute();
        } catch (Exception $e) {
            throw new DataBaseErrorException;
        }
    }

    public function update ($entity) {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new DataBaseErrorException($e->getMessage());
        }
    }

    public function persistEntity($entity) {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
        } catch (Exception $e) {
            throw new DataBaseErrorException($e->getMessage());
        }
    }

    public function getAll($totalPerPage = null, $offset = null) {
        return $this->_getResults($totalPerPage, $offset);
    }

    public function getOne($uuid) {
        return $this->_getResults(null, null, $uuid);
    }

    public function startTransaction() {
        $this->manager->beginTransaction();
    }

    public function commit() {
        $this->manager->commit();
    }

    public function rollback() {
        $this->manager->rollback();
    }
}