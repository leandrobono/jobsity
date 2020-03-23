<?php

namespace AppBundle\Classes;
use AppBundle\Entity\Transactions;
use AppBundle\Exceptions\IncompleteOrWrongBodyRequestException;
use AppBundle\Resources\Constants;
use AppBundle\Exceptions\BadRequestException;
use AppBundle\Exceptions\DataBaseErrorException;
use AppBundle\Exceptions\NoAuthorizationActionException;
use AppBundle\Exceptions\UnauthorizedLoginException;

use Unirest\Request as APIClient;

class Transaction {
    private $tools;
    private $classServiceDB;

    public function __construct(
        $tools,
        $classServiceDB
    ) {
        $this->tools = $tools;
        $this->classServiceDB = $classServiceDB;
    }

    public function transaction($params, $curr, $token) {

        if (isset($params[0]) && isset($params[1]) && (sizeof($params) == 2 || sizeof($params) == 3)) {
            //check if user already exists
            if ($params[0] != "deposit" && $params[0] != "withdraw") {
                throw new BadRequestException('Only available actions to make a transactions are: deposit and withdraw!');
            }

            /*if (isset($params[2])) {
                //check currency exists
                try {
                    $curr->checkCurrency($params[2]);
                    //$params[1] = $curr->convert($params[2], $token->currency, $params[1]);
                } catch(BadRequestException $e) {
                    throw new BadRequestException($e->getErrorMessage());
                }
            }*/

            $tran = new Transactions();
            $tran->setUser($token->id);
            $tran->setDate(date("Y/m/d H:i:s"));
            if ($params[0] == "deposit") {
                $tran->setAmount($params[1]);
            } else if ($params[0] == "withdraw") {
                $tran->setAmount($params[1] - ($params[1] * 2));
                $bal = $this->balance($token);
                if ($bal < $params[1]) {
                    throw new BadRequestException('No available money to withdraw!');
                }
            }

            /*if (isset($params[2])) {
                $tran->setFromCur($params[2]);
                $tran->setToCur($token->currency);
            }*/

            try {
                $this->classServiceDB->persistEntity($tran);

                return "Operation Success";
            } catch(DataBaseErrorException $e) {
                throw new DataBaseErrorException($e->getErrorMessage());
            }
        } else {
            throw new BadRequestException('To make a transaction, mandatory fields are: action amount. Optionally, currency');
        }
    }

    public function balance($token) {
        try {
            return $this->classServiceDB->getBalance($token->id);
        } catch(DataBaseErrorException $e) {
            throw new DataBaseErrorException($e->getErrorMessage());
        }
    }
}
