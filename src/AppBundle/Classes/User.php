<?php

namespace AppBundle\Classes;
use AppBundle\Entity\Users;
use AppBundle\Exceptions\IncompleteOrWrongBodyRequestException;
use AppBundle\Resources\Constants;
use AppBundle\Exceptions\BadRequestException;
use AppBundle\Exceptions\DataBaseErrorException;
use AppBundle\Exceptions\NoAuthorizationActionException;
use AppBundle\Exceptions\UnauthorizedLoginException;

use Unirest\Request as APIClient;

class User {
    private $tools;
    private $classServiceDB;

    public function __construct(
        $tools,
        $classServiceDB
    ) {
        $this->tools = $tools;
        $this->classServiceDB = $classServiceDB;
    }

    public function create($params, $curr, $algorithm) {

        if (isset($params[0]) && isset($params[1]) && isset($params[2]) && sizeof($params) == 3) {
            //check if user already exists
            if ($this->classServiceDB->getEntityByUsername($params[0]) == true) {
                throw new BadRequestException('User already exists!');
            }

            //check password length
            if (strlen($params[1]) < 6) {
                throw new BadRequestException('Password min length is 6 characters!');
            }

            //check currency exists
            try {
                $curr->checkCurrency($params[2]);
            } catch(BadRequestException $e) {
                throw new BadRequestException($e->getErrorMessage());
            }

            $user = new Users();
            $user->setUsername($params[0]);
            $user->setPassword(hash($algorithm, $params[1]));
            $user->setCurrency($params[2]);

            try {
                $this->classServiceDB->persistEntity($user);

                return "Successfully user created. Please login to start your transactions.";
            } catch(DataBaseErrorException $e) {
                throw new DataBaseErrorException($e->getErrorMessage());
            }
        } else {
            throw new BadRequestException('To create a user, mandatory fields are: username password currency');
        }
    }

    public function login($params) {
        try {
            if (isset($params[0]) && isset($params[1]) && sizeof($params) == 2) {
                return $this->tools->login($params[0], $params[1]);
            } else {
                throw new BadRequestException('To login as a user, mandatory fields are: username password');
            }
        } catch(UnauthorizedLoginException $e) {
            throw new UnauthorizedLoginException($e->getErrorMessage());
        }
    }
}
